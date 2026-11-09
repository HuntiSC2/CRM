<?php

namespace App\Http\Controllers\Comercial;

use App\Http\Controllers\Controller;
use App\Models\Obra;
use App\Models\Cliente;
use App\Models\Inspeccion;
use App\Models\Cotizacion;
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

        $obrasQuery = Obra::with(['cliente', 'inspecciones', 'cotizaciones'])
            ->whereNotIn('estado', ['Aceptada', 'Cancelada'])
            ->latest()
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
            $estado = $obra->estado;

            if (array_key_exists($estado, $obras)) {
                $inspeccionPendiente  = $obra->inspecciones->where('estado_inspeccion', 'Pendiente')->sortByDesc('id')->first();
                $inspeccionCompletada = $obra->inspecciones->where('estado_inspeccion', 'Completada')->sortByDesc('id')->first();

                $cotizacionPendiente  = $obra->cotizaciones->where('estado_cotizacion', 'Programada')->sortByDesc('id')->first();
                $cotizacionEnviada    = $obra->cotizaciones->whereIn('estado_cotizacion', ['Enviada', 'Aprobada', 'Aceptada'])->sortByDesc('id')->first();
                
                $ultimaCotizacion     = $obra->cotizaciones->sortByDesc('id')->first();
                $cotizacionAceptada   = $obra->cotizaciones->where('estado_cotizacion', 'Aceptada')->first();
                $cotizacionRechazada  = $obra->cotizaciones->where('estado_cotizacion', 'Rechazada')->first();

                $obras[$estado][] = [
                    'id'                            => $obra->id,
                    'codigo'                        => $obra->codigo ?? ('OBR-' . str_pad($obra->id, 3, '0', STR_PAD_LEFT)),
                    'titulo'                        => $obra->titulo,
                    'cliente'                       => $obra->cliente ? $obra->cliente->razon_social : 'Sin Cliente',
                    'monto'                         => 'S/ ' . number_format($obra->monto, 2),
                    'monto_raw'                     => (float) $obra->monto,
                    'fecha'                         => $obra->fecha ? Carbon::parse($obra->fecha)->format('d/m/Y') : '',
                    'estado'                        => $obra->estado,
                    
                    // Inspección
                    'tiene_inspeccion_pendiente'    => !is_null($inspeccionPendiente),
                    'inspeccion_pendiente_id'       => $inspeccionPendiente?->id,
                    'inspeccion_ingeniero'          => $inspeccionPendiente?->ingeniero_asignado ?? 'No asignado',
                    'inspeccion_fecha'              => $inspeccionPendiente?->fecha_inspeccion ? Carbon::parse($inspeccionPendiente->fecha_inspeccion)->format('d/m/Y H:i') : '-',
                    'inspeccion_es_completada'      => !is_null($inspeccionCompletada),
                    
                    // Cotización
                    'tiene_cotizacion_pendiente'    => !is_null($cotizacionPendiente),
                    'cotizacion_pendiente_id'       => $cotizacionPendiente?->id,
                    'cotizacion_pendiente_codigo'   => $cotizacionPendiente?->codigo_cotizacion,
                    'cotizacion_es_completada'      => !is_null($cotizacionEnviada),
                    'cotizacion_es_rechazada'       => !is_null($cotizacionRechazada) && is_null($cotizacionEnviada) && is_null($cotizacionPendiente),
                    
                    // Cierre
                    'tiene_cotizacion_aceptada'     => !is_null($cotizacionAceptada),
                    'tiene_cotizacion_rechazada'    => !is_null($cotizacionRechazada),
                    'estado_cotizacion_final'       => $ultimaCotizacion?->estado_cotizacion,
                ];

                $totalesPorColumna[$estado] += (float) $obra->monto;
            }
        }

        $clientes = Cliente::orderBy('razon_social', 'asc')->get();

        return view('comercial.pipeline.index', compact('statuses', 'obras', 'totalesPorColumna', 'clientes'));
    }

    /**
     * 1. AGENDAR INSPECCIÓN:
     * HITO TÉCNICO -> Fuerza la reubicación automática a la columna 'Inspeccion'.
     */
    public function agendarInspeccion(Request $request)
    {
        $request->validate([
            'obra_id'            => 'required|exists:obras,id',
            'ingeniero_asignado' => 'required|string|min:3|max:150',
            'fecha_inspeccion'   => 'required|date',
            'contacto_nombre'    => 'nullable|string|max:150',
            'contacto_telefono'  => 'nullable|string|max:50',
        ]);

        DB::transaction(function () use ($request) {
            Inspeccion::create([
                'obra_id'            => $request->obra_id,
                'user_id'            => Auth::id() ?? 1,
                'ingeniero_asignado' => $request->ingeniero_asignado,
                'fecha_inspeccion'   => $request->fecha_inspeccion,
                'contacto_nombre'    => $request->contacto_nombre,
                'contacto_telefono'  => $request->contacto_telefono,
                'estado_inspeccion'  => 'Pendiente',
                'resultado'          => null,
            ]);

            // REGLA: Sin importar en qué columna esté, salta inmediatamente a 'Inspeccion'
            $obra = Obra::find($request->obra_id);
            if ($obra && $obra->estado !== 'Inspeccion') {
                $obra->update(['estado' => 'Inspeccion']);
                self::actualizarEstadoCliente($obra->cliente_id);
            }
        });

        return response()->json([
            'success' => true,
            'message' => 'Inspección agendada. El expediente avanzó a la columna Inspeccion.'
        ]);
    }

    /**
     * 2. COMPLETAR INSPECCIÓN:
     * HITO TÉCNICO -> Dictamen realizado. Fuerza la reubicación a 'Cotización'.
     */
    public function completarInspeccion(Request $request)
    {
        $request->validate([
            'inspeccion_id' => 'required|exists:inspecciones,id',
            'resultado'     => 'required|string|min:4',
        ]);

        $inspeccion = Inspeccion::with('obra')->findOrFail($request->inspeccion_id);

        DB::transaction(function () use ($inspeccion, $request) {
            $fechaActual = now();
            $inspeccion->update([
                'resultado'         => trim($request->resultado) . " (Completada el {$fechaActual->format('d/m/Y H:i')})",
                'estado_inspeccion' => 'Completada',
                'updated_at'        => $fechaActual
            ]);

            // REGLA: Al emitir el informe técnico, avanza directamente a 'Cotización'
            if ($inspeccion->obra && $inspeccion->obra->estado !== 'Cotización') {
                $inspeccion->obra->update(['estado' => 'Cotización']);
                self::actualizarEstadoCliente($inspeccion->obra->cliente_id);
            }
        });

        return response()->json([
            'success' => true,
            'message' => 'Inspección completada. El expediente avanzó a la columna Cotización.'
        ]);
    }

    /**
     * 3. PROGRAMAR COTIZACIÓN:
     * HITO TÉCNICO -> Prepara la emisión y asegura la obra en 'Cotización'.
     */
    public function programarCotizacion(Request $request)
    {
        $request->validate([
            'obra_id'       => 'required|exists:obras,id',
            'fecha_emision' => 'required|date',
        ]);

        $obra = Obra::findOrFail($request->obra_id);

        $anioActual = date('Y');
        $ultimaCotizacion = Cotizacion::where('codigo_cotizacion', 'like', "COT-{$anioActual}-%")
            ->orderBy('id', 'desc')
            ->first();

        $nuevoNumero = $ultimaCotizacion ? intval(explode('-', $ultimaCotizacion->codigo_cotizacion)[2] ?? 0) + 1 : 1;
        $nuevoCodigo = 'COT-' . $anioActual . '-' . str_pad($nuevoNumero, 4, '0', STR_PAD_LEFT);

        $validezDias = 15;
        $fechaEmision = Carbon::parse($request->fecha_emision);
        $fechaVencimiento = (clone $fechaEmision)->addDays($validezDias);

        DB::transaction(function () use ($obra, $nuevoCodigo, $fechaEmision, $validezDias, $fechaVencimiento) {
            Cotizacion::create([
                'obra_id'           => $obra->id,
                'user_id'           => Auth::id() ?? 1,
                'codigo_cotizacion' => $nuevoCodigo,
                'monto_total'       => 0.00,
                'fecha_emision'     => $fechaEmision->toDateString(),
                'validez_dias'      => $validezDias,
                'fecha_vencimiento' => $fechaVencimiento->toDateString(),
                'estado_cotizacion' => 'Programada',
                'observaciones'     => null,
            ]);

            // REGLA: Fuerza su ubicación en 'Cotización'
            if ($obra->estado !== 'Cotización') {
                $obra->update(['estado' => 'Cotización']);
                self::actualizarEstadoCliente($obra->cliente_id);
            }
        });

        return response()->json([
            'success' => true,
            'message' => "Cotización {$nuevoCodigo} programada. Expediente ubicado en Cotización."
        ]);
    }

    /**
     * 4. EMITIR Y ENVIAR COTIZACIÓN:
     * HITO TÉCNICO -> Fija el monto real y fuerza la reubicación a 'Cierre Comercial'.
     */
    public function enviarCotizacion(Request $request)
    {
        $request->validate([
            'cotizacion_id' => 'required|exists:cotizaciones,id',
            'monto_total'   => 'required|numeric|gt:0',
            'observaciones' => 'nullable|string',
        ]);

        $cotizacion = Cotizacion::with('obra')->findOrFail($request->cotizacion_id);
        $fechaActual = now();

        DB::transaction(function () use ($cotizacion, $request, $fechaActual) {
            $cotizacion->update([
                'monto_total'        => $request->monto_total,
                'observaciones'      => $request->observaciones,
                'fecha_vencimiento'  => $fechaActual,
                'estado_cotizacion'  => 'Enviada',
                'updated_at'         => $fechaActual,
            ]);

            if ($cotizacion->obra) {
                // REGLA: Actualiza monto ofertado y salta automáticamente a 'Cierre Comercial'
                $cotizacion->obra->update([
                    'monto'  => $request->monto_total,
                    'estado' => 'Cierre Comercial'
                ]);
                self::actualizarEstadoCliente($cotizacion->obra->cliente_id);
            }
        });

        return response()->json([
            'success' => true,
            'message' => "Cotización emitida con éxito. Expediente trasladado a Cierre Comercial."
        ]);
    }

    /**
     * 5. BITÁCORA RÁPIDA:
     * Registro técnico sin alterar la posición actual del expediente.
     */
    public function agregarBitacora(Request $request)
    {
        $request->validate([
            'obra_id'     => 'required|exists:obras,id',
            'descripcion' => 'required|string|min:4|max:1000',
        ]);

        if (class_exists('App\\Models\\Bitacora')) {
            Bitacora::create([
                'obra_id'     => $request->obra_id,
                'user_id'     => Auth::id() ?? 1,
                'fecha'       => now(),
                'descripcion' => $request->descripcion,
                'tipo'        => 'Seguimiento',
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Nota registrada en la bitácora técnica.'
        ]);
    }

    public function store(Request $request)
    {
        $request->merge([
            'titulo' => trim(preg_replace('/\s+/', ' ', $request->titulo))
        ]);

        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'titulo'     => [
                'required',
                'string',
                'min:5',
                'max:255',
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

        return response()->json([
            'success' => true,
            'message' => "Expediente {$codigo} registrado en etapa Prospecto."
        ]);
    }

    /**
     * LIBERTAD VISUAL MANUAL:
     * El usuario puede mover con el cursor la tarjeta a la columna que guste.
     */
    public function updateStatus(Request $request)
    {
        $request->validate([
            'obra_id'      => 'required|exists:obras,id',
            'nuevo_estado' => 'required|string|in:Prospecto,Inspeccion,Cotización,Cierre Comercial,Aceptada,Cancelada',
        ]);

        $obra = Obra::find($request->obra_id);
        if (!$obra) {
            return response()->json(['success' => false, 'message' => 'Expediente no encontrado.'], 404);
        }

        // Si es cierre final (Aceptada / Cancelada), se delega a archivar
        if (in_array($request->nuevo_estado, ['Aceptada', 'Cancelada'])) {
            return $this->archivar(new Request([
                'obra_id'      => $obra->id,
                'estado_final' => $request->nuevo_estado
            ]));
        }

        $obra->estado = $request->nuevo_estado;
        $obra->save();

        if ($obra->cliente_id) {
            self::actualizarEstadoCliente($obra->cliente_id);
        }

        return response()->json(['success' => true, 'message' => "Expediente movido a {$request->nuevo_estado}."]);
    }

    public function archivar(Request $request)
    {
        $request->validate([
            'obra_id'      => 'required|exists:obras,id',
            'estado_final' => 'required|string|in:Aceptada,Cancelada',
        ]);

        $obra = Obra::with('cliente')->findOrFail($request->obra_id);

        DB::transaction(function () use ($obra, $request) {
            $cotizacionReciente = Cotizacion::where('obra_id', $obra->id)->latest()->first();
            if ($cotizacionReciente && $cotizacionReciente->monto_total > 0) {
                $obra->monto = $cotizacionReciente->monto_total;
            }

            $obra->estado = $request->estado_final;
            $obra->save();

            Cotizacion::where('obra_id', $obra->id)->update([
                'estado_cotizacion' => ($request->estado_final === 'Aceptada') ? 'Aceptada' : 'Rechazada'
            ]);

            if ($obra->cliente_id) {
                self::actualizarEstadoCliente($obra->cliente_id);
            }
        });

        return response()->json([
            'success' => true, 
            'message' => "Expediente finalizado exitosamente como {$request->estado_final}."
        ]);
    }

    public function eliminar(Request $request)
    {
        $request->validate(['obra_id' => 'required|exists:obras,id']);
        $obra = Obra::findOrFail($request->obra_id);

        $clienteId = $obra->cliente_id;
        $obra->delete();
        if ($clienteId) self::actualizarEstadoCliente($clienteId);

        return response()->json(['success' => true, 'message' => 'Expediente eliminado con éxito.']);
    }

    public function historial(Request $request)
    {
        $search = $request->input('search');
        $obrasHistorial = Obra::with(['cliente', 'user', 'inspecciones', 'cotizaciones'])
            ->when($search, function ($query, $search) {
                return $query->where('codigo', 'like', "%{$search}%")
                           ->orWhere('titulo', 'like', "%{$search}%")
                           ->orWhereHas('cliente', fn($q) => $q->where('razon_social', 'like', "%{$search}%"));
            })
            ->latest()
            ->paginate(10);

        return view('comercial.pipeline.historial', compact('obrasHistorial', 'search'));
    }

    public static function actualizarEstadoCliente(int $clienteId)
    {
        $cliente = Cliente::with('obras')->find($clienteId);
        if (!$cliente) return;

        $tieneAceptadas = $cliente->obras->where('estado', 'Aceptada')->count() > 0;
        $tieneActivas   = $cliente->obras->whereNotIn('estado', ['Aceptada', 'Cancelada'])->count() > 0;

        $nuevoEstado = $tieneAceptadas ? 'ACTIVO' : ($tieneActivas ? 'EN_EVALUACION' : 'INACTIVO');
        $cliente->update(['estado' => $nuevoEstado]);
    }
}