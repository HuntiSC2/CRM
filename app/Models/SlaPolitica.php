<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SlaPolitica extends Model
{
    protected $table = 'sla_politicas';

    protected $fillable = [
        'user_id',
        'etapa_evaluada',
        'tiempo_limite_horas',
        'nivel_severidad',
        'email_notificacion',
        'notificacion_activa',
    ];

    protected $casts = [
        'notificacion_activa' => 'boolean',
    ];

    public function responsable(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function alertas(): HasMany
    {
        return $this->hasMany(SlaAlertaLog::class, 'sla_politica_id');
    }
}