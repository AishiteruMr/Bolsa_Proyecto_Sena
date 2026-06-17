<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ProcessBackupJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout = 300;

    public function __construct(
        private string $outputFilename
    ) {
        $this->onQueue('low');
    }

    public function handle(): void
    {
        $db = config('database.connections.mysql');
        $backupPath = storage_path("app/backups/{$this->outputFilename}");
        $dir = dirname($backupPath);

        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $sqlPath = str_replace('.zip', '.sql', $backupPath);

        $command = sprintf(
            '"%s" --host=%s --port=%s --user=%s --password=%s %s > "%s"',
            'mysqldump',
            $db['host'],
            $db['port'],
            $db['username'],
            $db['password'],
            $db['database'],
            $sqlPath
        );

        $output = null;
        $resultCode = null;
        exec($command, $output, $resultCode);

        if ($resultCode !== 0) {
            throw new \RuntimeException("mysqldump failed with code {$resultCode}");
        }

        $zip = new \ZipArchive();
        if ($zip->open($backupPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === true) {
            $zip->addFile($sqlPath, basename($sqlPath));
            $zip->close();
            unlink($sqlPath);
        }

        $this->cleanOldBackups();

        Log::info("Backup created: {$this->outputFilename}");
    }

    private function cleanOldBackups(): void
    {
        $files = Storage::files('backups');
        $backups = array_filter($files, fn($f) => str_ends_with($f, '.zip'));

        usort($backups, fn($a, $b) => Storage::lastModified($a) - Storage::lastModified($b));

        while (count($backups) > 5) {
            $oldest = array_shift($backups);
            Storage::delete($oldest);
            Log::info("Removed old backup: {$oldest}");
        }
    }
}
