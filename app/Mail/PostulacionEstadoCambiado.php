<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PostulacionEstadoCambiado extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $aprendizNombre,
        public string $proyectoTitulo,
        public string $nuevoEstado
    ) {}

    public function envelope(): Envelope
    {
        $estadoEmoji = $this->nuevoEstado === 'Aprobada' ? '✅' : '❌';
        return new Envelope(
            subject: "{$estadoEmoji} Postulación {$this->nuevoEstado} - {$this->proyectoTitulo}",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.postulacion-estado',
        );
    }
}
