<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AlertaSlaMail extends Mailable
{
    use Queueable, SerializesModels;

    public $obrasRojas;

    public function __construct($obrasRojas)
    {
        $this->obrasRojas = $obrasRojas;
    }

    public function build()
    {
        return $this->subject('🚨 [ALERTA SLA] Solicitudes Estancadas en DTL PREMIER')
                    ->html("
                        <h2 style='color: #dc2626;'>Alerta de Solicitudes Estancadas (> 48h sin Cotización)</h2>
                        <p>Las siguientes obras del pipeline han superado el plazo máximo de respuesta:</p>
                        <ul>" .
                        $this->obrasRojas->map(fn($o) => "<li><strong>{$o->codigo} - {$o->titulo}</strong> (Cliente: {$o->cliente->razon_social}) - {$o->sla['mensaje']}</li>")->implode('') .
                        "</ul>
                        <p>Por favor, revisar el panel de Administración y Ajustes.</p>
                    ");
    }
}