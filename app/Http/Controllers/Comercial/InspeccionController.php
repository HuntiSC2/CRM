<?php

namespace App\Http\Controllers\Comercial;

use App\Http\Controllers\Controller;
use App\Models\Inspeccion;
use Illuminate\Http\Request;

class InspeccionController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Consulta de auditoría histórica y trazabilidad técnica
        $inspecciones = Inspeccion::with(['obra.cliente', 'user'])
            ->when($search, function ($query, $search) {
                return $query->where('resultado', 'like', '%' . $search . '%')
                             ->orWhere('estado_inspeccion', 'like', '%' . $search . '%')
                             ->orWhere('ingeniero_asignado', 'like', '%' . $search . '%')
                             ->orWhereHas('obra', function ($q) use ($search) {
                                 $q->where('titulo', 'like', '%' . $search . '%')
                                   ->orWhere('codigo', 'like', '%' . $search . '%')
                                   ->orWhereHas('cliente', function ($c) use ($search) {
                                       $c->where('razon_social', 'like', '%' . $search . '%');
                                   });
                             });
            })
            ->latest()
            ->paginate(10);

        return view('comercial.visitas.index', compact('inspecciones'));
    }

    /**
     * Completar una inspección técnica existente si se requiere desde este panel
     */
    public function completar(Request $request, $id)
    {
        $request->validate([
            'resultado' => 'required|string|min:5',
        ]);

        $inspeccion = Inspeccion::findOrFail($id);
        $inspeccion->resultado = $request->resultado;
        $inspeccion->estado_inspeccion = 'Completada';
        $inspeccion->save();

        return redirect()->route('comercial.visitas.index')
                         ->with('success', "Inspección #INS-{$inspeccion->id} completada exitosamente.");
    }
}