<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AppNotification extends Notification
{
    use Queueable;

    public $titulo;
    public $mensaje;
    public $icono;
    public $url;

    public function __construct($titulo, $mensaje, $icono = 'fa-bell', $url = null)
    {
        $this->titulo = $titulo;
        $this->mensaje = $mensaje;
        $this->icono = $icono;
        $this->url = $url;
    }

    public function via(object $notifiable): array
    {
        return ['database']; // Solo guardamos en base de datos, el correo va aparte
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'titulo' => $this->titulo,
            'mensaje' => $this->mensaje,
            'icono' => $this->icono,
            'url' => $this->url,
        ];
    }
}
