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

    // <-- Agrega esta relación para conectar 1 a muchos con las obras -->
    public function obras()
    {
        return $this->hasMany(Obra::class, 'cliente_id');
    }
}