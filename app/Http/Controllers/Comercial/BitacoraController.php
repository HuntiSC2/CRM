<?php

namespace App\Http\Controllers\Comercial;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BitacoraController extends Controller
{
    public function index()
    {
        return view('comercial.bitacora.index');
    }

    public function store(Request $request)
    {
        return redirect()->route('comercial.bitacora.index')->with('success', 'Registro añadido a la bitácora CRM.');
    }
}