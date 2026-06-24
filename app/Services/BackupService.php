<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class BackupService
{
    private string $backupsDir;

    public function __construct()
    {
        $this->backupsDir = storage_path('app/backups');
    }

    public function generateBackup(string $name, string $type = 'manual'): string
    {
        if (!File::exists($this->backupsDir)) {
            File::makeDirectory($this->backupsDir, 0755, true);
        }

        $directorio = $this->backupsDir . '/' . $name;
        File::makeDirectory($directorio, 0755, true);

        $dbName = DB::getDatabaseName();
        $tablas = DB::select('SHOW TABLES');

        $sql = $this->buildSqlHeader($name, $dbName, $type);

        foreach ($tablas as $tabla) {
            $tableName = $tabla->{array_keys((array) $tabla)[0]};
            $tableName = preg_replace('/[^a-zA-Z0-9_]/', '', $tableName);

            $createTable = DB::select("SHOW CREATE TABLE `{$tableName}`")[0]->{"Create Table"};
            $sql .= "DROP TABLE IF EXISTS `{$tableName}`;\n";
            $sql .= $createTable . ";\n\n";

            $registros = DB::table($tableName)->get();
            if ($registros->isNotEmpty()) {
                $campos = array_map(
                    fn($campo) => preg_replace('/[^a-zA-Z0-9_]/', '', $campo),
                    array_keys((array) $registros->first())
                );
                $valores = [];

                foreach ($registros as $registro) {
                    $valores[] = '(' . $this->formatValues((array) $registro, $campos) . ')';
                }

                $sql .= "INSERT INTO `{$tableName}` (`" . implode('`, `', $campos) . "`) VALUES\n";
                $sql .= implode(",\n", $valores) . ";\n\n";
            }
        }

        $sql .= "SET FOREIGN_KEY_CHECKS=1;\n";

        File::put("{$directorio}/database.sql", $sql);
        File::put("{$directorio}/metadata.json", json_encode([
            'nombre' => $name,
            'fecha'  => now()->toIso8601String(),
            'db'     => $dbName,
            'tablas' => count($tablas),
            'tipo'   => $type,
        ], JSON_PRETTY_PRINT));

        $zipPath = "{$this->backupsDir}/{$name}.zip";

        if (class_exists('ZipArchive')) {
            $zip = new \ZipArchive();
            if ($zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === true) {
                foreach (File::files($directorio) as $archivo) {
                    $zip->addFile($archivo->getPathname(), "{$name}/" . $archivo->getFilename());
                }
                $zip->close();
            } else {
                File::deleteDirectory($directorio);
                throw new \RuntimeException('No se pudo crear el archivo ZIP. Verifica los permisos del directorio.');
            }
        } else {
            File::deleteDirectory($directorio);
            throw new \RuntimeException('La extensión ZipArchive no está disponible en el servidor.');
        }

        if (!file_exists($zipPath)) {
            throw new \RuntimeException('El archivo ZIP no se creó correctamente.');
        }

        File::deleteDirectory($directorio);

        return $zipPath;
    }

    public function cleanOldAutomaticBackups(int $keep = 5): void
    {
        if (!File::exists($this->backupsDir)) {
            return;
        }

        $archivos = File::files($this->backupsDir);

        $autoBackups = array_filter($archivos, fn($f) =>
            str_starts_with($f->getFilenameWithoutExtension(), 'auto_backup_') &&
            $f->getExtension() === 'zip'
        );

        usort($autoBackups, fn($a, $b) => $b->getMTime() <=> $a->getMTime());

        foreach (array_slice($autoBackups, $keep) as $viejo) {
            File::delete($viejo->getPathname());
            Log::info("Backup automático antiguo eliminado: " . $viejo->getFilename());
        }
    }

    public function getBackupList(): array
    {
        if (!File::exists($this->backupsDir)) {
            return [];
        }

        $backups = [];

        foreach (File::files($this->backupsDir) as $archivo) {
            if ($archivo->getExtension() === 'zip') {
                $nombre = $archivo->getFilenameWithoutExtension();
                $backups[] = [
                    'nombre'     => $nombre,
                    'ruta'       => $archivo->getPathname(),
                    'tamano'     => $archivo->getSize(),
                    'fecha'      => \Carbon\Carbon::createFromTimestamp($archivo->getMTime()),
                    'tipo'       => 'zip',
                    'automatico' => str_starts_with($nombre, 'auto_backup_'),
                ];
            }
        }

        foreach (File::directories($this->backupsDir) as $dir) {
            $nombre = basename($dir);
            $backups[] = [
                'nombre'     => $nombre,
                'ruta'       => $dir,
                'tamano'     => $this->getDirectorySize($dir),
                'fecha'      => \Carbon\Carbon::createFromTimestamp(File::lastModified($dir)),
                'tipo'       => 'folder',
                'automatico' => str_starts_with($nombre, 'auto_backup_'),
            ];
        }

        usort($backups, fn($a, $b) => $b['fecha'] <=> $a['fecha']);

        return $backups;
    }

    public function getNextBackupTime(): ?string
    {
        $hoy     = now();
        $diaHoy  = (int) $hoy->format('j');
        $diasMes = (int) $hoy->format('t');

        $proximoDia = (int) (ceil($diaHoy / 10) * 10);
        if ($proximoDia > $diasMes || $proximoDia === $diaHoy) {
            $proximoDia = 10;
            $fecha = $hoy->copy()->addMonthNoOverflow()->startOfMonth()->addDays($proximoDia - 1)->setTime(2, 0);
        } else {
            $fecha = $hoy->copy()->setDay($proximoDia)->setTime(2, 0);
        }

        return $fecha->format('d/m/Y \a \l\a\s H:i');
    }

    public function getDirectorySize(string $directory): int
    {
        $tamano = 0;
        foreach (File::allFiles($directory) as $archivo) {
            $tamano += $archivo->getSize();
        }
        return $tamano;
    }

    public function findSqlFile(string $directory): ?string
    {
        foreach (File::allFiles($directory) as $archivo) {
            if ($archivo->getFilename() === 'database.sql') {
                return $archivo->getPathname();
            }
        }

        foreach (File::allFiles($directory) as $archivo) {
            if ($archivo->getExtension() === 'sql') {
                return $archivo->getPathname();
            }
        }

        return null;
    }

    public function isStatementSafe(string $statement): bool
    {
        $statementUpper = strtoupper(trim($statement));

        $patronesPermitidos = [
            '/^SET\s+FOREIGN_KEY_CHECKS\s*=/i',
            '/^DROP\s+TABLE\s+(IF\s+EXISTS\s+)?`?[a-zA-Z0-9_]+`?\s*/i',
            '/^CREATE\s+TABLE\s+`?[a-zA-Z0-9_]+`?\s*\(/i',
            '/^INSERT\s+INTO\s+`?[a-zA-Z0-9_]+`?\s*\(/i',
            '/^LOCK\s+TABLES\s+/i',
            '/^UNLOCK\s+TABLES/i',
            '/^--\s/i',
        ];

        foreach ($patronesPermitidos as $patron) {
            if (preg_match($patron, $statementUpper)) {
                return true;
            }
        }

        return false;
    }

    public function splitSql(string $sql): array
    {
        $sentencias = [];
        $actual     = '';
        $inString   = false;
        $charString = '';
        $len        = strlen($sql);

        for ($i = 0; $i < $len; $i++) {
            $char = $sql[$i];

            if ($inString) {
                $actual .= $char;
                if ($char === $charString && ($i === 0 || $sql[$i - 1] !== '\\')) {
                    $inString = false;
                }
            } else {
                if ($char === "'" || $char === '"') {
                    $inString   = true;
                    $charString = $char;
                    $actual    .= $char;
                } elseif ($char === ';') {
                    $sentencias[] = trim($actual);
                    $actual = '';
                } else {
                    $actual .= $char;
                }
            }
        }

        if (!empty(trim($actual))) {
            $sentencias[] = trim($actual);
        }

        return $sentencias;
    }

    public function executeSql(string $sql): void
    {
        $sentencias = array_filter(
            array_map('trim', $this->splitSql($sql)),
            fn($s) => !empty($s) && !str_starts_with($s, '--')
        );

        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        foreach ($sentencias as $sentencia) {
            if (!$this->isStatementSafe($sentencia)) {
                throw new \RuntimeException('Sentencia SQL no permitida detectada: ' . substr($sentencia, 0, 100));
            }
            DB::unprepared($sentencia);
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }

    public function deleteBackup(string $name): bool
    {
        $name = basename($name);
        $name = preg_replace('/[^a-zA-Z0-9_\-]/', '', $name);

        if (empty($name)) {
            return false;
        }

        $rutaZip    = "{$this->backupsDir}/{$name}.zip";
        $rutaFolder = "{$this->backupsDir}/{$name}_folder";
        $eliminado  = false;

        if (file_exists($rutaZip)) {
            unlink($rutaZip);
            $eliminado = true;
        }

        if (is_dir($rutaFolder)) {
            File::deleteDirectory($rutaFolder);
            $eliminado = true;
        }

        return $eliminado;
    }

    public function getBackupPath(string $name): ?string
    {
        $name = basename($name);
        $name = preg_replace('/[^a-zA-Z0-9_\-]/', '', $name);

        if (empty($name)) {
            return null;
        }

        $rutaZip    = "{$this->backupsDir}/{$name}.zip";
        $rutaFolder = "{$this->backupsDir}/{$name}_folder";

        if (file_exists($rutaZip)) {
            return $rutaZip;
        }

        if (is_dir($rutaFolder)) {
            $sqlFile = "{$rutaFolder}/database.sql";
            if (file_exists($sqlFile)) {
                return $sqlFile;
            }
        }

        return null;
    }

    private function buildSqlHeader(string $name, string $dbName, string $type): string
    {
        $header  = "-- " . ($type === 'automatico' ? 'Backup AUTOMÁTICO' : 'Backup') . ": {$name}\n";
        $header .= "-- Base de datos: {$dbName}\n";
        $header .= "-- Fecha: " . now()->toDateTimeString() . "\n";
        if ($type === 'automatico') {
            $header .= "-- Tipo: Automático (cada 10 días)\n";
        }
        $header .= "\nSET FOREIGN_KEY_CHECKS=0;\n\n";

        return $header;
    }

    private function formatValues(array $registro, array $campos): string
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
