<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateFileUpload
{
    private const ALLOWED_IMAGE_MIMES = [
        'image/jpeg',
        'image/png',
        'image/webp',
        'image/gif',
    ];

    private const MAX_IMAGE_SIZE = 4096; // 4MB in KB

    public function handle(Request $request, Closure $next): Response
    {
        $fileFields = ['imagen', 'evidencia', 'documento', 'foto', 'logo'];

        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);

                if (! $this->validateFile($file, $field)) {
                    return back()->with('error', "El archivo {$field} no es válido.");
                }
            }
        }

        return $next($request);
    }

    private function validateFile($file, string $field): bool
    {
        // Check if file is valid
        if (! $file->isValid()) {
            return false;
        }

        // Check file size
        if ($file->getSize() > self::MAX_IMAGE_SIZE * 1024) {
            return false;
        }

        // Validate MIME type using finfo (more reliable than getMimeType)
        $realMime = $this->getRealMimeType($file);

        if ($field === 'imagen' || $field === 'foto' || $field === 'logo') {
            if (! in_array($realMime, self::ALLOWED_IMAGE_MIMES)) {
                return false;
            }
        }

        // Additional validation: check for valid image data
        if (strpos($realMime, 'image/') === 0) {
            $imageInfo = @getimagesize($file->getRealPath());
            if ($imageInfo === false) {
                return false;
            }
        }

        return true;
    }

    /**
     * Get real MIME type using finfo - cannot be spoofed
     */
    private function getRealMimeType($file): string
    {
        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($file->getRealPath());

        // Also verify with getimagesize as additional check
        if (strpos($mime, 'image/') === 0) {
            $info = @getimagesize($file->getRealPath());
            if ($info !== false) {
                $imageMime = image_type_to_mime_type($info[2]);
                if ($imageMime !== $mime) {
                    return $imageMime;
                }
            }
        }

        return $mime;
    }
}
