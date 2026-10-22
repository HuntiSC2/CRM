<?php

namespace App\Http\Controllers\Comercial;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CotizadorController extends Controller
{
    public function index()
    {
        return view('comercial.cotizador.index');
    }

    public function generarPdf(Request $request)
    {
        // Lógica para emision de PDF
        return back();
    }
}