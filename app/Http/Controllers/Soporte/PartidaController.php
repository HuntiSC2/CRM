<?php

namespace App\Http\Controllers\Soporte;

use App\Http\Controllers\Controller;
use App\Models\Partida;
use App\Models\HistorialPrecioPartida;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PartidaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $partidas = Partida::with(['creador', 'historialPrecios.usuario'])
            ->when($search, function ($q) use ($search) {
                $q->where('codigo', 'like', "%{$search}%")
                  ->orWhere('descripcion', 'like', "%{$search}%")
                  ->orWhere('categoria', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10);

        return view('soporte.partidas.index', compact('partidas'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'codigo'          => 'required|string|unique:partidas,codigo|max:30',
            'descripcion'     => 'required|string|max:255',
            'categoria'       => 'required|string|max:100',
            'unidad_medida'   => 'required|string|max:20',
            'precio_unitario' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($data) {
            $partida = Partida::create(array_merge($data, [
                'user_id' => Auth::id() ?? 1,
            ]));

            HistorialPrecioPartida::create([
                'partida_id'      => $partida->id,
                'user_id'         => Auth::id() ?? 1,
                'precio_anterior' => 0.00,
                'precio_nuevo'    => $partida->precio_unitario,
                'motivo_cambio'   => 'Alta inicial de partida en tarifario',
            ]);
        });

        return redirect()->route('soporte.partidas.index')->with('success', 'Partida incorporada al catálogo exitosamente.');
    }

    public function update(Request $request, $id)
    {
        $partida = Partida::findOrFail($id);

        $data = $request->validate([
            'descripcion'     => 'required|string|max:255',
            'categoria'       => 'required|string|max:100',
            'unidad_medida'   => 'required|string|max:20',
            'precio_unitario' => 'required|numeric|min:0',
            'motivo_cambio'   => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($partida, $data, $request) {
            $precioAnterior = $partida->precio_unitario;

            if ((float)$precioAnterior !== (float)$data['precio_unitario']) {
                HistorialPrecioPartida::create([
                    'partida_id'      => $partida->id,
                    'user_id'         => Auth::id() ?? 1,
                    'precio_anterior' => $precioAnterior,
                    'precio_nuevo'    => $data['precio_unitario'],
                    'motivo_cambio'   => $request->input('motivo_cambio') ?: 'Actualización oficial de precio',
                ]);
            }

            $partida->update($data);
        });

        return redirect()->route('soporte.partidas.index')->with('success', 'Partida actualizada y registrada en la auditoría.');
    }

    public function destroy($id)
    {
        $partida = Partida::findOrFail($id);

        if ($partida->cotizaciones()->exists()) {
            return redirect()->back()->with('error', 'No se puede eliminar la partida: ya se encuentra cotizada en una o más obras.');
        }

        $partida->delete();
        return redirect()->route('soporte.partidas.index')->with('success', 'Partida eliminada correctamente.');
    }
}