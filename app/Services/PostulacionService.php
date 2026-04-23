<?php

namespace App\Services;

use App\Mail\PostulacionExitosa;
use App\Models\Aprendiz;
use App\Models\Postulacion;
use App\Models\Proyecto;
use App\Models\User;
use App\Notifications\AppNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class PostulacionService
{
    private const MAX_POSTULACIONES = 5;

    public function puedePostular(int $aprendizId, int $proyectoId): array
    {
        $aprendiz = DB::table('aprendices')->where('id', $aprendizId)->first();
        if (!$aprendiz) {
            return [false, 'No se encontró tu perfil de aprendiz.'];
        }

        $proyecto = Proyecto::find($proyectoId);
        if (!$proyecto) {
            return [false, 'Proyecto no encontrado.'];
        }

        if (!in_array($proyecto->estado, ['aprobado', 'en_progreso'])) {
            return [false, 'Este proyecto no está aceptando postulaciones.'];
        }

        if (!$proyecto->fecha_publicacion) {
            return [false, 'Este proyecto no tiene fecha de publicación válida.'];
        }

        $fechaPublicacion = Carbon::parse($proyecto->fecha_publicacion);
        if ($fechaPublicacion->isFuture()) {
            return [false, 'El período de postulación aún no ha iniciado.'];
        }

        $fechaLimite = $fechaPublicacion->copy()->addDays($proyecto->duracion_estimada_dias ?? 0);
        if (now()->greaterThan($fechaLimite)) {
            return [false, 'El período de postulación para este proyecto ha vencido.'];
        }

        $yaPostulado = DB::table('postulaciones')
            ->where('aprendiz_id', $aprendizId)
            ->where('proyecto_id', $proyectoId)
            ->exists();

        if ($yaPostulado) {
            return [false, 'Ya te postulaste a este proyecto.'];
        }

        $totalPostulaciones = DB::table('postulaciones')
            ->where('aprendiz_id', $aprendizId)
            ->whereIn('estado', ['pendiente', 'en_revision'])
            ->count();

        if ($totalPostulaciones >= self::MAX_POSTULACIONES) {
            return [false, "Has alcanzado el límite máximo de ".self::MAX_POSTULACIONES." postulaciones activas."];
        }

        return [true, null];
    }

    public function crear(int $aprendizId, int $proyectoId): array
    {
        [$esValido, $mensaje] = $this->puedePostular($aprendizId, $proyectoId);

        if (!$esValido) {
            return [false, $mensaje];
        }

        try {
            DB::table('postulaciones')->insert([
                'aprendiz_id' => $aprendizId,
                'proyecto_id' => $proyectoId,
                'fecha_postulacion' => now(),
                'estado' => 'pendiente',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $this->enviarNotificaciones($aprendizId, $proyectoId);

            return [true, 'Postulación enviada correctamente.'];
        } catch (\Exception $e) {
            Log::error('Error al crear postulación: '.$e->getMessage());
            return [false, 'Error al procesar la postulación.'];
        }
    }

    private function enviarNotificaciones(int $aprendizId, int $proyectoId): void
    {
        $aprendiz = DB::table('aprendices')->where('id', $aprendizId)->first();
        $proyecto = Proyecto::find($proyectoId);

        if (!$aprendiz || !$proyecto) {
            return;
        }

        $usuCorreo = DB::table('usuarios')->where('id', $aprendiz->usuario_id)->value('correo');

        try {
            if ($usuCorreo) {
                Mail::to($usuCorreo)->send(new PostulacionExitosa($aprendiz->nombres, $proyecto));
            }
        } catch (\Exception $e) {
            Log::error('Error enviando email de postulación: '.$e->getMessage());
        }

        try {
            $aprendizUsr = User::find($aprendiz->usuario_id);
            if ($aprendizUsr) {
                $aprendizUsr->notify(new AppNotification(
                    'Postulación enviada',
                    'Tu postulación al proyecto fue registrada. Pronto recibirás una respuesta.',
                    'fa-paper-plane'
                ));
            }

            if ($proyecto->instructor_usuario_id) {
                $instUsr = User::find($proyecto->instructor_usuario_id);
                if ($instUsr) {
                    $instUsr->notify(new AppNotification(
                        'Nueva Postulación',
                        'El aprendiz '.$aprendiz->nombres.' se ha postulado a tu proyecto: '.Str::limit($proyecto->titulo, 30),
                        'fa-user-plus'
                    ));
                }
            }
        } catch (\Exception $e) {
            Log::warning('Error en notificaciones: '.$e->getMessage());
        }
    }
}