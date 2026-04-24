<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NuevaEtapaCreada extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $aprendizNombre,
        public string $proyectoTitulo,
        public string $etapaNombre,
        public string $etapaDescripcion
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "📌 Nueva Etapa: {$this->etapaNombre} - {$this->proyectoTitulo}",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.nueva-etapa',
        );
    }
}
