<?php

namespace App\Console\Commands;

use App\Services\BackupService;
use Illuminate\Console\Command;

class CreateBackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a full backup of the database and essential files';

    /**
     * Execute the console command.
     */
    public function handle(BackupService $backupService)
    {
        $this->info('Starting automated backup process...');

        // 1. Create Full Backup
        $this->comment('Creating database and file backups...');
        $results = $backupService::class === BackupService::class 
            ? $backupService->createFullBackup() 
            : null; // Fallback if injection is weird, but standard Laravel injection works here.
        
        // Use the injected service directly
        $results = $backupService->createFullBackup();

        if ($results['success']) {
            $this->info('Backup created successfully!');
            $this->line("- Database: {$results['database']}");
            $this->line("- Files: {$results['files']}");
        } else {
            $this->error('Backup failed partly or completely.');
            if ($results['database']) {
                $this->line("- Database: Success ({$results['database']})");
            } else {
                $this->error("- Database: Failed");
            }
            if ($results['files']) {
                $this->line("- Files: Success ({$results['files']})");
            } else {
                $this->error("- Files: Failed");
            }
        }

        // 2. Cleanup old backups
        $this->comment('Cleaning up old backups based on retention policy...');
        $cleanup = $backupService->cleanupOldBackups();

        if ($cleanup['deleted_files'] > 0) {
            $this->info("Deleted {$cleanup['deleted_files']} old backup files.");
            $this->info("Freed " . round($cleanup['freed_space_mb'], 2) . " MB of space.");
        } else {
            $this->line('No old backups required deletion.');
        }

        if (!empty($cleanup['errors'])) {
            foreach ($cleanup['errors'] as $error) {
                $this->warn("Cleanup warning: {$error}");
            }
        }

        $this->info('Backup process completed at ' . now()->toDateTimeString());
        
        return $results['success'] ? Command::SUCCESS : Command::FAILURE;
    }
}
