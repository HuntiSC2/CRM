<?php

namespace App\Http\Controllers\Comercial;

use App\Http\Controllers\Controller;
use App\Models\Obra;
use App\Models\Cliente;
use App\Models\Inspeccion;
use App\Models\Cotizacion;
use App\Models\CotizacionDetalle;
use App\Models\Partida;
use App\Models\Bitacora;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PipelineController extends Controller
{
    public function index()
    {
        $statuses = ['Prospecto', 'Inspeccion', 'Cotización', 'Cierre Comercial'];

        $obrasQuery = Obra::with(['cliente', 'inspecciones', 'cotizaciones.detalles.partida'])
            ->whereNotIn('estado', ['Aceptada', 'Cancelada', 'Perdida'])
            ->latest('id')
            ->get();

        $obras = [
            'Prospecto'        => [],
            'Inspeccion'       => [],
            'Cotización'       => [],
            'Cierre Comercial' => [],
        ];

        $totalesPorColumna = [
            'Prospecto'        => 0,
            'Inspeccion'       => 0,
            'Cotización'       => 0,
            'Cierre Comercial' => 0,
        ];

        foreach ($obrasQuery as $obra) {
            $estadoCalculado = $obra->estado;
            
            $todasInsp = $obra->inspecciones->sortBy('id')->values();
            $totalInspecciones = $todasInsp->count();
            $inspCompletadasCount = $todasInsp->where('estado_inspeccion', 'Completada')->count();
            $inspeccionPendiente = $todasInsp->where('estado_inspeccion', 'Pendiente')->last();

            $todasCotizaciones = $obra->cotizaciones->sortBy('id')->values();
            $totalCotizaciones = $todasCotizaciones->count();
            $ultimaCot = $todasCotizaciones->last();
            $estadoCotizacion = $ultimaCot?->estado_cotizacion;

            if ($estadoCalculado === 'Cotización' && $totalCotizaciones === 0) {
                $estadoCalculado = 'Inspeccion';
            }

            if (array_key_exists($estadoCalculado, $obras)) {
                $cotizacionesCulminadasCount = $todasCotizaciones->whereIn('estado_cotizacion', ['Aceptada', 'Rechazada'])->count();
                $cotizacionFinalizada = in_array($estadoCotizacion, ['Aceptada', 'Rechazada']);

                $cicloCerrado = ($inspCompletadasCount === $cotizacionesCulminadasCount) && is_null($inspeccionPendiente);
                $puedeAgendarInspeccion = ($totalInspecciones === 0) || $cicloCerrado;
                $hayInspeccionSinCotizar = ($inspCompletadasCount > $totalCotizaciones);
                $puedeProgramarCotizacion = ($estadoCalculado !== 'Prospecto') && $hayInspeccionSinCotizar && ($estadoCotizacion !== 'Programada');

                $puedeIrACierre = ($estadoCalculado === 'Cotización') 
                                && ($inspCompletadasCount > 0)
                                && ($inspCompletadasCount === $cotizacionesCulminadasCount)
                                && is_null($inspeccionPendiente)
                                && ($estadoCotizacion === 'Aceptada');

                $obras[$estadoCalculado][] = [
                    'id'                          => $obra->id,
                    'codigo'                      => $obra->codigo ?? ('OBR-' . str_pad($obra->id, 3, '0', STR_PAD_LEFT)),
                    'titulo'                      => $obra->titulo,
                    'cliente'                     => $obra->cliente ? $obra->cliente->razon_social : 'Sin Cliente',
                    'monto'                       => 'S/ ' . number_format($obra->monto, 2),
                    'monto_raw'                   => (float) $obra->monto,
                    'fecha'                       => $obra->fecha ? Carbon::parse($obra->fecha)->format('d/m/Y') : '',
                    'estado'                      => $estadoCalculado,

                    // Inspecciones
                    'total_inspecciones'          => $totalInspecciones,
                    'insp_completadas_count'      => $inspCompletadasCount,
                    'tiene_inspeccion_pendiente'  => !is_null($inspeccionPendiente),
                    'inspeccion_pendiente_id'     => $inspeccionPendiente?->id,
                    'inspeccion_ingeniero'        => $inspeccionPendiente?->ingeniero_asignado ?? 'No asignado',
                    'inspeccion_fecha'            => $inspeccionPendiente?->fecha_inspeccion ? Carbon::parse($inspeccionPendiente->fecha_inspeccion)->format('d/m/Y H:i') : '-',
                    'inspeccion_fecha_raw'        => $inspeccionPendiente?->fecha_inspeccion ? Carbon::parse($inspeccionPendiente->fecha_inspeccion)->format('Y-m-d\TH:i') : '',
                    'inspeccion_es_completada'    => ($totalInspecciones > 0 && is_null($inspeccionPendiente)),
                    'historial_inspecciones'      => $todasInsp->map(function ($ins, $idx) {
                        return [
                            'id'        => $ins->id,
                            'numero'    => $idx + 1,
                            'ingeniero' => $ins->ingeniero_asignado,
                            'fecha'     => Carbon::parse($ins->fecha_inspeccion)->format('d/m/Y H:i'),
                            'estado'    => $ins->estado_inspeccion,
                            'resultado' => $ins->resultado,
                        ];
                    })->toArray(),

                    // Cotizaciones (1:1)
                    'total_cotizaciones'          => $totalCotizaciones,
                    'cotizaciones_ok_count'       => $cotizacionesCulminadasCount,
                    'tiene_cotizaciones'          => ($totalCotizaciones > 0),
                    'cotizacion_id'               => $ultimaCot?->id,
                    'cotizacion_codigo'           => $ultimaCot?->codigo_cotizacion,
                    'cotizacion_monto'            => $ultimaCot?->monto_total ? 'S/ ' . number_format($ultimaCot->monto_total, 2) : 'S/ 0.00',
                    'cotizacion_monto_raw'        => (float) ($ultimaCot?->monto_total ?? 0),
                    'cotizacion_fecha_emision'    => $ultimaCot?->fecha_emision ? Carbon::parse($ultimaCot->fecha_emision)->format('Y-m-d') : date('Y-m-d'),
                    'cotizacion_fecha_formato'    => $ultimaCot?->fecha_emision ? Carbon::parse($ultimaCot->fecha_emision)->format('d/m/Y') : '-',
                    'cotizacion_observaciones'    => $ultimaCot?->observaciones ?? 'Sin observaciones.',
                    'estado_cotizacion'           => $estadoCotizacion,
                    'cotizacion_finalizada'       => $cotizacionFinalizada,
                    'es_rechazada'                => ($estadoCotizacion === 'Rechazada'),
                    'historial_cotizaciones'      => $todasCotizaciones->map(function ($cot, $idx) use ($todasInsp) {
                        $inspAsociada = $todasInsp->get($idx);
                        return [
                            'id'             => $cot->id,
                            'numero'         => $idx + 1,
                            'codigo'         => $cot->codigo_cotizacion,
                            'monto'          => 'S/ ' . number_format($cot->monto_total, 2),
                            'fecha'          => Carbon::parse($cot->fecha_emision)->format('d/m/Y'),
                            'estado'         => $cot->estado_cotizacion,
                            'observaciones'  => $cot->observaciones,
                            'insp_numero'    => $idx + 1,
                            'insp_dictamen'  => $inspAsociada?->resultado ?? 'Inspección completada.',
                            'insp_ingeniero' => $inspAsociada?->ingeniero_asignado ?? '-',
                            'detalles'       => $cot->detalles->map(function ($d) {
                                return [
                                    'partida_id'      => $d->partida_id,
                                    'codigo'          => $d->partida->codigo ?? 'PAR-S/N',
                                    'descripcion'     => $d->partida->descripcion ?? 'Partida',
                                    'unidad_medida'   => $d->partida->unidad_medida ?? 'und',
                                    'cantidad'        => (float) $d->cantidad,
                                    'precio_unitario' => (float) $d->precio_unitario,
                                    'subtotal'        => (float) $d->subtotal,
                                ];
                            })->toArray(),
                        ];
                    })->toArray(),

                    'puede_agendar_inspeccion'    => $puedeAgendarInspeccion,
                    'puede_programar_cotizacion'  => $puedeProgramarCotizacion,
                    'puede_ir_a_cierre'           => $puedeIrACierre,
                ];

                $totalesPorColumna[$estadoCalculado] += (float) $obra->monto;
            }
        }

        $clientes = Cliente::orderBy('razon_social', 'asc')->get();
        $partidas = Partida::where('is_active', true)->orderBy('categoria')->orderBy('descripcion')->get();

        return view('comercial.pipeline.index', compact('statuses', 'obras', 'totalesPorColumna', 'clientes', 'partidas'));
    }

    public function obtenerPartidasCatalogo()
    {
        $partidas = Partida::where('is_active', true)
            ->select('id', 'codigo', 'descripcion', 'categoria', 'unidad_medida', 'precio_unitario')
            ->orderBy('codigo')
            ->get();

        return response()->json($partidas);
    }

    public function agendarInspeccion(Request $request)
    {
        $request->validate([
            'obra_id'            => 'required|exists:obras,id',
            'ingeniero_asignado' => 'required|string|min:3|max:150',
            'fecha_inspeccion'   => 'required|date',
        ]);

        $obra = Obra::with(['inspecciones', 'cotizaciones'])->findOrFail($request->obra_id);

        if ($obra->inspecciones()->where('estado_inspeccion', 'Pendiente')->exists()) {
            return response()->json(['success' => false, 'message' => 'Complete la inspección en curso antes de agendar otra.'], 422);
        }

        $ultimaCot = $obra->cotizaciones()->latest('id')->first();
        if ($ultimaCot && !in_array($ultimaCot->estado_cotizacion, ['Aceptada', 'Rechazada'])) {
            return response()->json(['success' => false, 'message' => 'Debe culminar la cotización actual antes de iniciar una nueva fase.'], 422);
        }

        DB::transaction(function () use ($obra, $request) {
            Inspeccion::create([
                'obra_id'            => $obra->id,
                'user_id'            => Auth::id() ?? 1,
                'ingeniero_asignado' => $request->ingeniero_asignado,
                'fecha_inspeccion'   => $request->fecha_inspeccion,
                'estado_inspeccion'  => 'Pendiente',
                'resultado'          => null,
            ]);

            $obra->update(['estado' => 'Inspeccion']);
            self::actualizarEstadoCliente($obra->cliente_id);
        });

        return response()->json(['success' => true, 'message' => 'Inspección agendada exitosamente. Expediente trasladado a Inspección.']);
    }

    public function reprogramarInspeccion(Request $request)
    {
        $request->validate([
            'inspeccion_id'      => 'required|exists:inspecciones,id',
            'nueva_fecha'        => 'required|date',
            'ingeniero_asignado' => 'required|string|min:3|max:150',
        ]);

        $inspeccion = Inspeccion::findOrFail($request->inspeccion_id);
        $inspeccion->update([
            'fecha_inspeccion'   => $request->nueva_fecha,
            'ingeniero_asignado' => $request->ingeniero_asignado,
        ]);

        return response()->json(['success' => true, 'message' => 'Fecha reprogramada con éxito.']);
    }

    public function completarInspeccion(Request $request)
    {
        $request->validate([
            'inspeccion_id' => 'required|exists:inspecciones,id',
            'resultado'     => 'required|string|min:4',
        ]);

        $inspeccion = Inspeccion::findOrFail($request->inspeccion_id);
        $fechaActual = now();

        $inspeccion->update([
            'resultado'         => trim($request->resultado),
            'estado_inspeccion' => 'Completada',
            'updated_at'        => $fechaActual
        ]);

        return response()->json([
            'success' => true, 
            'message' => 'Inspección completada con éxito. Ya puede programar la cotización correspondiente.'
        ]);
    }

    public function programarCotizacion(Request $request)
    {
        $request->validate([
            'obra_id'       => 'required|exists:obras,id',
            'fecha_emision' => 'required|date',
        ]);

        $obra = Obra::with(['inspecciones', 'cotizaciones'])->findOrFail($request->obra_id);

        $completadas = $obra->inspecciones()->where('estado_inspeccion', 'Completada')->orderBy('id')->get();
        $totalCots = $obra->cotizaciones()->count();

        if ($completadas->count() <= $totalCots) {
            return response()->json(['success' => false, 'message' => 'No hay inspecciones pendientes de cotizar.'], 422);
        }

        $inspeccionAsociada = $completadas->get($totalCots);
        $numFase = $totalCots + 1;

        $anioActual = date('Y');
        $ultimaCotizacion = Cotizacion::where('codigo_cotizacion', 'like', "COT-{$anioActual}-%")
            ->orderBy('id', 'desc')
            ->first();

        $nuevoNumero = $ultimaCotizacion ? intval(explode('-', $ultimaCotizacion->codigo_cotizacion)[2] ?? 0) + 1 : 1;
        $nuevoCodigo = 'COT-' . $anioActual . '-' . str_pad($nuevoNumero, 4, '0', STR_PAD_LEFT);

        $validezDias = 15;
        $fechaEmision = Carbon::parse($request->fecha_emision);
        $fechaVencimiento = (clone $fechaEmision)->addDays($validezDias);

        $obsAuditoria = "[Fase #{$numFase} ⇄ Inspección #{$numFase} - {$inspeccionAsociada->ingeniero_asignado}] " . $inspeccionAsociada->resultado;

        DB::transaction(function () use ($obra, $nuevoCodigo, $fechaEmision, $validezDias, $fechaVencimiento, $obsAuditoria) {
            Cotizacion::create([
                'obra_id'           => $obra->id,
                'user_id'           => Auth::id() ?? 1,
                'codigo_cotizacion' => $nuevoCodigo,
                'monto_total'       => 0.00,
                'fecha_emision'     => $fechaEmision->toDateString(),
                'validez_dias'      => $validezDias,
                'fecha_vencimiento' => $fechaVencimiento->toDateString(),
                'estado_cotizacion' => 'Programada',
                'observaciones'     => $obsAuditoria,
            ]);

            $obra->update(['estado' => 'Cotización']);
            self::actualizarEstadoCliente($obra->cliente_id);
        });

        return response()->json([
            'success' => true,
            'message' => "Cotización {$nuevoCodigo} vinculada a la Inspección #{$numFase}. Expediente ubicado en Cotización."
        ]);
    }

    public function reprogramarCotizacion(Request $request)
    {
        $request->validate([
            'cotizacion_id'       => 'required|exists:cotizaciones,id',
            'nueva_fecha_emision' => 'required|date',
        ]);

        $cot = Cotizacion::findOrFail($request->cotizacion_id);
        $nuevaFecha = Carbon::parse($request->nueva_fecha_emision);

        $cot->update([
            'fecha_emision'     => $nuevaFecha->toDateString(),
            'fecha_vencimiento' => (clone $nuevaFecha)->addDays($cot->validez_dias ?? 15)->toDateString(),
            'updated_at'        => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Fecha de emisión actualizada por retraso.'
        ]);
    }

    /**
     * EMISIÓN DE COTIZACIÓN CON VINCULACIÓN DIRECTA A PARTIDAS
     */
    public function enviarCotizacion(Request $request)
    {
        $request->validate([
            'cotizacion_id'       => 'required|exists:cotizaciones,id',
            'observaciones'       => 'nullable|string',
            'partidas'            => 'required|array|min:1',
            'partidas.*.id'       => 'required|exists:partidas,id',
            'partidas.*.cantidad' => 'required|numeric|gt:0',
            'partidas.*.precio'   => 'required|numeric|min:0',
        ], [
            'partidas.required'   => 'Debe vincular al menos una partida a la cotización.',
            'partidas.min'        => 'Debe vincular al menos una partida a la cotización.',
        ]);

        $cotizacion = Cotizacion::with('obra')->findOrFail($request->cotizacion_id);
        $fechaActual = now();

        DB::transaction(function () use ($cotizacion, $request, $fechaActual) {
            // Eliminar detalles previos si existían
            $cotizacion->detalles()->delete();

            $sumaTotal = 0.00;

            foreach ($request->partidas as $item) {
                $subtotal = round((float)$item['cantidad'] * (float)$item['precio'], 2);
                $sumaTotal += $subtotal;

                CotizacionDetalle::create([
                    'cotizacion_id'   => $cotizacion->id,
                    'partida_id'      => $item['id'],
                    'cantidad'        => $item['cantidad'],
                    'precio_unitario' => $item['precio'],
                    'subtotal'        => $subtotal,
                ]);
            }

            $obsFinal = $request->observaciones;
            if (str_starts_with($cotizacion->observaciones ?? '', '[')) {
                $prefijo = explode('] ', $cotizacion->observaciones)[0] . '] ';
                $obsFinal = $prefijo . ($request->observaciones ?? '');
            }

            $cotizacion->update([
                'monto_total'       => $sumaTotal,
                'observaciones'     => $obsFinal,
                'fecha_vencimiento' => $fechaActual,
                'estado_cotizacion' => 'Enviada',
                'updated_at'        => $fechaActual,
            ]);

            if ($cotizacion->obra) {
                $cotizacion->obra->update([
                    'monto' => $sumaTotal,
                ]);
            }
        });

        return response()->json([
            'success' => true,
            'message' => "Cotización emitida formalmente con sus partidas vinculadas."
        ]);
    }

    public function ajustarPrecioCotizacion(Request $request)
    {
        $request->validate([
            'cotizacion_id'     => 'required|exists:cotizaciones,id',
            'nuevo_monto'       => 'required|numeric|gt:0',
            'motivo_reajuste'   => 'required|string|min:4',
        ]);

        $cotizacion = Cotizacion::with('obra')->findOrFail($request->cotizacion_id);
        $fechaActual = now();

        DB::transaction(function () use ($cotizacion, $request, $fechaActual) {
            $obsAnterior = $cotizacion->observaciones ?? '';
            $notaAjuste  = " [Reajuste por cliente: {$request->motivo_reajuste}]";

            $cotizacion->update([
                'monto_total'       => $request->nuevo_monto,
                'observaciones'     => $obsAnterior . $notaAjuste,
                'estado_cotizacion' => 'Enviada',
                'updated_at'        => $fechaActual,
            ]);

            if ($cotizacion->obra) {
                $cotizacion->obra->update([
                    'monto' => $request->nuevo_monto,
                ]);
            }
        });

        return response()->json([
            'success' => true,
            'message' => 'Precio reajustado exitosamente. La cotización vuelve a estado Enviada.'
        ]);
    }

    public function responderCotizacion(Request $request)
    {
        $request->validate([
            'cotizacion_id'      => 'required|exists:cotizaciones,id',
            'estado_cotizacion'  => 'required|in:Aceptada,Rechazada',
        ]);

        $cot = Cotizacion::findOrFail($request->cotizacion_id);
        $cot->update([
            'estado_cotizacion' => $request->estado_cotizacion,
            'updated_at'        => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => "Cotización actualizada como {$request->estado_cotizacion}."
        ]);
    }

    public function trasladarACierre(Request $request)
    {
        $request->validate([
            'obra_id' => 'required|exists:obras,id',
        ]);

        $obra = Obra::with('cotizaciones')->findOrFail($request->obra_id);

        $ultimaCot = $obra->cotizaciones()->latest('id')->first();
        if (!$ultimaCot || $ultimaCot->estado_cotizacion !== 'Aceptada') {
            return response()->json([
                'success' => false, 
                'message' => 'No se puede trasladar a Cierre Comercial si la cotización está rechazada o no ha sido aceptada.'
            ], 422);
        }

        $obra->update(['estado' => 'Cierre Comercial']);
        self::actualizarEstadoCliente($obra->cliente_id);

        return response()->json([
            'success' => true,
            'message' => "Obra trasladada magnéticamente a Cierre Comercial."
        ]);
    }

    public function cerrarObraPerdida(Request $request)
    {
        $request->validate([
            'obra_id'       => 'required|exists:obras,id',
            'motivo'        => 'required|string|min:4|max:1000',
            'tipo_contacto' => 'nullable|string|max:100',
            'cotizacion_id' => 'nullable|exists:cotizaciones,id',
        ]);

        $obra = Obra::with(['cliente', 'cotizaciones'])->findOrFail($request->obra_id);

        DB::transaction(function () use ($obra, $request) {
            $obra->update(['estado' => 'Perdida']);

            if ($request->filled('cotizacion_id')) {
                $cot = Cotizacion::find($request->cotizacion_id);
                if ($cot) {
                    $cot->update([
                        'estado_cotizacion' => 'Rechazada',
                        'motivo_rechazo'    => trim($request->motivo),
                    ]);
                }
            }

            $tipoContacto = $request->filled('tipo_contacto') ? trim($request->tipo_contacto) : 'Llamada Telefónica';

            Bitacora::create([
                'obra_id'       => $obra->id,
                'user_id'       => Auth::id() ?? $obra->user_id ?? 1,
                'tipo_contacto' => $tipoContacto,
                'comentario'    => trim($request->motivo),
            ]);

            if ($obra->cliente_id) {
                self::actualizarEstadoCliente($obra->cliente_id);
            }
        });

        return response()->json([
            'success' => true,
            'message' => 'Obra cerrada como Perdida y registrada en la bitácora técnica con éxito.'
        ]);
    }

    public function updateStatus(Request $request)
    {
        $request->validate([
            'obra_id'       => 'required|exists:obras,id',
            'nuevo_estado'  => 'required|string|in:Aceptada,Cancelada,Perdida',
            'motivo'        => 'nullable|string|max:1000',
            'tipo_contacto' => 'nullable|string|max:100',
        ]);

        return $this->archivar(new Request([
            'obra_id'       => $request->obra_id,
            'estado_final'  => $request->nuevo_estado,
            'motivo'        => $request->motivo,
            'tipo_contacto' => $request->tipo_contacto,
        ]));
    }

    public function archivar(Request $request)
    {
        $request->validate([
            'obra_id'       => 'required|exists:obras,id',
            'estado_final'  => 'required|string|in:Aceptada,Cancelada,Perdida',
            'motivo'        => 'nullable|string|max:1000',
            'tipo_contacto' => 'nullable|string|max:100',
        ]);

        $obra = Obra::with('cliente')->findOrFail($request->obra_id);

        DB::transaction(function () use ($obra, $request) {
            $cotizacionReciente = Cotizacion::where('obra_id', $obra->id)->latest('id')->first();
            if ($cotizacionReciente && $cotizacionReciente->monto_total > 0) {
                $obra->monto = $cotizacionReciente->monto_total;
            }

            $obra->estado = $request->estado_final;
            $obra->save();

            if ($request->estado_final === 'Aceptada') {
                Cotizacion::where('obra_id', $obra->id)->update([
                    'estado_cotizacion' => 'Aceptada'
                ]);
            } else {
                Cotizacion::where('obra_id', $obra->id)->update([
                    'estado_cotizacion' => 'Rechazada',
                    'motivo_rechazo'    => $request->filled('motivo') ? trim($request->motivo) : 'Cancelada en Cierre Comercial.'
                ]);
            }

            if ($request->filled('motivo')) {
                $tipoContacto = $request->filled('tipo_contacto') ? trim($request->tipo_contacto) : 'Llamada Telefónica';
                Bitacora::create([
                    'obra_id'       => $obra->id,
                    'user_id'       => Auth::id() ?? $obra->user_id ?? 1,
                    'tipo_contacto' => $tipoContacto,
                    'comentario'    => trim($request->motivo),
                ]);
            }

            if ($obra->cliente_id) {
                self::actualizarEstadoCliente($obra->cliente_id);
            }
        });

        return response()->json([
            'success' => true,
            'message' => "Expediente finalizado como {$request->estado_final} y archivado en el Historial."
        ]);
    }

    public function agregarBitacora(Request $request)
{
    $request->validate([
        'obra_id'       => 'required|exists:obras,id',
        'tipo_contacto' => 'required|string|max:100',
        'descripcion'   => 'required|string|min:4|max:1000',
    ]);

    Bitacora::create([
        'obra_id'       => $request->obra_id,
        'user_id'       => Auth::id() ?? 1,
        'tipo_contacto' => $request->tipo_contacto,
        'comentario'    => trim($request->descripcion),
    ]);

    return response()->json([
        'success' => true, 
        'message' => 'Nota registrada en la bitácora técnica.'
    ]);
}

    public function store(Request $request)
    {
        $request->merge(['titulo' => trim(preg_replace('/\s+/', ' ', $request->titulo))]);

        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'titulo'     => [
                'required', 'string', 'min:5', 'max:255',
                \Illuminate\Validation\Rule::unique('obras', 'titulo')->where(function ($query) use ($request) {
                    return $query->where('cliente_id', $request->cliente_id);
                }),
            ],
            'monto'      => 'required|numeric|gt:0|max:999999999',
            'fecha'      => 'nullable|date',
        ]);

        $ultimoId = Obra::max('id') ?? 0;
        $codigo = 'OBR-' . str_pad($ultimoId + 1, 3, '0', STR_PAD_LEFT);
        while (Obra::where('codigo', $codigo)->exists()) {
            $ultimoId++;
            $codigo = 'OBR-' . str_pad($ultimoId + 1, 3, '0', STR_PAD_LEFT);
        }

        $obra = Obra::create([
            'cliente_id' => $request->cliente_id,
            'user_id'    => Auth::id() ?? 1,
            'codigo'     => $codigo,
            'titulo'     => $request->titulo,
            'monto'      => $request->monto,
            'estado'     => 'Prospecto',
            'fecha'      => $request->fecha ?? now(),
        ]);

        if ($obra->cliente_id) {
            self::actualizarEstadoCliente($obra->cliente_id);
        }

        return response()->json(['success' => true, 'message' => "Expediente {$codigo} registrado en Prospecto."]);
    }

public function historial(Request $request)
{
    $search = trim((string) $request->input('search', ''));

    // Incluye tanto 'Aceptada' como 'Ganada', además de 'Cancelada' y 'Perdida'
    $obrasHistorial = Obra::with(['cliente', 'user', 'inspecciones', 'cotizaciones.detalles.partida'])
        ->whereIn('estado', ['Aceptada', 'Ganada', 'Cancelada', 'Perdida'])
        ->when($search !== '', function ($query) use ($search) {
            // Agrupación de condiciones para no anular el whereIn anterior
            $query->where(function ($q) use ($search) {
                $q->where('codigo', 'like', "%{$search}%")
                  ->orWhere('titulo', 'like', "%{$search}%")
                  ->orWhereHas('cliente', function ($c) use ($search) {
                      $c->where('razon_social', 'like', "%{$search}%");
                  });
            });
        })
        ->latest('updated_at')
        ->paginate(15)
        ->withQueryString();

    return view('comercial.pipeline.historial', compact('obrasHistorial', 'search'));
}

    public static function actualizarEstadoCliente(int $clienteId)
    {
        $cliente = Cliente::with('obras')->find($clienteId);
        if (!$cliente) return;

        $tieneAceptadas = $cliente->obras->whereIn('estado', ['Aceptada', 'Ganada'])->count() > 0;
        $tieneActivas   = $cliente->obras->whereNotIn('estado', ['Aceptada', 'Ganada', 'Cancelada', 'Perdida'])->count() > 0;

        // Si tiene obras en curso (Prospecto, Inspeccion, Cotización, Cierre Comercial) -> EN_EVALUACION ("En Proceso")
        // Si no tiene activas pero tiene Aceptadas -> ACTIVO
        // De lo contrario -> INACTIVO
        $nuevoEstado = $tieneActivas ? 'EN_EVALUACION' : ($tieneAceptadas ? 'ACTIVO' : 'INACTIVO');
        $cliente->update(['estado' => $nuevoEstado]);
    }
}