<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Mail\PostulacionEstadoCambiado;
use App\Models\Instructor;
use App\Models\Proyecto;
use App\Models\Postulacion;
use App\Models\Aprendiz;
use App\Models\Etapa;
use App\Models\Evidencia;
use App\Models\User;
use App\Services\InstructorService;

class InstructorController extends Controller
{
    protected $instructorService;

    public function __construct(InstructorService $instructorService)
    {
        $this->instructorService = $instructorService;
    }

    public function dashboard()
    {
        $instructor = Instructor::where('usr_id', cuser_id())->first();

        if (!$instructor) {
            return redirect()->route('login')->with('error', 'No se encontró tu perfil de instructor.');
        }

        $stats = $this->instructorService->getDashboardStats(cdocumento(), cuser_id());

        return view('instructor.dashboard', array_merge([
            'instructor' => $instructor,
            'proyectos' => $this->instructorService->getProyectos(cdocumento())->take(5),
        ], $stats));
    }

    public function proyectos()
    {
        $proyectos = $this->instructorService->getProyectos(cdocumento());
        return view('instructor.proyectos', compact('proyectos'));
    }

    public function aprendices()
    {
        $aprendices = $this->instructorService->getAprendices(cdocumento());
        return view('instructor.aprendices', compact('aprendices'));
    }

    public function perfil()
    {
        $usrId = cuser_id();
        $instructor = Instructor::where('usr_id', $usrId)->firstOrFail();
        $usuario = User::findOrFail($usrId);

        $stats = $this->instructorService->getProfileStats(cdocumento());

        return view('instructor.perfil', array_merge([
            'instructor' => $instructor,
            'usuario' => $usuario,
        ], $stats));
    }

    public function actualizarPerfil(Request $request)
    {
        $request->validate([
            'nombre'       => 'required|string|max:50',
            'apellido'     => 'required|string|max:50',
            'especialidad' => 'required|string|max:100',
            'password'     => 'nullable|string|min:6',
        ]);

        $this->instructorService->updateProfile(cuser_id(), $request->all());

        return back()->with('success', 'Perfil actualizado correctamente.');
    }

    public function historial()
    {
        $proyectos = $this->instructorService->getHistorial(cdocumento());
        return view('instructor.historial', compact('proyectos'));
    }

    // ── REPORTE DE SEGUIMIENTO POR PROYECTO ──
    public function reporteSeguimiento($proId)
    {
        $usrId = session('usr_id');
        
        // Verificar que el proyecto pertenece al instructor
        $proyecto = Proyecto::where('pro_id', $proId)
            ->where('ins_usr_documento', cdocumento())
            ->with('empresa')
            ->firstOrFail();

        // Obtener etapas del proyecto
        $etapas = Etapa::where('eta_pro_id', $proId)
            ->orderBy('eta_orden')
            ->get();

        // Obtener aprendices aprobados
        $aprendices = Aprendiz::whereHas('postulaciones', function($query) use ($proId) {
            $query->where('pro_id', $proId)
                ->where('pos_estado', 'Aprobada');
        })->with('usuario')->get();

        // Obtener evidencias
        $evidencias = Evidencia::where('evid_pro_id', $proId)
            ->with(['etapa', 'aprendiz'])
            ->orderBy('eta_orden', 'asc')
            ->orderByDesc('evid_fecha')
            ->get();

        return view('instructor.reporte-seguimiento', compact(
            'proyecto', 'etapas', 'aprendices', 'evidencias'
        ));
    }

    public function detalleProyecto($id)
    {
        $usrId = session('usr_id');

        $proyecto = Proyecto::where('pro_id', $id)
            ->where('ins_usr_documento', cdocumento())
            ->with('empresa')
            ->firstOrFail();

        // Obtener etapas del proyecto
        $etapas = Etapa::where('eta_pro_id', $id)
            ->orderBy('eta_orden')
            ->get();

        // Obtener postulaciones con aprendices
        $postulaciones = Postulacion::where('pro_id', $id)
            ->with(['aprendiz.usuario'])
            ->orderByDesc('pos_fecha')
            ->get();

        // Obtener integrantes aprobados
        $integrantes = Postulacion::where('pro_id', $id)
            ->where('pos_estado', 'Aprobada')
            ->with(['aprendiz.usuario'])
            ->get();

        return view('instructor.detalle_proyecto', compact('proyecto', 'etapas', 'postulaciones', 'integrantes'));
    }

    // ✅ MÉTODO PARA CAMBIAR ESTADO DE POSTULACIÓN (SOLO EL INSTRUCTOR)
    public function cambiarEstadoPostulacion(Request $request, int $id)
    {
        $request->validate(['estado' => 'required|in:Pendiente,Aprobada,Rechazada']);

        $this->instructorService->updatePostulacionStatus($id, $request->estado, cdocumento());

        return back()->with('success', 'Estado de postulación actualizado correctamente.');
    }

    // ✅ MÉTODO PARA CREAR ETAPA
    public function crearEtapa(Request $request, int $proId)
    {
        $usrId = session('usr_id');

        // Verificar que el proyecto pertenece al instructor
        $proyecto = Proyecto::where('pro_id', $proId)
            ->where('ins_usr_documento', cdocumento())
            ->firstOrFail();

        $request->validate([
            'nombre'       => 'required|string|max:200',
            'descripcion'  => 'required|string|max:1000',
            'orden'        => 'required|integer|min:1',
        ]);

        Etapa::create([
            'eta_pro_id'      => $proId,
            'eta_orden'       => $request->orden,
            'eta_nombre'      => $request->nombre,
            'eta_descripcion' => $request->descripcion,
        ]);

        return back()->with('success', 'Etapa creada correctamente.');
    }

    // ✅ MÉTODO PARA EDITAR ETAPA
    public function editarEtapa(Request $request, int $etaId)
    {
        $usrId = session('usr_id');

        // Verificar que la etapa pertenece a un proyecto del instructor
        $etapa = Etapa::where('eta_id', $etaId)
            ->whereHas('proyecto', function($query) {
                $query->where('ins_usr_documento', cdocumento());
            })->firstOrFail();

        $request->validate([
            'nombre'       => 'required|string|max:200',
            'descripcion'  => 'required|string|max:1000',
            'orden'        => 'required|integer|min:1',
        ]);

        $etapa->update([
            'eta_orden'       => $request->orden,
            'eta_nombre'      => $request->nombre,
            'eta_descripcion' => $request->descripcion,
        ]);

        return back()->with('success', 'Etapa actualizada correctamente.');
    }

    // ✅ MÉTODO PARA ELIMINAR ETAPA
    public function eliminarEtapa(int $etaId)
    {
        $usrId = session('usr_id');

        // Verificar que la etapa pertenece a un proyecto del instructor
        $etapa = Etapa::where('eta_id', $etaId)
            ->whereHas('proyecto', function($query) {
                $query->where('ins_usr_documento', cdocumento());
            })->firstOrFail();

        $etapa->delete();

        return back()->with('success', 'Etapa eliminada correctamente.');
    }

    // ✅ MÉTODO PARA SUBIR IMAGEN AL PROYECTO
    public function subirImagenProyecto(Request $request, int $proId)
    {
        $usrId = session('usr_id');

        // Verificar que el proyecto pertenece al instructor
        $proyecto = Proyecto::where('pro_id', $proId)
            ->where('ins_usr_documento', cdocumento())
            ->firstOrFail();

        $request->validate([
            'imagen' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('proyectos', 'public');
            $imagenUrl = '/storage/' . $path;

            $proyecto->update(['pro_imagen_url' => $imagenUrl]);

            return back()->with('success', 'Imagen del proyecto actualizada correctamente.');
        }

        return back()->with('error', 'No se pudo guardar la imagen.');
    }

    // ✅ MÉTODO PARA VER EVIDENCIAS DE UN PROYECTO
    public function verEvidencias(int $proId)
    {
        $usrId = session('usr_id');

        // Verificar que el proyecto pertenece al instructor
        $proyecto = Proyecto::where('pro_id', $proId)
            ->where('ins_usr_documento', cdocumento())
            ->with('empresa')
            ->firstOrFail();

        // Obtener evidencias del proyecto con detalles del aprendiz y etapa
        $evidencias = Evidencia::where('evid_pro_id', $proId)
            ->with(['aprendiz.usuario', 'etapa'])
            ->orderBy('eta_orden')
            ->orderByDesc('evid_fecha')
            ->get();

        return view('instructor.evidencias', compact('proyecto', 'evidencias'));
    }

    // ✅ MÉTODO PARA CALIFICAR EVIDENCIA
    public function calificarEvidencia(Request $request, int $evidId)
    {
        $request->validate([
            'estado'      => 'required|in:Aprobada,Rechazada,Pendiente',
            'comentario'  => 'nullable|string|max:1000',
        ]);

        $this->instructorService->gradeEvidence($evidId, $request->estado, $request->comentario, cdocumento());

        return back()->with('success', 'Evidencia calificada correctamente.');
    }
}
