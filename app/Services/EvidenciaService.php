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
    public function enviarEvidencia(
        int $aprendizId,
        int $proyectoId,
        int $etapaId,
        string $descripcion,
        ?UploadedFile $archivo = null
    ): array {
        try {
            $postulacion = Postulacion::where('aprendiz_id', $aprendizId)
                ->where('proyecto_id', $proyectoId)
                ->where('estado', 'aceptada')
                ->first();

            if (!$postulacion) {
                return [false, 'No tienes acceso o tu postulación no fue aprobada.'];
            }

            $etapa = Etapa::where('id', $etapaId)
                ->where('proyecto_id', $proyectoId)
                ->first();

            if (!$etapa) {
                return [false, 'La etapa no existe o no pertenece al proyecto.'];
            }

            $archivoUrl = null;
            if ($archivo) {
                $archivoUrl = $archivo->store('evidencias', 'public');
            }

            Evidencia::create([
                'aprendiz_id'  => $aprendizId,
                'etapa_id'     => $etapaId,
                'proyecto_id'  => $proyectoId,
                'ruta_archivo' => $archivoUrl,
                'fecha_envio'  => now(),
                'estado'       => 'pendiente',
                'comentario_instructor' => null,
            ]);

            return [true, 'Evidencia enviada. El instructor la revisará.'];
        } catch (\Exception $e) {
            return [false, 'Error al enviar la evidencia.'];              
        }
    }

    public function obtenerEvidenciasProyecto(int $aprendizId, int $proyectoId)
    {
        return Evidencia::where('aprendiz_id', $aprendizId)
            ->where('proyecto_id', $proyectoId)
            ->with('etapa')
            ->join('etapas', 'evidencias.etapa_id', '=', 'etapas.id')
            ->orderBy('etapas.orden')
            ->orderByDesc('evidencias.fecha_envio')
            ->select('evidencias.*')
            ->get();
    }

    public function obtenerTodasLasEvidencias(int $aprendizId)
    {
        return Evidencia::where('aprendiz_id', $aprendizId)
            ->with(['etapa', 'proyecto'])
            ->orderByDesc('evidencias.fecha_envio')
            ->get();
    }

    public function obtenerEvidenciasAprobadas(int $aprendizId)
    {
        return Evidencia::where('aprendiz_id', $aprendizId)
            ->where('estado', 'aceptada')
            ->with(['etapa', 'proyecto'])
            ->orderByDesc('fecha_envio')
            ->get();
    }

    public function contarEvidenciasPorEstado(int $aprendizId, string $estado): int
    {
        return Evidencia::where('aprendiz_id', $aprendizId)
            ->where('estado', $estado)
            ->count();
    }

    public function obtenerEvidenciasPendientes(int $aprendizId)
    {
        return Evidencia::where('aprendiz_id', $aprendizId)
            ->where('estado', 'pendiente')
            ->with(['etapa', 'proyecto'])
            ->orderByDesc('fecha_envio')
            ->get();
    }

    public function existeEvidencia(int $aprendizId, int $etapaId): bool
    {
        return Evidencia::where('aprendiz_id', $aprendizId)
            ->where('etapa_id', $etapaId)
            ->exists();
    }

    public function obtenerUltimaEvidencia(int $aprendizId, int $etapaId): ?Evidencia
    {
        return Evidencia::where('aprendiz_id', $aprendizId)
            ->where('etapa_id', $etapaId)
            ->orderByDesc('fecha_envio')
            ->first();
    }
}
