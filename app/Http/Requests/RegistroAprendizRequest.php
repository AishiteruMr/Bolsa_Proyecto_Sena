<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistroAprendizRequest extends FormRequest
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
            'nombre'    => 'required|string|max:50|regex:/^[a-zA-Z\s]+$/',
            'apellido'  => 'required|string|max:50|regex:/^[a-zA-Z\s]+$/',
            'documento' => 'required|numeric|digits_between:6,12|unique:usuario,usr_documento',
            'programa'  => 'required|string|max:100',
            'correo'    => 'required|email|max:255|unique:usuario,usr_correo',
            'password'  => 'required|string|min:8|max:100|confirmed',
            'terminos'  => 'accepted',
        ];
    }

    public function messages(): array
    {
        return [
            'required'           => 'El campo :attribute es obligatorio.',
            'email'              => 'Ingresa un correo electrónico válido.',
            'unique'             => 'Este :attribute ya está registrado.',
            'min'                => 'El campo :attribute debe tener al menos :min caracteres.',
            'max'                => 'El campo :attribute no puede exceder :max caracteres.',
            'numeric'            => 'El campo :attribute debe ser numérico.',
            'digits_between'     => 'El documento debe tener entre :min y :max dígitos.',
            'accepted'           => 'Debes aceptar los términos y condiciones.',
            'regex'              => 'El campo :attribute solo puede contener letras.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ];
    }
}
