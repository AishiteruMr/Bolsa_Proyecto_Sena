<?php

namespace App\Services;

use App\Models\Aprendiz;
use App\Models\Proyecto;
use App\Models\Etapa;
use App\Models\Evidencia;
use App\Models\Postulacion;
use Illuminate\Http\UploadedFile;

class EvidenciaService
{
    /**
     * Enviar evidencia de un aprendiz para una etapa
     *
     * @param  int  $aprendizId
     * @param  int  $proyectoId
     * @param  int  $etapaId
     * @param  string  $descripcion
     * @param  UploadedFile|null  $archivo
     * @return array [boolean, string mensaje]
     */
    public function enviarEvidencia(
        int $aprendizId,
        int $proyectoId,
        int $etapaId,
        string $descripcion,
        ?UploadedFile $archivo = null
    ): array {
        try {
            // Validar que el aprendiz está aprobado en el proyecto
            $postulacion = Postulacion::where('aprendiz_id', $aprendizId)
                ->where('proyecto_id', $proyectoId)
                ->where('estado', 'aceptada')
                ->first();

            if (!$postulacion) {
                return [false, 'No tienes acceso a este proyecto o tu postulación no está aprobada.'];
            }

            // Validar que la etapa pertenece al proyecto
            $etapa = Etapa::where('id', $etapaId)
                ->where('proyecto_id', $proyectoId)
                ->first();

            if (!$etapa) {
                return [false, 'La etapa no existe o no pertenece a este proyecto.'];
            }

            // Guardar archivo si existe
            $archivoUrl = null;
            if ($archivo) {
                $archivoUrl = $archivo->store('evidencias', 'public');
            }

            // Crear evidencia
            Evidencia::create([
                'aprendiz_id'     => $aprendizId,
                'etapa_id'     => $etapaId,
                'proyecto_id'     => $proyectoId,
                'ruta_archivo'    => $archivoUrl,
                'fecha_envio'      => now(),
                'estado'     => 'pendiente',
                'comentario_instructor' => null,
            ]);

            return [true, '✅ Evidencia enviada correctamente. El instructor la revisará.'];
        } catch (\Exception $e) {
            return [false, '❌ Error al enviar la evidencia: ' . $e->getMessage()];
        }
    }

    /**
     * Obtener evidencias de un aprendiz para un proyecto
     *
     * @param  int  $aprendizId
     * @param  int  $proyectoId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function obtenerEvidenciasProyecto(int $aprendizId, int $proyectoId)
    {
        return Evidencia::where('aprendiz_id', $aprendizId)
            ->where('proyecto_id', $proyectoId)
            ->with('etapa')
            ->join('etapas', 'evidencias.etapa_id', '=', 'etapas.id')
            ->orderBy('orden')
            ->orderByDesc('fecha_envio')
            ->get();
    }

    /**
     * Obtener todas las evidencias de un aprendiz
     *
     * @param  int  $aprendizId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function obtenerTodasLasEvidencias(int $aprendizId)
    {
        return Evidencia::where('aprendiz_id', $aprendizId)
            ->with(['etapa', 'proyecto'])
            ->orderBy('proyecto_id')
            ->orderByDesc('fecha_envio')
            ->get();
    }

    /**
     * Obtener evidencias aprobadas de un aprendiz
     *
     * @param  int  $aprendizId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function obtenerEvidenciasAprobadas(int $aprendizId)
    {
        return Evidencia::where('aprendiz_id', $aprendizId)
            ->where('estado', 'aceptada')
            ->with(['etapa', 'proyecto'])
            ->orderByDesc('fecha_envio')
            ->get();
    }

    /**
     * Contar evidencias por estado
     *
     * @param  int  $aprendizId
     * @param  string  $estado
     * @return int
     */
    public function contarEvidenciasPorEstado(int $aprendizId, string $estado): int
    {
        return Evidencia::where('aprendiz_id', $aprendizId)
            ->where('estado', $estado)
            ->count();
    }

    /**
     * Obtener evidencias pendientes de revisión
     *
     * @param  int  $aprendizId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function obtenerEvidenciasPendientes(int $aprendizId)
    {
        return Evidencia::where('aprendiz_id', $aprendizId)
            ->where('estado', 'pendiente')
            ->with(['etapa', 'proyecto'])
            ->orderByDesc('fecha_envio')
            ->get();
    }

    /**
     * Verificar si existe evidencia para una etapa específica
     *
     * @param  int  $aprendizId
     * @param  int  $etapaId
     * @return bool
     */
    public function existeEvidencia(int $aprendizId, int $etapaId): bool
    {
        return Evidencia::where('aprendiz_id', $aprendizId)
            ->where('etapa_id', $etapaId)
            ->exists();
    }

    /**
     * Obtener última evidencia de una etapa
     *
     * @param  int  $aprendizId
     * @param  int  $etapaId
     * @return Evidencia|null
     */
    public function obtenerUltimaEvidencia(int $aprendizId, int $etapaId): ?Evidencia
    {
        return Evidencia::where('aprendiz_id', $aprendizId)
            ->where('etapa_id', $etapaId)
            ->orderByDesc('fecha_envio')
            ->first();
    }
}
