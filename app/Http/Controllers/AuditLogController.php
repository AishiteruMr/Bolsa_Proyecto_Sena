<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Proyecto;
use App\Models\Postulacion;
use App\Models\Aprendiz;
use App\Models\Instructor;
use App\Models\Empresa;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    public function index(Request $request)
    {
        $query = AuditLog::with('usuario')->orderByDesc('id');

        // Aplicar filtros
        if ($request->filled('modulo')) {
            $query->modulo($request->modulo);
        }

        if ($request->filled('accion')) {
            $query->accion($request->accion);
        }

        if ($request->filled('usuario_id')) {
            $query->where('user_id', $request->usuario_id);
        }

        if ($request->filled('fecha_inicio')) {
            $query->whereDate('created_at', '>=', $request->fecha_inicio);
        }

        if ($request->filled('fecha_fin')) {
            $query->whereDate('created_at', '<=', $request->fecha_fin);
        }

        $logs = $query->paginate(30);

        // Estadísticas para el dashboard
        $stats = [
            'total_24h' => AuditLog::where('created_at', '>=', now()->subDay())->count(),
            'most_active_module' => AuditLog::select('modulo')
                ->groupBy('modulo')
                ->orderByRaw('COUNT(*) DESC')
                ->first()->modulo ?? 'N/A',
            'most_active_user' => AuditLog::select('user_id')
                ->with('usuario')
                ->groupBy('user_id')
                ->orderByRaw('COUNT(*) DESC')
                ->first()->usuario ?? null,
            'recent_logs' => AuditLog::with('usuario')->orderByDesc('id')->take(4)->get(),
            'action_distribution' => [
                'crear' => AuditLog::where('accion', 'crear')->count(),
                'editar' => AuditLog::where('accion', 'editar')->count(),
                'eliminar' => AuditLog::where('accion', 'eliminar')->count(),
            ],
            'pending_projects' => Proyecto::where('estado', 'pendiente')->count(),
            'pending_users' => Aprendiz::where('activo', 0)->count() + 
                              Instructor::where('activo', 0)->count() + 
                              Empresa::where('activo', 0)->count(),
            'pending_postulations' => Postulacion::where('estado', 'pendiente')->count(),
        ];

        $modulos = AuditLog::select('modulo')->distinct()->pluck('modulo');
        $acciones = AuditLog::select('accion')->distinct()->pluck('accion');

        return view('admin.audit-logs', compact('logs', 'modulos', 'acciones', 'stats'));
    }
}
