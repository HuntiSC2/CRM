<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Valida el acceso según los roles permitidos en la ruta.
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            abort(403, 'Acceso no autorizado. Debe iniciar sesión.');
        }

        $userRole = strtolower(trim(Auth::user()->role ?? ''));

        // 1. EL ADMINISTRADOR TIENE LLAVE MAESTRA UNIVERSAL A TODOS LOS MÓDULOS
        if ($userRole === 'administrador') {
            return $next($request);
        }

        // 2. VERIFICA SI EL ROL DEL USUARIO ESTÁ PERMITIDO EN ESTA RUTA
        if (in_array($userRole, $roles)) {
            return $next($request);
        }

        abort(403, 'Acceso no autorizado para este perfil.');
    }
}