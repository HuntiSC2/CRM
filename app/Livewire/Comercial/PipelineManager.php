<?php

namespace App\Livewire\Comercial;

use Livewire\Component;
use App\Models\Obra;
use App\Models\Cliente;

class PipelineManager extends Component
{
    public bool $mostrarFormulario = false;
    
    // Propiedades del formulario con tipos de datos explícitos
    public ?int $cliente_id = null;
    public ?string $titulo = null;
    public ?float $monto = null;
    public string $estado = 'Inspección';
    public ?string $fecha = null;

    protected array $rules = [
        'cliente_id' => 'required|exists:clientes,id',
        'titulo'     => 'required|string|max:255',
        'monto'      => 'required|numeric|min:0',
        'estado'     => 'required|string',
        'fecha'      => 'nullable|date',
    ];

    public function mount(): void
    {
        $this->fecha = date('Y-m-d');
    }

    public function abrirFormulario(): void
    {
        $this->resetErrorBag();
        $this->mostrarFormulario = true;
    }

    public function cerrarFormulario(): void
    {
        $this->mostrarFormulario = false;
        $this->reset(['cliente_id', 'titulo', 'monto']);
        $this->estado = 'Inspección';
        $this->fecha = date('Y-m-d');
    }

    public function guardarObra(): void
    {
        $this->validate();

        $ultimoId = Obra::max('id') ?? 0;
        $codigoObra = 'OBR-' . str_pad($ultimoId + 1, 3, '0', STR_PAD_LEFT);

        Obra::create([
            'codigo'     => $codigoObra,
            'cliente_id' => $this->cliente_id,
            'titulo'     => $this->titulo,
            'monto'      => $this->monto,
            'estado'     => $this->estado,
            'fecha'      => $this->fecha ?? date('Y-m-d'),
            'user_id'    => auth()->id(),
        ]);

        session()->flash('success', 'Expediente ' . $codigoObra . ' registrado correctamente al instante.');

        $this->cerrarFormulario();
    }

    public function render()
    {
        $statuses = ['Inspección', 'Cotizado', 'Aprobado'];
        $clientes = Cliente::all();
        
        $obras = [];
        foreach ($statuses as $st) {
            $obras[$st] = Obra::with('cliente')
                ->where('estado', $st)
                ->get()
                ->map(function($obra) {
                    return [
                        'id'      => $obra->id,
                        'codigo'  => $obra->codigo ?? 'OBR-00' . $obra->id,
                        'titulo'  => $obra->titulo,
                        'cliente' => $obra->cliente->razon_social ?? 'Sin Cliente',
                        'monto'   => 'S/ ' . number_format($obra->monto, 2)
                    ];
                });
        }

        return view('livewire.comercial.pipeline-manager', compact('statuses', 'clientes', 'obras'));
    }
}