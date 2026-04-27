<?php

namespace App\Http\Controllers;

use App\Http\Requests\CambiarEstadoUsuarioRequest;
use App\Http\Requests\GestionarPostulacionRequest;
use App\Http\Requests\GestionarProyectoRequest;
use App\Mail\InstructorAsignado;
use App\Mail\InstructorDesasignado;
use App\Mail\RegistroExitoso;
use App\Mail\RespuestaSoporte;
use App\Models\Aprendiz;
use App\Models\AuditLog;
use App\Models\Empresa;
use App\Models\Instructor;
use App\Models\MensajeSoporte;
use App\Models\Postulacion;
use App\Models\Proyecto;
use App\Models\User;
use App\Notifications\AppNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function dashboard(): View
    {
        $stats = Cache::remember('admin_stats', now()->addMinutes(5), function () {
            return [
                'aprendices' => Aprendiz::count(),
                'instructores' => Instructor::count(),
                'empresas' => Empresa::count(),
                'proyectos' => Proyecto::count(),
                'pendientes' => Proyecto::where('estado', 'pendiente')->count(),
                'usuarios' => User::count(),
            ];
        });

        $proyectosRecientes = Cache::remember('admin_proyectos_recientes', now()->addMinutes(5), function () {
            return Proyecto::with('empresa')
                ->orderByDesc('id')
                ->limit(5)
                ->get();
        });

        $usuariosRecientes = Cache::remember('admin_usuarios_recientes', now()->addMinutes(5), function () {
            return User::orderByDesc('created_at')
                ->limit(5)
                ->get();
        });

        return view('admin.dashboard', compact('stats', 'proyectosRecientes', 'usuariosRecientes'));
    }

    public function usuarios(Request $request): View
    {
        $aprendices = Aprendiz::with('usuario')
            ->orderByDesc('id')
            ->paginate($this->getPerPage($request, 15, 5, 50), ['*'], 'aprendices');

        $instructores = Instructor::with('usuario')
            ->orderByDesc('id')
            ->paginate($this->getPerPage($request, 15, 5, 50), ['*'], 'instructores');

        $empresas = Empresa::orderByDesc('id')
            ->paginate($this->getPerPage($request, 15, 5, 50), ['*'], 'empresas');

        return view('admin.usuarios', compact('aprendices', 'instructores', 'empresas'));
    }

    public function cambiarEstadoUsuario(CambiarEstadoUsuarioRequest $request, int $id): RedirectResponse
    {
        $usrId = session('usr_id');

        if ($request->tipo === 'aprendiz') {
            $aprendiz = Aprendiz::with('usuario')->findOrFail($id);
            $anterior = ['activo' => $aprendiz->activo];
            $aprendiz->update(['activo' => $request->estado]);
            Cache::forget('admin_stats');
            $usrToNotify = $aprendiz->usuario;

            // Audit log detallado
            AuditLog::registrarCambio(
                $usrId,
                'cambiar_estado',
                'usuarios',
                'aprendices',
                $id,
                $anterior,
                ['activo' => $request->estado]
            );
        } else {
            $instructor = Instructor::with('usuario')->findOrFail($id);
            $anterior = ['activo' => $instructor->activo];
            $instructor->update(['activo' => $request->estado]);
            Cache::forget('admin_stats');
            $usrToNotify = $instructor->usuario;

            // Audit log detallado
            AuditLog::registrarCambio(
                $usrId,
                'cambiar_estado',
                'usuarios',
                'instructores',
                $id,
                $anterior,
                ['activo' => $request->estado]
            );
        }

        try {
            if (isset($usrToNotify)) {
                $estadoTexto = $request->estado == 1 ? 'activada' : 'desactivada';
                $usrToNotify->notify(new AppNotification(
                    'Cuenta '.$estadoTexto,
                    'Tu cuenta ha sido '.$estadoTexto.' por un administrador.',
                    $request->estado == 1 ? 'fa-user-check' : 'fa-user-lock'
                ));

                // --- SEND WELCOME EMAIL ON ACTIVATION ---
                if ($request->estado == 1) {
                    $tabla = $request->tipo === 'aprendiz' ? 'aprendices' : 'instructores';
                    $perfil = DB::table($tabla)->where('usuario_id', $usrToNotify->id)->first();
                    if ($perfil) {
                        Mail::to($usrToNotify->correo)->send(new RegistroExitoso($perfil->nombres, $perfil->apellidos));
                    }
                }
                // ----------------------------------------
            }
        } catch (\Exception $e) {
            Log::error('Error al notificar estado de usuario: '.$e->getMessage(), ['trace' => $e->getTraceAsString()]);
        }

        return back()->with('success', 'Estado del usuario actualizado.');
    }

    public function empresas(Request $request): View
    {
        $empresas = Empresa::orderByDesc('id')
            ->paginate($this->getPerPage($request, 15, 5, 50));

        return view('admin.empresas', compact('empresas'));
    }

    public function cambiarEstadoEmpresa(Request $request, int $id): RedirectResponse
    {
        $request->validate(['estado' => 'required|in:0,1']);

        $usrId = session('usr_id');
        $empresa = Empresa::with('usuario')->findOrFail($id);

        $anterior = ['activo' => $empresa->activo];
        $empresa->update(['activo' => $request->estado]);
        Cache::forget('admin_stats');

        // Audit log detallado
        AuditLog::registrarCambio(
            $usrId,
            'cambiar_estado',
            'empresas',
            'empresas',
            $id,
            $anterior,
            ['activo' => $request->estado]
        );

        try {
            if ($empresa->usuario) {
                $estadoTexto = $request->estado == 1 ? 'activada' : 'desactivada';
                $empresa->usuario->notify(new AppNotification(
                    'Empresa '.$estadoTexto,
                    'La cuenta de tu empresa ha sido '.$estadoTexto.' por un administrador.',
                    $request->estado == 1 ? 'fa-building-circle-check' : 'fa-building-circle-xmark'
                ));

                // --- SEND WELCOME EMAIL ON ACTIVATION ---
                if ($request->estado == 1) {
                    Mail::to($empresa->usuario->correo)->send(new RegistroExitoso($empresa->nombre, ''));
                }
                // ----------------------------------------
            }
        } catch (\Exception $e) {
            Log::error('Error al notificar estado de empresa: '.$e->getMessage(), ['trace' => $e->getTraceAsString()]);
        }

        return back()->with('success', 'Estado de la empresa actualizado.');
    }

    public function proyectos(Request $request): View
    {
        $validated = $request->validate([
            'buscar' => 'nullable|string|max:100',
            'estado' => 'nullable|string|in:pendiente,aprobado,rechazado,cerrado,en_progreso',
            'categoria' => 'nullable|string|max:50',
            'fecha_inicio' => 'nullable|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'instructor_id' => 'nullable|integer|exists:usuarios,id',
        ]);

        $query = Proyecto::with(['empresa', 'instructor.usuario'])
            ->withCount('postulaciones');

        if (! empty($validated['buscar'])) {
            $buscar = addcslashes($validated['buscar'], '%_\\');
            $query->where(function ($q) use ($buscar) {
                $q->whereRaw('titulo LIKE ?', ["%{$buscar}%"])
                    ->orWhereRaw('descripcion LIKE ?', ["%{$buscar}%"])
                    ->orWhereHas('empresa', function ($q) use ($buscar) {
                        $q->whereRaw('nombre LIKE ?', ["%{$buscar}%"]);
                    });
            });
        }

        if (! empty($validated['estado'])) {
            $query->where('estado', $validated['estado']);
        }

        if (! empty($validated['categoria'])) {
            $query->where('categoria', $validated['categoria']);
        }

        if (! empty($validated['fecha_inicio'])) {
            $query->whereDate('fecha_publicacion', '>=', $validated['fecha_inicio']);
        }

        if (! empty($validated['fecha_fin'])) {
            $query->whereDate('fecha_publicacion', '<=', $validated['fecha_fin']);
        }

        if (! empty($validated['instructor_id'])) {
            $query->where('instructor_usuario_id', $validated['instructor_id']);
        }

        $proyectosPaginados = $query->orderByDesc('id')->paginate($this->getPerPage($request, 15, 5, 50));

        $proyectos = $proyectosPaginados->getCollection()->map(function ($proyecto) {
            return (object) [
                'id' => $proyecto->id,
                'titulo' => $proyecto->titulo,
                'empresa_nit' => $proyecto->empresa_nit,
                'instructor_usuario_id' => $proyecto->instructor_usuario_id,
                'calidad_aprobada' => (bool) $proyecto->calidad_aprobada,
                'estado' => $proyecto->estado,
                'categoria' => $proyecto->categoria,
                'fecha_publicacion' => $proyecto->fecha_publicacion,
                'empresa_nombre' => $proyecto->empresa?->nombre,
                'instructor_nombre' => $proyecto->instructor?->nombres,
                'postulaciones_count' => $proyecto->postulaciones_count ?? 0,
            ];
        });

        $instructores = Instructor::with('usuario')->get();

        $categorias = Proyecto::select('categoria')
            ->whereNotNull('categoria')
            ->distinct()
            ->pluck('categoria')
            ->filter()
            ->sort()
            ->values();

        return view('admin.proyectos', compact('proyectos', 'proyectosPaginados', 'instructores', 'categorias'));
    }

    public function cambiarEstadoProyecto(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'estado' => 'required|in:aprobado,rechazado,pendiente,cerrado,en_progreso',
        ], [
            'estado.required' => 'El estado es obligatorio.',
            'estado.in' => 'El estado debe ser uno de los valores permitidos.',
        ]);

        $proyecto = Proyecto::findOrFail($id);

        // Si el proyecto se inactiva, desasociar el instructor y notificarlo
        if ($request->estado === 'cerrado' || $request->estado === 'rechazado') {
            $proyectoActual = $proyecto->load('empresa');
            $instructorUsuarioId = $proyecto->instructor_usuario_id;
            $empresaUsr = $proyectoActual->empresa->usuario ?? null;

            $proyecto->update([
                'estado' => $request->estado,
                'instructor_usuario_id' => null,
                'calidad_aprobada' => false,
            ]);
            Cache::forget('admin_stats');
            Cache::forget('admin_proyectos_recientes');

            // Notificar a la empresa
            if ($empresaUsr) {
                $empresaUsr->notify(new AppNotification(
                    'Proyecto '.ucfirst($request->estado),
                    'Tu proyecto "'.Str::limit($proyectoActual->titulo, 30).'" ha sido '.$request->estado.'.',
                    $request->estado === 'cerrado' ? 'fa-ban' : 'fa-xmark'
                ));
            }

            // Notificar al instructor que fue desasignado
            if ($instructorUsuarioId) {
                try {
                    $instructorUsuario = User::where('id', $instructorUsuarioId)->with('instructor')->first();
                    if ($instructorUsuario && $instructorUsuario->instructor) {
                        Mail::to($instructorUsuario->correo)->send(new InstructorDesasignado($instructorUsuario->instructor->nombres, $proyectoActual->titulo, $proyectoActual->empresa->nombre));

                        $instructorUsuario->notify(new AppNotification(
                            'Desasignado de proyecto',
                            'Has sido removido del proyecto: '.Str::limit($proyectoActual->titulo, 30),
                            'fa-user-minus'
                        ));
                    }
                } catch (\Exception $e) {
                    Log::error('Error al actualizar estado de usuario: '.$e->getCode());
                }
            }
        } else {
            $proyecto->update([
                'estado' => $request->estado,
                'calidad_aprobada' => $request->estado === 'aprobado' ? true : $proyecto->calidad_aprobada,
            ]);
            Cache::forget('admin_stats');
            Cache::forget('admin_proyectos_recientes');
            $proyectoActual = $proyecto->load('empresa');
            $empresaUsr = $proyectoActual->empresa->usuario ?? null;
            if ($empresaUsr) {
                $empresaUsr->notify(new AppNotification(
                    'Estado de Proyecto: '.ucfirst($request->estado),
                    'El estado de tu proyecto "'.Str::limit($proyectoActual->titulo, 30).'" es: '.$request->estado,
                    'fa-info-circle'
                ));
            }
        }

        return back()->with('success', 'Estado del proyecto actualizado.');
    }

    public function asignarInstructor(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'instructor_usuario_id' => 'required|exists:usuarios,id',
        ]);

        $proyecto = Proyecto::findOrFail($id);

        if (!in_array($proyecto->estado, ['pendiente', 'aprobado'])) {
            return back()->with('error', 'No se puede asignar instructor a un proyecto que está '.$proyecto->estado.'.');
        }

        $proyecto->update(['instructor_usuario_id' => $request->instructor_usuario_id]);
        Cache::forget('admin_stats');

        // Enviar correo de notificación al instructor asignado
        try {
            $proyecto->load('empresa');

            $instructorUsuario = User::where('id', $request->instructor_usuario_id)
                ->with('instructor')
                ->first();

            if ($proyecto && $instructorUsuario && $instructorUsuario->instructor) {
                $totalPostulaciones = Postulacion::where('proyecto_id', $id)
                    ->where('estado', 'pendiente')
                    ->count();

                Mail::to($instructorUsuario->correo)
                    ->send(new InstructorAsignado(
                        $instructorUsuario->instructor->nombres,
                        $proyecto,
                        $totalPostulaciones
                    ));

                $instructorUsuario->notify(new AppNotification(
                    'Proyecto Asignado',
                    'Te han asignado liderar el proyecto: '.Str::limit($proyecto->titulo, 30),
                    'fa-chalkboard-user'
                ));
            }
        } catch (\Exception $e) {
            Log::error('Error al enviar correo de asignación de instructor: '.$e->getMessage());
        }

        return back()->with('success', 'Instructor asignado correctamente');
    }

    public function mensajesSoporte(): View
    {
        $mensajes = MensajeSoporte::orderByDesc('created_at')->paginate(15);
        return view('admin.mensajes-soporte', compact('mensajes'));
    }

    public function responderMensajeSoporte(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'respuesta' => 'required|string',
        ]);

        $mensaje = MensajeSoporte::findOrFail($id);
        $mensaje->update([
            'respuesta' => $request->respuesta,
            'estado' => 'respondido',
        ]);

        try {
            Mail::to($mensaje->email)->send(new RespuestaSoporte(
                $mensaje->nombre,
                $mensaje->motivo,
                $mensaje->mensaje,
                $mensaje->respuesta
            ));
        } catch (\Exception $e) {
            Log::error('Error al enviar respuesta de soporte: ' . $e->getMessage());
            return back()->with('error', 'Respuesta guardada pero ocurrió un error al enviar el email.');
        }

        return back()->with('success', 'Respuesta enviada correctamente.');
    }

    public function revisarProyecto(int $id): View
    {
        $proyecto = Proyecto::with('empresa')->findOrFail($id);
        $calidad = $proyecto->calidadProyecto();

        return view('admin.revisar-proyecto', compact('proyecto', 'calidad'));
    }
}
