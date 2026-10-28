<?php

namespace App\Http\Controllers\Comercial;

use App\Http\Controllers\Controller;
use App\Models\Inspeccion;
use App\Models\Obra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InspeccionController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $inspecciones = Inspeccion::with(['obra', 'user'])
            ->when($search, function ($query, $search) {
                return $query->where('resultado', 'like', '%' . $search . '%')
                             ->orWhere('estado_inspeccion', 'like', '%' . $search . '%')
                             ->orWhere('ingeniero_asignado', 'like', '%' . $search . '%')
                             ->orWhereHas('obra', function ($q) use ($search) {
                                 $q->where('titulo', 'like', '%' . $search . '%')
                                   ->orWhere('codigo', 'like', '%' . $search . '%');
                             });
            })
            ->latest()
            ->paginate(10);

        // REGLA CRM: Obras disponibles (sin inspección pendiente activa con usuario activo)
        $obrasDisponibles = Obra::whereDoesntHave('inspecciones', function ($query) {
            $query->where('estado_inspeccion', 'Pendiente')
                  ->whereHas('user', function ($q) {
                      $q->where('is_active', true);
                  });
        })->get();

        return view('comercial.visitas.index', compact('inspecciones', 'obrasDisponibles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'obra_id' => 'required|exists:obras,id',
            'ingeniero_asignado' => 'required|string|max:255',
            'fecha_inspeccion' => 'required|date',
            'resultado' => 'nullable|string',
            'estado_inspeccion' => 'required|string',
        ]);

        $user = Auth::user();

        // REGLA CRM: Validar que otro usuario activo no tenga el seguimiento en curso de esta obra
        $inspeccionActiva = Inspeccion::where('obra_id', $request->obra_id)
            ->where('estado_inspeccion', 'Pendiente')
            ->whereHas('user', function ($q) {
                $q->where('is_active', true);
            })
            ->first();

        if ($inspeccionActiva && $inspeccionActiva->user_id !== $user->id) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Restricción CRM: Esta obra ya cuenta con un seguimiento activo asignado a otro asesor. Solo se puede retomar si el usuario anterior se encuentra inactivo.');
        }

        // Crear la inspección guardando el ingeniero asignado
        Inspeccion::create([
            'obra_id' => $request->obra_id,
            'user_id' => $user->id,
            'ingeniero_asignado' => $request->ingeniero_asignado,
            'fecha_inspeccion' => $request->fecha_inspeccion,
            'resultado' => $request->resultado,
            'estado_inspeccion' => $request->estado_inspeccion,
        ]);

        // Sincronizar automáticamente el estado de la obra en el Pipeline CRM
        $obra = Obra::find($request->obra_id);
        if ($obra && $request->estado_inspeccion === 'Completada') {
            $obra->update(['estado' => 'Cotizado']);
        }

        // Redirección corregida al nombre real de la ruta
        return redirect()->route('comercial.visitas.index')
                         ->with('success', 'Inspección técnica registrada correctamente y sincronizada en el Pipeline CRM.');
    }
}