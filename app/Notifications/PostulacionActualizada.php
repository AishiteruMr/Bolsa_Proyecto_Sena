<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PostulacionActualizada extends Notification
{
    use Queueable;

    public $proyectoTitulo;
    public $estado;

    public function __construct($proyectoTitulo, $estado)
    {
        $this->proyectoTitulo = $proyectoTitulo;
        $this->estado = $estado;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'mensaje'   => "Tu postulación para el proyecto '{$this->proyectoTitulo}' ha sido cambiada a '{$this->estado}'.",
            'estado'    => $this->estado,
            'proyecto'  => $this->proyectoTitulo,
            'fecha'     => now()->toDateTimeString(),
        ];
    }
}
