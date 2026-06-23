<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegistroEmpresaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre_empresa' => 'required|string|max:150',
            'nit' => 'required|numeric|digits_between:6,15|unique:empresas,nit|unique:usuarios,numero_documento',
            'representante' => [
                'required',
                'string',
                'max:100',
                'min:10',
                'regex:/^[a-zA-ZÀ-ÿ\s]+$/u',
                function ($attribute, $value, $fail) {
                    $palabras = count(array_filter(explode(' ', trim($value))));
                    if ($palabras < 2) {
                        $fail('El nombre del representante debe incluir nombre y apellido (mínimo 2 palabras).');
                    }
                },
            ],
            'correo' => 'required|email|max:255|unique:empresas,correo_contacto|unique:usuarios,correo',
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
            'consentimiento_datos' => 'accepted',
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
            'accepted' => 'Debes aceptar este campo para continuar.',
            'password.confirmed' => 'Las contraseñas no son iguales.',
            'password.letters' => 'Debe tener al menos una letra.',
            'password.mixedCase' => 'Usa mayúsculas y minúsculas.',
            'password.numbers' => 'Debe tener al menos un número.',
            'password.symbols' => 'Debe tener un carácter especial.',
            'representante.regex' => 'Solo letras y espacios, sin números.',
            'representante.min' => 'Mínimo 10 caracteres.',
        ];
    }
}
