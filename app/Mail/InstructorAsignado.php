<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InstructorAsignado extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $instructorNombre,
        public object $proyecto,
        public int $totalPostulaciones
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '🎓 Nuevo Proyecto Asignado - ' . $this->proyecto->pro_titulo_proyecto,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.instructor-asignado',
        );
    }
}
