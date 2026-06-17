<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NuevoUsuarioEvent implements ShouldBroadcast
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
        return [
            new PrivateChannel('role.admin'),
        ];
    }

    public function broadcastAs(): string
    {
        return 'usuario.' . $this->action;
    }

    public function broadcastWith(): array
    {
        return [
            'action' => $this->action,
            'message' => $this->data['message'] ?? '',
            'usuario' => $this->data['usuario'] ?? '',
            'rol' => $this->data['rol'] ?? '',
            'url' => $this->data['url'] ?? null,
            'timestamp' => now()->toIso8601String(),
        ];
    }
}
