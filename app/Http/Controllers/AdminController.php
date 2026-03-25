<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\InstructorAsignado;
use App\Mail\InstructorDesasignado;
use App\Models\Aprendiz;
use App\Models\Instructor;
use App\Models\Empresa;
use App\Models\Proyecto;
use App\Models\User;
use App\Models\Postulacion;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'aprendices'    => Aprendiz::count(),
            'instructores'  => Instructor::count(),
            'empresas'      => Empresa::count(),
            'proyectos'     => Proyecto::count(),
            'pendientes'    => Proyecto::where('pro_estado', 'Inactivo')->count(),
            'usuarios'      => User::count(),
        ];

        $proyectosRecientes = Proyecto::with('empresa')
            ->orderByDesc('pro_id')
            ->limit(5)
            ->get();

        $usuariosRecientes = User::orderByDesc('usr_fecha_creacion')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'proyectosRecientes', 'usuariosRecientes'));
    }

    public function usuarios()
    {
        $aprendices = Aprendiz::with('usuario')->get();
        $instructores = Instructor::with('usuario')->get();

        return view('admin.usuarios', compact('aprendices', 'instructores'));
    }

    public function cambiarEstadoUsuario(Request $request, int $id)
    {
        $request->validate([
            'tipo' => 'required|in:aprendiz,instructor',
            'estado' => 'required|in:0,1'
        ]);

        if ($request->tipo === 'aprendiz') {
            $aprendiz = Aprendiz::findOrFail($id);
            $aprendiz->update(['apr_estado' => $request->estado]);
        } else {
            $instructor = Instructor::where('usr_id', $id)->firstOrFail();
            $instructor->update(['ins_estado' => $request->estado]);
        }

        return back()->with('success', 'Estado del usuario actualizado.');
    }

    public function empresas()
    {
        $empresas = Empresa::orderByDesc('emp_id')->get();
        return view('admin.empresas', compact('empresas'));
    }

    public function cambiarEstadoEmpresa(Request $request, int $id)
    {
        $request->validate(['estado' => 'required|in:0,1']);

        $empresa = Empresa::findOrFail($id);
        $empresa->update(['emp_estado' => $request->estado]);

        return back()->with('success', 'Estado de la empresa actualizado.');
    }

    public function proyectos()
    {
        $proyectos = Proyecto::with(['empresa', 'instructor.usuario'])
            ->orderByDesc('pro_id')
            ->get()
            ->map(function($proyecto) {
                return (object)[
                    'pro_id' => $proyecto->pro_id,
                    'pro_titulo_proyecto' => $proyecto->pro_titulo_proyecto,
                    'emp_nit' => $proyecto->emp_nit,
                    'ins_usr_documento' => $proyecto->ins_usr_documento,
                    'pro_estado' => $proyecto->pro_estado,
                    'emp_nombre' => $proyecto->empresa->emp_nombre,
                    'ins_nombre' => $proyecto->instructor ? $proyecto->instructor->ins_nombre : null,
                ];
            });

        $instructores = Instructor::with('usuario')
            ->get()
            ->map(function($instructor) {
                return (object)[
                    'ins_nombre' => $instructor->ins_nombre,
                    'usr_documento' => $instructor->usuario->usr_documento,
                ];
            });

        return view('admin.proyectos', compact('proyectos', 'instructores'));
    }

    public function cambiarEstadoProyecto(Request $request, int $id)
    {
        $request->validate([
            'estado' => 'required|in:Activo,Inactivo,Aprobado,Rechazado'
        ]);

        $proyecto = Proyecto::findOrFail($id);

        // Si el proyecto se inactiva, desasociar el instructor y notificarlo
        if ($request->estado === 'Inactivo') {
            $proyectoActual = $proyecto->load('empresa');
            $instructorDocumento = $proyecto->ins_usr_documento;

            $proyecto->update([
                'pro_estado' => $request->estado,
                'ins_usr_documento' => null
            ]);

            // Notificar al instructor que fue desasignado
            if ($instructorDocumento) {
                try {
                    $instructorUsuario = User::where('usr_documento', $instructorDocumento)
                        ->with('instructor')
                        ->first();

                    if ($instructorUsuario && $instructorUsuario->instructor) {
                        Mail::to($instructorUsuario->usr_correo)
                            ->send(new InstructorDesasignado(
                                $instructorUsuario->instructor->ins_nombre,
                                $proyectoActual->pro_titulo_proyecto,
                                $proyectoActual->empresa->emp_nombre
                            ));
                    }
                } catch (\Exception $e) {
                    Log::error('Error al enviar correo de desasignación: ' . $e->getMessage());
                }
            }
        } else {
            $proyecto->update(['pro_estado' => $request->estado]);
        }

        return back()->with('success', 'Estado del proyecto actualizado.');
    }

    public function asignarInstructor(Request $request, $id)
    {
        $request->validate([
            'ins_usr_documento' => 'required|exists:usuario,usr_documento'
        ]);

        $proyecto = Proyecto::findOrFail($id);
        $proyecto->update(['ins_usr_documento' => $request->ins_usr_documento]);

        // Enviar correo de notificación al instructor asignado
        try {
            $proyecto->load('empresa');
            
            $instructorUsuario = User::where('usr_documento', $request->ins_usr_documento)
                ->with('instructor')
                ->first();

            if ($proyecto && $instructorUsuario && $instructorUsuario->instructor) {
                $totalPostulaciones = Postulacion::where('pro_id', $id)
                    ->where('pos_estado', 'Pendiente')
                    ->count();

                Mail::to($instructorUsuario->usr_correo)
                    ->send(new InstructorAsignado(
                        $instructorUsuario->instructor->ins_nombre,
                        $proyecto,
                        $totalPostulaciones
                    ));
            }
        } catch (\Exception $e) {
            Log::error('Error al enviar correo de asignación de instructor: ' . $e->getMessage());
        }

        return back()->with('success', 'Instructor asignado correctamente');
    }
}
