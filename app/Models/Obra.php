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

    // =========================================================================
    // EVENTOS ELOQUENT (SINCRONIZACIÓN DE ESTADOS CON EL CLIENTE)
    // =========================================================================

    protected static function booted(): void
    {
        static::saved(function (Obra $obra) {
            if ($obra->cliente_id) {
                \App\Http\Controllers\Comercial\PipelineController::actualizarEstadoCliente($obra->cliente_id);
            }
        });

        static::deleted(function (Obra $obra) {
            if ($obra->cliente_id) {
                \App\Http\Controllers\Comercial\PipelineController::actualizarEstadoCliente($obra->cliente_id);
            }
        });
    }

    // =========================================================================
    // RELACIONES ELOQUENT
    // =========================================================================

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function inspecciones(): HasMany
    {
        return $this->hasMany(Inspeccion::class, 'obra_id')->latest('id');
    }

    public function cotizaciones(): HasMany
    {
        return $this->hasMany(Cotizacion::class, 'obra_id')->latest('id');
    }

    public function ultimaCotizacion(): HasOne
    {
        return $this->hasOne(Cotizacion::class, 'obra_id')->latestOfMany('id');
    }

    public function ultimaInspeccion(): HasOne
    {
        return $this->hasOne(Inspeccion::class, 'obra_id')->latestOfMany('id');
    }

    public function bitacoras(): HasMany
    {
        return $this->hasMany(Bitacora::class, 'obra_id')->latest('id');
    }

    public function alertasSla(): HasMany
    {
        return $this->hasMany(SlaAlertaLog::class, 'obra_id')->latest('id');
    }

    // =========================================================================
    // ESTADO REAL DERIVADO
    // =========================================================================

public function getEstadoRealAttribute(): string
{
    // Se añade 'Ganada' para que no recalcule a Prospecto o Cotización una obra cerrada
    if (in_array($this->estado, ['Aceptada', 'Ganada', 'Cancelada', 'Perdida', 'Cierre Comercial'])) {
        return $this->estado;
    }

    $ultimaCotizacion = $this->cotizaciones->first();
    $ultimaInspeccion = $this->inspecciones->first();

    if (
        ($ultimaCotizacion && in_array($ultimaCotizacion->estado_cotizacion, ['Programada', 'Enviada', 'Aceptada', 'Rechazada'])) ||
        ($ultimaInspeccion && $ultimaInspeccion->estado_inspeccion === 'Completada')
    ) {
        return 'Cotización';
    }

    if ($ultimaInspeccion && $ultimaInspeccion->estado_inspeccion === 'Pendiente') {
        return 'Inspeccion';
    }

    return 'Prospecto';
}

    // =========================================================================
    // MOTOR DE DIAGNÓSTICO SLA (OPTIMIZADO EN MEMORIA)
    // =========================================================================

    /**
     * Evalúa el SLA recibiendo los límites por parámetro (para no consultar la BD 100 veces)
     */
    public function calcularDiagnosticoSla(int $limiteVisita = 24, int $limiteCotiz = 48): array
    {
        // 1. REGLA: Obra concluida o perdida -> Semáforo apagado
        if (in_array($this->estado, ['Aceptada', 'Cancelada', 'Perdida', 'Cierre Comercial'])) {
            return [
                'color'   => 'GRIS',
                'badge'   => 'secondary',
                'mensaje' => 'Expediente Terminado / Sin acciones pendientes',
                'horas'   => 0
            ];
        }

        // Trabajamos con las relaciones YA CARGADAS en memoria (sin ejecutar SQL)
        $ultimaInspeccion = $this->inspecciones->first();
        $ultimaCotizacion = $this->cotizaciones->first();

        // 2. ESCENARIO COTIZACIÓN (ROJO):
        // La inspección se completó O la cotización ya está "Programada", pero no se ha enviado
        if ($ultimaInspeccion && $ultimaInspeccion->estado_inspeccion === 'Completada') {
            
            // Revisamos si ya existe cotización enviada o aceptada posterior a la inspección
            $cotizacionVigente = $this->cotizaciones
                ->where('created_at', '>=', $ultimaInspeccion->updated_at)
                ->whereNotIn('estado_cotizacion', ['Rechazada'])
                ->first();

            // Si aún no se envía cotización válida:
            if (!$cotizacionVigente || $cotizacionVigente->estado_cotizacion === 'Programada') {
                $referencia = ($ultimaCotizacion && $ultimaCotizacion->estado_cotizacion === 'Rechazada')
                    ? $ultimaCotizacion->updated_at
                    : $ultimaInspeccion->updated_at;

                $horas = (int) round($referencia->diffInHours(now()));

                if ($horas > $limiteCotiz) {
                    return [
                        'color'   => 'ROJO',
                        'badge'   => 'danger',
                        'mensaje' => "Cotización demorada ({$horas}h transcurridas / SLA: {$limiteCotiz}h)",
                        'horas'   => $horas
                    ];
                }
            }
        }

        // 3. ESCENARIO INSPECCIÓN (AMARILLO):
        // Solo cuenta si YA SE AGENDÓ una inspección y sigue "Pendiente"
        if ($ultimaInspeccion && $ultimaInspeccion->estado_inspeccion === 'Pendiente') {
            
            // Si tiene fecha_inspeccion pactada, contamos desde esa fecha programada hacia adelante si ya pasó
            $fechaCompromiso = $ultimaInspeccion->fecha_inspeccion ?? $ultimaInspeccion->created_at;
            
            if (now()->greaterThan($fechaCompromiso)) {
                $horas = (int) round($fechaCompromiso->diffInHours(now()));
                if ($horas > $limiteVisita) {
                    return [
                        'color'   => 'AMARILLO',
                        'badge'   => 'warning text-dark',
                        'mensaje' => "Visita técnica demorada ({$horas}h de retraso / SLA: {$limiteVisita}h)",
                        'horas'   => $horas
                    ];
                }
            }
        }

        // 4. ESCENARIO CONTROL (VERDE):
        // Está en prospecto aún sin agendar, o las fechas están dentro del margen
        return [
            'color'   => 'VERDE',
            'badge'   => 'success',
            'mensaje' => 'SLA bajo control comercial',
            'horas'   => 0
        ];
    }

    public function getDiagnosticoSlaAttribute(): array
    {
        return $this->calcularDiagnosticoSla();
    }

    // =========================================================================
    // SCOPES
    // =========================================================================

    public function scopeActivas($query)
    {
        return $query->whereNotIn('estado', ['Aceptada', 'Cancelada', 'Perdida', 'Cierre Comercial']);
    }

    /**
     * Filtra solo las obras que están en fases operativas de SLA (Inspección o Cotización)
     */
    public function scopeEnRiesgoSla($query)
    {
        return $query->activas()->where(function ($q) {
            // Tiene inspección pendiente
            $q->whereHas('inspecciones', function ($ins) {
                $ins->where('estado_inspeccion', 'Pendiente');
            })
            // O tiene inspección completada esperando cotización
            ->orWhereHas('inspecciones', function ($ins) {
                $ins->where('estado_inspeccion', 'Completada');
            })
            // O tiene cotización programada
            ->orWhereHas('cotizaciones', function ($cot) {
                $cot->where('estado_cotizacion', 'Programada');
            });
        });
    }
}