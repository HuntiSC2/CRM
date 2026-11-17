<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HistorialPrecioPartida extends Model
{
    use HasFactory;

    protected $table = 'historial_precios_partidas';

    protected $fillable = [
        'partida_id',
        'user_id',
        'precio_anterior',
        'precio_nuevo',
        'motivo_cambio',
    ];

    protected $casts = [
        'precio_anterior' => 'decimal:2',
        'precio_nuevo'    => 'decimal:2',
    ];

    public function partida(): BelongsTo
    {
        return $this->belongsTo(Partida::class, 'partida_id');
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}