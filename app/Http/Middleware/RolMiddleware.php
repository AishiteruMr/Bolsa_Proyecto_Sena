<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RolMiddleware
{
    public function handle(Request $request, Closure $next, int ...$roles): Response
    {
        $rolSesion = session('rol');

        if (!session()->has('usr_id')) {
            return redirect()->route('login')->with('error', 'Sesión expirada. Inicia sesión.');
        }

        if (!in_array($rolSesion, $roles)) {
            abort(403, 'No tienes permiso para acceder.');
        }

        return $next($request);
    }
}
