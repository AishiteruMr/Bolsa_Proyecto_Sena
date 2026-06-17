<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PostulacionEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public string $action;
    public array $data;

    public function __construct(
        public User $user,
        string $action,
        array $data = []
    ) {
        $this->action = $action;
        $this->data = $data;
    }

    public function broadcastOn(): array
    {
        $channels = [
            new PrivateChannel('user.' . $this->user->id),
        ];

        if (in_array($this->action, ['nueva', 'pendiente'])) {
            $channels[] = new PrivateChannel('role.instructor');
            $channels[] = new PrivateChannel('role.empresa');
        }

        if (in_array($this->action, ['aceptada', 'rechazada'])) {
            $channels[] = new PrivateChannel('role.instructor');
            $channels[] = new PrivateChannel('role.empresa');
        }

        return $channels;
    }

    public function broadcastAs(): string
    {
        return 'postulacion.' . $this->action;
    }

    public function broadcastWith(): array
    {
        return [
            'action' => $this->action,
            'message' => $this->data['message'] ?? '',
            'proyecto' => $this->data['proyecto'] ?? '',
            'usuario' => $this->data['usuario'] ?? '',
            'url' => $this->data['url'] ?? null,
            'timestamp' => now()->toIso8601String(),
        ];
    }
}
