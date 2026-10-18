<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    // Dashboard maestro unificado para todo el sistema
    public function index()
    {
        $user = Auth::user();

        // Asignación de módulo 1 a 1 según el rol exclusivo
        $permisos = [
            'es_admin'     => ($user->role === 'admin'),     // Únicamente el módulo de Soporte
            'es_gerente'   => ($user->role === 'gerente'),   // Únicamente el módulo de Gerencia
            'es_comercial' => ($user->role === 'comercial'), // Únicamente el módulo Comercial
        ];

        return view('dashboard', compact('user', 'permisos'));
    }
}