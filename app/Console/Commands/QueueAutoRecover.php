<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class QueueAutoRecover extends Command
{
    protected $signature = 'queue:auto-recover
                            {--max-attempts=3 : Máximo de reintentos por lote}
                            {--pending-threshold=50 : Umbral de jobs pendientes para alertar}';
    protected $description = 'Monitorea y recupera automáticamente trabajos fallidos de la cola';

    public function handle(): int
    {
        $threshold = (int) $this->option('pending-threshold');
        $maxAttempts = (int) $this->option('max-attempts');

        // 1. Verificar pendientes
        $pending = DB::table('jobs')->count();
        if ($pending > $threshold) {
            $this->warn("⚠️  {$pending} jobs pendientes (umbral: {$threshold})");
            Log::warning("QueueAutoRecover: {$pending} jobs pending", [
                'threshold' => $threshold,
                'action' => 'alert_only',
            ]);
        } else {
            $this->info("✓ {$pending} jobs pendientes (dentro del umbral)");
        }

        // 2. Reintentar fallidos automáticamente
        $failed = DB::table('failed_jobs')->count();
        if ($failed > 0) {
            $this->info("→ Reintentando {$failed} trabajo(s) fallido(s)...");

            $exitCode = Artisan::call('queue:retry', ['id' => 'all']);

            $this->line(Artisan::output());

            if ($exitCode === 0) {
                $this->info("✓ {$failed} trabajo(s) reenviado(s) a la cola");
                Log::info("QueueAutoRecover: {$failed} failed jobs retried successfully");
            } else {
                $this->error("✗ Error al reintentar trabajos fallidos");
                Log::error("QueueAutoRecover: failed to retry jobs");
                return Command::FAILURE;
            }

            // 3. Verificar reintentos excesivos
            $recentRetries = DB::table('failed_jobs')
                ->where('failed_at', '>=', now()->subHours(1))
                ->count();

            if ($recentRetries > $maxAttempts * 5) {
                $this->warn("⚠️  Alta tasa de fallos: {$recentRetries} fallos en la última hora");
                Log::warning("QueueAutoRecover: high failure rate detected", [
                    'recent_failures' => $recentRetries,
                    'per_hour' => $recentRetries,
                ]);
            }
        } else {
            $this->info("✓ No hay trabajos fallidos");
        }

        return Command::SUCCESS;
    }
}
