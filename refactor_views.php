<?php

$dir = __DIR__ . '/resources/views';

$replacements = [
    // Usuario
    'usr_id' => 'id',
    'usr_tipo_documento' => 'tipo_documento',
    'usr_documento' => 'numero_documento',
    'usr_correo' => 'correo',
    'usr_contrasena' => 'contrasena',
    'usr_rol' => 'rol',
    'usr_fecha_creacion' => 'created_at',
    // Aprendiz
    'apr_id' => 'id',
    'apr_usr_documento' => 'usuario_id',
    'apr_nombre' => 'nombres',
    'apr_apellido' => 'apellidos',
    'apr_programa' => 'programa_formacion',
    'apr_ficha' => 'ficha',
    'apr_estado' => 'activo',
    // Instructor
    'ins_usr_documento' => 'usuario_id',
    'ins_nombre' => 'nombres',
    'ins_apellido' => 'apellidos',
    'ins_especialidad' => 'especialidad',
    'ins_estado' => 'activo',
    // Administrador
    'adm_usr_documento' => 'usuario_id',
    'adm_nombre' => 'nombres',
    'adm_apellido' => 'apellidos',
    // Empresa
    'emp_id' => 'id',
    'emp_nit' => 'nit',
    'emp_nombre' => 'nombre',
    'emp_representante' => 'representante',
    'emp_telefono' => 'telefono',
    'emp_direccion' => 'direccion',
    'emp_correo' => 'correo_contacto',
    'emp_estado' => 'activo',
    'emp_usr_documento' => 'usuario_id',
    // Proyecto
    'pro_id' => 'id',
    'pro_titulo_proyecto' => 'titulo',
    'pro_categoria' => 'categoria',
    'pro_descripcion' => 'descripcion',
    'pro_requisitos_especificos' => 'requisitos_especificos',
    'pro_habilidades_requerida' => 'habilidades_requeridas',
    'pro_fecha_publi' => 'fecha_publicacion',
    'pro_fecha_finalizacion' => 'fecha_finalizacion', // Esto en algunos stdClass lo pasamos así
    'pro_duracion_estimada' => 'duracion_estimada_dias',
    'pro_imagen_url' => 'imagen_url',
    'pro_estado' => 'estado',
    'pro_latitud' => 'latitud',
    'pro_longitud' => 'longitud',
    // Postulación
    'pos_id' => 'id',
    'pos_fecha' => 'fecha_postulacion',
    'pos_estado' => 'estado',
    // Etapa
    'eta_id' => 'id',
    'eta_pro_id' => 'proyecto_id',
    'eta_orden' => 'orden',
    'eta_nombre' => 'nombre',
    'eta_descripcion' => 'descripcion',
    // Evidencia
    'evid_id' => 'id',
    'evid_apr_id' => 'aprendiz_id',
    'evid_eta_id' => 'etapa_id',
    'evid_pro_id' => 'proyecto_id',
    'evid_archivo' => 'archivo_url',
    'evid_fecha' => 'fecha_subida',
    'evid_estado' => 'estado',
    'evid_comentario' => 'comentarios_instructor',
    // Entregas (obsoleto, pero por si acaso)
    'ene_id' => 'id',
    'ene_eta_id' => 'etapa_id',
    'ene_apr_id' => 'aprendiz_id',
    'ene_pro_id' => 'proyecto_id',
    'ene_fecha_entrega' => 'fecha_entrega',
    'ene_archivo_url' => 'archivo_url',
    'ene_estado' => 'estado',
    'ene_comentarios' => 'comentarios_instructor',
];

function processDirectory($dir, $replacements) {
    if (!is_dir($dir)) return;

    $files = scandir($dir);
    foreach ($files as $file) {
        if ($file === '.' || $file === '..') continue;

        $path = $dir . '/' . $file;
        if (is_dir($path)) {
            processDirectory($path, $replacements);
        } elseif (is_file($path) && pathinfo($path, PATHINFO_EXTENSION) === 'php') {
            $content = file_get_contents($path);
            $originalContent = $content;

            foreach ($replacements as $old => $new) {
                // We typically use these as object properties: ->pro_titulo_proyecto
                // Or as array keys: ['pro_titulo_proyecto']
                // Or as input names: name="pro_titulo_proyecto"
                // Let's replace instances of $old to $new strictly when it's variables/keys.
                // Using word boundaries \b prevents matching part of another word.
                $content = preg_replace("/\b" . preg_quote($old, "/") . "\b/", $new, $content);
            }

            // Some specific tricky ones:
            // "Pendiente" -> "pendiente"
            // "Aprobada" -> "aceptada" (for postulaciones)
            // "Activo" -> "aprobado" (for projects)
            // But doing this globally is dangerous (might replace form labels). 
            // So we'll skip global state string replacement if possible, or do it manually if it fails.

            if ($content !== $originalContent) {
                file_put_contents($path, $content);
                echo "Updated: $path\n";
            }
        }
    }
}

processDirectory($dir, $replacements);
echo "Completed.\n";
