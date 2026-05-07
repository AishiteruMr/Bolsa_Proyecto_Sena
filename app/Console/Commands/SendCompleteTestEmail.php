<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Aprendiz;
use App\Mail\RegistroExitoso;
use App\Jobs\SendEmailJob;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendCompleteTestEmail extends Command
{
    protected $signature = 'mail:test-complete';
    protected $description = 'Send complete test email with sync and async options';

    public function handle()
    {
        $this->info("═══════════════════════════════════════════════════════════");
        $this->info("    EMAIL NOTIFICATION SYSTEM - TEST");
        $this->info("═══════════════════════════════════════════════════════════");

        // Get first user
        $user = User::first();
        
        if (!$user) {
            $this->error('❌ No users found in database');
            return 1;
        }

        $this->info("\n📧 Email Configuration:");
        $this->info("   From: " . config('mail.from.address'));
        $this->info("   To: {$user->correo}");
        $this->info("   Queue Driver: " . config('queue.default'));
        
        // Test 1: Synchronous email
        $this->info("\n📤 Test 1: SYNCHRONOUS Email Sending");
        $this->info("   Status: Processing...");
        
        try {
            Mail::to($user->correo)->send(new RegistroExitoso($user->nombre_completo ?? 'Usuario', 'Prueba Sincrónico'));
            $this->info("   ✅ Status: SENT SUCCESSFULLY");
            $this->info("   Type: Direct mail send (synchronous)");
        } catch (\Exception $e) {
            $this->error("   ❌ Error: " . $e->getMessage());
            return 1;
        }

        // Test 2: Queue-based email
        $this->info("\n📤 Test 2: ASYNCHRONOUS Email (via Queue)");
        $this->info("   Status: Dispatching to queue...");
        
        try {
            SendEmailJob::dispatch($user->correo, new RegistroExitoso($user->nombre_completo ?? 'Usuario', 'Prueba Asincrónico'));
            $this->info("   ✅ Status: DISPATCHED TO QUEUE");
            $this->info("   Type: Job dispatch (asynchronous)");
        } catch (\Exception $e) {
            $this->error("   ❌ Error: " . $e->getMessage());
            return 1;
        }

        // Check queue status
        $this->info("\n📋 Queue Status:");
        $pending = \Illuminate\Support\Facades\DB::table('jobs')->count();
        $failed = \Illuminate\Support\Facades\DB::table('failed_jobs')->count();
        
        $this->info("   Pending jobs: " . $pending);
        $this->info("   Failed jobs: " . $failed);

        $this->info("\n═══════════════════════════════════════════════════════════");
        $this->info("✅ TEST COMPLETED SUCCESSFULLY");
        $this->info("═══════════════════════════════════════════════════════════");

        $this->info("\n💡 Next Steps:");
        $this->info("   1. Check your email inbox: {$user->correo}");
        $this->info("   2. To process queued jobs, run:");
        $this->info("      php artisan queue:work database --stop-when-empty");
        $this->info("   3. For production, set up a queue worker supervisor.");

        return 0;
    }
}
