<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EvidenciaCalificada extends Notification
{
    use Queueable;

    public $proyectoTitulo;
    public $etapaNombre;
    public $estado;

    public function __construct($proyectoTitulo, $etapaNombre, $estado)
    {
        $this->proyectoTitulo = $proyectoTitulo;
        $this->etapaNombre = $etapaNombre;
        $this->estado = $estado;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'mensaje'   => "Tu evidencia de la etapa '{$this->etapaNombre}' en el proyecto '{$this->proyectoTitulo}' ha sido calificada como '{$this->estado}'.",
            'estado'    => $this->estado,
            'proyecto'  => $this->proyectoTitulo,
            'etapa'     => $this->etapaNombre,
            'fecha'     => now()->toDateTimeString(),
        ];
    }
}
