<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RegistroExitoso extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $nombre,
        public string $apellido = ''
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '🎉 Registro Exitoso - Bolsa de Proyecto SENA',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.registro-exitoso',
        );
    }
}
