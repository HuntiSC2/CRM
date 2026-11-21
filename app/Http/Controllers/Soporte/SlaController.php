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
    // 1. Cargamos o inicializamos políticas una única vez
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

    $limiteVisita = $politicaVisita->tiempo_limite_horas;
    $limiteCotiz  = $politicaCotiz->tiempo_limite_horas;

    // 2. FILTRO ESTRICTO: Solo obras vivas que TIENEN inspección o cotización en curso
    $obras = Obra::activas()
        ->where(function ($q) {
            // Caso A: Tiene inspección agendada o completada
            $q->whereHas('inspecciones')
              // Caso B: O tiene cotización en proceso
              ->orWhereHas('cotizaciones', function ($cot) {
                  $cot->whereIn('estado_cotizacion', ['Programada']);
              });
        })
        ->with([
            'cliente:id,razon_social,ruc',
            'user:id,name',
            'inspecciones' => fn($q) => $q->latest('id'),
            'cotizaciones' => fn($q) => $q->latest('id'),
        ])
        ->latest('id')
        ->paginate(15);

    // 3. Evaluamos SLA en memoria para los elementos filtrados
    $obrasCriticasList = collect();
    $obrasDemoradasList = collect();

    foreach ($obras as $obra) {
        $diag = $obra->calcularDiagnosticoSla($limiteVisita, $limiteCotiz);
        $obra->sla = $diag;

        if ($diag['color'] === 'ROJO') {
            $obrasCriticasList->push($obra);

            if ($politicaCotiz->notificacion_activa) {
                SlaAlertaLog::updateOrCreate(
                    [
                        'obra_id'         => $obra->id,
                        'sla_politica_id' => $politicaCotiz->id,
                        'estado_alerta'   => 'VIGENTE'
                    ],
                    [
                        'user_id'                  => $obra->user_id,
                        'horas_retraso_detectadas' => $diag['horas'],
                        'fecha_disparo'            => now(),
                    ]
                );
            }
        } elseif ($diag['color'] === 'AMARILLO') {
            $obrasDemoradasList->push($obra);
        }
    }

    $obrasCriticas = $obrasCriticasList;
    $obrasDemoradas = $obrasDemoradasList;

    return view('soporte.sla.index', compact(
        'politicaVisita',
        'politicaCotiz',
        'obras',
        'obrasCriticas',
        'obrasDemoradas'
    ));
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