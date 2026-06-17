<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class FileProcessingService
{
    private ImageManager $imageManager;

    private string $disk = 'public';

    public function __construct()
    {
        $this->imageManager = new ImageManager(new Driver());
    }

    /**
     * Optimizar imagen: redimensionar y comprimir
     */
    public function optimize(UploadedFile $file, int $maxWidth = 1920, int $quality = 80): string
    {
        $image = $this->imageManager->read($file->getRealPath());

        $image->scaleDown(width: $maxWidth);

        $path = 'proyectos/optimized_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $file->getClientOriginalExtension();

        Storage::disk($this->disk)->put($path, (string) $image->encode());

        $this->compressImage(Storage::disk($this->disk)->path($path), $quality);

        return $path;
    }

    /**
     * Comprimir imagen según formato
     */
    private function compressImage(string $path, int $quality): void
    {
        $info = getimagesize($path);
        if (!$info) return;

        switch ($info['mime']) {
            case 'image/jpeg':
                $img = imagecreatefromjpeg($path);
                if ($img) {
                    imagejpeg($img, $path, $quality);
                    imagedestroy($img);
                }
                break;
            case 'image/png':
                $pngQuality = (int) round((100 - $quality) / 10);
                $img = imagecreatefrompng($path);
                if ($img) {
                    imagepng($img, $path, $pngQuality);
                    imagedestroy($img);
                }
                break;
            case 'image/webp':
                $img = imagecreatefromwebp($path);
                if ($img) {
                    imagewebp($img, $path, $quality);
                    imagedestroy($img);
                }
                break;
        }
    }

    /**
     * Aplicar watermark a imagen
     */
    public function applyWatermark(UploadedFile $file, ?string $text = null): string
    {
        $text = $text ?? config('app.name', 'Bolsa Proyectos SENA');

        $image = $this->imageManager->read($file->getRealPath());

        $image->text($text, 20, 20, function ($font) {
            $font->size(12);
            $font->color([255, 255, 255, 0.5]);
            $font->align('left');
            $font->valign('top');
        });

        $path = 'evidencias/watermarked_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $file->getClientOriginalExtension();

        Storage::disk($this->disk)->put($path, (string) $image->encode());

        return $path;
    }

    /**
     * Verificar si archivo es imagen
     */
    public function isImage(UploadedFile $file): bool
    {
        $mime = $file->getMimeType();
        return str_starts_with($mime, 'image/');
    }

    /**
     * Escanear archivo en busca de virus (requiere ClamAV instalado en servidor)
     */
    public function scanForViruses(UploadedFile $file): array
    {
        $path = $file->getRealPath();
        
        if (!file_exists($path)) {
            return [false, 'Archivo no encontrado'];
        }

        $scanPath = $this->getClamavPath();
        
        if ($scanPath === null) {
            Log::warning('ClamAV no está instalado en el servidor. Virus scanning omitido.');
            return [true, 'Escaneo de virus no disponible'];
        }

        $output = [];
        $returnVar = 0;
        
        exec(escapeshellarg($scanPath) . ' --move=quarantine ' . escapeshellarg($path) . ' 2>&1', $output, $returnVar);
        
        if ($returnVar === 0) {
            return [true, 'Archivo limpio'];
        }
        
        if ($returnVar === 1) {
            @unlink($path);
            return [false, 'Se detectó un virus en el archivo.'];
        }
        
        return [false, 'Error al escanear el archivo.'];
    }

    /**
     * Obtener ruta de ClamAV según el sistema operativo
     */
    private function getClamavPath(): ?string
    {
        $customPath = env('CLAMAV_SCAN_PATH');
        
        if ($customPath && file_exists($customPath)) {
            return $customPath;
        }

        $isWindows = str_starts_with(PHP_OS, 'WIN');
        
        if ($isWindows) {
            $possiblePaths = [
                'C:\clamav\clamscan.exe',
                'C:\Program Files\ClamAV\clamscan.exe',
                'C:\Program Files (x86)\ClamAV\clamscan.exe',
            ];
        } else {
            $possiblePaths = [
                '/usr/bin/clamscan',
                '/usr/local/bin/clamscan',
                '/opt/clamscan/bin/clamscan',
            ];
        }
        
        foreach ($possiblePaths as $path) {
            if (file_exists($path)) {
                return $path;
            }
        }
        
        return null;
    }

    /**
     * Procesar y guardar archivo con todas las validaciones
     */
    public function processUpload(UploadedFile $file, string $directory, array $options = []): ?string
    {
        $applyWatermark = $options['watermark'] ?? true;
        $scanVirus = $options['scan_virus'] ?? true;
        $maxSize = $options['max_size'] ?? 5120; // 5MB por defecto
        $optimize = $options['optimize'] ?? true;
        $maxWidth = $options['max_width'] ?? 1920;
        $quality = $options['quality'] ?? 80;

        // Validar tamaño
        if ($file->getSize() > $maxSize * 1024) {
            return null;
        }

        // Escanear virus si está habilitado
        if ($scanVirus) {
            [$clean, $message] = $this->scanForViruses($file);
            if (!$clean) {
                Log::error("Virus detectado en archivo: $message");
                return null;
            }
        }

        // Optimizar imagen (redimensionar y comprimir)
        if ($this->isImage($file) && $optimize) {
            try {
                $filename = $this->optimize($file, $maxWidth, $quality);
            } catch (\Exception $e) {
                Log::error("Error optimizando imagen: " . $e->getMessage());
                $filename = $file->storeAs($directory, 'imagen_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $file->getClientOriginalExtension(), $this->disk);
            }
        } else {
            $filename = $file->storeAs($directory, 'archivo_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $file->getClientOriginalExtension(), $this->disk);
        }

        // Aplicar watermark si es imagen (después de optimizar)
        if ($filename && $this->isImage($file) && $applyWatermark && !$optimize) {
            try {
                $filename = $this->applyWatermark($file, $options['watermark_text'] ?? null);
            } catch (\Exception $e) {
                Log::error("Error aplicando watermark: " . $e->getMessage());
            }
        }

        return $filename;
    }
}