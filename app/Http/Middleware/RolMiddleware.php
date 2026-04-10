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

        // Si no hay sesión válida
        if (! session()->has('usr_id') && ! session()->has('emp_id')) {
            return redirect()->route('login')->with('error', 'Sesión expirada o no autorizada.');
        }

        // Si el rol en sesión no coincide con el exigido por la ruta
        if ($rolSesion !== $rol) {
            abort(403, 'No tienes permiso para acceder a esta sección.');
        }

        return $next($request);
    }
}
