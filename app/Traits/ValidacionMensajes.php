<?php

namespace App\Traits;

trait ValidacionMensajes
{
    protected static function mensajesValidacion(): array
    {
        $minPassword = config('app_config.password.min_length', 8);

        return [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.max' => 'El nombre no puede exceder 50 caracteres.',
            'nombre.string' => 'El nombre debe ser texto válido.',
            'apellido.required' => 'El apellido es obligatorio.',
            'apellido.max' => 'El apellido no puede exceder 50 caracteres.',
            'apellido.string' => 'El apellido debe ser texto válido.',
            'correo.required' => 'El correo es obligatorio.',
            'correo.email' => 'Ingresa un correo válido.',
            'correo.max' => 'El correo no puede exceder 255 caracteres.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => "La contraseña debe tener al menos {$minPassword} caracteres.",
            'password.max' => 'La contraseña no puede exceder 100 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'password.mixedCase' => 'La contraseña debe contener mayúsculas y minúsculas.',
            'password.letters' => 'La contraseña debe contener letras.',
            'password.numbers' => 'La contraseña debe contener números.',
            'password.symbols' => 'La contraseña debe contener caracteres especiales.',
            'programa.required' => 'El programa de formación es obligatorio.',
            'programa.max' => 'El programa no puede exceder 100 caracteres.',
            'descripcion.required' => 'La descripción es obligatoria.',
            'descripcion.max' => 'La descripción no puede exceder 5000 caracteres.',
            'descripcion.min' => 'La descripción debe tener al menos 80 caracteres.',
            'estado.required' => 'El estado es obligatorio.',
            'estado.in' => 'El estado debe ser uno de los valores permitidos.',
            'comentario.max' => 'El comentario no puede exceder 1000 caracteres.',
            'archivo.required' => 'El archivo es obligatorio.',
            'archivo.file' => 'Debes subir un archivo válido.',
            'archivo.max' => 'El archivo no puede ser mayor a 5MB.',
            'archivo.mimes' => 'Tipo de archivo no permitido.',
            'token.required' => 'El token es obligatorio.',
            'token.exists' => 'El token de recuperación es inválido o ha expirado.',
        ];
    }

    public static function getMensajesValidacion(): array
    {
        return self::mensajesValidacion();
    }
}