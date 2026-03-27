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

    public string $proyectoTitulo;

    public function __construct(
        public string $aprendizNombre,
        public object $proyecto,
        public string $nuevoEstado
    ) {
        $this->proyectoTitulo = $proyecto->pro_titulo_proyecto ?? 'Proyecto';
    }

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
