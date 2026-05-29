<?php

namespace App\Traits;

trait ValidacionMensajes
{
    protected static function mensajesValidacion(): array
    {
        $minPassword = config('app_config.password.min_length', 8);

        return [
            'nombre.required' => 'Escribe tu nombre.',
            'nombre.max' => 'Máximo 50 caracteres.',
            'nombre.string' => 'El nombre solo debe tener texto.',
            'apellido.required' => 'Escribe tu apellido.',
            'apellido.max' => 'Máximo 50 caracteres.',
            'apellido.string' => 'El apellido solo debe tener texto.',
            'correo.required' => 'Escribe tu correo.',
            'correo.email' => 'Correo no válido.',
            'correo.max' => 'Máximo 255 caracteres.',
            'password.required' => 'Escribe una contraseña.',
            'password.min' => "Mínimo {$minPassword} caracteres.",
            'password.max' => 'Máximo 100 caracteres.',
            'password.confirmed' => 'Las contraseñas no son iguales.',
            'password.mixedCase' => 'Usa mayúsculas y minúsculas.',
            'password.letters' => 'Debe contener letras.',
            'password.numbers' => 'Debe contener números.',
            'password.symbols' => 'Debe contener un carácter especial.',
            'programa.required' => 'Escribe tu programa de formación.',
            'programa.max' => 'Máximo 100 caracteres.',
            'descripcion.required' => 'Escribe una descripción.',
            'descripcion.max' => 'Máximo 5000 caracteres.',
            'descripcion.min' => 'Escribe al menos 80 caracteres.',
            'estado.required' => 'Selecciona un estado.',
            'estado.in' => 'Estado no válido.',
            'comentario.max' => 'Máximo 1000 caracteres.',
            'archivo.required' => 'Selecciona un archivo.',
            'archivo.file' => 'El archivo no es válido.',
            'archivo.max' => 'Máximo 5MB.',
            'archivo.mimes' => 'Tipo de archivo no permitido.',
            'token.required' => 'El token es obligatorio.',
            'token.exists' => 'El enlace de recuperación ya no es válido.',
        ];
    }

    public static function getMensajesValidacion(): array
    {
        return self::mensajesValidacion();
    }
}