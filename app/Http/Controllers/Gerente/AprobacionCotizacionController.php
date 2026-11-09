<?php

namespace App\Http\Controllers\Gerente;

use App\Http\Controllers\Controller;
use App\Models\Cotizacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AprobacionCotizacionController extends Controller
{
    /**
     * Muestra la bandeja gerencial con métricas y cotizaciones filtradas.
     */
    public function index(Request $request): View
    {
        $tab        = $request->input('tab', 'enviadas');
        $search     = $request->input('search');
        $fechaDesde = $request->input('fecha_desde');
        $fechaHasta = $request->input('fecha_hasta');

        // Métricas superiores del panel gerencial
        $metricas = [
            'pendientes_count' => Cotizacion::where('estado_cotizacion', 'Enviada')->count(),
            'pendientes_monto' => Cotizacion::where('estado_cotizacion', 'Enviada')->sum('monto_total') ?? 0.00,
            'aprobadas_count'  => Cotizacion::where('estado_cotizacion', 'Aceptada')->count(),
            'rechazadas_count' => Cotizacion::where('estado_cotizacion', 'Rechazada')->count(),
        ];

        // Filtro por pestaña seleccionada
        $query = match ($tab) {
            'enviadas'   => Cotizacion::where('estado_cotizacion', 'Enviada'),
            'aceptadas'  => Cotizacion::where('estado_cotizacion', 'Aceptada'),
            'rechazadas' => Cotizacion::where('estado_cotizacion', 'Rechazada'),
            'todas'      => Cotizacion::query(),
            default      => Cotizacion::where('estado_cotizacion', 'Enviada'),
        };

        $cotizaciones = $query->with(['obra.cliente', 'comercial'])
            ->buscar($search)
            ->filtroFechas($fechaDesde, $fechaHasta)
            ->latest('fecha_emision')
            ->paginate(10)
            ->withQueryString();

        return view('gerencia.hu-07.index', compact('cotizaciones', 'metricas', 'tab', 'search'));
    }

    /**
     * Acepta y Firma Digitalmente la cotización: pasa de 'Enviada' a 'Aceptada'.
     * Afecta únicamente a la tabla 'cotizaciones'.
     */
    public function aceptar(Cotizacion $cotizacion): RedirectResponse
    {
        if ($cotizacion->estado_cotizacion !== 'Enviada') {
            return back()->with('error', "La cotización {$cotizacion->codigo_cotizacion} no se encuentra en estado Enviada para ser aceptada.");
        }

        DB::transaction(function () use ($cotizacion) {
            $usuario       = Auth::user();
            $usuarioNombre = $usuario->name ?? 'Gerencia General';
            $fechaFirma    = now()->format('d/m/Y H:i:s');
            $firmaDigital  = "[FIRMADO DIGITALMENTE Y ACEPTADO por: {$usuarioNombre} | ID: {$usuario->id} | Fecha-Hora: {$fechaFirma}]";

            // Se actualiza únicamente el estado y la auditoría de la cotización
            $cotizacion->update([
                'estado_cotizacion' => 'Aceptada',
                'observaciones'     => trim($cotizacion->observaciones . " | " . $firmaDigital)
            ]);
        });

        return back()->with('success', "Cotización {$cotizacion->codigo_cotizacion} firmada y aceptada exitosamente. Registro actualizado a ACEPTADA para auditoría.");
    }

    /**
     * Rechaza la cotización con motivo obligatorio para control de auditoría.
     * Afecta únicamente a la tabla 'cotizaciones'.
     */
    public function rechazar(Request $request, Cotizacion $cotizacion): RedirectResponse
    {
        $request->validate([
            'motivo_rechazo' => 'required|string|min:5|max:600'
        ], [
            'motivo_rechazo.required' => 'Debe ingresar obligatoriamente el motivo del rechazo.',
            'motivo_rechazo.min'      => 'El motivo del rechazo debe tener al menos 5 caracteres.'
        ]);

        if ($cotizacion->estado_cotizacion !== 'Enviada') {
            return back()->with('error', 'Solo se pueden rechazar cotizaciones que se encuentren en estado Enviada.');
        }

        DB::transaction(function () use ($request, $cotizacion) {
            $usuarioNombre = Auth::user()->name ?? 'Gerencia General';
            $fechaRechazo  = now()->format('d/m/Y H:i:s');

            // Se actualiza únicamente el estado y la auditoría de la cotización
            $cotizacion->update([
                'estado_cotizacion' => 'Rechazada',
                'motivo_rechazo'    => $request->input('motivo_rechazo'),
                'observaciones'     => trim($cotizacion->observaciones . " | [RECHAZADO por {$usuarioNombre} el {$fechaRechazo}]")
            ]);
        });

        return back()->with('success', "Cotización {$cotizacion->codigo_cotizacion} rechazada exitosamente. Registro actualizado para auditoría.");
    }
}