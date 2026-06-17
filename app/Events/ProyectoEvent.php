<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProyectoEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public string $action;
    public array $data;

    public function __construct(
        string $action,
        array $data = []
    ) {
        $this->action = $action;
        $this->data = $data;
    }

    public function broadcastOn(): array
    {
        $channels = [];

        switch ($this->action) {
            case 'creado':
                $channels[] = new PrivateChannel('role.admin');
                $channels[] = new PrivateChannel('role.aprendiz');
                break;
            case 'aprobado':
                $channels[] = new PrivateChannel('role.admin');
                $channels[] = new PrivateChannel('role.aprendiz');
                $channels[] = new PrivateChannel('role.instructor');
                break;
            case 'en_progreso':
                $channels[] = new PrivateChannel('role.instructor');
                $channels[] = new PrivateChannel('role.empresa');
                break;
            case 'completado':
            case 'cerrado':
                $channels[] = new PrivateChannel('role.admin');
                $channels[] = new PrivateChannel('role.instructor');
                $channels[] = new PrivateChannel('role.empresa');
                break;
            default:
                $channels[] = new PrivateChannel('role.admin');
                break;
        }

        return $channels;
    }

    public function broadcastAs(): string
    {
        return 'proyecto.' . $this->action;
    }

    public function broadcastWith(): array
    {
        return [
            'action' => $this->action,
            'message' => $this->data['message'] ?? '',
            'proyecto' => $this->data['proyecto'] ?? '',
            'empresa' => $this->data['empresa'] ?? '',
            'url' => $this->data['url'] ?? null,
            'timestamp' => now()->toIso8601String(),
        ];
    }
}
