<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistroAprendizRequest;
use App\Http\Requests\RegistroEmpresaRequest;
use App\Http\Requests\RegistroInstructorRequest;
use App\Http\Requests\ValidarLoginRequest;
use App\Mail\RecuperarContraseña;
use App\Models\AuditLog;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
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
                return back()->with('error', 'Perfil no encontrado.')->withInput(['correo' => $correo]);
            }

            if (isset($perfil->estado) && $perfil->estado == 0) {
                return back()->with('error', 'Tu cuenta está pendiente de activación.');
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
            session(['mostrar_loader' => true]); // Flag para mostrar loader en la primera página del panel

            // Autenticar con guard web para que Laravel Auth y Broadcasting funcionen
            $userModel = User::find($usuario->id);
            if ($userModel) {
                Auth::login($userModel);
            }

            // Registrar inicio de sesión en el historial
            AuditLog::registrar($usuario->id, 'login', 'autenticacion', "Inicio de sesión exitoso desde ".request()->ip());

            return $this->redirectByRol($usuario->rol_id);
        }

        return back()->with('error', 'Usuario no registrado.')->withInput(['correo' => $correo]);
    }

    // ─── LOGOUT ─────────────────────────────────────────────────────────────────

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $request->session()->flush();

        return redirect()->route('login')->with('success', 'Sesión cerrada.');
    }

    public function verifyEmail(Request $request, int $id, string $hash): RedirectResponse
    {
        $user = User::findOrFail($id);

        if (! hash_equals(hash('sha256', $user->getAttribute('correo')), $hash)) {
            return redirect()->route('login')->with('error', 'Enlace de verificación no válido.');
        }

        if ($user->hasVerifiedEmail()) {
            return redirect()->route('login')->with('info', 'Tu correo ya está verificado.');
        }

        $user->markEmailAsVerified();

        return redirect()->route('login')->with('success', 'Correo verificado. Ya puedes iniciar sesión.');
    }

    public function resendVerification(Request $request): RedirectResponse
    {
        if (! $request->filled('correo')) {
            return back()->with('error', 'Escribe tu correo.');
        }

        $user = User::where('correo', $request->correo)->first();

        if (! $user) {
            return back()->with('error', 'No hay una cuenta con ese correo.');
        }

        if ($user->hasVerifiedEmail()) {
            return back()->with('info', 'Este correo ya está verificado.');
        }

        $user->sendEmailVerificationNotification();

        return back()->with('success', 'Nuevo enlace de verificación enviado a tu correo.');
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
                    'consentimiento_datos' => true,
                    'fecha_consentimiento' => now(),
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
                $nombreCompleto = strip_tags(trim($request->nombre)).' '.strip_tags(trim($request->apellido));
                AuditLog::registrar($resultado, 'crear', 'usuarios', 'aprendices', $resultado, null, ['nombre_objetivo' => $nombreCompleto, 'tipo' => 'aprendiz'], "Se ha registrado un nuevo aprendiz en el sistema: {$nombreCompleto}. Su cuenta está pendiente de activación por un administrador.");
                return redirect()->route('login')->with('success', 'Registro exitoso. Un administrador activará tu cuenta.');
            }

            return back()->with('error', 'Error en el registro. Intenta de nuevo.')->withInput();
        } catch (\Exception $e) {
            Log::error('Error en registro aprendiz: '.$e->getMessage());

            return back()->with('error', 'Error al registrarte. Intenta de nuevo.')->withInput();
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
                    'consentimiento_datos' => true,
                    'fecha_consentimiento' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                DB::table('instructores')->insert([
                    'usuario_id' => $usrId,
                    'nombres' => strip_tags(trim($request->nombre)),
                    'apellidos' => strip_tags(trim($request->apellido)),
                    'especialidad' => strip_tags(trim($request->especialidad)),
                    'activo' => false,
                    'disponibilidad' => 'disponible',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                return $usrId;
            });

            if ($resultado) {
                $nombreCompleto = strip_tags(trim($request->nombre)).' '.strip_tags(trim($request->apellido));
                AuditLog::registrar($resultado, 'crear', 'usuarios', 'instructores', $resultado, null, ['nombre_objetivo' => $nombreCompleto, 'tipo' => 'instructor'], "Se ha registrado un nuevo instructor en el sistema: {$nombreCompleto}. Su cuenta está pendiente de activación por un administrador.");
                return redirect()->route('login')->with('success', 'Registro exitoso. Un administrador activará tu cuenta.');
            }

            return back()->with('error', 'Error en el registro. Intenta de nuevo.')->withInput();
        } catch (\Exception $e) {
            Log::error('Error en registro instructor: '.$e->getMessage());

            return back()->with('error', 'Error al registrarte. Intenta de nuevo.')->withInput();
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
                    'consentimiento_datos' => true,
                    'fecha_consentimiento' => now(),
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
                $nombreEmpresa = strip_tags(trim($request->nombre_empresa));
                AuditLog::registrar($resultado, 'crear', 'usuarios', 'empresas', $resultado, null, ['nombre_objetivo' => $nombreEmpresa, 'tipo' => 'empresa'], "Se ha registrado una nueva empresa en el sistema: {$nombreEmpresa}. Su cuenta está pendiente de activación por un administrador.");
                return redirect()->route('login')->with('success', 'Registro exitoso. Un administrador activará tu cuenta.');
            }

            return back()->with('error', 'Error en el registro. Intenta de nuevo.')->withInput();
        } catch (\Exception $e) {
            Log::error('Error en registro empresa: '.$e->getMessage());

            return back()->with('error', 'Error al registrarte. Intenta de nuevo.')->withInput();
        }
    }

    // ─── HELPERS PRIVADOS ────────────────────────────────────────────────────────

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
            return back()->with('warning', 'Si el correo existe, recibirás un enlace de recuperación.');
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
            \Illuminate\Support\Facades\Mail::to($correo)->send(new RecuperarContraseña($nombre, $enlaceRecuperacion));

            return back()->with('success', 'Enlace de recuperación enviado a tu correo.');
        } catch (\Exception $e) {
            Log::error('Error al enviar correo de recuperación: '.$e->getMessage());

            return back()->with('error', 'Error al enviar el correo.');
        }
    }

    /**
     * ✅ SEGURIDAD: Mostrar formulario de restablecimiento sin email en URL
     * El token es el único parámetro, y el email se obtiene de la BD
     */
    public function mostrarFormularioRestablecerContraseña(string $token): View|RedirectResponse
    {
        // ✅ BUSCAR: Encontrar el email desde el token (sin pasar email en URL)
        $registro = DB::table('password_reset_tokens')
            ->where('token', hash('sha256', $token))
            ->first();

        if (! $registro) {
            return redirect()->route('login')->with('error', 'El enlace de recuperación ya no es válido.');
        }

        $correo = $registro->email;

        // ✅ VERIFICAR: Que el enlace no haya expirado
        if ($registro->expires_at && Carbon::parse($registro->expires_at)->isPast()) {
            DB::table('password_reset_tokens')->where('email', $correo)->delete();

            return redirect()->route('login')->with('error', 'El enlace expiró. Solicita uno nuevo.');
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
            return back()->with('error', 'El enlace de recuperación ya no es válido.');
        }

        // Verificar que no haya expirado (usar expires_at)
        if ($registro->expires_at && Carbon::parse($registro->expires_at)->isPast()) {
            DB::table('password_reset_tokens')->where('email', $correo)->delete();

            return back()->with('error', 'El enlace expiró. Solicita uno nuevo.');
        }

        // Buscar usuario
        $usuario = DB::table('usuarios')->where('correo', $correo)->first();

        if ($usuario) {
            // Actualizar contraseña de usuario
            DB::table('usuarios')
                ->where('id', $usuario->id)
                ->update(['contrasena' => Hash::make($request->password)]);

            // Registrar cambio de contraseña
            AuditLog::registrar($usuario->id, 'editar', 'seguridad', 'Se restableció la contraseña mediante el enlace de recuperación.');

            $mensaje = 'Usuario';
        } else {
            return back()->with('error', 'Cuenta no encontrada.');
        }

        // Eliminar token usado
        DB::table('password_reset_tokens')->where('email', $correo)->delete();

        return redirect()->route('login')->with('success', 'Contraseña actualizada. Ya puedes iniciar sesión.');
    }

    // ─── RETIRO DE CONSENTIMIENTO DE DATOS ─────────────────────────────────

    public function retirarConsentimiento(Request $request): RedirectResponse
    {
        $usuarioId = session('usr_id');
        if (! $usuarioId) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión.');
        }

        DB::table('usuarios')
            ->where('id', $usuarioId)
            ->update([
                'consentimiento_datos' => false,
                'fecha_consentimiento' => now(),
            ]);

        AuditLog::registrar($usuarioId, 'editar', 'privacidad', 'El usuario retiró su consentimiento para el tratamiento de datos personales.');

        return back()->with('info', 'Has retirado tu consentimiento para el tratamiento de datos personales. Algunas funcionalidades pueden verse limitadas.');
    }
}
