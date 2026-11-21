<?php

namespace App\Http\Controllers\Comercial;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Http\Requests\ClienteRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClienteController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        
        $clientes = Cliente::with(['user', 'obras'])
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('ruc', 'like', "%{$search}%")
                      ->orWhere('razon_social', 'like', "%{$search}%")
                      ->orWhere('nombre_contacto', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10);

        return view('comercial.clientes.index', compact('clientes', 'search'));
    }

    public function show($id)
    {
        $cliente = Cliente::with([
            'user',
            'obras.inspecciones',
            'obras.cotizaciones',
        ])->findOrFail($id);

        return view('comercial.clientes.show', compact('cliente'));
    }

    public function create()
    {
        return view('comercial.clientes.create');
    }

    public function store(ClienteRequest $request)
    {
        $data = $request->validated();

        $cliente = Cliente::create([
            'ruc'               => $data['ruc'],
            'razon_social'      => $data['razon_social'],
            'direccion'         => $data['direccion'] ?? null,
            'nombre_contacto'   => $data['nombre_contacto'],
            'telefono_contacto' => $data['telefono_contacto'],
            'email_contacto'    => $data['email_contacto'],
            'estado'            => 'INACTIVO', 
            'observaciones'     => $data['observaciones'] ?? null,
            'user_id'           => Auth::id(),
        ]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Ficha del cliente/contratista registrada correctamente.',
                'cliente' => $cliente
            ], 200);
        }

        return redirect()->route('comercial.clientes.index')
            ->with('success', 'Ficha del cliente/contratista registrada correctamente.');
    }

    /**
     * Da de baja a un cliente activo con validación estricta de obras/pipeline.
     */
    public function toggleEstado($id)
    {
        $cliente = Cliente::with('obras')->findOrFail($id);
        $estadoActual = $cliente->estado_dinamico;

        // Si el cliente está en proceso (con obras en Prospecto, Inspección, Cotización o Cierre Comercial)
        if ($estadoActual === 'EN_PROCESO') {
            return back()->with('error', "No es posible darle de baja porque el cliente {$cliente->razon_social} está siendo evaluado en el pipeline comercial.");
        }

        // Si el cliente está Activo (obra Aceptada/culminada) -> pasa a INACTIVO
        if ($estadoActual === 'ACTIVO') {
            $cliente->update(['estado' => 'INACTIVO']);
            return back()->with('success', "El cliente {$cliente->razon_social} ha sido dado de baja exitosamente (Estado: Inactivo).");
        }

        // Si ya está inactivo, se le informa que se reactiva automáticamente al registrarle una nueva obra en Prospecto
        if ($estadoActual === 'INACTIVO') {
            return back()->with('info', "El cliente {$cliente->razon_social} se encuentra Inactivo. Se reactivará automáticamente a 'En Proceso' cuando registre una nueva obra en Prospecto desde el Pipeline.");
        }

        return back();
    }

    public function checkRuc(Request $request)
    {
        $exists = Cliente::where('ruc', $request->ruc)->exists();
        return response()->json(['exists' => $exists]);
    }
}