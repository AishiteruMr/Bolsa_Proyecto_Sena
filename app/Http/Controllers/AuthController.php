<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistroAprendizRequest;
use App\Http\Requests\RegistroEmpresaRequest;
use App\Http\Requests\RegistroInstructorRequest;
use App\Http\Requests\ValidarLoginRequest;
use App\Mail\RecuperarContraseña;
use App\Mail\RegistroExitoso;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class AuthController extends Controller
{
    // ─── VISTAS DE LOGIN ────────────────────────────────────────────────────────

    public function showLogin(): View|RedirectResponse
    {
        if (session()->has('usr_id') || session()->has('emp_id')) {
            return $this->redirectByRol(session('rol'));
        }

        return view('auth.login');
    }

    // ─── PROCESO DE LOGIN ────────────────────────────────────────────────────────

    public function login(ValidarLoginRequest $request): RedirectResponse
    {
        $correo = strip_tags(trim($request->correo));
        $password = $request->password;

        $usuario = DB::table('usuarios')->where('correo', $correo)->first();

        if ($usuario) {
            $loginOk = false;

            if (! empty($password) && ! empty($usuario->contrasena) && Hash::check($password, $usuario->contrasena)) {
                $loginOk = true;
            }

            if (! $loginOk) {
                return back()->with('error', 'Contraseña incorrecta.')->withInput(['correo' => $correo]);
            }

            $perfil = $this->getPerfilUsuario($usuario->id, $usuario->rol_id);

            if (! $perfil) {
                return back()->with('error', 'Perfil de usuario no encontrado.')->withInput(['correo' => $correo]);
            }

            if (isset($perfil->estado) && $perfil->estado == 0) {
                return back()->with('error', 'Tu cuenta está pendiente de activación por un administrador.');
            }

            if (property_exists($usuario, 'email_verified_at') && is_null($usuario->email_verified_at)) {
                $userModel = User::find($usuario->id);
                if ($userModel) {
                    $userModel->sendEmailVerificationNotification();
                }

                return back()->with('error', 'Debes verificar tu correo electrónico antes de iniciar sesión. Se ha enviado un nuevo enlace de verificación.')->withInput(['correo' => $correo]);
            }

            $sessionData = [
                'usr_id' => $usuario->id,
                'documento' => $usuario->numero_documento,
                'correo' => $correo,
                'rol' => $usuario->rol_id,
                'nombre' => $perfil->nombre ?? '',
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
                    $sessionData['nit'] = $perfil->nit;
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

        return back()->with('error', 'Usuario no registrado.')->withInput(['correo' => $correo]);
    }

    // ─── LOGOUT ─────────────────────────────────────────────────────────────────

    public function logout(Request $request): RedirectResponse
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $request->session()->flush();

        return redirect()->route('login')->with('success', 'Sesión cerrada correctamente.');
    }

    public function verifyEmail(Request $request, int $id, string $hash): RedirectResponse
    {
        $user = User::findOrFail($id);

        if (! hash_equals(hash('sha256', $user->getAttribute('correo')), $hash)) {
            return redirect()->route('login')->with('error', 'Enlace de verificación inválido.');
        }

        if ($user->hasVerifiedEmail()) {
            return redirect()->route('login')->with('info', 'Tu correo ya ha sido verificado.');
        }

        $user->markEmailAsVerified();

        return redirect()->route('login')->with('success', '¡Correo verificado exitosamente! Ya puedes iniciar sesión.');
    }

    public function resendVerification(Request $request): RedirectResponse
    {
        if (! $request->filled('correo')) {
            return back()->with('error', 'Debes proporcionar tu correo electrónico.');
        }

        $user = User::where('correo', $request->correo)->first();

        if (! $user) {
            return back()->with('error', 'No se encontró un usuario con ese correo.');
        }

        if ($user->hasVerifiedEmail()) {
            return back()->with('info', 'Este correo ya ha sido verificado.');
        }

        $user->sendEmailVerificationNotification();

        return back()->with('success', 'Se ha enviado un nuevo enlace de verificación a tu correo.');
    }

    // ─── VISTAS DE REGISTRO ──────────────────────────────────────────────────────

    public function showRegistroAprendiz(): View|RedirectResponse
    {
        return view('auth.registro-aprendiz');
    }

    public function showRegistroEmpresa(): View|RedirectResponse
    {
        return view('auth.registro-empresa');
    }

    public function showRegistroInstructor(): View|RedirectResponse
    {
        return view('auth.registro-instructor');
    }

    // ─── REGISTRO APRENDIZ ───────────────────────────────────────────────────────

    public function registrarAprendiz(RegistroAprendizRequest $request): RedirectResponse
    {
        try {
            $resultado = DB::transaction(function () use ($request) {
                $usrId = DB::table('usuarios')->insertGetId([
                    'numero_documento' => (int) $request->documento,
                    'correo' => strip_tags(trim($request->correo)),
                    'contrasena' => Hash::make($request->password),
                    'rol_id' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                DB::table('aprendices')->insert([
                    'usuario_id' => $usrId,
                    'nombres' => strip_tags(trim($request->nombre)),
                    'apellidos' => strip_tags(trim($request->apellido)),
                    'programa_formacion' => strip_tags(trim($request->programa)),
                    'activo' => false,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                return $usrId;
            });

            if ($resultado) {
                $this->enviarCorreoBienvenida($request->correo, $request->nombre, $request->apellido);

                $user = User::find($resultado);
                if ($user) {
                    $user->sendEmailVerificationNotification();
                }

                return redirect()->route('login')->with('success', 'Registro exitoso. Verifica tu correo antes de iniciar sesion.');
            }

            return back()->with('error', 'Error en el registro. Intenta de nuevo.')->withInput();
        } catch (\Exception $e) {
            Log::error('Error en registro aprendiz: '.$e->getMessage());

            return back()->with('error', 'Error al procesar el registro. Intenta de nuevo.')->withInput();
        }
    }

    // ─── REGISTRO INSTRUCTOR ─────────────────────────────────────────────────────

    public function registrarInstructor(RegistroInstructorRequest $request): RedirectResponse
    {
        try {
            $resultado = DB::transaction(function () use ($request) {
                $usrId = DB::table('usuarios')->insertGetId([
                    'numero_documento' => (int) $request->documento,
                    'correo' => strip_tags(trim($request->correo)),
                    'contrasena' => Hash::make($request->password),
                    'rol_id' => 2,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                DB::table('instructores')->insert([
                    'usuario_id' => $usrId,
                    'nombres' => strip_tags(trim($request->nombre)),
                    'apellidos' => strip_tags(trim($request->apellido)),
                    'especialidad' => strip_tags(trim($request->especialidad)),
                    'activo' => false,
                    'disponibilidad' => 'Disponible',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                return $usrId;
            });

            if ($resultado) {
                $this->enviarCorreoBienvenida($request->correo, $request->nombre, $request->apellido);

                $user = User::find($resultado);
                if ($user) {
                    $user->sendEmailVerificationNotification();
                }

                return redirect()->route('login')->with('success', 'Registro exitoso. Verifica tu correo antes de iniciar sesion.');
            }

            return back()->with('error', 'Error en el registro. Intenta de nuevo.')->withInput();
        } catch (\Exception $e) {
            Log::error('Error en registro instructor: '.$e->getMessage());

            return back()->with('error', 'Error al procesar el registro. Intenta de nuevo.')->withInput();
        }
    }

    // ─── REGISTRO EMPRESA ────────────────────────────────────────────────────────

    public function registrarEmpresa(RegistroEmpresaRequest $request): RedirectResponse
    {
        try {
            $resultado = DB::transaction(function () use ($request) {
                $usrId = DB::table('usuarios')->insertGetId([
                    'numero_documento' => (int) $request->nit,
                    'correo' => strip_tags(trim($request->correo)),
                    'contrasena' => Hash::make($request->password),
                    'rol_id' => 3,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                DB::table('empresas')->insert([
                    'usuario_id' => $usrId,
                    'nit' => (int) $request->nit,
                    'nombre' => strip_tags(trim($request->nombre_empresa)),
                    'representante' => strip_tags(trim($request->representante)),
                    'correo_contacto' => strip_tags(trim($request->correo)),
                    'activo' => false,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                return $usrId;
            });

            if ($resultado) {
                $this->enviarCorreoBienvenida($request->correo, $request->nombre_empresa, '');

                $user = User::find($resultado);
                if ($user) {
                    $user->sendEmailVerificationNotification();
                }

                return redirect()->route('login')->with('success', 'Empresa registrada. Verifica tu correo antes de iniciar sesion.');
            }

            return back()->with('error', 'Error en el registro. Intenta de nuevo.')->withInput();
        } catch (\Exception $e) {
            Log::error('Error en registro empresa: '.$e->getMessage());

            return back()->with('error', 'Error al procesar el registro. Intenta de nuevo.')->withInput();
        }
    }

    // ─── HELPERS PRIVADOS ────────────────────────────────────────────────────────

    private function getPerfilUsuario(int $usrId, int $rol): ?object
    {
        return match ($rol) {
            1 => DB::table('aprendices')
                ->where('usuario_id', $usrId)
                ->select('id as id', 'nombres as nombre', 'apellidos as apellido', 'activo as estado')
                ->first(),
            2 => DB::table('instructores')
                ->where('usuario_id', $usrId)
                ->select('id as id', 'nombres as nombre', 'apellidos as apellido', 'activo as estado')
                ->first(),
            3 => DB::table('empresas')
                ->where('usuario_id', $usrId)
                ->select('id as id', 'nit as nit', 'nombre as nombre', DB::raw("'' as apellido"), 'activo as estado')
                ->first(),
            4 => DB::table('administradores')
                ->where('usuario_id', $usrId)
                ->select('id as id', 'nombres as nombre', 'apellidos as apellido', DB::raw('1 as estado'))
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
            Log::error('Error al enviar correo de bienvenida: '.$e->getMessage());
        }
    }

    // ─── RECUPERACIÓN DE CONTRASEÑA ──────────────────────────────────────────

    public function showOlvideContraseña(): View
    {
        return view('auth.olvide-contraseña');
    }

    public function enviarEnlaceRecuperacion(Request $request): RedirectResponse
    {
        $request->validate([
            'correo' => 'required|email|max:255',
        ], self::mensajesValidacion());

        $correo = strip_tags(trim($request->correo));

        // Buscar usuario
        $usuario = DB::table('usuarios')->where('correo', $correo)->first();
        $nombre = null;
        $tipo = 'usuario';

        if ($usuario) {
            $perfil = $this->getPerfilUsuario($usuario->id, $usuario->rol_id);
            if ($perfil) {
                $nombre = $perfil->nombre ?? 'Usuario';
            }
        }

        if (! $nombre) {
            return back()->with('warning', 'Si existe una cuenta con este correo, recibirás un enlace de recuperación.');
        }

        // ✅ SEGURIDAD: Generar token único y seguro
        $token = Str::random(64);

        // Eliminar tokens antiguos para este email
        DB::table('password_reset_tokens')->where('email', $correo)->delete();

        // ✅ SEGURIDAD: Guardar token hasheado con expiración
        DB::table('password_reset_tokens')->insert([
            'email' => $correo,
            'token' => hash('sha256', $token),
            'created_at' => now(),
            'expires_at' => now()->addMinutes(30),  // Expira en 30 minutos
        ]);

        // ✅ SEGURIDAD: Generar URL SIN email en query parameters
        // Solo el token va en la URL, el email se recupera de la BD
        $enlaceRecuperacion = route('auth.mostrar-restablecer-seguro', ['token' => $token]);

        // Enviar correo
        try {
            Mail::to($correo)->send(new RecuperarContraseña($nombre, $enlaceRecuperacion));

            return back()->with('success', '✅ Se envió un enlace de recuperación a tu correo. Revisa tu bandeja de entrada.');
        } catch (\Exception $e) {
            Log::error('Error al enviar correo de recuperación: '.$e->getMessage());

            return back()->with('error', 'Error al enviar el correo. Intenta más tarde.');
        }
    }

    /**
     * ✅ SEGURIDAD: Mostrar formulario de restablecimiento sin email en URL
     * El token es el único parámetro, y el email se obtiene de la BD
     */
    public function mostrarFormularioRestablecerContraseña(string $token): View
    {
        // ✅ BUSCAR: Encontrar el email desde el token (sin pasar email en URL)
        $registro = DB::table('password_reset_tokens')
            ->where('token', hash('sha256', $token))
            ->first();

        if (! $registro) {
            return redirect()->route('login')->with('error', 'El enlace de recuperación es inválido o ha expirado.');
        }

        $correo = $registro->email;

        // ✅ VERIFICAR: Que el enlace no haya expirado
        if ($registro->expires_at && Carbon::parse($registro->expires_at)->isPast()) {
            DB::table('password_reset_tokens')->where('email', $correo)->delete();

            return redirect()->route('login')->with('error', 'El enlace de recuperación ha expirado. Solicita uno nuevo.');
        }

        return view('auth.restablecer-contraseña', compact('token', 'correo'));
    }

    public function restablecerContraseña(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => 'required|string',
            'correo' => 'required|email|max:255',
            'password' => [
                'required',
                'string',
                'max:100',
                'confirmed',
                Password::min(config('app_config.password.min_length', 8))
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
            ],
        ], self::mensajesValidacion());

        $correo = strip_tags(trim($request->correo));
        $token = $request->token;

        // Verificar token
        $registro = DB::table('password_reset_tokens')
            ->where('email', $correo)
            ->where('token', hash('sha256', $token))
            ->first();

        if (! $registro) {
            return back()->with('error', 'El enlace de recuperación es inválido o ha expirado.');
        }

        // Verificar que no haya expirado (30 minutos)
        if (Carbon::parse($registro->created_at)->addMinutes(30)->isPast()) {
            DB::table('password_reset_tokens')->where('email', $correo)->delete();

            return back()->with('error', 'El enlace de recuperación ha expirado.');
        }

        // Buscar usuario
        $usuario = DB::table('usuarios')->where('correo', $correo)->first();

        if ($usuario) {
            // Actualizar contraseña de usuario
            DB::table('usuarios')
                ->where('id', $usuario->id)
                ->update(['contrasena' => Hash::make($request->password)]);

            $mensaje = 'Usuario';
        } else {
            return back()->with('error', 'Cuenta no encontrada.');
        }

        // Eliminar token usado
        DB::table('password_reset_tokens')->where('email', $correo)->delete();

        return redirect()->route('login')->with('success', '✅ Contraseña actualizada correctamente. Ya puedes iniciar sesión.');
    }
}
