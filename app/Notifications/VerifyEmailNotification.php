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
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );

        return (new MailMessage)
            ->subject(Lang::get('Verifica tu correo electrónico'))
            ->greeting('¡Hola!')
            ->line('Gracias por registrarte. Por favor, verifica tu correo electrónico haciendo clic en el botón de abajo.')
            ->action(Lang::get('Verificar Correo Electrónico'), $verificationUrl)
            ->line('Este enlace expira en 60 minutos.')
            ->line('Si no creaste esta cuenta, puedes ignorar este mensaje.');
    }

    public function toArray(object $notifiable): array
    {
        return [];
    }
}
