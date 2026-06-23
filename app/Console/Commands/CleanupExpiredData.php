<?php

namespace App\Console\Commands;

use App\Jobs\CleanupExpiredDataJob;
use Illuminate\Console\Command;

class CleanupExpiredData extends Command
{
    protected $signature = 'app:cleanup-expired';
    protected $description = 'Limpia datos caducados (tokens, notificaciones, sesiones, logs)';

    public function handle(): int
    {
        $this->info('Despachando limpieza de datos caducados...');

        CleanupExpiredDataJob::dispatch();

        $this->info('Job de limpieza despachado a la cola low.');

        return Command::SUCCESS;
    }
}
