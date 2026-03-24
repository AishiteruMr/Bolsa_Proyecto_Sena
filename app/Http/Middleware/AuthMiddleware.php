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

        // Verificar si el usuario o empresa sigue activo y tiene perfil
        if (session()->has('usr_id')) {
            $rol = (int) session('rol');
            $usrId = session('usr_id');
            
            $perfil = match ($rol) {
                1 => \Illuminate\Support\Facades\DB::table('aprendiz')->where('usr_id', $usrId)->first(),
                2 => \Illuminate\Support\Facades\DB::table('instructor')->where('usr_id', $usrId)->first(),
                3 => \Illuminate\Support\Facades\DB::table('empresa')->where('usr_id', $usrId)->first(),
                4 => (object)['estado' => 1], // Admin siempre activo
                default => null
            };

            if (!$perfil || (isset($perfil->apr_estado) && $perfil->apr_estado == 0) || 
                (isset($perfil->ins_estado) && $perfil->ins_estado == 0) || 
                (isset($perfil->emp_estado) && $perfil->emp_estado == 0)) {
                
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect()->route('login')->with('error', 'Tu sesión ha expirado o tu perfil no fue encontrado.');
            }

            // AUTO-HEAL: Asegurar que variables críticas estén en sesión
            if ($rol === 3 && !session()->has('nit')) {
                session([
                    'nit'    => $perfil->emp_nit,
                    'emp_id' => $perfil->emp_id,
                    'documento' => $perfil->emp_nit
                ]);
            }
            if ($rol === 2 && !session()->has('documento')) {
                $usuario = \Illuminate\Support\Facades\DB::table('usuario')->where('usr_id', $usrId)->first();
                if ($usuario) session(['documento' => $usuario->usr_documento]);
            }

        } elseif (session()->has('emp_id')) {
            $empId = session('emp_id');
            $empresa = \Illuminate\Support\Facades\DB::table('empresa')->where('emp_id', $empId)->where('emp_estado', 1)->first();
            
            if (!$empresa) {
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect()->route('login')->with('error', 'Esta empresa ha sido desactivada o no existe.');
            }

            // Asegurar nit en sesión
            if (!session()->has('nit')) session(['nit' => $empresa->emp_nit]);
        }

        return $next($request);
    }
}
