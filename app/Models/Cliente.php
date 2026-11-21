<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'clientes';

    protected $fillable = [
        'ruc',
        'razon_social',
        'direccion',
        'nombre_contacto',
        'telefono_contacto',
        'email_contacto',
        'estado',
        'observaciones',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function obras()
    {
        return $this->hasMany(Obra::class, 'cliente_id');
    }

    /**
     * Calcula automáticamente los 3 estados solicitados:
     * 1. ACTIVO (Verde): Obra Ganada/Aceptada
     * 2. EN_PROCESO (Amarillo): En Pipeline (Prospecto hasta Cierre)
     * 3. INACTIVO (Rojo): Sin obras, Obra Perdida o dado de baja
     */
    public function getEstadoDinamicoAttribute(): string
    {
        if (!$this->relationLoaded('obras')) {
            $this->load('obras');
        }

        // Si tiene obras en curso en el pipeline (Prospecto, Inspección, Cotización, Cierre Comercial)
        $tieneEnProceso = $this->obras->whereNotIn('estado', ['Aceptada', 'Ganada', 'Cancelada', 'Perdida'])->count() > 0;
        if ($tieneEnProceso) {
            return 'EN_PROCESO';
        }

        // Si fue dado de baja manualmente y no tiene obras en proceso
        if (strtoupper($this->estado) === 'INACTIVO') {
            return 'INACTIVO';
        }

        if ($this->obras->isEmpty()) {
            return 'INACTIVO';
        }

        $tieneGanadas = $this->obras->whereIn('estado', ['Aceptada', 'Ganada'])->count() > 0;
        if ($tieneGanadas) {
            return 'ACTIVO';
        }

        return 'INACTIVO';
    }
}