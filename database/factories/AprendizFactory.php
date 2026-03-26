<?php

namespace Database\Factories;

use App\Models\Aprendiz;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AprendizFactory extends Factory
{
    protected $model = Aprendiz::class;

    public function definition(): array
    {
        return [
            'usr_id'       => User::factory(['rol_id' => 1]),
            'apr_nombre'   => fake()->firstName(),
            'apr_apellido' => fake()->lastName(),
            'apr_programa' => 'ADSO',
            'apr_estado'   => 1,
        ];
    }
}
