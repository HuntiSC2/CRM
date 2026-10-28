<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inspeccion extends Model
{
    use HasFactory;

    protected $table = 'inspecciones';

    protected $fillable = [
        'obra_id',
        'user_id',
        'ingeniero_asignado', // <-- Agregado para permitir la asignación masiva
        'fecha_inspeccion',
        'resultado',
        'estado_inspeccion',
    ];

    public function obra()
    {
        return $this->belongsTo(Obra::class, 'obra_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}