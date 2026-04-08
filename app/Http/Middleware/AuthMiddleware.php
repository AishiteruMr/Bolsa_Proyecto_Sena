<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!session()->has('usr_id')) {
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
        $usrId = session('usr_id');
        
        $perfil = match ($rol) {
            1 => \Illuminate\Support\Facades\DB::table('aprendices')->where('usuario_id', $usrId)->first(),
            2 => \Illuminate\Support\Facades\DB::table('instructores')->where('usuario_id', $usrId)->first(),
            3 => \Illuminate\Support\Facades\DB::table('empresas')->where('usuario_id', $usrId)->first(),
            4 => (object)['activo' => 1], // Admin siempre activo
            default => null
        };

        if (!$perfil || (isset($perfil->activo) && $perfil->activo == 0)) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login')->with('error', 'Tu sesión ha expirado o tu perfil no fue encontrado.');
        }

        // AUTO-HEAL: Asegurar que variables críticas estén en sesión
        if ($rol === 3 && !session()->has('nit')) {
            session([
                'nit'    => $perfil->nit,
                'emp_id' => $perfil->id,
                'documento' => $perfil->nit // compatibilidad si hay algo usando documento
            ]);
        }
        if ($rol === 2 && !session()->has('documento')) {
            $usuario = \Illuminate\Support\Facades\DB::table('usuarios')->where('id', $usrId)->first();
            if ($usuario) session(['documento' => $usuario->numero_documento]);
        }

        return $next($request);
    }
}
