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

        // Obtener proyectos de la empresa
        $proyectos = $empresa->proyectos();

        $totalProyectos = $proyectos->count();
        $proyectosActivos = $proyectos->where('estado', 'aprobado')->count(); // 'aprobado' o 'en_progreso' según semántica

        // Mejor contamos activos como 'aprobado' para coincidir con `Activo` viejo
        // En proyecto model isActivo() checkea ['aprobado', 'en_progreso']
        $proyectosActivos = $empresa->proyectos()->whereIn('estado', ['aprobado', 'en_progreso'])->count();

        // Proyectos recientes con eager loading y conteo de postulaciones
        $proyectosRecientes = $empresa->proyectos()
            ->with(['instructor'])
            ->withCount('postulaciones')
            ->orderByDesc('id')
            ->limit(5)
            ->get();

        $totalPostulaciones = Postulacion::whereIn('proyecto_id',
            $empresa->proyectos()->pluck('id')
        )->count();

        $postulacionesPendientes = Postulacion::whereIn('proyecto_id',
            $empresa->proyectos()->pluck('id')
        )->where('estado', 'pendiente')->count();

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
            'imagen' => [
                'nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048',
                'dimensions:min_width=100,min_height=100,max_width=2000,max_height=2000',
            ],
        ], [
            'imagen.mimes' => 'La imagen debe ser JPG, JPEG, PNG o WEBP.',
            'imagen.max' => 'La imagen no puede ser mayor a 2MB.',
            'imagen.dimensions' => 'La imagen debe tener al menos 100x100px y máximo 2000x2000px.',
        ]);

        $nit = session('nit');
        $imagenUrl = null;

        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');

            // Validar MIME type real
            $allowedMimes = ['image/jpeg', 'image/png', 'image/webp'];
            if (! in_array($file->getMimeType(), $allowedMimes)) {
                return back()->with('error', 'El archivo de imagen no es válido.');
            }

            $path = $file->store('proyectos', 'public');
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
            'imagen' => [
                'nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048',
                'dimensions:min_width=100,min_height=100,max_width=2000,max_height=2000',
            ],
        ], [
            'imagen.mimes' => 'La imagen debe ser JPG, JPEG, PNG o WEBP.',
            'imagen.max' => 'La imagen no puede ser mayor a 2MB.',
            'imagen.dimensions' => 'La imagen debe tener al menos 100x100px y máximo 2000x2000px.',
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

            // Validar MIME type real
            $allowedMimes = ['image/jpeg', 'image/png', 'image/webp'];
            if (! in_array($file->getMimeType(), $allowedMimes)) {
                return back()->with('error', 'El archivo de imagen no es válido.');
            }

            $path = $file->store('proyectos', 'public');
            $datos['imagen_url'] = $path;
        }

        $proyecto->update($datos);

        return redirect()->route('empresa.proyectos')->with('success', 'Proyecto actualizado correctamente.');
    }

    public function eliminarProyecto(int $id)
    {
        $nit = session('nit');

        // Verificar que el proyecto pertenece a la empresa
        $proyecto = Proyecto::where('id', $id)
            ->where('empresa_nit', $nit)
            ->first();

        if (! $proyecto) {
            return redirect()->route('empresa.proyectos')->with('error', 'Proyecto no encontrado.');
        }

        // Eliminar evidencias del proyecto
        Evidencia::where('proyecto_id', $id)->delete();

        // Eliminar etapas del proyecto
        Etapa::where('proyecto_id', $id)->delete();

        // Eliminar postulaciones del proyecto
        Postulacion::where('proyecto_id', $id)->delete();

        // Finalmente eliminar el proyecto
        $proyecto->delete();

        return redirect()->route('empresa.proyectos')->with('success', 'Proyecto eliminado correctamente.');
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

    public function cambiarEstadoPostulacion(Request $request, int $id)
    {
        // En blade tienen nombres 'Pendiente', 'Aprobada', 'Rechazada', asi que por ahora aceptamos o capitalizamos
        $estadoInput = strtolower($request->estado);
        if (in_array($estadoInput, ['aprobada', 'aprobado', 'aceptada', 'aceptado'])) {
            $estadoInput = 'aceptada';
        } elseif (in_array($estadoInput, ['rechazada', 'rechazado'])) {
            $estadoInput = 'rechazada';
        }

        // $request->validate(['estado' => 'required|in:pendiente,aceptada,rechazada']);

        $nit = session('nit');

        // SEGURIDAD: Validar que la postulación pertenece a un proyecto de esta empresa
        $postulacion = Postulacion::with('proyecto')
            ->where('id', $id)
            ->whereHas('proyecto', function ($query) use ($nit) {
                $query->where('empresa_nit', $nit);
            })
            ->firstOrFail();

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
            'password' => [
                'nullable', 'string', 'min:8', 'max:100', 'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)/',
            ],
        ], [
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'password.regex' => 'La contraseña debe tener mayúsculas, minúsculas y números.',
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
