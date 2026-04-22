<?php

namespace App\Http\Controllers;

use App\Mail\InstructorAsignado;
use App\Mail\InstructorDesasignado;
use App\Models\Aprendiz;
use App\Models\AuditLog;
use App\Models\Empresa;
use App\Models\Instructor;
use App\Models\Postulacion;
use App\Models\Proyecto;
use App\Models\User;
use App\Notifications\AppNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'aprendices' => Aprendiz::count(),
            'instructores' => Instructor::count(),
            'empresas' => Empresa::count(),
            'proyectos' => Proyecto::count(),
            'pendientes' => Proyecto::where('estado', 'pendiente')->count(),
            'usuarios' => User::count(),
        ];

        $proyectosRecientes = Proyecto::with('empresa')
            ->orderByDesc('id')
            ->limit(5)
            ->get();

        $usuariosRecientes = User::orderByDesc('created_at')
            ->limit(5)
            ->get();

        return Inertia::render('Admin/Dashboard', [
            'stats' => $stats,
            'proyectosRecientes' => $proyectosRecientes,
            'usuariosRecientes' => $usuariosRecientes
        ]);
    }

    public function usuarios()
    {
        $aprendices = Aprendiz::with('usuario')->get();
        $instructores = Instructor::with('usuario')->get();
        $empresas = Empresa::orderByDesc('id')->get();

        return Inertia::render('Admin/Usuarios', [
            'aprendices' => $aprendices,
            'instructores' => $instructores,
            'empresas' => $empresas
        ]);
    }

    public function cambiarEstadoUsuario(Request $request, int $id)
    {
        $request->validate([
            'tipo' => 'required|in:aprendiz,instructor',
            'estado' => 'required|in:0,1',
        ]);

        $usrId = session('usr_id');

        if ($request->tipo === 'aprendiz') {
            $aprendiz = Aprendiz::with('usuario')->findOrFail($id);
            $anterior = ['activo' => $aprendiz->activo];
            $aprendiz->update(['activo' => $request->estado]);
            $usrToNotify = $aprendiz->usuario;

            // Audit log
            AuditLog::registrar(
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
            $usrToNotify = $instructor->usuario;

            // Audit log
            AuditLog::registrar(
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
            }
        } catch (\Exception $e) {
            Log::error('Error al notificar estado de usuario: '.$e->getMessage(), ['trace' => $e->getTraceAsString()]);
        }

        return back()->with('success', 'Estado del usuario actualizado.');
    }

    public function empresas()
    {
        $empresas = Empresa::orderByDesc('id')->get();

        return Inertia::render('Admin/Empresas', [
            'empresas' => $empresas
        ]);
    }

    public function cambiarEstadoEmpresa(Request $request, int $id)
    {
        $request->validate(['estado' => 'required|in:0,1']);

        $usrId = session('usr_id');
        $empresa = Empresa::with('usuario')->findOrFail($id);

        $anterior = ['activo' => $empresa->activo];
        $empresa->update(['activo' => $request->estado]);

        // Audit log
        AuditLog::registrar(
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
            }
        } catch (\Exception $e) {
            Log::error('Error al notificar estado de empresa: '.$e->getMessage(), ['trace' => $e->getTraceAsString()]);
        }

        return back()->with('success', 'Estado de la empresa actualizado.');
    }

    public function proyectos(Request $request)
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
            $buscar = str_replace(['%', '_', '\\'], ['\\%', '\\_', '\\\\'], $validated['buscar']);
            $query->where(function ($q) use ($buscar) {
                $q->where('titulo', 'like', "%{$buscar}%")
                    ->orWhere('descripcion', 'like', "%{$buscar}%")
                    ->orWhereHas('empresa', function ($q) use ($buscar) {
                        $q->where('nombre', 'like', "%{$buscar}%");
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

        $proyectos = $query->orderByDesc('id')->get()->map(function ($proyecto) {
            return (object) [
                'id' => $proyecto->id,
                'titulo' => $proyecto->titulo,
                'empresa_nit' => $proyecto->empresa_nit,
                'instructor_usuario_id' => $proyecto->instructor_usuario_id,
                'estado' => $proyecto->estado,
                'categoria' => $proyecto->categoria,
                'fecha_publicacion' => $proyecto->fecha_publicacion,
                'empresa_nombre' => $proyecto->empresa->nombre ?? null,
                'instructor_nombre' => $proyecto->instructor ? $proyecto->instructor->nombres : null,
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

        return Inertia::render('Admin/Proyectos', [
            'proyectos' => $proyectos,
            'instructores' => $instructores,
            'categorias' => $categorias
        ]);
    }

    public function cambiarEstadoProyecto(Request $request, int $id)
    {
        $request->validate([
            'estado' => 'required|in:aprobado,rechazado,pendiente,cerrado,en_progreso',
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
            ]);

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
            $proyecto->update(['estado' => $request->estado]);
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

    public function asignarInstructor(Request $request, $id)
    {
        $request->validate([
            'instructor_usuario_id' => 'required|exists:usuarios,id',
        ]);

        $proyecto = Proyecto::findOrFail($id);
        $proyecto->update(['instructor_usuario_id' => $request->instructor_usuario_id]);

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

    public function revisarProyecto(int $id)
    {
        $proyecto = Proyecto::with('empresa')->findOrFail($id);
        $calidad = $proyecto->calidadProyecto();

        return Inertia::render('Admin/RevisarProyecto', [
            'proyecto' => $proyecto,
            'calidad' => $calidad
        ]);
    }
}
