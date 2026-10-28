<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obra extends Model
{
    use HasFactory;

    protected $table = 'obras';

    // Permitir asignación masiva en base a tu migración
    protected $fillable = [
        'codigo',
        'titulo',
        'monto',
        'fecha',
        'estado',
        'cliente_id',
        'user_id',
    ];

    /**
     * Relación con Inspecciones Técnicas
     */
    public function inspecciones()
    {
        return $this->hasMany(Inspeccion::class, 'obra_id');
    }

    /**
     * Relación con Cliente
     */
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    /**
     * Relación con el Usuario (Comercial responsable)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function cotizaciones()
    {
        return $this->hasMany(Cotizacion::class, 'obra_id');
    }
}