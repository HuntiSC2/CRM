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

        // 2. Cargamos la vista y activamos los permisos para imágenes locales
        $pdf = Pdf::loadView('comercial.cotizador.pdf', compact('cotizacion'))
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
                return $query->where('codigo_cotizacion', 'like', '%' . $search . '%')
                             ->orWhere('estado_cotizacion', 'like', '%' . $search . '%')
                             ->orWhereHas('obra', function ($q) use ($search) {
                                 $q->where('titulo', 'like', '%' . $search . '%')
                                   ->orWhere('codigo', 'like', '%' . $search . '%')
                                   ->orWhereHas('cliente', function ($c) use ($search) {
                                       $c->where('razon_social', 'like', '%' . $search . '%');
                                   });
                             });
            })
            ->latest()
            ->paginate(10);

        return view('comercial.cotizador.index', compact('cotizaciones'));
    }
}