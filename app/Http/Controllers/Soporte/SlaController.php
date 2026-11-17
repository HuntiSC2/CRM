<?php

namespace App\Http\Controllers\Soporte;

use App\Http\Controllers\Controller;
use App\Models\SlaPolitica;
use App\Models\SlaAlertaLog;
use App\Models\Obra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SlaController extends Controller
{
    public function index()
    {
        $politicaVisita = SlaPolitica::firstOrCreate(
            ['etapa_evaluada' => 'VISITA_INSPECCION'],
            [
                'user_id'             => Auth::id() ?? 1,
                'tiempo_limite_horas' => 24,
                'nivel_severidad'     => 'AMARILLO',
                'email_notificacion'  => 'soporte@dtlpremier.pe',
                'notificacion_activa' => true,
            ]
        );

        $politicaCotiz = SlaPolitica::firstOrCreate(
            ['etapa_evaluada' => 'COTIZACION_PROPUESTA'],
            [
                'user_id'             => Auth::id() ?? 1,
                'tiempo_limite_horas' => 48,
                'nivel_severidad'     => 'ROJO',
                'email_notificacion'  => 'soporte@dtlpremier.pe',
                'notificacion_activa' => true,
            ]
        );

        $obras = Obra::with(['cliente', 'user', 'inspecciones', 'cotizaciones'])
            ->whereNotIn('estado', ['Aceptada', 'Cancelada'])
            ->latest()
            ->get()
            ->map(function ($obra) use ($politicaCotiz) {
                $diag = $obra->diagnostico_sla;
                $obra->sla = $diag;

                if ($diag['color'] === 'ROJO' && $politicaCotiz) {
                    SlaAlertaLog::firstOrCreate([
                        'obra_id'                  => $obra->id,
                        'sla_politica_id'          => $politicaCotiz->id,
                        'user_id'                  => $obra->user_id,
                        'estado_alerta'            => 'VIGENTE',
                        'horas_retraso_detectadas' => $diag['horas'],
                    ]);
                }

                return $obra;
            });

        $obrasCriticas = $obras->where('sla.color', 'ROJO');
        $obrasDemoradas = $obras->where('sla.color', 'AMARILLO');

        return view('soporte.sla.index', compact('politicaVisita', 'politicaCotiz', 'obras', 'obrasCriticas', 'obrasDemoradas'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'visita_horas' => 'required|integer|min:1',
            'cotiz_horas'  => 'required|integer|min:1',
            'email_notif'  => 'required|email',
        ]);

        $notif = $request->has('notificacion_activa');

        SlaPolitica::where('etapa_evaluada', 'VISITA_INSPECCION')->update([
            'tiempo_limite_horas' => $request->visita_horas,
            'email_notificacion'  => $request->email_notif,
            'notificacion_activa' => $notif,
            'user_id'             => Auth::id() ?? 1,
        ]);

        SlaPolitica::where('etapa_evaluada', 'COTIZACION_PROPUESTA')->update([
            'tiempo_limite_horas' => $request->cotiz_horas,
            'email_notificacion'  => $request->email_notif,
            'notificacion_activa' => $notif,
            'user_id'             => Auth::id() ?? 1,
        ]);

        return redirect()->route('soporte.sla.index')->with('success', 'Políticas de SLA actualizadas exitosamente.');
    }
}