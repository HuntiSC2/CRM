<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Obra extends Model
{
    use HasFactory;

    protected $table = 'obras';

    // Asignación masiva alineada a tu base de datos unificada
    protected $fillable = [
        'codigo',
        'titulo',
        'monto',
        'fecha',
        'estado',
        'cliente_id',
        'user_id',
    ];

    protected $casts = [
        'fecha' => 'date',
        'monto' => 'decimal:2',
    ];

    /**
     * Sumatoria de cotizaciones cuando se carga con withSum.
     */
    protected $appends = ['monto_total_cotizado'];

    // =========================================================================
    // RELACIONES ELOQUENT (MODELO ESTRELLA 100% CONECTADO)
    // =========================================================================

    /**
     * Cliente empresarial al que pertenece la obra (COSAPI, AESA, etc.)
     */
    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    /**
     * Asesor comercial responsable de la obra
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Inspecciones técnicas y visitas de campo realizadas para esta obra (1 a N)
     */
    public function inspecciones(): HasMany
    {
        return $this->hasMany(Inspeccion::class, 'obra_id')->latest();
    }

    /**
     * Presupuestos y propuestas económicas emitidas para esta obra (1 a N)
     */
    public function cotizaciones(): HasMany
    {
        return $this->hasMany(Cotizacion::class, 'obra_id')->latest();
    }

    /**
     * Última cotización registrada (mayor id) para la obra.
     */
    public function ultimaCotizacion(): HasOne
    {
        return $this->hasOne(Cotizacion::class, 'obra_id')->latestOfMany('id');
    }

    // =========================================================================
    // ACCESSORS DE MONTOS
    // =========================================================================

    /**
     * Monto total acumulado: sumatoria de todas las cotizaciones asociadas
     * (la obra puede dividirse por áreas y cotizarse por separado).
     * Se apoya en withSum('cotizaciones', 'monto_total') cuando está disponible.
     */
    public function getMontoTotalCotizadoAttribute(): float
    {
        if (array_key_exists('cotizaciones_sum_monto_total', $this->attributes)) {
            return (float) ($this->attributes['cotizaciones_sum_monto_total'] ?? 0);
        }

        return (float) $this->cotizaciones()->sum('monto_total');
    }

    /**
     * Alias de presentación formateada en soles.
     */
    public function getMontoTotalCotizadoFormateadoAttribute(): string
    {
        return 'S/ ' . number_format($this->monto_total_cotizado, 2);
    }

    /**
     * Bitácora de incidencias, reuniones y contactos
     */
    public function bitacoras(): HasMany
    {
        return $this->hasMany(Bitacora::class, 'obra_id')->latest();
    }

    /**
     * Registro auditable de alertas semafóricas disparadas (HU-08)
     */
    public function alertasSla(): HasMany
    {
        return $this->hasMany(SlaAlertaLog::class, 'obra_id')->latest();
    }

    // =========================================================================
    // ESTADO REAL DERIVADO DE LOS REGISTROS EN BASE DE DATOS
    // =========================================================================

    /**
     * Determina la etapa oficial de la obra según sus registros reales
     * (cotizaciones e inspecciones), sin depender de arrastres manuales.
     */
    public function getEstadoRealAttribute(): string
    {
        // 1. Si ya fue cerrada definitivamente o trasladada explícitamente a Cierre Comercial, se respeta
        if (in_array($this->estado, ['Aceptada', 'Cancelada', 'Perdida', 'Cierre Comercial'])) {
            return $this->estado;
        }

        $ultimaCotizacion = $this->cotizaciones->sortByDesc('id')->first();
        $ultimaInspeccion = $this->inspecciones->sortByDesc('id')->first();

        // 2. Si tiene cotizaciones y/o inspección completada -> Cotización
        if (
            ($ultimaCotizacion && in_array($ultimaCotizacion->estado_cotizacion, ['Programada', 'Enviada', 'Aceptada', 'Rechazada'])) ||
            ($ultimaInspeccion && $ultimaInspeccion->estado_inspeccion === 'Completada')
        ) {
            return 'Cotización';
        }

        // 3. Si tiene inspección pendiente -> Inspeccion
        if ($ultimaInspeccion && $ultimaInspeccion->estado_inspeccion === 'Pendiente') {
            return 'Inspeccion';
        }

        // 4. Si solo tiene el registro inicial -> Prospecto
        return 'Prospecto';
    }

    // =========================================================================
    // MOTOR DE DIAGNÓSTICO SEMAFÓRICO INTELIGENTE (HU-08)
    // =========================================================================

    /**
     * Evalúa el estado real del expediente sin depender de la ubicación visual
     * de la tarjeta en el Kanban (inmune a arrastres por descuido).
     */
    public function getDiagnosticoSlaAttribute(): array
    {
        // 1. REGLA CERO: Obra terminada, cancelada o perdida -> Semáforo apagado
        if (in_array($this->estado, ['Aceptada', 'Cancelada', 'Perdida'])) {
            return [
                'color'   => 'GRIS',
                'badge'   => 'secondary',
                'mensaje' => 'Expediente Terminado/Inactivo',
                'horas'   => 0
            ];
        }

        // Obtener parámetros de la tabla institucional de SLA (o valores por defecto)
        $politicaVisita = SlaPolitica::where('etapa_evaluada', 'VISITA_INSPECCION')->first();
        $politicaCotiz  = SlaPolitica::where('etapa_evaluada', 'COTIZACION_PROPUESTA')->first();

        $limiteVisita = $politicaVisita ? $politicaVisita->tiempo_limite_horas : 24;
        $limiteCotiz  = $politicaCotiz ? $politicaCotiz->tiempo_limite_horas : 48;

        // Consultamos los hechos reales registrados en la base de datos
        $ultimaInspeccion = $this->inspecciones()->latest('created_at')->first();
        $ultimaCotizacion = $this->cotizaciones()->latest('created_at')->first();

        // 2. CRITERIO ROJO: Hay inspección técnica completada, pero no hay cotización vigente en > 48h
        if ($ultimaInspeccion && $ultimaInspeccion->estado_inspeccion === 'Completada') {
            $tieneCotizVigente = $this->cotizaciones()
                ->where('created_at', '>=', $ultimaInspeccion->updated_at)
                ->where('estado_cotizacion', '!=', 'Rechazada')
                ->exists();

            if (!$tieneCotizVigente) {
                // Si la última cotización fue rechazada por precio, contamos desde la fecha de rechazo
                $referencia = ($ultimaCotizacion && $ultimaCotizacion->estado_cotizacion === 'Rechazada')
                    ? $ultimaCotizacion->updated_at
                    : $ultimaInspeccion->updated_at;

                $horas = round($referencia->diffInHours(now()));

                if ($horas > $limiteCotiz) {
                    return [
                        'color'   => 'ROJO',
                        'badge'   => 'danger',
                        'mensaje' => "Cotización retrasada ({$horas}h transcurridas / Límite {$limiteCotiz}h)",
                        'horas'   => $horas
                    ];
                }
            }
        }

        // 3. CRITERIO AMARILLO: Obra activa sin visita o con inspección pendiente en > 24h
        if (!$ultimaInspeccion || $ultimaInspeccion->estado_inspeccion === 'Pendiente') {
            $referencia = $ultimaInspeccion ? $ultimaInspeccion->created_at : $this->created_at;
            $horas = round($referencia->diffInHours(now()));

            if ($horas > $limiteVisita) {
                return [
                    'color'   => 'AMARILLO',
                    'badge'   => 'warning text-dark',
                    'mensaje' => "Inspección demorada ({$horas}h transcurridas / Límite {$limiteVisita}h)",
                    'horas'   => $horas
                ];
            }
        }

        // 4. CRITERIO VERDE: Expediente dentro de los plazos SLA
        return [
            'color'   => 'VERDE',
            'badge'   => 'success',
            'mensaje' => 'SLA bajo control comercial',
            'horas'   => 0
        ];
    }

    /**
     * Alias para compatibilidad con vistas y componentes
     */
    public function getSlaInfoAttribute(): array
    {
        return $this->diagnostico_sla;
    }

    // =========================================================================
    // QUERY SCOPES (Filtros de Alto Rendimiento)
    // =========================================================================

    /**
     * Scope: Obras vivas en el pipeline comercial (excluye cerradas y perdidas)
     */
    public function scopeActivas($query)
    {
        return $query->whereNotIn('estado', ['Aceptada', 'Cancelada', 'Perdida']);
    }
}