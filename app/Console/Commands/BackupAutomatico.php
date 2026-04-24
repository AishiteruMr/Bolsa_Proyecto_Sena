<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class BackupAutomatico extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'backup:automatico';

    /**
     * The console command description.
     */
    protected $description = 'Crea un backup automático de la base de datos (se ejecuta cada 1.5 semanas)';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        try {
            $nombre = 'auto_backup_' . date('Y-m-d_H-i-s');
            $directorio = storage_path("app/backups/{$nombre}");

            if (!File::exists(storage_path("app/backups"))) {
                File::makeDirectory(storage_path("app/backups"), 0755, true);
            }

            File::makeDirectory($directorio, 0755, true);

            $dbName = DB::getDatabaseName();
            $tablas = DB::select('SHOW TABLES');

            $sqlCompleto = "-- Backup AUTOMÁTICO de Base de Datos: {$dbName}\n";
            $sqlCompleto .= "-- Fecha: " . now()->toDateTimeString() . "\n";
            $sqlCompleto .= "-- Tipo: Automático (cada 1.5 semanas)\n\n";
            $sqlCompleto .= "SET FOREIGN_KEY_CHECKS=0;\n\n";

            foreach ($tablas as $tabla) {
                $tableName = $tabla->{array_keys((array) $tabla)[0]};

                $createTable = DB::select("SHOW CREATE TABLE `{$tableName}`")[0]->{"Create Table"};
                $sqlCompleto .= "DROP TABLE IF EXISTS `{$tableName}`;\n";
                $sqlCompleto .= $createTable . ";\n\n";

                $registros = DB::table($tableName)->get();
                if ($registros->isNotEmpty()) {
                    $campos = array_keys((array) $registros->first());
                    $valores = [];

                    foreach ($registros as $registro) {
                        $valores[] = '(' . $this->formatearValores((array) $registro, $campos) . ')';
                    }

                    $sqlCompleto .= "INSERT INTO `{$tableName}` (`" . implode('`, `', $campos) . "`) VALUES\n";
                    $sqlCompleto .= implode(",\n", $valores) . ";\n\n";
                }
            }

            $sqlCompleto .= "SET FOREIGN_KEY_CHECKS=1;\n";

            File::put("{$directorio}/database.sql", $sqlCompleto);

            File::put("{$directorio}/metadata.json", json_encode([
                'nombre'   => $nombre,
                'fecha'    => now()->toIso8601String(),
                'db'       => $dbName,
                'tablas'   => count($tablas),
                'tipo'     => 'automatico',
            ], JSON_PRETTY_PRINT));

            // Crear ZIP
            $zipPath = storage_path("app/backups/{$nombre}.zip");
            if (class_exists('ZipArchive')) {
                $zip = new \ZipArchive();
                if ($zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === true) {
                    foreach (File::files($directorio) as $archivo) {
                        $zip->addFile($archivo->getPathname(), basename($directorio) . '/' . $archivo->getFilename());
                    }
                    $zip->close();
                }
            }

            File::deleteDirectory($directorio);

            // Eliminar backups automáticos viejos (mantener solo los últimos 5)
            $this->limpiarBackupsAntiguos();

            Log::info("Backup automático creado exitosamente: {$nombre}");
            $this->info("✅ Backup automático creado: {$nombre}");

            return Command::SUCCESS;
        } catch (\Exception $e) {
            Log::error('Error en backup automático: ' . $e->getMessage());
            $this->error('❌ Error al crear backup automático: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }

    /**
     * Mantiene solo los últimos 5 backups automáticos.
     */
    private function limpiarBackupsAntiguos(): void
    {
        $backupsDir = storage_path("app/backups");
        $archivos = File::files($backupsDir);

        $autoBackups = array_filter($archivos, fn($f) =>
            str_starts_with($f->getFilenameWithoutExtension(), 'auto_backup_') &&
            $f->getExtension() === 'zip'
        );

        usort($autoBackups, fn($a, $b) => $b->getMTime() <=> $a->getMTime());

        // Eliminar los que superen los últimos 5
        foreach (array_slice($autoBackups, 5) as $viejo) {
            File::delete($viejo->getPathname());
            Log::info("Backup automático antiguo eliminado: " . $viejo->getFilename());
        }
    }

    private function formatearValores(array $registro, array $campos): string
    {
        $valores = [];
        foreach ($campos as $campo) {
            $valor = $registro[$campo];
            if (is_null($valor)) {
                $valores[] = 'NULL';
            } elseif (is_numeric($valor) && !is_string($valor)) {
                $valores[] = $valor;
            } else {
                $valores[] = "'" . str_replace("'", "''", (string) $valor) . "'";
            }
        }
        return implode(', ', $valores);
    }
}
