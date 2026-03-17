<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RecuperarContraseña extends Mailable
{
    use Queueable, SerializesModels;

    public $nombre;
    public $token;
    public $correo;

    public function __construct($nombre, $token, $correo)
    {
        $this->nombre = $nombre;
        $this->token = $token;
        $this->correo = $correo;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Recuperar Contraseña - Bolsa de Proyectos SENA',
        );
    }

    public function content(): Content
    {
        $enlaceRecuperacion = url("/recuperar-contraseña/{$this->token}?email=" . urlencode($this->correo));

        return new Content(
            view: 'emails.recuperar-contraseña',
            with: [
                'nombre' => $this->nombre,
                'enlaceRecuperacion' => $enlaceRecuperacion,
                'token' => $this->token,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
