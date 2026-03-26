<?php

namespace Database\Factories;

use App\Models\Instructor;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class InstructorFactory extends Factory
{
    protected $model = Instructor::class;

    public function definition(): array
    {
        return [
            'usr_id'           => fn() => User::factory()->create(['rol_id' => 2])->usr_id,
            'ins_nombre'       => fake()->firstName(),
            'ins_apellido'     => fake()->lastName(),
            'ins_especialidad' => fake()->word(),
            'ins_estado'       => 1,
            'ins_estado_dis'   => 'Disponible',
        ];
    }
}
