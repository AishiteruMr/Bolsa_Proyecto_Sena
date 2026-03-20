<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InstructorDesasignado extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $instructorNombre,
        public string $proyectoTitulo,
        public string $empresaNombre
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '⚠️ Has sido desasignado de un proyecto - ' . $this->proyectoTitulo,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.instructor-desasignado',
        );
    }
}
