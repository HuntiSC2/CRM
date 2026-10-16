<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; // <-- Importación clave

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Verificamos si el usuario no ha iniciado sesión o no tiene el rol correcto
        if (!Auth::check() || Auth::user()->role !== $role) {
            abort(403, 'Acceso no autorizado para este perfil.');
        }

        return $next($request);
    }
}