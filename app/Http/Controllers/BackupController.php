<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Services\BackupService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class BackupController extends Controller
{
    public function __construct(
        private BackupService $backupService
    ) {}

    public function index()
    {
        $backups = $this->backupService->getBackupList();
        $proximoBackup = $this->backupService->getNextBackupTime();

        return view('admin.backup', compact('backups', 'proximoBackup'));
    }

    public function crear(Request $request)
    {
        try {
            $nombre = 'backup_' . date('Y-m-d_H-i-s');
            $this->backupService->generateBackup($nombre);

            Log::info("Backup manual creado: {$nombre}");

            AuditLog::registrar(session('usr_id'), 'crear', 'backups', "Se creó un backup manual de la base de datos: {$nombre}");

            return back()->with('success', "Backup '{$nombre}' creado.");
        } catch (\Exception $e) {
            Log::error('Error al crear backup: ' . $e->getMessage());
            return back()->with('error', 'Error al crear el backup.');
        }
    }

    public function exportar()
    {
        try {
            $nombre  = 'exportacion_' . date('Y-m-d_H-i-s');
            $zipPath = $this->backupService->generateBackup($nombre);

            Log::info("Backup exportado manualmente: {$nombre}");

            return response()->download($zipPath, "{$nombre}.zip", [
                'Content-Type' => 'application/zip',
            ])->deleteFileAfterSend(false);
        } catch (\Exception $e) {
            Log::error('Error al exportar backup: ' . $e->getMessage());
            return back()->with('error', 'Error al exportar el backup.');
        }
    }

    public function importar(Request $request)
    {
        $request->validate([
            'archivo_backup' => 'required|file|extensions:sql,zip,txt|max:51200',
        ], [
            'archivo_backup.required' => 'Selecciona un archivo.',
            'archivo_backup.extensions' => 'Solo archivos .sql o .zip.',
            'archivo_backup.max'      => 'Máximo 50 MB.',
        ]);

        try {
            $archivo   = $request->file('archivo_backup');
            $extension = strtolower($archivo->getClientOriginalExtension());
            $tmpDir    = storage_path('app/backups/tmp_import_' . time());

            File::makeDirectory($tmpDir, 0755, true);

            if ($extension === 'zip') {
                $zipTmp = $tmpDir . '/upload.zip';
                $archivo->move($tmpDir, 'upload.zip');

                if (!class_exists('ZipArchive')) {
                    File::deleteDirectory($tmpDir);
                    return back()->with('error', 'ZipArchive no disponible. Sube un archivo .sql.');
                }

                $zip = new \ZipArchive();
                if ($zip->open($zipTmp) !== true) {
                    File::deleteDirectory($tmpDir);
                    return back()->with('error', 'No se pudo abrir el archivo ZIP.');
                }
                $zip->extractTo($tmpDir . '/extracted');
                $zip->close();

                $sqlFile = $this->backupService->findSqlFile($tmpDir . '/extracted');

                if (!$sqlFile) {
                    File::deleteDirectory($tmpDir);
                    return back()->with('error', 'No se encontró database.sql en el ZIP.');
                }
            } else {
                $archivo->move($tmpDir, 'database.sql');
                $sqlFile = $tmpDir . '/database.sql';
            }

            $sql = File::get($sqlFile);
            $this->backupService->executeSql($sql);

            File::deleteDirectory($tmpDir);

            Log::info('Base de datos restaurada desde importación manual. Archivo: ' . $archivo->getClientOriginalName());

            AuditLog::registrar(session('usr_id'), 'editar', 'backups', "Se restauró la base de datos desde el archivo: " . $archivo->getClientOriginalName());

            return back()->with('success', 'Base de datos restaurada correctamente.');
        } catch (\Exception $e) {
            if (isset($tmpDir) && File::exists($tmpDir)) {
                File::deleteDirectory($tmpDir);
            }
            Log::error('Error al importar backup: ' . $e->getMessage());
            return back()->with('error', 'Error al importar el backup.');
        }
    }

    public function descargar(string $nombre)
    {
        $path = $this->backupService->getBackupPath($nombre);

        if (!$path) {
            return back()->with('error', 'Archivo de backup no encontrado.');
        }

        if (str_ends_with($path, '.sql')) {
            return response()->download($path, "{$nombre}_database.sql", [
                'Content-Type' => 'application/sql',
            ]);
        }

        return response()->download($path);
    }

    public function eliminar(string $nombre)
    {
        if (!$this->backupService->deleteBackup($nombre)) {
            return back()->with('error', 'Archivo de backup no encontrado.');
        }

        Log::info("Backup eliminado: {$nombre}");

        AuditLog::registrar(session('usr_id'), 'eliminar', 'backups', "Se eliminó permanentemente el archivo de backup: {$nombre}");

        return back()->with('success', "Backup '{$nombre}' eliminado.");
    }
}