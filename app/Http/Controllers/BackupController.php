<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class BackupController extends Controller
{
    public function index()
    {
        $backups = $this->obtenerListaBackups();
        
        return view('admin.backup', compact('backups'));
    }

    public function crear(Request $request)
    {
        try {
            $nombre = 'backup_' . date('Y-m-d_H-i-s');
            $directorio = storage_path("app/backups/{$nombre}");

            if (!File::exists(storage_path("app/backups"))) {
                File::makeDirectory(storage_path("app/backups"), 0755, true);
            }

            if (!File::exists($directorio)) {
                File::makeDirectory($directorio, 0755, true);
            }

            $dbName = DB::getDatabaseName();
            $tablas = DB::select('SHOW TABLES');
            
            $sqlCompleto = "-- Backup de Base de Datos: {$dbName}\n";
            $sqlCompleto .= "-- Fecha: " . now()->toDateTimeString() . "\n\n";

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

            File::put("{$directorio}/database.sql", $sqlCompleto);

            File::put("{$directorio}/metadata.json", json_encode([
                'nombre' => $nombre,
                'fecha' => now()->toIso8601String(),
                'db' => $dbName,
                'tablas' => count($tablas),
            ], JSON_PRETTY_PRINT));

            foreach ($tablas as $tabla) {
                $tableName = $tabla->{array_keys((array) $tabla)[0]};
                $createTable = DB::select("SHOW CREATE TABLE `{$tableName}`")[0]->{"Create Table"};
                File::put("{$directorio}/{$tableName}_structure.sql", $createTable . ";\n");

                $registros = DB::table($tableName)->get();
                if ($registros->isNotEmpty()) {
                    $campos = array_keys((array) $registros->first());
                    $valores = [];

                    foreach ($registros as $registro) {
                        $valores[] = '(' . $this->formatearValores((array) $registro, $campos) . ')';
                    }

                    $sqlTabla = "INSERT INTO `{$tableName}` (`" . implode('`, `', $campos) . "`) VALUES\n";
                    $sqlTabla .= implode(",\n", $valores) . ";";
                    File::put("{$directorio}/{$tableName}_data.sql", $sqlTabla);
                }
            }

            $this->crearZip($directorio, $nombre);

            File::deleteDirectory($directorio);

            Log::info("Backup creado: {$nombre}");

            return back()->with('success', "Backup '{$nombre}' creado exitosamente.");
        } catch (\Exception $e) {
            Log::error('Error al crear backup: ' . $e->getMessage());
            return back()->with('error', 'Error al crear el backup: ' . $e->getMessage());
        }
    }

    private function crearZip(string $directorio, string $nombre): void
    {
        $zipPath = storage_path("app/backups/{$nombre}.zip");

        if (class_exists('ZipArchive')) {
            $zip = new \ZipArchive();
            if ($zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === true) {
                $this->agregarDirectorioAlZip($zip, $directorio, basename($directorio));
                $zip->close();
            }
        } else {
            $tarPath = storage_path("app/backups/{$nombre}.tar.gz");
            
            if (function_exists('exec')) {
                $command = "cd " . dirname($directorio) . " && tar -czf " . basename($tarPath) . " " . basename($directorio);
                exec($command, $output, $return);
                
                if ($return === 0 && file_exists($tarPath)) {
                    rename($tarPath, $zipPath);
                }
            }
            
            if (!file_exists($zipPath)) {
                rename($directorio, storage_path("app/backups/{$nombre}_folder"));
                return;
            }
        }
    }

    private function agregarDirectorioAlZip(\ZipArchive $zip, string $directorio, string $raiz): void
    {
        $archivos = File::files($directorio);
        foreach ($archivos as $archivo) {
            $zip->addFile($archivo->getPathname(), "{$raiz}/" . $archivo->getFilename());
        }
    }

    public function descargar(string $nombre)
    {
        $rutaZip = storage_path("app/backups/{$nombre}.zip");
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

    public function eliminar(string $nombre)
    {
        $rutaZip = storage_path("app/backups/{$nombre}.zip");
        $rutaFolder = storage_path("app/backups/{$nombre}_folder");

        $eliminado = false;

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

    private function obtenerListaBackups(): array
    {
        $directorio = storage_path("app/backups");
        $backups = [];

        if (!File::exists($directorio)) {
            return $backups;
        }

        $archivos = File::directories($directorio);
        foreach ($archivos as $archivo) {
            $backups[] = [
                'nombre' => basename($archivo),
                'ruta' => $archivo,
                'tamano' => $this->calcularTamanoDirectorio($archivo),
                'fecha' => \Carbon\Carbon::createFromTimestamp(File::lastModified($archivo)),
                'tipo' => 'folder',
            ];
        }

        $zipFiles = File::files($directorio);
        foreach ($zipFiles as $archivo) {
            if (in_array($archivo->getExtension(), ['zip', 'tar.gz'])) {
                $backups[] = [
                    'nombre' => $archivo->getFilenameWithoutExtension(),
                    'ruta' => $archivo->getPathname(),
                    'tamano' => $archivo->getSize(),
                    'fecha' => \Carbon\Carbon::createFromTimestamp($archivo->getMTime()),
                    'tipo' => 'zip',
                ];
            }
        }

        usort($backups, fn($a, $b) => $b['fecha'] <=> $a['fecha']);

        return $backups;
    }

    private function calcularTamanoDirectorio(string $directorio): int
    {
        $tamano = 0;
        $archivos = File::allFiles($directorio);
        
        foreach ($archivos as $archivo) {
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
                $valores[] = "'" . str_replace("'", "''", $valor) . "'";
            }
        }

        return implode(', ', $valores);
    }
}