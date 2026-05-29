<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        return [
            'numero_documento' => fake()->unique()->numerify('##########'),
            'correo'           => fake()->unique()->safeEmail(),
            'contrasena'       => static::$password ??= Hash::make('password'),
            'rol_id'           => 1,
            'email_verified_at'=> now(),
            'remember_token'   => Str::random(10),
        ];
    }

    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
