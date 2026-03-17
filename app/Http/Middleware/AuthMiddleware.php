<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!session()->has('usr_id') && !session()->has('emp_id')) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para continuar.');
        }

        return $next($request);
    }
}
