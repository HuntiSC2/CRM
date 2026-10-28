<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cotizacion extends Model
{
    use HasFactory;

    protected $table = 'cotizaciones';

    protected $fillable = [
        'obra_id',
        'codigo_cotizacion',
        'monto_total',
        'validez_dias',
        'observaciones',
        'estado_cotizacion',
    ];

    /**
     * Relación con la Obra / Proyecto
     */
    public function obra()
    {
        return $this->belongsTo(Obra::class, 'obra_id');
    }

    // Nota: Si tu tabla no tiene user_id, puedes omitir esta relación o dejarla si la usa el with(['user'])
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}