<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\RegistroExitoso;
use App\Mail\RecuperarContraseña;
use Illuminate\Support\Str;
use App\Http\Requests\ValidarLoginRequest;
use App\Http\Requests\RegistroAprendizRequest;
use App\Http\Requests\RegistroInstructorRequest;
use App\Http\Requests\RegistroEmpresaRequest;

class AuthController extends Controller
{
    // ─── VISTAS DE LOGIN ────────────────────────────────────────────────────────

    public function showLogin()
    {
        if (session()->has('usr_id') || session()->has('emp_id')) {
            return $this->redirectByRol(session('rol'));
        }
        return view('auth.login');
    }

    // ─── PROCESO DE LOGIN ────────────────────────────────────────────────────────

    public function login(ValidarLoginRequest $request)
    {
        $correo   = strip_tags(trim($request->correo));
        $password = $request->password;

        $rateLimitKey = 'login_attempts:' . $request->ip();
        $attempts = cache()->get($rateLimitKey, 0);
        
        if ($attempts >= 5) {
            return back()->with('error', 'Demasiados intentos. Intenta de nuevo en 15 minutos.')->withInput(['correo' => $correo]);
        }

        $usuario = DB::table('usuario')->where('usr_correo', $correo)->first();

        if ($usuario) {
            $loginOk = false;

            if (!empty($usuario->usr_contrasena) && Hash::check($password, $usuario->usr_contrasena)) {
                $loginOk = true;
            } elseif ($usuario->usr_contrasena === $password) {
                DB::table('usuario')
                    ->where('usr_id', $usuario->usr_id)
                    ->update(['usr_contrasena' => Hash::make($password)]);
                $loginOk = true;
            }

            if (!$loginOk) {
                cache()->put($rateLimitKey, $attempts + 1, now()->addMinutes(15));
                return back()->with('error', 'Contraseña incorrecta.')->withInput(['correo' => $correo]);
            }

            $perfil = $this->getPerfilUsuario($usuario->usr_id, $usuario->rol_id);

            if (!$perfil) {
                return back()->with('error', 'Perfil de usuario no encontrado.')->withInput(['correo' => $correo]);
            }

            if (isset($perfil->estado) && $perfil->estado == 0) {
                return back()->with('error', 'Tu cuenta está desactivada. Contacta al administrador.');
            }

            cache()->forget($rateLimitKey);

            $sessionData = [
                'usr_id'   => $usuario->usr_id,
                'documento'=> $usuario->usr_documento,
                'correo'   => $correo,
                'rol'      => $usuario->rol_id,
                'nombre'   => $perfil->nombre ?? '',
                'apellido' => $perfil->apellido ?? '',
            ];

            // Poblar IDs específicos según el rol
            switch ($usuario->rol_id) {
                case 1: // Aprendiz
                    $sessionData['apr_id'] = $perfil->id;
                    break;
                case 2: // Instructor
                    $sessionData['ins_id'] = $perfil->id;
                    break;
                case 3: // Empresa
                    $sessionData['emp_id'] = $perfil->id;
                    $sessionData['nit']    = $perfil->nit;
                    $sessionData['documento'] = $perfil->nit; // Sobrescribir documento con NIT
                    break;
                case 4: // Admin
                    $sessionData['adm_id'] = $perfil->id;
                    break;
            }

            session($sessionData);
            $request->session()->regenerate();

            return $this->redirectByRol($usuario->rol_id);
        }

        // Fallback para empresas que no están en la tabla 'usuario' (opcional, por robustez)
        $empresa = DB::table('empresa')->where('emp_correo', $correo)->first();
        if ($empresa) {
            if ($empresa->emp_estado == 0) {
                return back()->with('error', 'Esta empresa está desactivada.')->withInput(['correo' => $correo]);
            }
            if (!Hash::check($password, $empresa->emp_contrasena)) {
                cache()->put($rateLimitKey, $attempts + 1, now()->addMinutes(15));
                return back()->with('error', 'Contraseña incorrecta.')->withInput(['correo' => $correo]);
            }
            cache()->forget($rateLimitKey);
            session([
                'emp_id'   => $empresa->emp_id,
                'nit'      => $empresa->emp_nit,
                'documento'=> $empresa->emp_nit,
                'rol'      => 3,
                'correo'   => $correo,
                'nombre'   => $empresa->emp_nombre,
                'apellido' => '',
            ]);
            $request->session()->regenerate();
            return redirect()->route('empresa.dashboard');
        }

        cache()->put($rateLimitKey, $attempts + 1, now()->addMinutes(15));
        return back()->with('error', 'Usuario no registrado.')->withInput(['correo' => $correo]);
    }

    // ─── LOGOUT ─────────────────────────────────────────────────────────────────

    public function logout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $request->session()->flush();
        return redirect()->route('login')->with('success', 'Sesión cerrada correctamente.');
    }

    // ─── VISTAS DE REGISTRO ──────────────────────────────────────────────────────

    public function showRegistroAprendiz()
    {
        return view('auth.registro-aprendiz');
    }

    public function showRegistroEmpresa()
    {
        return view('auth.registro-empresa');
    }

    public function showRegistroInstructor()
    {
        return view('auth.registro-instructor');
    }

    // ─── REGISTRO APRENDIZ ───────────────────────────────────────────────────────

    public function registrarAprendiz(RegistroAprendizRequest $request)
    {
        DB::transaction(function () use ($request) {
            $usrId = DB::table('usuario')->insertGetId([
                'usr_documento' => (int) $request->documento,
                'usr_correo'    => strip_tags(trim($request->correo)),
                'usr_contrasena'=> Hash::make($request->password),
                'rol_id'        => 1,
                'usr_fecha_creacion' => now(),
            ]);

            DB::table('aprendiz')->insert([
                'usr_id'       => $usrId,
                'apr_nombre'   => strip_tags(trim($request->nombre)),
                'apr_apellido' => strip_tags(trim($request->apellido)),
                'apr_programa' => strip_tags(trim($request->programa)),
                'apr_estado'   => 1,
            ]);

            $this->enviarCorreoBienvenida($request->correo, $request->nombre, $request->apellido);
        });

        return redirect()->route('login')->with('success', '✅ Registro exitoso. Ya puedes iniciar sesión.');
    }

    // ─── REGISTRO INSTRUCTOR ─────────────────────────────────────────────────────

    public function registrarInstructor(RegistroInstructorRequest $request)
    {
        DB::transaction(function () use ($request) {
            $usrId = DB::table('usuario')->insertGetId([
                'usr_documento' => (int) $request->documento,
                'usr_correo'    => strip_tags(trim($request->correo)),
                'usr_contrasena'=> Hash::make($request->password),
                'rol_id'        => 2,
                'usr_fecha_creacion' => now(),
            ]);

            DB::table('instructor')->insert([
                'usr_id'          => $usrId,
                'ins_nombre'      => strip_tags(trim($request->nombre)),
                'ins_apellido'    => strip_tags(trim($request->apellido)),
                'ins_especialidad'=> strip_tags(trim($request->especialidad)),
                'ins_estado'      => 1,
                'ins_estado_dis'  => 'Disponible',
            ]);

            $this->enviarCorreoBienvenida($request->correo, $request->nombre, $request->apellido);
        });

        return redirect()->route('login')->with('success', '✅ Registro exitoso. Ya puedes iniciar sesión.');
    }

    // ─── REGISTRO EMPRESA ────────────────────────────────────────────────────────

    public function registrarEmpresa(RegistroEmpresaRequest $request)
    {
        DB::transaction(function () use ($request) {
            $usrId = DB::table('usuario')->insertGetId([
                'usr_documento'  => (int) $request->nit,
                'usr_correo'     => strip_tags(trim($request->correo)),
                'usr_contrasena' => Hash::make($request->password),
                'rol_id'         => 3,
                'usr_fecha_creacion' => now(),
            ]);

            DB::table('empresa')->insert([
                'usr_id'            => $usrId,
                'emp_nit'           => (int) $request->nit,
                'emp_nombre'        => strip_tags(trim($request->nombre_empresa)),
                'emp_representante' => strip_tags(trim($request->representante)),
                'emp_correo'        => strip_tags(trim($request->correo)),
                'emp_contrasena'    => Hash::make($request->password),
                'emp_estado'        => 1,
            ]);

            $this->enviarCorreoBienvenida($request->correo, $request->nombre_empresa, '');
        });

        return redirect()->route('login')->with('success', '✅ Empresa registrada exitosamente. Ya puedes iniciar sesión.');
    }

    // ─── HELPERS PRIVADOS ────────────────────────────────────────────────────────

    private function getPerfilUsuario(int $usrId, int $rol): ?object
    {
        return match ($rol) {
            1 => DB::table('aprendiz')
                    ->where('usr_id', $usrId)
                    ->select('apr_id as id', 'apr_nombre as nombre', 'apr_apellido as apellido', 'apr_estado as estado')
                    ->first(),
            2 => DB::table('instructor')
                    ->where('usr_id', $usrId)
                    ->select('usr_id as id', 'ins_nombre as nombre', 'ins_apellido as apellido', 'ins_estado as estado')
                    ->first(),
            3 => DB::table('empresa')
                    ->where('usr_id', $usrId)
                    ->select('emp_id as id', 'emp_nit as nit', 'emp_nombre as nombre', DB::raw("'' as apellido"), 'emp_estado as estado')
                    ->first(),
            4 => DB::table('administrador')
                    ->where('usr_id', $usrId)
                    ->select('adm_id as id', 'adm_nombre as nombre', 'adm_apellido as apellido', DB::raw('1 as estado'))
                    ->first(),
            default => null
        };
    }

    private function redirectByRol(int $rol)
    {
        return match ($rol) {
            1 => redirect()->route('aprendiz.dashboard'),
            2 => redirect()->route('instructor.dashboard'),
            3 => redirect()->route('empresa.dashboard'),
            4 => redirect()->route('admin.dashboard'),
            default => redirect()->route('login'),
        };
    }

    private function enviarCorreoBienvenida(string $correo, string $nombre, string $apellido): void
    {
        try {
            Mail::to($correo)->send(new RegistroExitoso($nombre, $apellido));
        } catch (\Exception $e) {
            Log::error('Error al enviar correo de bienvenida: ' . $e->getMessage());
        }
    }

    // Removed mensajesValidacion function as it is now part of the FormRequests

    // ─── RECUPERACIÓN DE CONTRASEÑA ──────────────────────────────────────────

    public function showOlvideContraseña()
    {
        return view('auth.olvide-contraseña');
    }

    public function enviarEnlaceRecuperacion(Request $request)
    {
        $request->validate([
            'correo' => 'required|email|max:255',
        ], [
            'correo.required' => 'El correo es obligatorio.',
            'correo.email'    => 'Ingresa un correo válido.',
        ]);

        $correo = strip_tags(trim($request->correo));

        // Buscar usuario
        $usuario = DB::table('usuario')->where('usr_correo', $correo)->first();
        $nombre = null;
        $tipo = 'usuario';

        if ($usuario) {
            $perfil = $this->getPerfilUsuario($usuario->usr_id, $usuario->rol_id);
            if ($perfil) {
                $nombre = $perfil->nombre ?? 'Usuario';
            }
        } else {
            // Buscar empresa
            $empresa = DB::table('empresa')->where('emp_correo', $correo)->first();
            if ($empresa) {
                $nombre = $empresa->emp_nombre;
                $tipo = 'empresa';
            }
        }

        if (!$nombre) {
            return back()->with('warning', 'Si existe una cuenta con este correo, recibirás un enlace de recuperación.');
        }

        // Generar token único
        $token = Str::random(64);

        // Eliminar tokens antiguos
        DB::table('password_reset_tokens')->where('email', $correo)->delete();

        // Guardar nuevo token
        DB::table('password_reset_tokens')->insert([
            'email'      => $correo,
            'token'      => hash('sha256', $token),
            'created_at' => now(),
        ]);

        // Enviar correo
        try {
            Mail::to($correo)->send(new RecuperarContraseña($nombre, $token, $correo));
            return back()->with('success', '✅ Se envió un enlace de recuperación a tu correo. Revisa tu bandeja de entrada.');
        } catch (\Exception $e) {
            Log::error('Error al enviar correo de recuperación: ' . $e->getMessage());
            return back()->with('error', 'Error al enviar el correo. Intenta más tarde.');
        }
    }

    public function mostrarFormularioRestablecerContraseña($token)
    {
        $correo = request('email');

        if (!$correo) {
            return redirect()->route('login')->with('error', 'Enlace inválido o expirado.');
        }

        // Verificar token
        $registro = DB::table('password_reset_tokens')
            ->where('email', $correo)
            ->where('token', hash('sha256', $token))
            ->first();

        if (!$registro) {
            return redirect()->route('login')->with('error', 'El enlace de recuperación es inválido o ha expirado.');
        }

        // Verificar que no haya expirado (30 minutos)
        if (\Carbon\Carbon::parse($registro->created_at)->addMinutes(30)->isPast()) {
            DB::table('password_reset_tokens')->where('email', $correo)->delete();
            return redirect()->route('login')->with('error', 'El enlace de recuperación ha expirado. Solicita uno nuevo.');
        }

        return view('auth.restablecer-contraseña', compact('token', 'correo'));
    }

    public function restablecerContraseña(Request $request)
    {
        $request->validate([
            'token'    => 'required|string',
            'correo'   => 'required|email|max:255',
            'password' => 'required|string|min:6|max:100|confirmed',
        ], [
            'password.required'   => 'La contraseña es obligatoria.',
            'password.min'        => 'La contraseña debe tener al menos 6 caracteres.',
            'password.confirmed'  => 'Las contraseñas no coinciden.',
        ]);

        $correo = strip_tags(trim($request->correo));
        $token = $request->token;

        // Verificar token
        $registro = DB::table('password_reset_tokens')
            ->where('email', $correo)
            ->where('token', hash('sha256', $token))
            ->first();

        if (!$registro) {
            return back()->with('error', 'El enlace de recuperación es inválido o ha expirado.');
        }

        // Verificar que no haya expirado (30 minutos)
        if (\Carbon\Carbon::parse($registro->created_at)->addMinutes(30)->isPast()) {
            DB::table('password_reset_tokens')->where('email', $correo)->delete();
            return back()->with('error', 'El enlace de recuperación ha expirado.');
        }

        // Buscar usuario
        $usuario = DB::table('usuario')->where('usr_correo', $correo)->first();

        if ($usuario) {
            // Actualizar contraseña de usuario
            DB::table('usuario')
                ->where('usr_id', $usuario->usr_id)
                ->update(['usr_contrasena' => Hash::make($request->password)]);

            $mensaje = 'Usuario';
        } else {
            // Buscar empresa
            $empresa = DB::table('empresa')->where('emp_correo', $correo)->first();

            if (!$empresa) {
                return back()->with('error', 'Cuenta no encontrada.');
            }

            // Actualizar contraseña de empresa
            DB::table('empresa')
                ->where('emp_id', $empresa->emp_id)
                ->update(['emp_contrasena' => Hash::make($request->password)]);

            $mensaje = 'Empresa';
        }

        // Eliminar token usado
        DB::table('password_reset_tokens')->where('email', $correo)->delete();

        return redirect()->route('login')->with('success', '✅ Contraseña actualizada correctamente. Ya puedes iniciar sesión.');
    }
}
