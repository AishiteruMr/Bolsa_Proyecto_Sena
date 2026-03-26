<?php

namespace Database\Factories;

use App\Models\Empresa;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class EmpresaFactory extends Factory
{
    protected $model = Empresa::class;

    public function definition(): array
    {
        return [
            'usr_id'           => fn() => User::factory()->create(['rol_id' => 3])->usr_id,
            'emp_nit'          => fake()->unique()->numberBetween(100000000, 999999999),
            'emp_nombre'       => fake()->company(),
            'emp_representante' => fake()->name(),
            'emp_correo'       => fake()->unique()->companyEmail(),
            'emp_contrasena'   => Hash::make('password123'),
            'emp_estado'       => 1,
        ];
    }
}
