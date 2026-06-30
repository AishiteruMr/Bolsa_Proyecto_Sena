<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EvidenciaEvent implements ShouldBroadcast, ShouldQueue
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

        if ($this->action === 'subida') {
            $channels[] = new PrivateChannel('role.instructor');
        }

        if (in_array($this->action, ['aprobada', 'rechazada'])) {
            $channels[] = new PrivateChannel('role.instructor');
        }

        return $channels;
    }

    public function broadcastAs(): string
    {
        return 'evidencia.' . $this->action;
    }

    public function broadcastWith(): array
    {
        return [
            'action' => $this->action,
            'message' => $this->data['message'] ?? '',
            'proyecto' => $this->data['proyecto'] ?? '',
            'etapa' => $this->data['etapa'] ?? '',
            'estado' => $this->data['estado'] ?? '',
            'url' => $this->data['url'] ?? null,
            'timestamp' => now()->toIso8601String(),
        ];
    }
}
