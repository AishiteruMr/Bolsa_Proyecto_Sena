<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistroInstructorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => [
                'required',
                'string',
                'min:2',
                'max:50',
                'regex:/^[a-zA-ZÀ-ÿÑñ\s\.]+$/u',
                function ($attribute, $value, $fail) {
                    $palabras = array_filter(explode(' ', trim($value)));
                    $count = count($palabras);
                    if ($count < 1 || $count > 4) {
                        $fail('El nombre debe tener entre 1 y 4 palabras.');
                    }
                    foreach ($palabras as $palabra) {
                        if (!ctype_upper(mb_substr($palabra, 0, 1))) {
                            $fail('El nombre debe tener mayúscula inicial en cada palabra.');
                            break;
                        }
                    }
                },
            ],
            'apellido' => [
                'required',
                'string',
                'min:2',
                'max:50',
                'regex:/^[a-zA-ZÀ-ÿÑñ\s\.]+$/u',
                function ($attribute, $value, $fail) {
                    $palabras = array_filter(explode(' ', trim($value)));
                    $count = count($palabras);
                    if ($count < 1 || $count > 4) {
                        $fail('El apellido debe tener entre 1 y 4 palabras.');
                    }
                    foreach ($palabras as $palabra) {
                        if (!ctype_upper(mb_substr($palabra, 0, 1))) {
                            $fail('El apellido debe tener mayúscula inicial en cada palabra.');
                            break;
                        }
                    }
                },
            ],
            'documento' => [
                'required',
                'numeric',
                'digits_between:8,12',
                'unique:usuarios,numero_documento',
            ],
            'especialidad' => [
                'required',
                'string',
                'min:5',
                'max:150',
            ],
            'correo' => 'required|email:rfc,dns|max:255|unique:usuarios,correo',
            'password' => [
                'required',
                'string',
                'min:8',
                'max:100',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
            ],
            'terminos' => 'accepted',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'El campo :attribute es obligatorio.',
            'email' => 'Ingresa un correo electrónico válido y existente.',
            'unique' => 'Este :attribute ya está registrado.',
            'min' => 'El campo :attribute debe tener al menos :min caracteres.',
            'max' => 'El campo :attribute no puede exceder :max caracteres.',
            'numeric' => 'El campo :attribute debe ser numérico.',
            'digits_between' => 'El documento debe tener entre :min y :max dígitos.',
            'accepted' => 'Debes aceptar los términos y condiciones.',
            'regex' => 'El campo :attribute solo puede contener letras y espacios.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'password.regex' => 'La contraseña debe tener mayúsculas, minúsculas y números.',
        ];
    }
}
