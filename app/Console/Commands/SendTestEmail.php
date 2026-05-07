<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Aprendiz;
use App\Mail\RegistroExitoso;
use App\Jobs\SendEmailJob;
use Illuminate\Support\Facades\Mail;

class SendTestEmail extends Command
{
    protected $signature = 'mail:test-send';
    protected $description = 'Send a test email using the first user in the database';

    public function handle()
    {
        // Get first user
        $user = User::first();
        
        if (!$user) {
            $this->error('No users found in database');
            return 1;
        }

        $this->info("Sending test email to: {$user->correo}");

        try {
            // Option 1: Send synchronously (for testing)
            Mail::to($user->correo)->send(new RegistroExitoso($user->nombre_completo ?? 'Usuario', 'Prueba'));
            $this->info('✅ Test email sent synchronously');

            // Option 2: Also dispatch to queue (async)
            SendEmailJob::dispatch($user->correo, new RegistroExitoso($user->nombre_completo ?? 'Usuario', 'Prueba'));
            $this->info('✅ Test email dispatched to queue');

            $this->info("Email sent to: {$user->correo}");
            return 0;
        } catch (\Exception $e) {
            $this->error('Error sending email: ' . $e->getMessage());
            return 1;
        }
    }
}
