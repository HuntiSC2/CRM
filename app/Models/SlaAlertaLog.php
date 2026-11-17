<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SlaAlertaLog extends Model
{
    protected $table = 'sla_alertas_logs';

    protected $fillable = [
        'obra_id',
        'sla_politica_id',
        'user_id',
        'horas_retraso_detectadas',
        'estado_alerta',
        'fecha_disparo',
        'fecha_resolucion',
    ];

    protected $casts = [
        'fecha_disparo'    => 'datetime',
        'fecha_resolucion' => 'datetime',
    ];

    public function obra(): BelongsTo
    {
        return $this->belongsTo(Obra::class, 'obra_id');
    }

    public function politica(): BelongsTo
    {
        return $this->belongsTo(SlaPolitica::class, 'sla_politica_id');
    }

    public function asesor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}