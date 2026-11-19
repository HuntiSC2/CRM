<?php

namespace App\Http\Controllers\Comercial;

use App\Http\Controllers\Controller;
use App\Models\Cotizacion;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class CotizadorController extends Controller
{
    public function generarPdf($id)
    {
        // 1. Cargamos relaciones seguras (incluyendo comercial si existe)
        $cotizacion = Cotizacion::with(['obra.cliente', 'user'])->findOrFail($id);

        // Monto acumulado de la obra: sumatoria de TODAS sus cotizaciones
        // (una obra puede dividirse por áreas y cotizarse por separado).
        $montoTotalObra = (float) Cotizacion::where('obra_id', $cotizacion->obra_id)->sum('monto_total');

        // 2. Cargamos la vista y activamos los permisos para imágenes locales
        $pdf = Pdf::loadView('comercial.cotizador.pdf', compact('cotizacion', 'montoTotalObra'))
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled'      => true, // Permite cargar imágenes locales/remotas
                'chroot'               => public_path(), // Permite leer la carpeta public/images/
                'defaultFont'          => 'sans-serif'
            ]);

        // 3. Devolvemos el PDF con cabeceras que permiten la vista previa en el modal
        return response($pdf->output(), 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'inline; filename="Cotizacion_' . $cotizacion->codigo_cotizacion . '.pdf"',
            'X-Frame-Options'     => 'SAMEORIGIN' // Permite mostrarse dentro del iframe de tu modal
        ]);
    }

    public function index(Request $request)
    {
        $search = $request->input('search');

        // Consulta de auditoría y trazabilidad histórica
        $cotizaciones = Cotizacion::with(['obra.cliente', 'user'])
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('codigo_cotizacion', 'like', '%' . $search . '%')
                      ->orWhere('estado_cotizacion', 'like', '%' . $search . '%')
                      ->orWhereHas('obra', function ($sub) use ($search) {
                          $sub->where('titulo', 'like', '%' . $search . '%')
                              ->orWhere('codigo', 'like', '%' . $search . '%')
                              ->orWhereHas('cliente', function ($c) use ($search) {
                                  $c->where('razon_social', 'like', '%' . $search . '%');
                              });
                      });
                });
            })
            ->latest()
            ->paginate(10);

        // Identifica la última cotización (mayor id) de cada obra para
        // mostrar únicamente su PDF, usando una única consulta agregada.
        $ultimasCotizacionesPorObra = Cotizacion::selectRaw('MAX(id) as id')
            ->whereIn('obra_id', $cotizaciones->pluck('obra_id')->filter()->unique()->all())
            ->groupBy('obra_id')
            ->pluck('id')
            ->all();

        $ultimasCotizacionesPorObra = array_flip($ultimasCotizacionesPorObra);

        return view('comercial.cotizador.index', compact('cotizaciones', 'ultimasCotizacionesPorObra'));
    }
}