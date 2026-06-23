<?php

namespace App\Console\Commands;

use App\Jobs\OptimizeDatabaseJob;
use Illuminate\Console\Command;

class OptimizeDatabase extends Command
{
    protected $signature = 'app:optimize-database';
    protected $description = 'Optimiza todas las tablas de la base de datos';

    public function handle(): int
    {
        $this->info('Despachando optimización de base de datos...');

        OptimizeDatabaseJob::dispatch();

        $this->info('Job de optimización despachado a la cola low.');

        return Command::SUCCESS;
    }
}
