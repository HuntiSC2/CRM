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
        'direccion', // <--- Agregado para permitir guardar la dirección fiscal
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
}