<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class RegistroAprendizRequest extends FormRequest
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
            'programa' => [
                'required',
                'string',
                Rule::in(collect(config('programas'))->flatten()->all()),
            ],
            'correo' => 'required|email|max:255|unique:usuarios,correo',
            'password' => [
                'required',
                'string',
                'max:100',
                'confirmed',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
            ],
            'terminos' => 'accepted',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'Completa este campo.',
            'email' => 'Correo no válido.',
            'unique' => 'Este :attribute ya está en uso.',
            'min' => 'Mínimo :min caracteres.',
            'max' => 'Máximo :max caracteres.',
            'numeric' => 'Solo números.',
            'digits_between' => 'Entre :min y :max dígitos.',
            'accepted' => 'Acepta los términos para continuar.',
            'regex' => 'Solo letras y espacios.',
            'password.confirmed' => 'Las contraseñas no son iguales.',
            'password.letters' => 'Debe tener al menos una letra.',
            'password.mixedCase' => 'Usa mayúsculas y minúsculas.',
            'password.numbers' => 'Debe tener al menos un número.',
            'password.symbols' => 'Debe tener un carácter especial.',
        ];
    }
}
