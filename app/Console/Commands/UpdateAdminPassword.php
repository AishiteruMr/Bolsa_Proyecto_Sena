<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UpdateAdminPassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-admin-password';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Actualiza la contraseña del administrador a adminSena2026';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = 'admin@gmail.com';
        $newPassword = 'adminSena2026';
        
        $user = DB::table('usuario')->where('usr_correo', $email)->first();
        
        if ($user) {
            DB::table('usuario')->where('usr_correo', $email)->update([
                'usr_contrasena' => Hash::make($newPassword)
            ]);
            
            $this->info("✅ Contraseña del administrador actualizada correctamente.");
            $this->info("📧 Email: {$email}");
            $this->info("🔐 Contraseña: {$newPassword}");
        } else {
            $this->error("❌ Usuario administrador no encontrado con email: {$email}");
        }
    }
}
