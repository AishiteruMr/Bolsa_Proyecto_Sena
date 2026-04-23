<?php

namespace App\Services;

use Illuminate\Validation\Rules\Password;

class PasswordValidationService
{
    public static function rules(bool $confirmed = false): array
    {
        $minLength = config('app_config.password.min_length', 8);

        $rules = [
            'nullable',
            'string',
            'min:'.$minLength,
        ];

        if ($confirmed) {
            $rules[] = 'confirmed';
        }

        return $rules;
    }

    public static function rulesWithMessages(): array
    {
        $minLength = config('app_config.password.min_length', 8);

        return [
            'rules' => self::rules(true),
            'messages' => [
                'password.min' => "La contraseña debe tener al menos {$minLength} caracteres.",
                'password.confirmed' => 'Las contraseñas no coinciden.',
            ],
        ];
    }

    public static function laravelRule(bool $confirmed = false): object
    {
        $rule = Password::min(config('app_config.password.min_length', 8))
            ->letters()
            ->mixedCase()
            ->numbers()
            ->symbols();

        if ($confirmed) {
            $rule = $rule->mixedCase()->numbers()->symbols();
        }

        return $rule;
    }
}