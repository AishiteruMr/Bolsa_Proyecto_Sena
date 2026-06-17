<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

class QueueRetryFailedCommand extends Command
{
    protected $signature = 'queue:retry-failed';
    protected $description = 'Reintenta todos los trabajos fallidos de la cola';

    public function handle(): int
    {
        $failed = DB::table('failed_jobs')->count();

        if ($failed === 0) {
            $this->info('No hay trabajos fallidos para reintentar.');
            return Command::SUCCESS;
        }

        $this->info("Reintentando {$failed} trabajo(s) fallido(s)...");

        $exitCode = Artisan::call('queue:retry', ['id' => 'all']);
        $output = Artisan::output();

        $this->line($output);

        if ($exitCode === 0) {
            $this->info("{$failed} trabajo(s) reenviado(s) a la cola exitosamente.");
        } else {
            $this->error('Ocurrió un error al reintentar los trabajos.');
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
