<?php

namespace App\Notifications;

use App\Events\NotificacionEnviada;
use Illuminate\Bus\Queueable;
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
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        $data = [
            'titulo' => $this->titulo,
            'mensaje' => $this->mensaje,
            'icono' => $this->icono,
            'url' => $this->url,
            'notificacion_id' => uniqid(),
            'created_at' => now()->toIso8601String(),
        ];

        if (config('broadcasting.default') === 'pusher') {
            event(new NotificacionEnviada($notifiable, $data));
        }

        return $data;
    }
}
