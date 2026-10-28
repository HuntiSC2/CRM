<?php

namespace App\Http\Controllers\Comercial;

use App\Http\Controllers\Controller;
use App\Models\Cotizacion;
use App\Models\Inspeccion;
use App\Models\Obra;
use Illuminate\Http\Request;

class CotizadorController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $cotizaciones = Cotizacion::with(['obra', 'user'])
            ->when($search, function ($query, $search) {
                return $query->where('codigo_cotizacion', 'like', '%' . $search . '%')
                             ->orWhere('estado_cotizacion', 'like', '%' . $search . '%')
                             ->orWhereHas('obra', function ($q) use ($search) {
                                 $q->where('titulo', 'like', '%' . $search . '%')
                                   ->orWhere('codigo', 'like', '%' . $search . '%');
                             });
            })
            ->latest()
            ->paginate(10);

        // -----------------------------------------------------------------
        // REGLA DE NEGOCIO (Filtro Dinámico): 
        // Solo mostrar obras que tengan inspección completada Y QUE NO TENGAN 
        // una cotización en estado "Aceptada" (proyecto cerrado/culminado).
        // -----------------------------------------------------------------
        $obrasDisponibles = Obra::whereHas('inspecciones', function ($query) {
            $query->where('estado_inspeccion', 'Completada');
        })
        ->whereDoesntHave('cotizaciones', function ($query) {
            $query->where('estado_cotizacion', 'Aceptada');
        })
        ->select('id', 'codigo', 'titulo', 'estado')
        ->get();

        // Generación automática del correlativo (COT-2026-XXXX)
        $anioActual = date('Y');
        $ultimaCotizacion = Cotizacion::where('codigo_cotizacion', 'like', "COT-{$anioActual}-%")
            ->orderBy('id', 'desc')
            ->first();

        $nuevoNumero = $ultimaCotizacion ? intval(explode('-', $ultimaCotizacion->codigo_cotizacion)[2] ?? 0) + 1 : 1;
        $nuevoCodigo = 'COT-' . $anioActual . '-' . str_pad($nuevoNumero, 4, '0', STR_PAD_LEFT);

        return view('comercial.cotizador.index', compact('cotizaciones', 'obrasDisponibles', 'nuevoCodigo'));
    }

    public function store(Request $request)
    {
        // Generar código blindado en servidor
        $anioActual = date('Y');
        $ultimaCotizacion = Cotizacion::where('codigo_cotizacion', 'like', "COT-{$anioActual}-%")
            ->orderBy('id', 'desc')
            ->first();
        
        $nuevoNumero = $ultimaCotizacion ? intval(explode('-', $ultimaCotizacion->codigo_cotizacion)[2] ?? 0) + 1 : 1;
        $codigoOficial = 'COT-' . $anioActual . '-' . str_pad($nuevoNumero, 4, '0', STR_PAD_LEFT);

        $request->merge(['codigo_cotizacion' => $codigoOficial]);

        $request->validate([
            'codigo_cotizacion' => 'required|string|unique:cotizaciones,codigo_cotizacion',
            'obra_id'           => 'required|exists:obras,id',
            'monto_total'       => 'required|numeric|min:0',
            'validez_dias'      => 'nullable|integer|min:1',
            'observaciones'     => 'nullable|string',
        ]);

        // 1. Validar que la obra tenga Inspección Técnica Completada
        $inspeccionCompletada = Inspeccion::where('obra_id', $request->obra_id)
            ->where('estado_inspeccion', 'Completada')
            ->first();

        if (!$inspeccionCompletada) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Restricción del Pipeline: La obra seleccionada no cuenta con una Inspección Técnica en estado "Completada".');
        }

        // -----------------------------------------------------------------
        // 2. VALIDACIÓN DE ESTADOS DUPLICADOS (Evitar múltiples "Enviadas")
        // -----------------------------------------------------------------
        $cotizacionActiva = Cotizacion::where('obra_id', $request->obra_id)
            ->where('estado_cotizacion', 'Enviada')
            ->first();

        if ($cotizacionActiva) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Restricción de Estado CRM: Esta obra ya cuenta con una cotización activa en estado "Enviada" (' . $cotizacionActiva->codigo_cotizacion . '). Debe esperar a que sea Aceptada o Rechazada antes de emitir otra.');
        }

        // 3. Crear la Cotización forzando el estado inicial "Enviada" por seguridad de negocio
        Cotizacion::create([
            'obra_id'           => $request->obra_id,
            'codigo_cotizacion' => $request->codigo_cotizacion,
            'monto_total'       => $request->monto_total,
            'validez_dias'      => $request->validez_dias ?? 15,
            'estado_cotizacion' => 'Enviada', // <--- Asignado automáticamente por el sistema
            'observaciones'     => $request->observaciones,
        ]);

        // Sincronizar estado de la obra (Al emitir cotización pasa automáticamente a "Cotizado")
        $obra = Obra::find($request->obra_id);
        if ($obra) {
            $obra->update(['estado' => 'Cotizado']);
        }

        return redirect()->route('comercial.cotizador.index')
                         ->with('success', 'Cotización ' . $request->codigo_cotizacion . ' emitida correctamente bajo control de estados.');
    }
}