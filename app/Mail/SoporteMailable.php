<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class SoporteMailable extends Mailable
{
    /**
     * Create a new message instance.
     */
    public function __construct(
        public array $data
    ) {}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nuevo mensaje de soporte: ' . $this->data['motivo'],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.soporte',
            with: [
                'data' => $this->data,
            ],
        );
    }
}
