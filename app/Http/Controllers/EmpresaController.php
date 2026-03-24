<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Proyecto;
use App\Models\Postulacion;
use App\Models\Empresa;
use App\Models\Evidencia;
use App\Models\Etapa;

class EmpresaController extends Controller
{
    public function dashboard()
    {
        $empresa = Empresa::where('emp_nit', cnit())->first();

        if (!$empresa) {
            return redirect()->route('login')->with('error', 'No se encontró el perfil de tu empresa.');
        }

        // Obtener proyectos de la empresa
        $proyectos = $empresa->proyectos();

        $totalProyectos = $proyectos->count();
        $proyectosActivos = $proyectos->where('pro_estado', 'Activo')->count();
        
        // Proyectos recientes con eager loading y conteo de postulaciones
        $proyectosRecientes = $empresa->proyectos()
            ->with(['instructor'])
            ->withCount('postulaciones')
            ->orderByDesc('pro_id')
            ->limit(5)
            ->get();
        
        $totalPostulaciones = Postulacion::whereIn('pro_id', 
            $empresa->proyectos()->pluck('pro_id')
        )->count();

        $postulacionesPendientes = Postulacion::whereIn('pro_id', 
            $empresa->proyectos()->pluck('pro_id')
        )->where('pos_estado', 'Pendiente')->count();

        return view('empresa.dashboard', compact(
            'totalProyectos', 'proyectosActivos', 'totalPostulaciones',
            'postulacionesPendientes', 'proyectosRecientes'
        ));
    }

    public function proyectos()
    {
        $empresa = Empresa::where('emp_nit', cnit())->first();

        if (!$empresa) {
            return redirect()->route('login')->with('error', 'No se encontró el perfil de tu empresa.');
        }
        
        $proyectos = $empresa->proyectos()
            ->orderByDesc('pro_id')
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
            'titulo'       => 'required|string|max:200',
            'categoria'    => 'required|string|max:100',
            'descripcion'  => 'required|string|max:500',
            'requisitos'   => 'required|string|max:200',
            'habilidades'  => 'required|string|max:200',
            'fecha_publi'  => 'required|date',
            'imagen'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $imagenUrl = null;

        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('proyectos', 'public');
            $imagenUrl = '/storage/' . $path;
        }

        // Calcular fecha de finalización (6 meses desde la fecha de publicación)
        $fechaPubli = \Carbon\Carbon::parse($request->fecha_publi);
        $fechaFinalizacion = $fechaPubli->addMonths(6);

        Proyecto::create([
            'emp_nit'                    => cnit(),
            'pro_titulo_proyecto'        => $request->titulo,
            'pro_categoria'              => $request->categoria,
            'pro_descripcion'            => $request->descripcion,
            'pro_requisitos_especificos' => $request->requisitos,
            'pro_habilidades_requerida'  => $request->habilidades,
            'pro_fecha_publi'            => $request->fecha_publi,
            'pro_fecha_finalizacion'     => $fechaFinalizacion,
            'pro_duracion_estimada'      => $fechaPubli->diffInDays($fechaFinalizacion),
            'pro_estado'                 => 'Activo',
            'pro_imagen_url'             => $imagenUrl,
        ]);

        Log::info('Proyecto creado por empresa', ['nit' => cnit(), 'titulo' => $request->titulo]);

        return redirect()->route('empresa.proyectos')->with('success', 'Proyecto publicado correctamente.');
    }

    public function editarProyecto(int $id)
    {
        $proyecto = Proyecto::where('pro_id', $id)
            ->where('emp_nit', cnit())
            ->firstOrFail();

        return view('empresa.editar-proyecto', compact('proyecto'));
    }

    public function actualizarProyecto(Request $request, int $id)
    {
        $request->validate([
            'titulo'      => 'required|string|max:200',
            'categoria'   => 'required|string|max:100',
            'descripcion' => 'required|string|max:500',
            'requisitos'  => 'required|string|max:200',
            'habilidades' => 'required|string|max:200',
            'fecha_publi' => 'required|date',
            'imagen'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $proyecto = Proyecto::where('pro_id', $id)
            ->where('emp_nit', cnit())
            ->firstOrFail();

        // Calcular fecha de finalización (6 meses desde la fecha de publicación)
        $fechaPubli = \Carbon\Carbon::parse($request->fecha_publi);
        $fechaFinalizacion = $fechaPubli->addMonths(6);
        
        $datos = [
            'pro_titulo_proyecto'        => $request->titulo,
            'pro_categoria'              => $request->categoria,
            'pro_descripcion'            => $request->descripcion,
            'pro_requisitos_especificos' => $request->requisitos,
            'pro_habilidades_requerida'  => $request->habilidades,
            'pro_fecha_publi'            => $request->fecha_publi,
            'pro_fecha_finalizacion'     => $fechaFinalizacion,
            'pro_duracion_estimada'      => $fechaPubli->diffInDays($fechaFinalizacion),
        ];

        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('proyectos', 'public');
            $datos['pro_imagen_url'] = '/storage/' . $path;
        }

        $proyecto->update($datos);

        return redirect()->route('empresa.proyectos')->with('success', 'Proyecto actualizado correctamente.');
    }

    public function eliminarProyecto(int $id)
    {
        // Verificar que el proyecto pertenece a la empresa
        $proyecto = Proyecto::where('pro_id', $id)
            ->where('emp_nit', cnit())
            ->first();
        
        if (!$proyecto) {
            return redirect()->route('empresa.proyectos')->with('error', 'Proyecto no encontrado.');
        }
        
        // Eliminar evidencias del proyecto
        Evidencia::where('evid_pro_id', $id)->delete();
        
        // Eliminar etapas del proyecto
        Etapa::where('eta_pro_id', $id)->delete();
        
        // Eliminar postulaciones del proyecto
        Postulacion::where('pro_id', $id)->delete();
        
        // Finalmente eliminar el proyecto
        $proyecto->delete();
        
        return redirect()->route('empresa.proyectos')->with('success', 'Proyecto eliminado correctamente.');
    }
    public function verPostulantes(int $id)
    {
        $proyecto = Proyecto::where('pro_id', $id)
            ->where('emp_nit', cnit())
            ->firstOrFail();

        // Obtener postulantes con relaciones eager loaded
        $postulantes = $proyecto->postulaciones()
            ->with(['aprendiz.usuario'])
            ->orderByDesc('pos_fecha')
            ->get();

        return view('empresa.postulantes', compact('proyecto', 'postulantes'));
    }

    public function cambiarEstadoPostulacion(Request $request, int $id)
    {
        $request->validate(['estado' => 'required|in:Pendiente,Aprobada,Rechazada']);
        
        // SEGURIDAD: Validar que la postulación pertenece a un proyecto de esta empresa
        $postulacion = Postulacion::with('proyecto')
            ->where('pos_id', $id)
            ->whereHas('proyecto', function($query) {
                $query->where('emp_nit', cnit());
            })
            ->firstOrFail();

        $postulacion->update(['pos_estado' => $request->estado]);

        return back()->with('success', 'Estado de postulación actualizado.');
    }

    public function perfil()
    {
        $empresa = Empresa::findOrFail(cemp_id());
        return view('empresa.perfil', compact('empresa'));
    }

    public function actualizarPerfil(Request $request)
    {
        $empresa = Empresa::findOrFail(cemp_id());

        $request->validate([
            'nombre_empresa' => 'required|string|max:150',
            'representante'  => 'required|string|max:100',
            'password'       => 'nullable|string|min:6',
        ]);

        $datos = [
            'emp_nombre'        => $request->nombre_empresa,
            'emp_representante' => $request->representante,
        ];

        if ($request->filled('password')) {
            $datos['emp_contrasena'] = Hash::make($request->password);
        }

        $empresa->update($datos);
        session(['nombre' => $request->nombre_empresa]);

        return back()->with('success', 'Perfil actualizado correctamente.');
    }
}
