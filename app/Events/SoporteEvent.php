<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SoporteEvent implements ShouldBroadcast, ShouldQueue
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public string $action;
    public array $data;

    public function __construct(string $action, array $data = [])
    {
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
        return 'soporte.' . $this->action;
    }

    public function broadcastWith(): array
    {
        return [
            'action' => $this->action,
            'message' => $this->data['message'] ?? '',
            'nombre' => $this->data['nombre'] ?? '',
            'email' => $this->data['email'] ?? '',
            'motivo' => $this->data['motivo'] ?? '',
            'timestamp' => now()->toIso8601String(),
        ];
    }
}
