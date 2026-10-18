<?php

namespace App\Http\Controllers\Comercial;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Http\Requests\ClienteRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClienteController extends Controller
{
    /**
     * Muestra el directorio de clientes/contratistas con búsqueda y paginación.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        
        $clientes = Cliente::with('user')
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

    /**
     * Muestra el formulario para registrar una nueva ficha.
     */
    public function create()
    {
        return view('comercial.clientes.create');
    }

    /**
     * Guarda la ficha comercial en MySQL utilizando validación mediante ClienteRequest.
     */
    public function store(ClienteRequest $request)
    {
        // Se valida a través de ClienteRequest y se extraen los datos validados
        $data = $request->validated();

        Cliente::create([
            'ruc'               => $data['ruc'],
            'razon_social'      => $data['razon_social'],
            'direccion'         => $data['direccion'] ?? null,
            'nombre_contacto'   => $data['nombre_contacto'],
            'telefono_contacto' => $data['telefono_contacto'],
            'email_contacto'    => $data['email_contacto'],
            'estado'            => $data['estado'] ?? 'ACTIVO',
            'observaciones'     => $data['observaciones'] ?? null,
            'user_id'           => Auth::id(),
        ]);

        return redirect()->route('comercial.clientes.index')
            ->with('success', 'Ficha del cliente/contratista registrada correctamente.');
    }

    /**
     * Endpoint ultraligero AJAX para detección asíncrona de RUC duplicado.
     */
    public function checkRuc(Request $request)
    {
        $exists = Cliente::where('ruc', $request->ruc)->exists();
        return response()->json(['exists' => $exists]);
    }
}