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
            'usr_id'       => fn() => User::factory()->create(['rol_id' => 1])->usr_id,
            'apr_nombre'   => fake()->firstName(),
            'apr_apellido' => fake()->lastName(),
            'apr_programa' => 'ADSO',
            'apr_estado'   => 1,
        ];
    }
}
