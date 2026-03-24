<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PostulacionExitosa extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $aprendizNombre,
        public object $proyecto
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '📋 Postulación Recibida - ' . $this->proyecto->pro_titulo_proyecto,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.postulacion-exitosa',
        );
    }
}
