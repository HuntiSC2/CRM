<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Obra;
use App\Models\SlaPolitica;
use App\Models\SlaAlertaLog;
use App\Mail\AlertaSlaMail;
use Illuminate\Support\Facades\Mail;

class VerificarSlaObras extends Command
{
    protected $signature = 'sla:verificar';
    protected $description = 'Audita obras activas, registra incidentes en base de datos y remite correo de alerta';

    public function handle()
    {
        $politica = SlaPolitica::where('etapa_evaluada', 'COTIZACION_PROPUESTA')->first();
        if (!$politica || !$politica->notificacion_activa) {
            $this->info('Notificaciones de SLA desactivadas.');
            return;
        }

        $obrasRojas = Obra::with(['cliente', 'inspecciones', 'cotizaciones'])
            ->whereNotIn('estado', ['Aceptada', 'Cancelada'])
            ->get()
            ->map(function ($obra) {
                $obra->sla = $obra->diagnostico_sla;
                return $obra;
            })
            ->filter(fn($o) => $o->sla['color'] === 'ROJO');

        if ($obrasRojas->isNotEmpty()) {
            foreach ($obrasRojas as $obra) {
                SlaAlertaLog::firstOrCreate([
                    'obra_id'                  => $obra->id,
                    'sla_politica_id'          => $politica->id,
                    'user_id'                  => $obra->user_id,
                    'estado_alerta'            => 'VIGENTE',
                    'horas_retraso_detectadas' => $obra->sla['horas'],
                ]);
            }

            if ($politica->email_notificacion) {
                Mail::to($politica->email_notificacion)->send(new AlertaSlaMail($obrasRojas));
                $this->info("Correo enviado a: {$politica->email_notificacion}");
            }
        } else {
            $this->info('Sin obras estancadas en alerta roja.');
        }
    }
}