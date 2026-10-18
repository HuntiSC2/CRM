<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthenticatedSessionController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $request->email)->first();

        // Criterio Scrum: Verificación de bloqueo por intentos fallidos (HU-01)
        if ($user && !$user->is_active) {
            return back()->withErrors([
                'email' => 'Su cuenta ha sido bloqueada temporalmente por seguridad tras múltiples intentos fallidos.',
            ]);
        }

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            
            // Resetear intentos si el login es exitoso
            $user->update(['login_attempts' => 0]);

            // Redirección unificada al Panel de Control Maestro para todos los roles
            return redirect()->intended('/dashboard');
        }

        // Si falla el login, incrementamos el contador de intentos
        if ($user) {
            $user->increment('login_attempts');
            if ($user->login_attempts >= 3) {
                $user->update(['is_active' => false]);
                return back()->withErrors([
                    'email' => 'Cuenta bloqueada: Ha superado el límite de 3 intentos permitidos.',
                ]);
            }
        }

        return back()->withErrors([
            'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ])->onlyInput('email');
    }

    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
