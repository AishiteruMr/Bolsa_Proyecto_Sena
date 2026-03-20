<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Validar que el usuario o empresa está autenticado
        $usuarioId = session('usr_id');
        $empresaId = session('emp_id');
        $instructorId = session('inst_id');
        
        // Verificar que al menos uno existe y es válido
        if (empty($usuarioId) && empty($empresaId) && empty($instructorId)) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para continuar.');
        }
        
        // Validar que existe un rol válido
        $rol = session('rol');
        if (!in_array($rol, [1, 2, 3, 4], true)) {
            // Rol inválido - cerrar sesión
            session()->flush();
            return redirect()->route('login')->with('error', 'Sesión inválida. Por favor inicia sesión nuevamente.');
        }

        return $next($request);
    }
}
