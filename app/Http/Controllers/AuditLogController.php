<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Http\Request;

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

        if ($request->filled('entidad')) {
            $entidad = $request->entidad;
            $entidadTabla = ['aprendiz' => 'aprendices', 'instructor' => 'instructores', 'empresa' => 'empresas', 'proyecto' => 'proyectos'][$entidad] ?? null;
            $query->where(function ($q) use ($entidad, $entidadTabla) {
                $q->whereRaw("JSON_EXTRACT(datos_nuevos, '$.tipo') = ?", [$entidad])
                  ->orWhereRaw("JSON_EXTRACT(datos_anteriores, '$.tipo') = ?", [$entidad])
                  ->orWhere('tabla_afectada', $entidadTabla);
            });
        }

        if ($request->filled('busqueda')) {
            $busqueda = $request->busqueda;
            $query->where(function ($q) use ($busqueda) {
                $q->where('descripcion', 'like', "%{$busqueda}%")
                  ->orWhereRaw("JSON_EXTRACT(datos_nuevos, '$.nombre_objetivo') like ?", ["%{$busqueda}%"])
                  ->orWhereRaw("JSON_EXTRACT(datos_anteriores, '$.nombre_objetivo') like ?", ["%{$busqueda}%"]);
            });
        }

        if ($request->filled('fecha_inicio')) {
            $query->whereDate('created_at', '>=', $request->fecha_inicio);
        }

        if ($request->filled('fecha_fin')) {
            $query->whereDate('created_at', '<=', $request->fecha_fin);
        }

        if ($request->filled('export')) {
            return $this->exportCsv($query);
        }

        $logs = $query->paginate(50);

        $grouped = [];
        foreach ($logs as $log) {
            $entidad = $this->determinarEntidad($log);
            $nombre = $log->datos_nuevos['nombre_objetivo'] ?? $log->datos_anteriores['nombre_objetivo'] ?? null;
            $nombre = $nombre ?: $log->datos_nuevos['instructor'] ?? $log->datos_anteriores['instructor'] ?? null;
            $nombre = $nombre ?: ('#' . $log->registro_id);
            if (!isset($grouped[$entidad])) {
                $grouped[$entidad] = [];
            }
            if (!isset($grouped[$entidad][$nombre])) {
                $grouped[$entidad][$nombre] = [];
            }
            $grouped[$entidad][$nombre][] = $log;
        }

        return view('admin.audit-logs', compact('logs', 'grouped'));
    }

    private function exportCsv($query)
    {
        $logs = $query->get();
        $filename = 'historial_' . now()->format('Y-m-d_His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];
        $callback = function () use ($logs) {
            $output = fopen('php://output', 'w');
            fputs($output, "\xEF\xBB\xBF");
            fputcsv($output, ['ID', 'Acción', 'Descripción', 'Entidad', 'Usuario', 'Módulo', 'Registro ID', 'Fecha']);
            foreach ($logs as $log) {
                fputcsv($output, [
                    $log->id,
                    $log->accion,
                    $log->descripcion,
                    $log->tabla_afectada,
                    $log->usuario->nombre_rol ?? 'Sistema',
                    $log->modulo,
                    $log->registro_id,
                    $log->created_at->format('Y-m-d H:i:s'),
                ]);
            }
            fclose($output);
        };
        return response()->stream($callback, 200, $headers);
    }

    private function determinarEntidad($log): string
    {
        $tipo = $log->datos_nuevos['tipo'] ?? $log->datos_anteriores['tipo'] ?? null;
        if ($tipo && in_array($tipo, ['aprendiz', 'instructor', 'empresa'])) {
            return $tipo;
        }

        return match ($log->tabla_afectada) {
            'aprendices' => 'aprendiz',
            'instructores' => 'instructor',
            'empresas' => 'empresa',
            'proyectos', 'postulaciones' => 'proyecto',
            default => 'general',
        };
    }
}
