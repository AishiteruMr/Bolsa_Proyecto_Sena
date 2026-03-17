<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\RegistroExitoso;

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

    public function login(Request $request)
    {
        $request->validate([
            'correo'   => 'required|email|max:255',
            'password' => 'required|string|min:6|max:100',
        ], [
            'correo.required'   => 'El correo es obligatorio.',
            'correo.email'      => 'Ingresa un correo válido.',
            'correo.max'        => 'El correo no puede tener más de 255 caracteres.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min'      => 'La contraseña debe tener al menos 6 caracteres.',
            'password.max'      => 'La contraseña no puede exceder 100 caracteres.',
        ]);

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

            session([
                'usr_id'   => $usuario->usr_id,
                'documento'=> $usuario->usr_documento,
                'correo'   => $correo,
                'rol'      => $usuario->rol_id,
                'nombre'   => $perfil->nombre ?? '',
                'apellido' => $perfil->apellido ?? '',
            ]);

            return $this->redirectByRol($usuario->rol_id);
        }

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

            return redirect()->route('empresa.dashboard');
        }

        cache()->put($rateLimitKey, $attempts + 1, now()->addMinutes(15));
        return back()->with('error', 'Usuario no registrado.')->withInput(['correo' => $correo]);
    }

    // ─── LOGOUT ─────────────────────────────────────────────────────────────────

    public function logout(Request $request)
    {
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

    public function registrarAprendiz(Request $request)
    {
        $request->validate([
            'nombre'    => 'required|string|max:50|regex:/^[a-zA-Z\s]+$/',
            'apellido'  => 'required|string|max:50|regex:/^[a-zA-Z\s]+$/',
            'documento' => 'required|numeric|digits_between:6,12|unique:usuario,usr_documento',
            'programa'  => 'required|string|max:100',
            'correo'    => 'required|email|max:255|unique:usuario,usr_correo',
            'password'  => 'required|string|min:6|max:100|confirmed',
            'terminos'  => 'accepted',
        ], $this->mensajesValidacion());

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

    public function registrarInstructor(Request $request)
    {
        $request->validate([
            'nombre'       => 'required|string|max:50|regex:/^[a-zA-Z\s]+$/',
            'apellido'     => 'required|string|max:50|regex:/^[a-zA-Z\s]+$/',
            'documento'    => 'required|numeric|digits_between:6,12|unique:usuario,usr_documento',
            'especialidad' => 'required|string|max:100',
            'correo'       => 'required|email|max:255|unique:usuario,usr_correo',
            'password'     => 'required|string|min:6|max:100|confirmed',
            'terminos'     => 'accepted',
        ], $this->mensajesValidacion());

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

    public function registrarEmpresa(Request $request)
    {
        $request->validate([
            'nombre_empresa' => 'required|string|max:150',
            'nit'            => 'required|numeric|digits_between:6,15|unique:empresa,emp_nit',
            'representante'  => 'required|string|max:100',
            'correo'         => 'required|email|max:255|unique:empresa,emp_correo',
            'password'       => 'required|string|min:6|max:100|confirmed',
            'terminos'       => 'accepted',
        ], $this->mensajesValidacion());

        DB::table('empresa')->insert([
            'emp_nit'           => (int) $request->nit,
            'emp_nombre'        => strip_tags(trim($request->nombre_empresa)),
            'emp_representante' => strip_tags(trim($request->representante)),
            'emp_correo'        => strip_tags(trim($request->correo)),
            'emp_contrasena'    => Hash::make($request->password),
            'emp_estado'        => 1,
        ]);

        $this->enviarCorreoBienvenida($request->correo, $request->nombre_empresa, '');

        return redirect()->route('login')->with('success', '✅ Empresa registrada exitosamente. Ya puedes iniciar sesión.');
    }

    // ─── HELPERS PRIVADOS ────────────────────────────────────────────────────────

    private function getPerfilUsuario(int $usrId, int $rol): ?object
    {
        return match ($rol) {
            1 => DB::table('aprendiz')
                    ->where('usr_id', $usrId)
                    ->select('apr_nombre as nombre', 'apr_apellido as apellido', 'apr_estado as estado')
                    ->first(),
            2 => DB::table('instructor')
                    ->where('usr_id', $usrId)
                    ->select('ins_nombre as nombre', 'ins_apellido as apellido', 'ins_estado as estado')
                    ->first(),
            4 => DB::table('administrador')
                    ->where('usr_id', $usrId)
                    ->select('adm_nombre as nombre', 'adm_apellido as apellido', DB::raw('1 as estado'))
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

    private function mensajesValidacion(): array
    {
        return [
            'required'          => 'El campo :attribute es obligatorio.',
            'email'             => 'Ingresa un correo electrónico válido.',
            'email.max'         => 'El correo no puede exceder 255 caracteres.',
            'unique'            => 'Este :attribute ya está registrado.',
            'min'              => 'La contraseña debe tener al menos :min caracteres.',
            'min.string'       => 'La contraseña debe tener al menos :min caracteres.',
            'max'              => 'El campo :attribute no puede exceder :max caracteres.',
            'numeric'          => 'El campo :attribute debe ser numérico.',
            'digits_between'    => 'El documento debe tener entre :min y :max dígitos.',
            'accepted'         => 'Debes aceptar los términos y condiciones.',
            'regex'            => 'El campo :attribute solo puede contener letras.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ];
    }
}
