<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class BackupController extends Controller
{
    // ─────────────────────────────────────────────
    // ÍNDICE
    // ─────────────────────────────────────────────
    public function index()
    {
        $backups = $this->obtenerListaBackups();
        $proximoBackup = $this->calcularProximoBackup();

        return view('admin.backup', compact('backups', 'proximoBackup'));
    }

    // ─────────────────────────────────────────────
    // CREAR (manual desde la interfaz)
    // ─────────────────────────────────────────────
    public function crear(Request $request)
    {
        try {
            $nombre    = 'backup_' . date('Y-m-d_H-i-s');
            $zipPath   = $this->generarZipBackup($nombre);

            Log::info("Backup manual creado: {$nombre}");

            return back()->with('success', "Backup '{$nombre}' creado exitosamente.");
        } catch (\Exception $e) {
            Log::error('Error al crear backup: ' . $e->getMessage());
            return back()->with('error', 'Error al crear el backup: ' . $e->getMessage());
        }
    }

    // ─────────────────────────────────────────────
    // EXPORTAR — genera el backup y lo descarga directamente
    // ─────────────────────────────────────────────
    public function exportar()
    {
        try {
            $nombre  = 'exportacion_' . date('Y-m-d_H-i-s');
            $zipPath = $this->generarZipBackup($nombre);

            Log::info("Backup exportado manualmente: {$nombre}");

            return response()->download($zipPath, "{$nombre}.zip", [
                'Content-Type' => 'application/zip',
            ])->deleteFileAfterSend(false);
        } catch (\Exception $e) {
            Log::error('Error al exportar backup: ' . $e->getMessage());
            return back()->with('error', 'Error al exportar: ' . $e->getMessage());
        }
    }

    // ─────────────────────────────────────────────
    // IMPORTAR — restaura la DB desde un archivo SQL o ZIP subido
    // ─────────────────────────────────────────────
    public function importar(Request $request)
    {
        $request->validate([
            'archivo_backup' => 'required|file|extensions:sql,zip,txt|max:51200', // máx 50 MB
        ], [
            'archivo_backup.required' => 'Debes seleccionar un archivo.',
            'archivo_backup.extensions' => 'Solo se aceptan archivos .sql o .zip.',
            'archivo_backup.max'      => 'El archivo no debe superar los 50 MB.',
        ]);

        try {
            $archivo   = $request->file('archivo_backup');
            $extension = strtolower($archivo->getClientOriginalExtension());
            $tmpDir    = storage_path('app/backups/tmp_import_' . time());

            File::makeDirectory($tmpDir, 0755, true);

            if ($extension === 'zip') {
                // Extraer ZIP y buscar el database.sql dentro
                $zipTmp = $tmpDir . '/upload.zip';
                $archivo->move($tmpDir, 'upload.zip');

                if (!class_exists('ZipArchive')) {
                    File::deleteDirectory($tmpDir);
                    return back()->with('error', 'ZipArchive no está disponible en este servidor. Sube directamente el archivo .sql.');
                }

                $zip = new \ZipArchive();
                if ($zip->open($zipTmp) !== true) {
                    File::deleteDirectory($tmpDir);
                    return back()->with('error', 'No se pudo abrir el archivo ZIP.');
                }
                $zip->extractTo($tmpDir . '/extracted');
                $zip->close();

                // Buscar database.sql dentro del ZIP (puede estar en subdirectorio)
                $sqlFile = $this->buscarArchivoSql($tmpDir . '/extracted');

                if (!$sqlFile) {
                    File::deleteDirectory($tmpDir);
                    return back()->with('error', 'No se encontró un archivo database.sql dentro del ZIP.');
                }
            } else {
                // Es un .sql directo
                $archivo->move($tmpDir, 'database.sql');
                $sqlFile = $tmpDir . '/database.sql';
            }

            // Ejecutar el SQL
            $sql = File::get($sqlFile);
            $this->ejecutarSql($sql);

            File::deleteDirectory($tmpDir);

            Log::info('Base de datos restaurada desde importación manual. Archivo: ' . $archivo->getClientOriginalName());

            return back()->with('success', '✅ Base de datos restaurada correctamente desde el archivo importado.');
        } catch (\Exception $e) {
            if (isset($tmpDir) && File::exists($tmpDir)) {
                File::deleteDirectory($tmpDir);
            }
            Log::error('Error al importar backup: ' . $e->getMessage());
            return back()->with('error', 'Error al importar: ' . $e->getMessage());
        }
    }

    // ─────────────────────────────────────────────
    // DESCARGAR (backup ya existente en lista)
    // ─────────────────────────────────────────────
    public function descargar(string $nombre)
    {
        $rutaZip    = storage_path("app/backups/{$nombre}.zip");
        $rutaFolder = storage_path("app/backups/{$nombre}_folder");

        if (file_exists($rutaZip)) {
            return response()->download($rutaZip);
        }

        if (is_dir($rutaFolder)) {
            $sqlFile = "{$rutaFolder}/database.sql";
            if (file_exists($sqlFile)) {
                return response()->download($sqlFile, "{$nombre}_database.sql", [
                    'Content-Type' => 'application/sql',
                ]);
            }
        }

        return back()->with('error', 'Archivo de backup no encontrado.');
    }

    // ─────────────────────────────────────────────
    // ELIMINAR
    // ─────────────────────────────────────────────
    public function eliminar(string $nombre)
    {
        $rutaZip    = storage_path("app/backups/{$nombre}.zip");
        $rutaFolder = storage_path("app/backups/{$nombre}_folder");
        $eliminado  = false;

        if (file_exists($rutaZip)) {
            unlink($rutaZip);
            $eliminado = true;
        }

        if (is_dir($rutaFolder)) {
            File::deleteDirectory($rutaFolder);
            $eliminado = true;
        }

        if (!$eliminado) {
            return back()->with('error', 'Archivo de backup no encontrado.');
        }

        Log::info("Backup eliminado: {$nombre}");

        return back()->with('success', "Backup '{$nombre}' eliminado.");
    }

    // ─────────────────────────────────────────────
    // HELPERS PRIVADOS
    // ─────────────────────────────────────────────

    /**
     * Genera el SQL completo y lo empaqueta en un ZIP.
     * Devuelve la ruta absoluta del ZIP creado.
     */
    private function generarZipBackup(string $nombre): string
    {
        $backupsDir = storage_path("app/backups");
        $directorio = "{$backupsDir}/{$nombre}";

        if (!File::exists($backupsDir)) {
            File::makeDirectory($backupsDir, 0755, true);
        }
        File::makeDirectory($directorio, 0755, true);

        $dbName  = DB::getDatabaseName();
        $tablas  = DB::select('SHOW TABLES');

        $sql  = "-- Backup: {$nombre}\n";
        $sql .= "-- Base de datos: {$dbName}\n";
        $sql .= "-- Fecha: " . now()->toDateTimeString() . "\n\n";
        $sql .= "SET FOREIGN_KEY_CHECKS=0;\n\n";

        foreach ($tablas as $tabla) {
            $tableName   = $tabla->{array_keys((array) $tabla)[0]};
            $createTable = DB::select("SHOW CREATE TABLE `{$tableName}`")[0]->{"Create Table"};

            $sql .= "DROP TABLE IF EXISTS `{$tableName}`;\n";
            $sql .= $createTable . ";\n\n";

            $registros = DB::table($tableName)->get();
            if ($registros->isNotEmpty()) {
                $campos  = array_keys((array) $registros->first());
                $valores = [];

                foreach ($registros as $registro) {
                    $valores[] = '(' . $this->formatearValores((array) $registro, $campos) . ')';
                }

                $sql .= "INSERT INTO `{$tableName}` (`" . implode('`, `', $campos) . "`) VALUES\n";
                $sql .= implode(",\n", $valores) . ";\n\n";
            }
        }

        $sql .= "SET FOREIGN_KEY_CHECKS=1;\n";

        File::put("{$directorio}/database.sql", $sql);

        File::put("{$directorio}/metadata.json", json_encode([
            'nombre' => $nombre,
            'fecha'  => now()->toIso8601String(),
            'db'     => $dbName,
            'tablas' => count($tablas),
        ], JSON_PRETTY_PRINT));

        $zipPath = "{$backupsDir}/{$nombre}.zip";

        if (class_exists('ZipArchive')) {
            $zip = new \ZipArchive();
            if ($zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === true) {
                foreach (File::files($directorio) as $archivo) {
                    $zip->addFile($archivo->getPathname(), "{$nombre}/" . $archivo->getFilename());
                }
                $zip->close();
            } else {
                // Si no se pudo crear el ZIP, lanzar excepción
                File::deleteDirectory($directorio);
                throw new \Exception('No se pudo crear el archivo ZIP. Verifica los permisos del directorio.');
            }
        } else {
            File::deleteDirectory($directorio);
            throw new \Exception('La extensión ZipArchive no está disponible en el servidor.');
        }

        // Verificar que el archivo ZIP se haya creado correctamente
        if (!file_exists($zipPath)) {
            throw new \Exception('El archivo ZIP no se creó correctamente.');
        }

        File::deleteDirectory($directorio);

        return $zipPath;
    }

    /**
     * Ejecuta un string SQL en la base de datos, sentencia por sentencia.
     */
    private function ejecutarSql(string $sql): void
    {
        // Dividir por ";" pero respetando las cadenas
        $sentencias = array_filter(
            array_map('trim', $this->dividirSql($sql)),
            fn($s) => !empty($s) && !str_starts_with($s, '--')
        );

        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        foreach ($sentencias as $sentencia) {
            DB::unprepared($sentencia);
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }

    /**
     * Divide un string SQL en sentencias individuales, respetando strings.
     */
    private function dividirSql(string $sql): array
    {
        $sentencias  = [];
        $actual      = '';
        $inString    = false;
        $charString  = '';
        $len         = strlen($sql);

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

    /**
     * Busca recursivamente el primer archivo database.sql en un directorio.
     */
    private function buscarArchivoSql(string $directorio): ?string
    {
        foreach (File::allFiles($directorio) as $archivo) {
            if ($archivo->getFilename() === 'database.sql') {
                return $archivo->getPathname();
            }
        }
        // Si no hay database.sql, aceptar cualquier .sql
        foreach (File::allFiles($directorio) as $archivo) {
            if ($archivo->getExtension() === 'sql') {
                return $archivo->getPathname();
            }
        }
        return null;
    }

    /**
     * Calcula la fecha estimada del próximo backup automático.
     */
    private function calcularProximoBackup(): ?string
    {
        // El cron es "0 2 */10 * *" (cada 10 días a las 2:00 AM)
        $hoy     = now();
        $diaHoy  = (int) $hoy->format('j');
        $diasMes = (int) $hoy->format('t');

        // Próximo múltiplo de 10 en el mes
        $proximoDia = (int) (ceil($diaHoy / 10) * 10);
        if ($proximoDia > $diasMes || $proximoDia === $diaHoy) {
            $proximoDia = 10; // Primero del siguiente ciclo
            $fecha = $hoy->copy()->addMonthNoOverflow()->startOfMonth()->addDays($proximoDia - 1)->setTime(2, 0);
        } else {
            $fecha = $hoy->copy()->setDay($proximoDia)->setTime(2, 0);
        }

        return $fecha->format('d/m/Y \a \l\a\s H:i');
    }

    private function obtenerListaBackups(): array
    {
        $directorio = storage_path("app/backups");
        $backups    = [];

        if (!File::exists($directorio)) {
            return $backups;
        }

        foreach (File::files($directorio) as $archivo) {
            if ($archivo->getExtension() === 'zip') {
                $nombre = $archivo->getFilenameWithoutExtension();
                $backups[] = [
                    'nombre'      => $nombre,
                    'ruta'        => $archivo->getPathname(),
                    'tamano'      => $archivo->getSize(),
                    'fecha'       => \Carbon\Carbon::createFromTimestamp($archivo->getMTime()),
                    'tipo'        => 'zip',
                    'automatico'  => str_starts_with($nombre, 'auto_backup_'),
                ];
            }
        }

        // Carpetas legacy (sin ZIP)
        foreach (File::directories($directorio) as $dir) {
            $backups[] = [
                'nombre'     => basename($dir),
                'ruta'       => $dir,
                'tamano'     => $this->calcularTamanoDirectorio($dir),
                'fecha'      => \Carbon\Carbon::createFromTimestamp(File::lastModified($dir)),
                'tipo'       => 'folder',
                'automatico' => str_starts_with(basename($dir), 'auto_backup_'),
            ];
        }

        usort($backups, fn($a, $b) => $b['fecha'] <=> $a['fecha']);

        return $backups;
    }

    private function calcularTamanoDirectorio(string $directorio): int
    {
        $tamano = 0;
        foreach (File::allFiles($directorio) as $archivo) {
            $tamano += $archivo->getSize();
        }
        return $tamano;
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