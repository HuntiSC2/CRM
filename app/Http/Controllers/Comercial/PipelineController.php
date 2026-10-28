<?php




namespace App\Http\Controllers\Comercial;

use App\Http\Controllers\Controller;
use App\Models\Obra;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PipelineController extends Controller
{
    public function index()
    {
        $statuses = ['Por Visitar', 'Cotizado', 'Aprobado'];

        // Consultar las obras reales registradas en la base de datos
        $obrasQuery = Obra::with('cliente')->latest()->get();

        $obras = [
            'Por Visitar' => [],
            'Cotizado'    => [],
            'Aprobado'    => [],
        ];

        foreach ($obrasQuery as $obra) {
            $estado = $obra->estado;
            if (!array_key_exists($estado, $obras)) {
                $obras[$estado] = [];
            }

            $obras[$estado][] = [
                'id'      => $obra->id,
                'codigo'  => $obra->codigo ?? 'OBR-' . str_pad($obra->id, 3, '0', STR_PAD_LEFT),
                'titulo'  => $obra->titulo,
                'cliente' => $obra->cliente ? $obra->cliente->razon_social : 'Sin Cliente',
                'monto'   => 'S/ ' . number_format($obra->monto, 2),
                'fecha'   => $obra->fecha ? date('d/m/Y', strtotime($obra->fecha)) : '',
            ];
        }

        // Obtener clientes activos para el dropdown del modal
        $clientes = Cliente::orderBy('razon_social', 'asc')->get();

        return view('comercial.pipeline.index', compact('statuses', 'obras', 'clientes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'titulo'     => 'required|string|max:255',
            'monto'      => 'required|numeric|min:0',
            'estado'     => 'required|string',
            'fecha'      => 'nullable|date',
        ]);

        $count = Obra::count() + 1;
        $codigo = 'OBR-' . str_pad($count, 3, '0', STR_PAD_LEFT);

        Obra::create([
            'cliente_id' => $request->cliente_id,
            'user_id'    => Auth::id() ?? 2,
            'codigo'     => $codigo,
            'titulo'     => $request->titulo,
            'monto'      => $request->monto,
            'estado'     => $request->estado,
            'fecha'      => $request->fecha ?? now(),
        ]);

        return redirect()->route('comercial.pipeline.index')
                         ->with('success', 'Nueva obra registrada en el Pipeline comercial.');
    }

    public function updateStatus(Request $request)
    {
        $request->validate([
            'obra_id'      => 'required',
            'nuevo_estado' => 'required|string',
        ]);

        $obra = Obra::find($request->obra_id);
        if ($obra) {
            $obra->estado = $request->nuevo_estado;
            $obra->save();

            return response()->json([
                'success' => true,
                'message' => 'Estado de la obra actualizado correctamente en el Kanban.'
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Obra no encontrada.'], 404);
    }
}