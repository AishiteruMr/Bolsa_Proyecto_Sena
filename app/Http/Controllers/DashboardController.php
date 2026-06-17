<?php

namespace App\Http\Controllers;

use App\Models\Aprendiz;
use App\Models\Empresa;
use App\Models\Instructor;
use App\Models\Postulacion;
use App\Models\Proyecto;
use App\Models\User;
use App\Models\MensajeSoporte;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;

class DashboardController extends Controller
{
    public function counters(Request $request)
    {
        $rolId = session('rol');
        $data = [];

        switch ((int) $rolId) {
            case 4:
                $data = [
                    'proyectos' => Proyecto::count(),
                    'pendientes' => Proyecto::where('estado', 'pendiente')->count(),
                    'usuarios' => User::count(),
                    'empresas' => Empresa::count(),
                    'aprendices' => Aprendiz::count(),
                    'instructores' => Instructor::count(),
                    'soporte' => MensajeSoporte::whereNull('respuesta')->count(),
                ];
                break;
            case 2:
                $instructorId = session('usr_id');
                $data = [
                    'proyectos' => Proyecto::whereHas('instructores', fn($q) => $q->where('users.id', $instructorId))->count(),
                    'evidencias' => Postulacion::whereHas('proyecto.instructores', fn($q) => $q->where('users.id', $instructorId))
                        ->whereHas('evidencias', fn($q) => $q->whereNull('calificacion'))->count(),
                ];
                break;
            case 3:
                $empresaId = session('emp_id');
                $data = [
                    'proyectos' => Proyecto::where('empresa_id', $empresaId)->count(),
                    'postulaciones' => Postulacion::whereHas('proyecto', fn($q) => $q->where('empresa_id', $empresaId))->count(),
                    'pendientes' => Postulacion::whereHas('proyecto', fn($q) => $q->where('empresa_id', $empresaId))
                        ->where('estado', 'pendiente')->count(),
                ];
                break;
            case 1:
                $aprendizId = session('usr_id');
                $data = [
                    'proyectos' => Postulacion::where('aprendiz_id', $aprendizId)->where('estado', 'aceptada')->count(),
                    'postulaciones' => Postulacion::where('aprendiz_id', $aprendizId)->count(),
                ];
                break;
        }

        return response()->json($data);
    }

    public function partialProyectos()
    {
        $rolId = session('rol');

        switch ((int) $rolId) {
            case 4:
                $proyectosRecientes = Cache::remember('admin_proyectos_recientes', now()->addSeconds(30), function () {
                    return Proyecto::with('empresa')
                        ->orderByDesc('id')
                        ->limit(5)
                        ->get();
                });
                return View::make('admin.partials.table-proyectos', compact('proyectosRecientes'));
            case 3:
                $empresaId = session('emp_id');
                $proyectosRecientes = Proyecto::with('postulaciones')
                    ->where('empresa_id', $empresaId)
                    ->orderByDesc('id')
                    ->limit(5)
                    ->get();
                return View::make('empresa.partials.table-proyectos', compact('proyectosRecientes'));
            default:
                return response('', 204);
        }
    }

    public function partialActividad()
    {
        $logs = AuditLog::with('user')
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        return View::make('admin.partials.list-actividad', compact('logs'));
    }

    public function partialUsuarios()
    {
        if ((int) session('rol') !== 4) {
            return response('', 204);
        }

        $usuariosRecientes = Cache::remember('admin_usuarios_recientes', now()->addSeconds(30), function () {
            return User::orderByDesc('created_at')
                ->limit(5)
                ->get();
        });

        return View::make('admin.partials.list-usuarios', compact('usuariosRecientes'));
    }
}
