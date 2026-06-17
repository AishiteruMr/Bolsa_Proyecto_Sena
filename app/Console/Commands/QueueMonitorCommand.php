<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class QueueMonitorCommand extends Command
{
    protected $signature = 'queue:monitor';
    protected $description = 'Monitorea el estado de las colas de trabajos';

    public function handle(): int
    {
        $pending = DB::table('jobs')->count();
        $failed = DB::table('failed_jobs')->count();

        $stats = [
            'pending' => $pending,
            'failed' => $failed,
            'timestamp' => now()->toIso8601String(),
        ];

        $this->info("Jobs pendientes: {$pending}");
        $this->info("Jobs fallidos: {$failed}");

        if ($failed > 0) {
            $failedJobs = DB::table('failed_jobs')
                ->select('id', 'queue', 'failed_at')
                ->orderBy('failed_at', 'desc')
                ->limit(10)
                ->get();

            $this->warn("\nÚltimos trabajos fallidos:");
            foreach ($failedJobs as $job) {
                $this->line("  #{$job->id} | Cola: {$job->queue} | Falló: {$job->failed_at}");
            }
        }

        $threshold = 50;
        if ($pending > $threshold) {
            $this->warn("\n⚠️  Cola con {$pending} trabajos pendientes (umbral: {$threshold})");
            Log::warning("QueueMonitor: {$pending} jobs pending (threshold: {$threshold})", $stats);
        }

        if ($failed > 0) {
            Log::warning("QueueMonitor: {$failed} failed jobs detected", $stats);
        }

        return Command::SUCCESS;
    }
}
