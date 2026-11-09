<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cotizacion extends Model
{
    use HasFactory;

    protected $table = 'cotizaciones';

    protected $fillable = [
        'obra_id',
        'user_id',
        'codigo_cotizacion',
        'monto_total',
        'fecha_emision',
        'validez_dias',
        'fecha_vencimiento',
        'observaciones',
        'estado_cotizacion',
        'motivo_rechazo',
        'cotizacion_padre_id',
    ];

    protected $casts = [
        'fecha_emision'     => 'date',
        'fecha_vencimiento' => 'date',
        'monto_total'       => 'decimal:2',
    ];

    // =========================================================================
    // RELACIONES ELOQUENT
    // =========================================================================

    public function obra(): BelongsTo
    {
        return $this->belongsTo(Obra::class, 'obra_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function comercial(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function cotizacionPadre(): BelongsTo
    {
        return $this->belongsTo(Cotizacion::class, 'cotizacion_padre_id');
    }

    public function versionesHijas(): HasMany
    {
        return $this->hasMany(Cotizacion::class, 'cotizacion_padre_id');
    }

    // =========================================================================
    // ACCESSORS
    // =========================================================================

    /**
     * Calcula en caliente el % de descuento comparado con el presupuesto base de la Obra.
     */
    public function getPorcentajeDescuentoAttribute(): float
    {
        if (!$this->obra || $this->obra->monto <= 0) {
            return 0.00;
        }

        if ($this->obra->monto > $this->monto_total) {
            $descuento = (($this->obra->monto - $this->monto_total) / $this->obra->monto) * 100;
            return round($descuento, 2);
        }

        return 0.00;
    }

    // =========================================================================
    // QUERY SCOPES (Módulo Gerencia HU-07 y HU-10)
    // =========================================================================

    /**
     * Scope: Cotizaciones pendientes de visto bueno de Gerencia (Programada o Registrada)
     */
    public function scopePendientesAprobacion(Builder $query): Builder
    {
        return $query->whereIn('estado_cotizacion', ['Programada', 'Registrada']);
    }

    /**
     * Scope: Cotizaciones aprobadas formalmente por Gerencia
     */
    public function scopeAprobadas(Builder $query): Builder
    {
        return $query->whereIn('estado_cotizacion', ['Aprobada', 'Enviada']);
    }

    /**
     * Scope: Cotizaciones rechazadas por Gerencia
     */
    public function scopeRechazadas(Builder $query): Builder
    {
        return $query->where('estado_cotizacion', 'Rechazada');
    }

    /**
     * Scope: Cotizaciones aceptadas/ganadas por el Cliente
     */
    public function scopeAceptadas(Builder $query): Builder
    {
        return $query->where('estado_cotizacion', 'Aceptada');
    }

    /**
     * Scope: Filtro de Búsqueda inteligente (Código, Proyecto, Cliente, RUC)
     */
    public function scopeBuscar(Builder $query, ?string $search): Builder
    {
        return $query->when($search, function ($q) use ($search) {
            $q->where(function ($sub) use ($search) {
                $sub->where('codigo_cotizacion', 'like', "%{$search}%")
                    ->orWhereHas('obra', function ($o) use ($search) {
                        $o->where('titulo', 'like', "%{$search}%")
                          ->orWhere('codigo', 'like', "%{$search}%")
                          ->orWhereHas('cliente', function ($c) use ($search) {
                              $c->where('razon_social', 'like', "%{$search}%")
                                ->orWhere('ruc', 'like', "%{$search}%");
                          });
                    });
            });
        });
    }

    /**
     * Scope: Filtro por Rango de Fechas
     */
    public function scopeFiltroFechas(Builder $query, ?string $desde, ?string $hasta): Builder
    {
        return $query->when($desde, fn($q) => $q->whereDate('fecha_emision', '>=', $desde))
                     ->when($hasta, fn($q) => $q->whereDate('fecha_emision', '<=', $hasta));
    }
}