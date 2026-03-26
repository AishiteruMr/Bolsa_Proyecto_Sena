<?php

namespace Database\Factories;

use App\Models\Proyecto;
use App\Models\Empresa;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProyectoFactory extends Factory
{
    protected $model = Proyecto::class;

    public function definition(): array
    {
        return [
            'emp_nit'                    => fn () => Empresa::factory()->create()->emp_nit,
            'pro_titulo_proyecto'        => fake()->text(100),
            'pro_categoria'              => fake()->randomElement(['Software', 'Hardware', 'Redes', 'IA']),
            'pro_descripcion'            => fake()->text(400),
            'pro_requisitos_especificos' => fake()->text(150),
            'pro_habilidades_requerida'  => fake()->text(150),
            'pro_fecha_publi'            => now()->toDateString(),
            'pro_duracion_estimada'      => fake()->numberBetween(1, 12),
            'pro_estado'                 => 'Activo',
        ];
    }
}
