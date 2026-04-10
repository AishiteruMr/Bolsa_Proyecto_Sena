<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\URL;

class VerifyEmailNotification extends Notification
{
    use Queueable;

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): object
    {
        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            [
                'id' => $notifiable->getKey(),
                'hash' => hash('sha256', $notifiable->getEmailForVerification()),
            ]
        );

        return (new MailMessage)
            ->subject(Lang::get('Verifica tu correo electrónico - Bolsa de Proyecto SENA'))
            ->view('emails.verificar-correo', [
                'verificationUrl' => $verificationUrl,
                'nombre' => $notifiable->nombre_completo ?? 'Usuario',
            ]);
    }

    public function toArray(object $notifiable): array
    {
        return [];
    }
}
