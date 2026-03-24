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
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para continuar.');
        }
        
        // Validar que existe un rol válido
        $rol = session('rol');
        if (!in_array($rol, [1, 2, 3, 4], true)) {
            // Rol inválido - cerrar sesión
            session()->flush();
            return redirect()->route('login')->with('error', 'Sesión inválida. Por favor inicia sesión nuevamente.');
        }

        // Verificar si el usuario o empresa sigue activo
        if (session()->has('usr_id')) {
            $rol = session('rol');
            $usrId = session('usr_id');
            
            $activo = match ((int) $rol) {
                1 => \Illuminate\Support\Facades\DB::table('aprendiz')->where('usr_id', $usrId)->where('apr_estado', 1)->exists(),
                2 => \Illuminate\Support\Facades\DB::table('instructor')->where('usr_id', $usrId)->where('ins_estado', 1)->exists(),
                3 => \Illuminate\Support\Facades\DB::table('empresa')->where('usr_id', $usrId)->where('emp_estado', 1)->exists(),
                4 => true, // Admin siempre activo por ahora
                default => false
            };

            if (!$activo) {
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect()->route('login')->with('error', 'Tu cuenta ha sido desactivada o no es válida.');
            }
        } elseif (session()->has('emp_id')) {
            $empId = session('emp_id');
            $empresaActiva = \Illuminate\Support\Facades\DB::table('empresa')->where('emp_id', $empId)->where('emp_estado', 1)->exists();
            
            if (!$empresaActiva) {
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect()->route('login')->with('error', 'Esta empresa ha sido desactivada.');
            }
        }

        return $next($request);
    }
}
