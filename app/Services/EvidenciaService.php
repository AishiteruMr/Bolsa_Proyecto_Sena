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
            $postulacion = Postulacion::where('apr_id', $aprendizId)
                ->where('pro_id', $proyectoId)
                ->where('pos_estado', 'Aprobada')
                ->first();

            if (!$postulacion) {
                return [false, 'No tienes acceso a este proyecto o tu postulación no está aprobada.'];
            }

            // Validar que la etapa pertenece al proyecto
            $etapa = Etapa::where('eta_id', $etapaId)
                ->where('eta_pro_id', $proyectoId)
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
                'evid_apr_id'     => $aprendizId,
                'evid_eta_id'     => $etapaId,
                'evid_pro_id'     => $proyectoId,
                'evid_archivo'    => $archivoUrl,
                'evid_fecha'      => now(),
                'evid_estado'     => 'Pendiente',
                'evid_comentario' => null,
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
        return Evidencia::where('evid_apr_id', $aprendizId)
            ->where('evid_pro_id', $proyectoId)
            ->with('etapa')
            ->join('etapa', 'evidencia.evid_eta_id', '=', 'etapa.eta_id')
            ->orderBy('etapa.eta_orden')
            ->orderByDesc('evid_fecha')
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
        return Evidencia::where('evid_apr_id', $aprendizId)
            ->with(['etapa', 'proyecto'])
            ->orderBy('evid_pro_id')
            ->orderByDesc('evid_fecha')
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
        return Evidencia::where('evid_apr_id', $aprendizId)
            ->where('evid_estado', 'Aprobada')
            ->with(['etapa', 'proyecto'])
            ->orderByDesc('evid_fecha')
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
        return Evidencia::where('evid_apr_id', $aprendizId)
            ->where('evid_estado', $estado)
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
        return Evidencia::where('evid_apr_id', $aprendizId)
            ->where('evid_estado', 'Pendiente')
            ->with(['etapa', 'proyecto'])
            ->orderByDesc('evid_fecha')
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
        return Evidencia::where('evid_apr_id', $aprendizId)
            ->where('evid_eta_id', $etapaId)
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
        return Evidencia::where('evid_apr_id', $aprendizId)
            ->where('evid_eta_id', $etapaId)
            ->orderByDesc('evid_fecha')
            ->first();
    }
}
