<?php

namespace App\Http\Controllers\Comercial;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VisitaTecnicaController extends Controller
{
    public function index()
    {
        return view('comercial.visitas.index');
    }

    public function store(Request $request)
    {
        return redirect()->route('comercial.visitas.index')->with('success', 'Visita técnica registrada con éxito.');
    }
}