<?php

$dir = __DIR__ . '/resources/views';

function processDirectory($dir) {
    if (!is_dir($dir)) return;

    $files = scandir($dir);
    foreach ($files as $file) {
        if ($file === '.' || $file === '..') continue;

        $path = $dir . '/' . $file;
        if (is_dir($path)) {
            processDirectory($path);
        } elseif (is_file($path) && pathinfo($path, PATHINFO_EXTENSION) === 'php') {
            $content = file_get_contents($path);
            $originalContent = $content;

            // Arreglar `usuario_id` como name de input para instructor
            $content = str_replace('name="usuario_id"', 'name="instructor_usuario_id"', $content);
            $content = str_replace('$p->usuario_id', '$p->instructor_usuario_id', $content);

            // Arreglar 'Activo' => 'aprobado'
            $content = str_replace("'Activo'", "'aprobado'", $content);
            $content = str_replace('"Activo"', '"aprobado"', $content);
            $content = str_replace("== 'Activo'", "== 'aprobado'", $content);

            // Arreglar 'Inactivo' => 'cerrado'
            $content = str_replace("'Inactivo'", "'cerrado'", $content);
            $content = str_replace('"Inactivo"', '"cerrado"', $content);

            // Arreglar 'Pendiente' => 'pendiente'
            $content = str_replace("'Pendiente'", "'pendiente'", $content);
            $content = str_replace('"Pendiente"', '"pendiente"', $content);

            // Arreglar 'Aprobada' => 'aceptada'
            $content = str_replace("'Aprobada'", "'aceptada'", $content);
            $content = str_replace('"Aprobada"', '"aceptada"', $content);

            // Arreglar 'Rechazada' => 'rechazada' o 'Rechazado' -> 'rechazado'
            $content = str_replace("'Rechazada'", "'rechazada'", $content);
            $content = str_replace('"Rechazada"', '"rechazada"', $content);
            $content = str_replace("'Rechazado'", "'rechazado'", $content);
            $content = str_replace('"Rechazado"', '"rechazado"', $content);

            // Ajuste emp_nombre -> empresa_nombre
            $content = str_replace('$p->nombre_empresa', '$p->empresa_nombre', $content);
            // Wait, previous script put $emp_nombre -> $nombre. 
            // In AdminController I passed 'empresa_nombre' => $proyecto->empresa->nombre
            // So I should replace $p->nombre with $p->empresa_nombre
            // but be careful not to replace actual $p->nombre if it's correct.
            // Let's just do it manually for admin/proyectos.blade.php.

            if ($content !== $originalContent) {
                file_put_contents($path, $content);
                echo "Fixed states: $path\n";
            }
        }
    }
}

processDirectory($dir);
echo "States correction completed.\n";
