<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AuditLogController extends Controller
{
    public function index(Request $request)
    {
        $query = AuditLog::with('usuario')->orderByDesc('id');

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

        $modulos = AuditLog::select('modulo')->distinct()->pluck('modulo');
        $acciones = AuditLog::select('accion')->distinct()->pluck('accion');

        return Inertia::render('Admin/AuditLogs', [
            'logs' => $logs,
            'modulos' => $modulos,
            'acciones' => $acciones
        ]);
    }
}
