<?php

namespace App\Http\Middleware;

use App\Models\Empresa;
use App\Models\Proyecto;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OwnershipMiddleware
{
    public function handle(Request $request, Closure $next, string $resource, ?string $param = null): Response
    {
        $usrId = session('usr_id');
        $rol = session('rol');
        $empId = session('emp_id');

        $param = $param ?? 'id';
        $resourceId = $request->route($param);

        if (!$resourceId) {
            return back()->with('error', 'Recurso no especificado.');
        }

        $hasAccess = match ($resource) {
            'proyecto' => $this->checkProyectoAccess($resourceId, $rol, $usrId, $empId),
            'etapa' => $this->checkEtapaAccess($resourceId, $rol, $usrId),
            'evidencia' => $this->checkEvidenciaAccess($resourceId, $rol, $usrId),
            'postulacion' => $this->checkPostulacionAccess($resourceId, $rol, $usrId),
            'aprendiz' => $this->checkAprendizAccess($resourceId, $usrId),
            'empresa' => $this->checkEmpresaAccess($resourceId, $empId),
            'perfil' => $this->checkPerfilAccess($resourceId, $usrId),
            default => false,
        };

        if (!$hasAccess) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'No tienes acceso a este recurso.'], 403);
            }
            return back()->with('error', 'No tienes acceso a este recurso.');
        }

        return $next($request);
    }

    private function checkProyectoAccess(int $proyectoId, ?int $rol, ?int $usrId, ?int $empId): bool
    {
        $proyecto = Proyecto::find($proyectoId);

        if (!$proyecto) {
            return false;
        }

        return match ($rol) {
            2 => $proyecto->instructor_usuario_id === $usrId,
            3 => $proyecto->empresa_nit === $empId,
            4 => true,
            default => false,
        };
    }

    private function checkEtapaAccess(int $etapaId, ?int $rol, ?int $usrId): bool
    {
        if ($rol === 4) {
            return true;
        }

        if ($rol === 2) {
            $etapa = \App\Models\Etapa::where('id', $etapaId)
                ->whereHas('proyecto', function ($query) use ($usrId) {
                    $query->where('instructor_usuario_id', $usrId);
                })
                ->exists();

            return $etapa;
        }

        return false;
    }

    private function checkEvidenciaAccess(int $evidenciaId, ?int $rol, ?int $usrId): bool
    {
        if ($rol === 4) {
            return true;
        }

        if ($rol === 2) {
            $evidencia = \App\Models\Evidencia::where('id', $evidenciaId)
                ->whereHas('proyecto', function ($query) use ($usrId) {
                    $query->where('instructor_usuario_id', $usrId);
                })
                ->exists();

            return $evidencia;
        }

        if ($rol === 1) {
            $evidencia = \App\Models\Evidencia::where('id', $evidenciaId)
                ->where('aprendiz_id', function ($query) use ($usrId) {
                    $query->select('id')
                        ->from('aprendices')
                        ->where('usuario_id', $usrId);
                })
                ->exists();

            return $evidencia;
        }

        return false;
    }

    private function checkPostulacionAccess(int $postulacionId, ?int $rol, ?int $usrId): bool
    {
        $postulacion = \App\Models\Postulacion::with('proyecto')->find($postulacionId);

        if (!$postulacion) {
            return false;
        }

        return match ($rol) {
            2 => $postulacion->proyecto->instructor_usuario_id === $usrId,
            3 => $postulacion->proyecto->empresa_nit === session('emp_id'),
            4 => true,
            default => false,
        };
    }

    private function checkAprendizAccess(int $aprendizId, ?int $usrId): bool
    {
        $aprendiz = \App\Models\Aprendiz::find($aprendizId);

        if (!$aprendiz) {
            return false;
        }

        return $aprendiz->usuario_id === $usrId || session('rol') === 4;
    }

    private function checkEmpresaAccess(int $empresaId, ?int $empId): bool
    {
        if (!$empId) {
            return false;
        }

        $empresa = Empresa::find($empresaId);

        if (!$empresa) {
            return false;
        }

        return $empresa->nit === $empId || session('rol') === 4;
    }

    private function checkPerfilAccess(int $userId, ?int $usrId): bool
    {
        return (int) $userId === (int) $usrId || session('rol') === 4;
    }
}