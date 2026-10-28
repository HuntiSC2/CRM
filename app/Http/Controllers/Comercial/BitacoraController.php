<?php

namespace App\Http\Controllers\Comercial;

use App\Http\Controllers\Controller;
use App\Models\Bitacora; // <--- Añade esta importación
use App\Models\Obra;     // <--- Añade esta importación
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class BitacoraController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $bitacoras = Bitacora::with(['obra', 'user'])
            ->when($search, function ($query, $search) {
                return $query->where('comentario', 'like', "%{$search}%")
                             ->orWhere('tipo_contacto', 'like', "%{$search}%")
                             ->orWhereHas('obra', function ($q) use ($search) {
                                 $q->where('titulo', 'like', "%{$search}%");
                             });
            })
            ->latest()
            ->paginate(10);

        $obras = Obra::select('id', 'titulo')->get();

        return view('comercial.bitacora.index', compact('bitacoras', 'obras'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'obra_id' => 'required|exists:obras,id',
            'tipo_contacto' => 'required|string',
            'comentario' => 'required|string',
        ]);

        Bitacora::create([
            'obra_id' => $request->obra_id,
            'user_id' => Auth::id(),
            'tipo_contacto' => $request->tipo_contacto,
            'comentario' => $request->comentario,
        ]);

        return redirect()->route('comercial.bitacora.index')
                         ->with('success', 'Anotación registrada correctamente en la bitácora.');
    }
}