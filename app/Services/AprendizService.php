<?php

namespace App\Services;

use App\Models\Aprendiz;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AprendizService
{
    /**
     * Obtener aprendiz por usuario ID
     *
     * @param  int  $usuarioId
     * @return Aprendiz|null
     */
    public function obtenerPorUsuario(int $usuarioId): ?Aprendiz
    {
        return Aprendiz::where('usr_id', $usuarioId)->first();
    }

    /**
     * Obtener información completa del aprendiz
     *
     * @param  int  $aprendizId
     * @return array
     */
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

    /**
     * Obtener estadísticas del aprendiz
     *
     * @param  int  $aprendizId
     * @return array
     */
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
            'evidenciasAprobadas' => $evidencias->where('evid_estado', 'Aprobada')->count(),
            'evidenciasPendientes' => $evidencias->where('evid_estado', 'Pendiente')->count(),
            'evidenciasRechazadas' => $evidencias->where('evid_estado', 'Rechazada')->count(),
        ];
    }

    /**
     * Actualizar perfil del aprendiz
     *
     * @param  int  $aprendizId
     * @param  string  $nombre
     * @param  string  $apellido
     * @param  string  $programa
     * @param  string|null  $contrasena
     * @return bool
     */
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

            // Actualizar aprendiz
            $aprendiz->update([
                'apr_nombre'   => $nombre,
                'apr_apellido' => $apellido,
                'apr_programa' => $programa,
            ]);

            // Actualizar contraseña si se proporciona
            if ($contrasena) {
                $usuario = $aprendiz->usuario;
                if ($usuario) {
                    $usuario->update([
                        'usr_contrasena' => Hash::make($contrasena),
                    ]);
                }
            }

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Obtener proyectos aprobados del aprendiz
     *
     * @param  int  $aprendizId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function obtenerProyectosAprobados(int $aprendizId)
    {
        return Aprendiz::find($aprendizId)
            ?->proyectosAprobados()
            ->get() ?? collect();
    }

    /**
     * Obtener proyectos postulados del aprendiz
     *
     * @param  int  $aprendizId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function obtenerProyectosPostulados(int $aprendizId)
    {
        return Aprendiz::find($aprendizId)
            ?->proyectosPostulados()
            ->get() ?? collect();
    }

    /**
     * Verificar si el aprendiz está activo
     *
     * @param  int  $aprendizId
     * @return bool
     */
    public function estaActivo(int $aprendizId): bool
    {
        $aprendiz = Aprendiz::find($aprendizId);
        return $aprendiz ? $aprendiz->isActivo() : false;
    }

    /**
     * Obtener nombre completo del aprendiz
     *
     * @param  int  $aprendizId
     * @return string
     */
    public function obtenerNombreCompleto(int $aprendizId): string
    {
        $aprendiz = Aprendiz::find($aprendizId);
        return $aprendiz ? $aprendiz->getFullNameAttribute() : '';
    }

    /**
     * Obtener todos los aprendices activos
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function obtenerActivos()
    {
        return Aprendiz::activos()->get();
    }

    /**
     * Contar aprendices activos
     *
     * @return int
     */
    public function contarActivos(): int
    {
        return Aprendiz::activos()->count();
    }
}
