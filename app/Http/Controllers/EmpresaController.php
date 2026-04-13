<?php

namespace App\Http\Controllers;

use App\Mail\PostulacionEstadoCambiado;
use App\Models\Aprendiz;
use App\Models\Empresa;
use App\Models\Etapa;
use App\Models\Evidencia;
use App\Models\Postulacion;
use App\Models\Proyecto;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class EmpresaController extends Controller
{
    public function dashboard()
    {
        $nit = session('nit');
        $empresa = Empresa::where('nit', $nit)->first();

        if (! $empresa) {
            return redirect()->route('login')->with('error', 'No se encontró el perfil de tu empresa.');
        }

        // Obtener proyectos de la empresa (una sola consulta)
        $empresaProyectos = $empresa->proyectos();
        $proyectoIds = $empresaProyectos->pluck('id');

        // Optimizado: usar una sola colección para todos los conteos
        $todosProyectos = $empresaProyectos->get();
        $totalProyectos = $todosProyectos->count();
        $proyectosActivos = $todosProyectos->whereIn('estado', ['aprobado', 'en_progreso'])->count();

        // Proyectos recientes con eager loading y conteo de postulaciones
        $proyectosRecientes = $empresa->proyectos()
            ->with(['instructor'])
            ->withCount('postulaciones')
            ->orderByDesc('id')
            ->limit(5)
            ->get();

        // Optimizado: una sola consulta para postulaciones
        $postulacionCounts = Postulacion::whereIn('proyecto_id', $proyectoIds)
            ->selectRaw('COUNT(*) as total, SUM(CASE WHEN estado = "pendiente" THEN 1 ELSE 0 END) as pendientes')
            ->first();

        $totalPostulaciones = $postulacionCounts->total ?? 0;
        $postulacionesPendientes = $postulacionCounts->pendientes ?? 0;

        return view('empresa.dashboard', compact(
            'totalProyectos', 'proyectosActivos', 'totalPostulaciones',
            'postulacionesPendientes', 'proyectosRecientes'
        ));
    }

    public function proyectos()
    {
        $nit = session('nit');
        $empresa = Empresa::where('nit', $nit)->first();

        if (! $empresa) {
            return redirect()->route('login')->with('error', 'No se encontró el perfil de tu empresa.');
        }

        $proyectos = $empresa->proyectos()
            ->orderByDesc('id')
            ->get();

        return view('empresa.proyectos', compact('proyectos'));
    }

    public function crearProyecto()
    {
        return view('empresa.crear-proyecto');
    }

    public function guardarProyecto(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:200',
            'categoria' => 'required|string|max:100',
            'descripcion' => 'required|string|max:500',
            'requisitos' => 'required|string|max:200',
            'habilidades' => 'required|string|max:200',
            'fecha_publi' => 'required|date',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        $nit = session('nit');
        $imagenUrl = null;

        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');

            // Validar MIME real
            $mime = $file->getMimeType();
            $allowedMimes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];

            if (! in_array($mime, $allowedMimes)) {
                return back()->with('error', 'Tipo de imagen no permitido.');
            }

            // Nombre seguro
            $extension = $file->getClientOriginalExtension();
            $safeFilename = 'proyecto_'.$nit.'_'.time().'_'.bin2hex(random_bytes(4)).'.'.$extension;
            $path = $file->storeAs('proyectos', $safeFilename, 'public');
            $imagenUrl = $path;
        }

        // Calcular fecha de finalización (6 meses desde la fecha de publicación)
        $fechaPubli = Carbon::parse($request->fecha_publi);
        $fechaFinalizacion = $fechaPubli->addMonths(6);

        Proyecto::create([
            'empresa_nit' => $nit,
            'titulo' => $request->titulo,
            'categoria' => $request->categoria,
            'descripcion' => $request->descripcion,
            'requisitos_especificos' => $request->requisitos,
            'habilidades_requeridas' => $request->habilidades,
            'fecha_publicacion' => $request->fecha_publi,
            'duracion_estimada_dias' => $fechaPubli->diffInDays($fechaFinalizacion),
            'estado' => 'pendiente', // Cambiado a Pendiente para flujo de aprobación
            'imagen_url' => $imagenUrl,
            'latitud' => $request->latitud,
            'longitud' => $request->longitud,
        ]);

        return redirect()->route('empresa.proyectos')->with('success', ' Proyecto enviado para revisión. Aparecerá como "Activo" una vez el administrador lo apruebe.');
    }

    public function editarProyecto(int $id)
    {
        $nit = session('nit');
        $proyecto = Proyecto::where('id', $id)
            ->where('empresa_nit', $nit)
            ->firstOrFail();

        return view('empresa.editar-proyecto', compact('proyecto'));
    }

    public function actualizarProyecto(Request $request, int $id)
    {
        $request->validate([
            'titulo' => 'required|string|max:200',
            'categoria' => 'required|string|max:100',
            'descripcion' => 'required|string|max:500',
            'requisitos' => 'required|string|max:200',
            'habilidades' => 'required|string|max:200',
            'fecha_publi' => 'required|date',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $nit = session('nit');
        $proyecto = Proyecto::where('id', $id)
            ->where('empresa_nit', $nit)
            ->firstOrFail();

        // Calcular fecha de finalización (6 meses desde la fecha de publicación)
        $fechaPubli = Carbon::parse($request->fecha_publi);
        $fechaFinalizacion = $fechaPubli->addMonths(6);

        $datos = [
            'titulo' => $request->titulo,
            'categoria' => $request->categoria,
            'descripcion' => $request->descripcion,
            'requisitos_especificos' => $request->requisitos,
            'habilidades_requeridas' => $request->habilidades,
            'fecha_publicacion' => $request->fecha_publi,
            'duracion_estimada_dias' => $fechaPubli->diffInDays($fechaFinalizacion),
            'latitud' => $request->latitud,
            'longitud' => $request->longitud,
        ];

        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');

            // Validar MIME real
            $mime = $file->getMimeType();
            $allowedMimes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];

            if (! in_array($mime, $allowedMimes)) {
                return back()->with('error', 'Tipo de imagen no permitido.');
            }

            // Nombre seguro
            $extension = $file->getClientOriginalExtension();
            $safeFilename = 'proyecto_'.$nit.'_'.time().'_'.bin2hex(random_bytes(4)).'.'.$extension;
            $path = $file->storeAs('proyectos', $safeFilename, 'public');
            $datos['imagen_url'] = $path;
        }

        $proyecto->update($datos);

        return redirect()->route('empresa.proyectos')->with('success', 'Proyecto actualizado correctamente.');
    }

    public function eliminarProyecto(int $id)
    {
        $nit = session('nit');

        try {
            // Verificar que el proyecto pertenece a la empresa
            $proyecto = Proyecto::where('id', $id)
                ->where('empresa_nit', $nit)
                ->firstOrFail();

            // Solo cerrar el proyecto (no eliminar)
            $proyecto->update(['estado' => 'cerrado']);

            return redirect()->route('empresa.proyectos')->with('success', 'Proyecto cerrado correctamente. Ya no será visible para nuevos aprendices.');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('empresa.proyectos')->with('error', 'Proyecto no encontrado.');
        } catch (\Exception $e) {
            return redirect()->route('empresa.proyectos')->with('error', 'Error al cerrar el proyecto.');
        }
    }

    public function verPostulantes(int $id)
    {
        $nit = session('nit');

        $proyecto = Proyecto::where('id', $id)
            ->where('empresa_nit', $nit)
            ->firstOrFail();

        // Obtener postulantes con relaciones eager loaded
        $postulantes = $proyecto->postulaciones()
            ->with(['aprendiz.usuario'])
            ->orderByDesc('fecha_postulacion')
            ->get()
            ->map(function ($postulacion) {
                return (object) [
                    'pos_id' => $postulacion->id,
                    'pos_estado' => $postulacion->estado,
                    'pos_fecha' => $postulacion->fecha_postulacion,
                    'apr_nombre' => $postulacion->aprendiz->nombres,
                    'apr_apellido' => $postulacion->aprendiz->apellidos,
                    'apr_programa' => $postulacion->aprendiz->programa_formacion,
                    'usr_correo' => $postulacion->aprendiz->usuario->correo,
                ];
            });

        return view('empresa.postulantes', compact('proyecto', 'postulantes'));
    }

    public function verParticipantes(int $id)
    {
        $nit = session('nit');

        $proyecto = Proyecto::with(['instructor', 'empresa'])
            ->where('id', $id)
            ->where('empresa_nit', $nit)
            ->firstOrFail();

        // Aprendices aprobados
        $aprendices = Postulacion::where('proyecto_id', $id)
            ->where('estado', 'aceptada')
            ->with(['aprendiz.usuario'])
            ->get()
            ->map(function ($post) {
                return (object) [
                    'apr_id' => $post->aprendiz->id,
                    'apr_nombre' => $post->aprendiz->nombres,
                    'apr_apellido' => $post->aprendiz->apellidos,
                    'apr_programa' => $post->aprendiz->programa_formacion,
                    'usr_correo' => optional($post->aprendiz->usuario)->correo,
                ];
            });

        return view('empresa.participantes', compact('proyecto', 'aprendices'));
    }

    /**
     * Ver reporte de proyecto para exportar PDF
     */
    public function verReporte(int $id)
    {
        $nit = session('nit');

        $proyecto = Proyecto::where('id', $id)
            ->where('empresa_nit', $nit)
            ->where('estado', 'aprobado')
            ->with(['instructor', 'empresa'])
            ->firstOrFail();

        $etapas = Etapa::where('proyecto_id', $id)
            ->orderBy('orden')
            ->get();

        $aprendices = Aprendiz::whereHas('postulaciones', function ($query) use ($id) {
            $query->where('proyecto_id', $id)
                ->where('estado', 'aceptada');
        })->with('usuario')->get();

        $evidencias = Evidencia::where('evidencias.proyecto_id', $id)
            ->join('etapas', 'evidencias.etapa_id', '=', 'etapas.id')
            ->join('aprendices', 'evidencias.aprendiz_id', '=', 'aprendices.id')
            ->orderBy('etapas.orden', 'asc')
            ->orderByDesc('evidencias.fecha_envio')
            ->select(
                'evidencias.*',
                'aprendices.nombres as aprendiz_nombres',
                'aprendices.apellidos as aprendiz_apellidos'
            )
            ->get();

        $entregas = $evidencias;

        return view('empresa.reporte-proyecto', compact(
            'proyecto', 'etapas', 'aprendices', 'evidencias', 'entregas'
        ));
    }

    public function cambiarEstadoPostulacion(Request $request, int $id)
    {
        // ✅ SEGURIDAD: Validación explícita de estados permitidos
        $request->validate([
            'estado' => 'required|string|in:pendiente,aceptada,rechazada',
        ], [
            'estado.required' => 'El estado es obligatorio.',
            'estado.in' => 'El estado debe ser: pendiente, aceptada o rechazada.',
        ]);

        $nit = session('nit');

        // ✅ SEGURIDAD: Validar que la postulación pertenece a un proyecto de esta empresa
        $postulacion = Postulacion::with('proyecto')
            ->where('id', $id)
            ->whereHas('proyecto', function ($query) use ($nit) {
                $query->where('empresa_nit', $nit);
            })
            ->firstOrFail();

        // ✅ SEGURIDAD: El estado es validado en el validator, se puede usar directamente
        $estadoInput = strtolower($request->estado);

        $postulacion->update(['estado' => $estadoInput]);

        // Send email notification to aprendiz
        try {
            $aprendiz = $postulacion->aprendiz;
            $usuarioCorreo = optional($aprendiz->usuario)->correo;
            if ($usuarioCorreo) {
                Mail::to($usuarioCorreo)->send(
                    new PostulacionEstadoCambiado(
                        $aprendiz->nombres ?? 'Aprendiz',
                        $postulacion->proyecto,
                        ucfirst($estadoInput)
                    )
                );
            }
        } catch (\Exception $e) {
            Log::error('Error enviando email de estado postulación: '.$e->getMessage());
        }

        return back()->with('success', 'Estado de postulación actualizado y aprendiz notificado.');
    }

    public function perfil()
    {
        $empId = session('emp_id');
        $empresa = Empresa::findOrFail($empId);

        return view('empresa.perfil', compact('empresa'));
    }

    public function actualizarPerfil(Request $request)
    {
        $empId = session('emp_id');
        $empresa = Empresa::findOrFail($empId);

        $request->validate([
            'nombre_empresa' => 'required|string|max:150',
            'representante' => [
                'required',
                'string',
                'max:100',
                'min:10',
                'regex:/^[a-zA-ZÀ-ÿ\s]+$/u',
                function ($attribute, $value, $fail) {
                    $palabras = count(array_filter(explode(' ', trim($value))));
                    if ($palabras < 2) {
                        $fail('El nombre del representante debe incluir nombre y apellido (mínimo 2 palabras).');
                    }
                },
            ],
            'password' => 'nullable|string|min:8',
        ]);

        $datos = [
            'nombre' => $request->nombre_empresa,
            'representante' => $request->representante,
        ];

        if ($request->filled('password')) {
            // Empresa uses password on User now ideally, but table may have it
            // Assuming it's still being replicated or purely in User table:
            $usuario = User::find($empresa->usuario_id);
            if ($usuario) {
                $usuario->update(['contrasena' => Hash::make($request->password)]);
            }
        }

        $empresa->update($datos);
        session(['nombre' => $request->nombre_empresa]);

        return back()->with('success', 'Perfil actualizado correctamente.');
    }
}
