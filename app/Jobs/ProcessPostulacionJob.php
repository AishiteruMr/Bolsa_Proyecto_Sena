<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Postulacione;
use App\Notifications\AppNotification;
use App\Notifications\PostulacionActualizada;

class ProcessPostulacionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private Postulacione $postulacion,
        private string $accion,
        private ?array $data = null
    ) {
        $this->onQueue('default');
    }

    public function handle(): void
    {
        match ($this->accion) {
            'notificar_estado' => $this->notificarCambioEstado(),
            'notificar_nueva' => $this->notificarNuevaPostulacion(),
            default => null,
        };
    }

    private function notificarCambioEstado(): void
    {
        $aprendiz = $this->postulacion->aprendiz;
        if (!$aprendiz || !$aprendiz->user) return;

        $this->postulacion->aprendiz->user->notify(new AppNotification(
            'Estado de postulación actualizado',
            "Tu postulación para el proyecto '{$this->postulacion->proyecto->titulo}' fue {$this->postulacion->estado}.",
            'fa-info-circle',
            route('postulaciones.show', $this->postulacion->id)
        ));
    }

    private function notificarNuevaPostulacion(): void
    {
        $proyecto = $this->postulacion->proyecto;
        if (!$proyecto) return;

        $instructores = $proyecto->instructores;
        foreach ($instructores as $instructor) {
            $user = $instructor->usuario ?? $instructor->user ?? null;
            if ($user) {
                $user->notify(new AppNotification(
                    'Nueva postulación',
                    "Un aprendiz se postuló al proyecto '{$proyecto->titulo}'.",
                    'fa-user-plus',
                    route('instructor.postulaciones', $proyecto->id)
                ));
            }
        }
    }
}
