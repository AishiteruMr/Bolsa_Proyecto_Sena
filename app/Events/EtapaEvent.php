<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EtapaEvent implements ShouldBroadcast, ShouldQueue
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
        $channels = [
            new PrivateChannel('role.aprendiz'),
        ];

        if (in_array($this->action, ['creada', 'editada'])) {
            $channels[] = new PrivateChannel('role.instructor');
        }

        return $channels;
    }

    public function broadcastAs(): string
    {
        return 'etapa.' . $this->action;
    }

    public function broadcastWith(): array
    {
        return [
            'action' => $this->action,
            'message' => $this->data['message'] ?? '',
            'proyecto' => $this->data['proyecto'] ?? '',
            'etapa' => $this->data['etapa'] ?? '',
            'timestamp' => now()->toIso8601String(),
        ];
    }
}
