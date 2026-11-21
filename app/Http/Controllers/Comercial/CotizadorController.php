<?php

namespace App\Http\Controllers\Comercial;

use App\Http\Controllers\Controller;
use App\Models\Cotizacion;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;

class CotizadorController extends Controller
{
    /**
     * Genera y visualiza el PDF oficial de la cotización de forma individual.
     */
    public function generarPdf($id)
    {
        try {
            // Cargamos la cotización con sus relaciones clave
            $cotizacion = Cotizacion::with(['obra.cliente', 'user', 'detalles.partida'])->findOrFail($id);

            $pdf = Pdf::loadView('comercial.cotizador.pdf', compact('cotizacion'))
                ->setPaper('a4', 'portrait')
                ->setOptions([
                    'isHtml5ParserEnabled' => true,
                    'isRemoteEnabled'      => true,
                    'chroot'               => public_path(),
                    'defaultFont'          => 'sans-serif'
                ]);

            return response($pdf->output(), 200, [
                'Content-Type'        => 'application/pdf',
                'Content-Disposition' => 'inline; filename="Cotizacion_' . $cotizacion->codigo_cotizacion . '.pdf"',
                'X-Frame-Options'     => 'SAMEORIGIN'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error'   => 'No se pudo generar el expediente PDF.',
                'detalle' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Listado y auditoría de cotizaciones con búsqueda y paginación optimizada.
     */
    public function index(Request $request)
    {
        $search = trim((string) $request->input('search', ''));

        $cotizaciones = Cotizacion::with(['obra.cliente', 'user', 'detalles.partida'])
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('codigo_cotizacion', 'like', "%{$search}%")
                      ->orWhere('estado_cotizacion', 'like', "%{$search}%")
                      ->orWhere('observaciones', 'like', "%{$search}%")
                      ->orWhereHas('obra', function ($sub) use ($search) {
                          $sub->where('titulo', 'like', "%{$search}%")
                              ->orWhere('codigo', 'like', "%{$search}%")
                              ->orWhereHas('cliente', function ($c) use ($search) {
                                  $c->where('razon_social', 'like', "%{$search}%");
                              });
                      });
                });
            })
            ->latest('id')
            ->paginate(10)
            ->withQueryString(); // Mantiene los filtros de búsqueda al pasar de página en celular

        // Sanitización segura: limpia el prefijo de corchetes [Fase #X ⇄ Inspección #X - Ing. ...]
        // Protegido contra valores NULL para evitar cualquier error en PHP
        $cotizaciones->getCollection()->transform(function ($cotizacion) {
            $raw = (string) ($cotizacion->observaciones ?? '');
            
            // Remueve el prefijo del sistema y deja solo el texto del usuario
            $limpio = preg_replace('/^\[.*?\]\s*/u', '', $raw);
            $cotizacion->observacion_limpia = trim((string) $limpio);

            return $cotizacion;
        });

        return view('comercial.cotizador.index', compact('cotizaciones', 'search'));
    }
}