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

        Log::info('Estado de usuario actualizado por admin', [
            'admin_id' => cuser_id(),
            'tipo'     => $request->tipo,
            'id'       => $id,
            'nuevo_id' => $request->estado
        ]);

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

        Log::info('Estado de empresa actualizado por admin', [
            'admin_id' => cuser_id(),
            'emp_id'   => $id,
            'estado'   => $request->estado
        ]);

        return back()->with('success', 'Estado de la empresa actualizado.');
    }

    public function proyectos()
    {
        $proyectos = Proyecto::with(['empresa', 'instructor.usuario'])
            ->orderByDesc('pro_id')
            ->get();

        $instructores = Instructor::with('usuario')
            ->get();

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

        Log::info('Estado de proyecto actualizado por admin', [
            'admin_id' => cuser_id(),
            'pro_id'   => $id,
            'estado'   => $request->estado
        ]);

        return back()->with('success', 'Estado del proyecto actualizado.');
    }

    public function asignarInstructor(Request $request, $id)
    {
        // ... (existing code for asignarInstructor)
        // (I'll keep it as is, just adding the new method after it)
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
                    ->send(new \App\Mail\InstructorAsignado(
                        $instructorUsuario->instructor->ins_nombre,
                        $proyecto,
                        $totalPostulaciones
                    ));
            }
        } catch (\Exception $e) {
            Log::error('Error al enviar correo de asignación de instructor: ' . $e->getMessage());
        }

        Log::info('Instructor asignado a proyecto por admin', [
            'admin_id'  => cuser_id(),
            'pro_id'    => $id,
            'ins_doc'   => $request->ins_usr_documento
        ]);

        return back()->with('success', 'Instructor asignado correctamente');
    }

    public function exportarProyectos()
    {
        $proyectos = Proyecto::with(['empresa', 'instructor'])
            ->orderByDesc('pro_id')
            ->get();

        $filename = "reporte_proyectos_" . date('Y-m-d') . ".csv";
        $handle = fopen('php://output', 'w');

        // UTF-8 BOM for Excel
        fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        // Header
        fputcsv($handle, [
            'ID', 'Título', 'Empresa', 'NIT', 'Categoría', 'Estado', 'Instructor', 'Fecha Publicación'
        ], ';');

        foreach ($proyectos as $p) {
            fputcsv($handle, [
                $p->pro_id,
                $p->pro_titulo_proyecto,
                $p->empresa->emp_nombre,
                $p->emp_nit,
                $p->pro_categoria,
                $p->pro_estado,
                $p->instructor ? $p->instructor->ins_nombre . ' ' . $p->instructor->ins_apellido : 'No asignado',
                $p->pro_fecha_publi ? $p->pro_fecha_publi->format('Y-m-d') : 'N/A'
            ], ';');
        }

        fclose($handle);
        exit;
    }
}
