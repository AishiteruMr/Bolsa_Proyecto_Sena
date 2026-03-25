<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!\Illuminate\Support\Facades\Auth::check()) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para continuar.');
        }
        
        $user = \Illuminate\Support\Facades\Auth::user();
        
        // Verificar si el usuario está activo (si es relevante para el rol)
        if (!$user->isActivo()) {
            \Illuminate\Support\Facades\Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login')->with('error', 'Tu cuenta está desactivada.');
        }

        // Poblar sesión para compatibilidad con código antiguo (Legacy Support)
        if (!session()->has('usr_id')) {
            session([
                'usr_id'    => $user->usr_id,
                'rol'       => $user->rol_id,
                'documento' => $user->usr_documento,
                'correo'    => $user->usr_correo,
            ]);
        }

        return $next($request);
    }
}
