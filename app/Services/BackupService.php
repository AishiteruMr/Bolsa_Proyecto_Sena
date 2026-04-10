<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

/**
 * Phase 3: Comprehensive Backup Service
 *
 * Manages automated database and file backups with retention policies
 * Supports multiple backup strategies and restoration
 */
class BackupService
{
    /**
     * Backup storage path
     */
    protected string $backupPath = 'backups/database';

    /**
     * Database backup configuration
     */
    protected array $dbConfig = [
        'host' => null,
        'port' => 3306,
        'database' => null,
        'username' => null,
        'password' => null,
    ];

    /**
     * Retention policies (in days)
     */
    protected array $retention = [
        'hourly' => 1,     // Keep hourly backups for 1 day
        'daily' => 7,      // Keep daily backups for 7 days
        'weekly' => 28,    // Keep weekly backups for 4 weeks
        'monthly' => 365,  // Keep monthly backups for 12 months
    ];

    public function __construct()
    {
        $this->initializeDbConfig();
    }

    /**
     * Initialize database configuration from .env
     */
    private function initializeDbConfig(): void
    {
        $this->dbConfig = [
            'host' => config('database.connections.mysql.host', '127.0.0.1'),
            'port' => config('database.connections.mysql.port', '3306'),
            'database' => config('database.connections.mysql.database', 'bolsa_de_proyectos'),
            'username' => config('database.connections.mysql.username', 'root'),
            'password' => config('database.connections.mysql.password', ''),
        ];
    }

    /**
     * Create a full database backup
     *
     * Returns backup filename or false on failure
     */
    public function backupDatabase(): bool|string
    {
        try {
            $timestamp = now()->format('YmdHis');
            $filename = "backup_database_{$timestamp}.sql";
            $filepath = storage_path("backups/database/{$filename}");

            // Ensure directory exists
            if (! file_exists(dirname($filepath))) {
                mkdir(dirname($filepath), 0755, true);
            }

            // Build mysqldump command
            $command = $this->buildMysqldumpCommand($filepath);

            // Execute backup
            $output = [];
            $returnCode = 0;
            exec($command, $output, $returnCode);

            if ($returnCode !== 0) {
                Log::error('Database backup failed', [
                    'filename' => $filename,
                    'error' => implode("\n", $output),
                    'return_code' => $returnCode,
                ]);

                return false;
            }

            // Compress backup
            $this->compressBackup($filepath);

            // Log successful backup
            Log::info('Database backup completed', [
                'filename' => $filename,
                'filepath' => $filepath,
                'size' => filesize($filepath.'.gz') / 1024 / 1024 .' MB',
            ]);

            return $filename.'.gz';
        } catch (\Exception $e) {
            Log::error('Database backup exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return false;
        }
    }

    /**
     * Create application files backup
     */
    public function backupFiles(array $paths = []): bool|string
    {
        try {
            $timestamp = now()->format('YmdHis');
            $filename = "backup_files_{$timestamp}.tar.gz";
            $backupPath = storage_path("backups/files/{$filename}");

            // Ensure directory exists
            if (! file_exists(dirname($backupPath))) {
                mkdir(dirname($backupPath), 0755, true);
            }

            // Default paths to backup
            if (empty($paths)) {
                $defaultPaths = [
                    base_path('app'),
                    base_path('config'),
                    base_path('routes'),
                    base_path('resources'),
                    base_path('database/migrations'),
                    storage_path('app/public/proyectos'),
                    storage_path('app/public/evidencias'),
                ];

                // Filter only existing paths
                $paths = array_filter($defaultPaths, function($path) {
                    return file_exists($path);
                });
            }

            if (empty($paths)) {
                Log::warning('No valid file paths found for backup');
                return false;
            }

            // Build tar command
            $pathsString = implode(' ', array_map('escapeshellarg', $paths));
            $command = 'cd '.escapeshellarg(base_path()).' && tar -czf '.escapeshellarg($backupPath)." {$pathsString}";

            // Execute backup
            $output = [];
            $returnCode = 0;
            exec($command, $output, $returnCode);

            if ($returnCode !== 0) {
                Log::error('Files backup failed', [
                    'filename' => $filename,
                    'error' => implode("\n", $output),
                ]);

                return false;
            }

            Log::info('Files backup completed', [
                'filename' => $filename,
                'size' => filesize($backupPath) / 1024 / 1024 .' MB',
            ]);

            return $filename;
        } catch (\Exception $e) {
            Log::error('Files backup exception', [
                'message' => $e->getMessage(),
            ]);

            return false;
        }
    }

    /**
     * Create complete backup (database + files)
     */
    public function createFullBackup(): array
    {
        $results = [
            'database' => $this->backupDatabase(),
            'files' => $this->backupFiles(),
            'timestamp' => now(),
            'success' => false,
        ];

        $results['success'] = $results['database'] !== false && $results['files'] !== false;

        return $results;
    }

    /**
     * Restore database from backup
     */
    public function restoreDatabase(string $filename): bool
    {
        try {
            $filepath = storage_path("backups/database/{$filename}");

            // Check if file exists
            if (! file_exists($filepath)) {
                Log::error('Backup file not found', ['filename' => $filename]);

                return false;
            }

            // Decompress if needed
            if (str_ends_with($filepath, '.gz')) {
                $command = 'gunzip -c '.escapeshellarg($filepath).' | ';
                $sqlFile = substr($filepath, 0, -3);
            } else {
                $command = '';
                $sqlFile = $filepath;
            }

            // Build mysql restore command
            $mysqlCmd = 'mysql '.
                "-h {$this->dbConfig['host']} ".
                "-u {$this->dbConfig['username']} ";

            if (! empty($this->dbConfig['password'])) {
                $mysqlCmd .= '-p'.escapeshellarg($this->dbConfig['password']).' ';
            }

            $mysqlCmd .= escapeshellarg($this->dbConfig['database']);

            $fullCommand = $command.$mysqlCmd.' < '.escapeshellarg($sqlFile);

            // Execute restore
            $output = [];
            $returnCode = 0;
            exec($fullCommand, $output, $returnCode);

            if ($returnCode !== 0) {
                Log::error('Database restore failed', [
                    'filename' => $filename,
                    'error' => implode("\n", $output),
                ]);

                return false;
            }

            Log::info('Database restored successfully', [
                'filename' => $filename,
                'timestamp' => now(),
            ]);

            return true;
        } catch (\Exception $e) {
            Log::error('Database restore exception', [
                'message' => $e->getMessage(),
            ]);

            return false;
        }
    }

    /**
     * List all available backups
     */
    public function listBackups(string $type = 'database'): array
    {
        try {
            $dir = storage_path("backups/{$type}");

            if (! is_dir($dir)) {
                return [];
            }

            $files = array_diff(scandir($dir, SCANDIR_SORT_DESCENDING), ['.', '..']);
            $backups = [];

            foreach ($files as $file) {
                $filepath = "{$dir}/{$file}";
                $backups[] = [
                    'filename' => $file,
                    'size' => filesize($filepath) / 1024 / 1024,
                    'created_at' => filemtime($filepath),
                    'readable_date' => date('Y-m-d H:i:s', filemtime($filepath)),
                ];
            }

            return $backups;
        } catch (\Exception $e) {
            Log::error('List backups exception', [
                'message' => $e->getMessage(),
            ]);

            return [];
        }
    }

    /**
     * Clean old backups based on retention policy
     */
    public function cleanupOldBackups(): array
    {
        $results = [
            'deleted_files' => 0,
            'freed_space_mb' => 0,
            'errors' => [],
        ];

        try {
            $backups = $this->listBackups('database');
            $now = time();

            foreach ($backups as $backup) {
                $age_days = ($now - $backup['created_at']) / (60 * 60 * 24);
                $should_delete = false;

                // Determine retention based on type
                if (str_contains($backup['filename'], 'hourly')) {
                    $should_delete = $age_days > $this->retention['hourly'];
                } elseif (str_contains($backup['filename'], 'weekly')) {
                    $should_delete = $age_days > $this->retention['weekly'];
                } elseif (str_contains($backup['filename'], 'monthly')) {
                    $should_delete = $age_days > $this->retention['monthly'];
                } else {
                    // Default daily retention
                    $should_delete = $age_days > $this->retention['daily'];
                }

                if ($should_delete) {
                    $filepath = storage_path("backups/database/{$backup['filename']}");
                    if (file_exists($filepath)) {
                        $size = filesize($filepath) / 1024 / 1024;
                        if (unlink($filepath)) {
                            $results['deleted_files']++;
                            $results['freed_space_mb'] += $size;
                        } else {
                            $results['errors'][] = "Failed to delete {$backup['filename']}";
                        }
                    }
                }
            }

            Log::info('Backup cleanup completed', [
                'deleted_files' => $results['deleted_files'],
                'freed_space_mb' => round($results['freed_space_mb'], 2),
            ]);

            return $results;
        } catch (\Exception $e) {
            Log::error('Backup cleanup exception', [
                'message' => $e->getMessage(),
            ]);
            $results['errors'][] = $e->getMessage();

            return $results;
        }
    }

    /**
     * Get backup statistics
     */
    public function getBackupStats(): array
    {
        $dbBackups = $this->listBackups('database');
        $fileBackups = $this->listBackups('files');

        $totalSize = 0;
        $latestDbBackup = null;
        $latestFileBackup = null;

        foreach ($dbBackups as $backup) {
            $totalSize += $backup['size'];
            if ($latestDbBackup === null) {
                $latestDbBackup = $backup;
            }
        }

        foreach ($fileBackups as $backup) {
            $totalSize += $backup['size'];
            if ($latestFileBackup === null) {
                $latestFileBackup = $backup;
            }
        }

        return [
            'total_backups' => count($dbBackups) + count($fileBackups),
            'database_backups' => count($dbBackups),
            'file_backups' => count($fileBackups),
            'total_size_mb' => round($totalSize, 2),
            'latest_database_backup' => $latestDbBackup,
            'latest_file_backup' => $latestFileBackup,
            'storage_used_mb' => round($totalSize, 2),
            'estimated_storage_cost' => round($totalSize * 0.01, 2), // Assuming $0.01 per MB
        ];
    }

    /**
     * Build mysqldump command with proper escaping
     */
    private function buildMysqldumpCommand(string $filepath): string
    {
        $cmd = 'mysqldump ';
        $cmd .= '--single-transaction --quick --lock-tables=false ';
        $cmd .= '-h '.escapeshellarg($this->dbConfig['host']).' ';
        $cmd .= '-u '.escapeshellarg($this->dbConfig['username']).' ';

        if (! empty($this->dbConfig['password'])) {
            $cmd .= '-p'.escapeshellarg($this->dbConfig['password']).' ';
        }

        $cmd .= escapeshellarg($this->dbConfig['database']).' ';
        $cmd .= '> '.escapeshellarg($filepath);

        return $cmd;
    }

    /**
     * Compress backup file with gzip
     */
    private function compressBackup(string $filepath): bool
    {
        try {
            // Use -f to force overwrite and avoid prompts
            exec('gzip -f '.escapeshellarg($filepath), $output, $returnCode);

            // Ensure the uncompressed file is gone (gzip usually does this, but for extra safety)
            if (file_exists($filepath)) {
                @unlink($filepath);
            }

            return $returnCode === 0;
        } catch (\Exception $e) {
            Log::warning('Backup compression failed', [
                'file' => $filepath,
                'message' => $e->getMessage(),
            ]);

            return false;
        }
    }

    /**
     * Verify backup integrity
     */
    public function verifyBackup(string $filename): bool
    {
        try {
            $filepath = storage_path("backups/database/{$filename}");

            if (! file_exists($filepath)) {
                return false;
            }

            // For .gz files, test if readable
            if (str_ends_with($filename, '.gz')) {
                $handle = gzopen($filepath, 'rb');
                if ($handle === false) {
                    return false;
                }
                gzclose($handle);
            }

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Get backup size and metadata
     */
    public function getBackupInfo(string $filename): ?array
    {
        try {
            $filepath = storage_path("backups/database/{$filename}");

            if (! file_exists($filepath)) {
                return null;
            }

            return [
                'filename' => $filename,
                'size_bytes' => filesize($filepath),
                'size_mb' => round(filesize($filepath) / 1024 / 1024, 2),
                'created_at' => filemtime($filepath),
                'readable_date' => date('Y-m-d H:i:s', filemtime($filepath)),
                'is_valid' => $this->verifyBackup($filename),
            ];
        } catch (\Exception $e) {
            return null;
        }
    }
}
