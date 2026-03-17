<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RolMiddleware
{
    public function handle(Request $request, Closure $next, int $rol): Response
    {
        $rolSesion = session('rol');

        if ($rolSesion != $rol) {
            // Redirigir al dashboard correcto según el rol en sesión
            return match ((int) $rolSesion) {
                1 => redirect()->route('aprendiz.dashboard'),
                2 => redirect()->route('instructor.dashboard'),
                3 => redirect()->route('empresa.dashboard'),
                4 => redirect()->route('admin.dashboard'),
                default => redirect()->route('login')->with('error', 'Acceso no autorizado.')
            };
        }

        return $next($request);
    }
}
