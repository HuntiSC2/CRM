<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Partida extends Model
{
    use HasFactory;

    protected $table = 'partidas';

    protected $fillable = [
        'user_id',
        'codigo',
        'descripcion',
        'categoria',
        'unidad_medida',
        'precio_unitario',
        'is_active',
    ];

    protected $casts = [
        'precio_unitario' => 'decimal:2',
        'is_active'       => 'boolean',
    ];

    public function creador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function historialPrecios(): HasMany
    {
        return $this->hasMany(HistorialPrecioPartida::class, 'partida_id')->latest();
    }

    public function cotizaciones(): BelongsToMany
    {
        return $this->belongsToMany(Cotizacion::class, 'cotizacion_detalles')
                    ->withPivot('cantidad', 'precio_unitario', 'subtotal')
                    ->withTimestamps();
    }
}