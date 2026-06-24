<?php

namespace App\Console\Commands;

use App\Services\BackupService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class BackupAutomatico extends Command
{
    protected $signature = 'backup:automatico';

    protected $description = 'Crea un backup automático de la base de datos (se ejecuta cada 10 días)';

    public function __construct(
        private BackupService $backupService
    ) {
        parent::__construct();
    }

    public function handle(): int
    {
        try {
            $nombre = 'auto_backup_' . date('Y-m-d_H-i-s');
            $this->backupService->generateBackup($nombre, 'automatico');
            $this->backupService->cleanOldAutomaticBackups();

            Log::info("Backup automático creado exitosamente: {$nombre}");
            $this->info("Backup automático creado: {$nombre}");

            return Command::SUCCESS;
        } catch (\Exception $e) {
            Log::error('Error en backup automático: ' . $e->getMessage());
            $this->error('Error al crear backup automático: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
