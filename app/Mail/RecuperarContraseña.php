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

    /**
     * ✅ SEGURIDAD: Solo almacenar nombre y enlace (NO email ni token)
     * El email se obtiene del destinatario del correo
     * El token ya está incluido en la URL
     */
    public $nombre;

    public $enlaceRecuperacion;

    public function __construct($nombre, $enlaceRecuperacion)
    {
        $this->nombre = $nombre;
        $this->enlaceRecuperacion = $enlaceRecuperacion;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Recuperar Contraseña - Bolsa de Proyectos SENA',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.recuperar-contraseña',
            with: [
                'nombre' => $this->nombre,
                'enlaceRecuperacion' => $this->enlaceRecuperacion,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
