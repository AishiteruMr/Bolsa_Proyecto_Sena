<?php

namespace App\Services;

use App\Models\Aprendiz;
use App\Models\Proyecto;
use App\Models\Postulacion;
use App\Models\Etapa;
use App\Models\Evidencia;
use Illuminate\Http\UploadedFile;

class PostulacionService
{
    /**
     * Procesar postulación de un aprendiz a un proyecto
     *
     * @param  int  $aprendizId
     * @param  int  $proyectoId
     * @return array [boolean, string mensaje]
     */
    public function postular(int $aprendizId, int $proyectoId): array
    {
        try {
            // Validar postulación
            [$esValido, $mensaje] = Postulacion::validarPostulacion($aprendizId, $proyectoId);

            if (!$esValido) {
                return [false, $mensaje];
            }

            // Crear postulación
            Postulacion::create([
                'aprendiz_id'     => $aprendizId,
                'proyecto_id'     => $proyectoId,
                'fecha_postulacion'  => now(),
                'estado' => 'pendiente',
            ]);

            return [true, '✅ Postulación enviada correctamente. Espera la revisión del instructor.'];
        } catch (\Exception $e) {
            return [false, '❌ Error al procesar la postulación: ' . $e->getMessage()];
        }
    }

    /**
     * Obtener postulaciones de un aprendiz
     *
     * @param  int  $aprendizId
     * @param  int  $paginate
     * @return \Illuminate\Pagination\Paginator
     */
    public function obtenerPostulacionesPaginadas(int $aprendizId, int $paginate = 10)
    {
        return Postulacion::with(['proyecto' => function ($query) {
            $query->with('empresa');
        }])
        ->where('aprendiz_id', $aprendizId)
        ->recientes()
        ->paginate($paginate);
    }

    /**
     * Obtener postulaciones aprobadas de un aprendiz
     *
     * @param  int  $aprendizId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function obtenerPostulacionesAprobadas(int $aprendizId)
    {
        return Postulacion::with(['proyecto' => function ($query) {
            $query->with('empresa');
        }])
        ->where('aprendiz_id', $aprendizId)
        ->aprobadas()
        ->recientes()
        ->get();
    }

    /**
     * Obtener historial de postulaciones con proyectos
     *
     * @param  int  $aprendizId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function obtenerHistorialPostulaciones(int $aprendizId)
    {
        return Postulacion::with(['proyecto' => function ($query) {
            $query->with(['empresa', 'instructor']);
        }])
        ->where('aprendiz_id', $aprendizId)
        ->recientes()
        ->get()
        ->map(function ($postulacion) {
            $proyecto = $postulacion->proyecto;
            $proyecto->pos_estado = $postulacion->estado;
            $proyecto->pos_fecha = $postulacion->fecha_postulacion;
            $proyecto->instructor_nombre = $proyecto->instructor?->getFullNameAttribute() ?? 'No asignado';
            return $proyecto;
        });
    }

    /**
     * Contar postulaciones de un aprendiz por estado
     *
     * @param  int  $aprendizId
     * @param  string  $estado
     * @return int
     */
    public function contarPostulacionesPorEstado(int $aprendizId, string $estado): int
    {
        return Postulacion::where('aprendiz_id', $aprendizId)
            ->where('estado', $estado)
            ->count();
    }

    /**
     * Verificar si un aprendiz está postulado a un proyecto
     *
     * @param  int  $aprendizId
     * @param  int  $proyectoId
     * @return bool
     */
    public function yaPostulado(int $aprendizId, int $proyectoId): bool
    {
        return Postulacion::yaPostulado($aprendizId, $proyectoId);
    }
}
