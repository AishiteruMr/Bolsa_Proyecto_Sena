<?php

namespace App\Services;

use App\Models\Aprendiz;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AprendizService
{
    public function obtenerPorUsuario(int $usuarioId): ?Aprendiz
    {
        return Aprendiz::where('usuario_id', $usuarioId)->first();
    }

    public function obtenerInformacion(int $aprendizId): array
    {
        $aprendiz = Aprendiz::find($aprendizId);

        if (!$aprendiz) {
            return [];
        }

        return [
            'aprendiz' => $aprendiz,
            'usuario' => $aprendiz->usuario,
            'totalPostulaciones' => $aprendiz->countPostulaciones(),
            'postulacionesAprobadas' => $aprendiz->countPostulacionesAprobadas(),
            'postulacionesPendientes' => $aprendiz->postulacionesPendientes()->count(),
            'postulacionesRechazadas' => $aprendiz->postulacionesRechazadas()->count(),
        ];
    }

    public function obtenerEstadisticas(int $aprendizId): array
    {
        $aprendiz = Aprendiz::with('evidencias')->find($aprendizId);

        if (!$aprendiz) {
            return [];
        }

        $evidencias = $aprendiz->evidencias;

        return [
            'totalPostulaciones' => $aprendiz->countPostulaciones(),
            'postulacionesAprobadas' => $aprendiz->countPostulacionesAprobadas(),
            'postulacionesPendientes' => $aprendiz->postulacionesPendientes()->count(),
            'postulacionesRechazadas' => $aprendiz->postulacionesRechazadas()->count(),
            'totalEvidencias' => $evidencias->count(),
            'evidenciasAprobadas' => $evidencias->where('estado', 'aceptada')->count(),
            'evidenciasPendientes' => $evidencias->where('estado', 'pendiente')->count(),
            'evidenciasRechazadas' => $evidencias->where('estado', 'rechazada')->count(),
        ];
    }

    public function actualizarPerfil(
        int $aprendizId,
        string $nombre,
        string $apellido,
        string $programa,
        ?string $contrasena = null
    ): bool {
        try {
            $aprendiz = Aprendiz::find($aprendizId);

            if (!$aprendiz) {
                return false;
            }

            $aprendiz->update([
                'nombres'            => $nombre,
                'apellidos'          => $apellido,
                'programa_formacion' => $programa,
            ]);

            if ($contrasena) {
                $usuario = $aprendiz->usuario;
                if ($usuario) {
                    $usuario->update([
                        'contrasena' => Hash::make($contrasena),
                    ]);
                }
            }

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function obtenerProyectosAprobados(int $aprendizId)
    {
        return Aprendiz::find($aprendizId)
            ?->proyectosAprobados()
            ?? collect();
    }

    public function obtenerProyectosPostulados(int $aprendizId)
    {
        return Aprendiz::find($aprendizId)
            ?->proyectosPostulados()
            ?? collect();
    }

    public function estaActivo(int $aprendizId): bool
    {
        $aprendiz = Aprendiz::find($aprendizId);
        return $aprendiz ? $aprendiz->isActivo() : false;
    }

    public function obtenerNombreCompleto(int $aprendizId): string
    {
        $aprendiz = Aprendiz::find($aprendizId);
        return $aprendiz ? $aprendiz->getFullNameAttribute() : '';
    }

    public function obtenerActivos()
    {
        return Aprendiz::activos()->get();
    }

    public function contarActivos(): int
    {
        return Aprendiz::activos()->count();
    }
}
