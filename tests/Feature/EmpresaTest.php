<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Empresa;
use App\Models\Proyecto;
use Illuminate\Support\Facades\Hash;

class EmpresaTest extends TestCase
{
    use RefreshDatabase;

    protected $usuario;
    protected $empresa;

    protected function setUp(): void
    {
        parent::setUp();

        // Crear usuario con rol empresa (3)
        $this->usuario = User::create([
            'usr_documento' => 123456789,
            'usr_correo'    => 'test_empresa@gmail.com',
            'usr_contrasena' => Hash::make('password123'),
            'rol_id'        => 3,
            'usr_fecha_creacion' => now(),
        ]);

        // Crear perfil de empresa
        $this->empresa = Empresa::create([
            'usr_id'           => $this->usuario->usr_id,
            'emp_nit'          => 900112233,
            'emp_nombre'       => 'Empresa Test SAS',
            'emp_representante'=> 'Representante Test',
            'emp_correo'       => 'test_empresa@gmail.com',
            'emp_contrasena'   => Hash::make('password123'),
            'emp_estado'       => 1,
        ]);
    }

    #[Test]
    public function empresa_can_view_dashboard()
    {
        $response = $this->actingAs($this->usuario)->withSession([
            'emp_id' => $this->empresa->emp_id,
            'nit'    => $this->empresa->emp_nit,
            'rol'    => 3,
            'nombre' => $this->empresa->emp_nombre
        ])->get(route('empresa.dashboard'));

        $response->assertStatus(200);
        $response->assertViewIs('empresa.dashboard');
    }

    #[Test]
    public function empresa_can_create_project()
    {
        $projectData = [
            'titulo'      => 'Nuevo Proyecto de Prueba',
            'categoria'   => 'Desarrollo Web',
            'descripcion' => 'Esta es una descripción detallada del proyecto de prueba.',
            'requisitos'  => 'Conocimientos en PHP y Laravel',
            'habilidades' => 'Trabajo en equipo, proactividad',
            'fecha_publi' => now()->format('Y-m-d'),
            'latitud'     => '4.5709',
            'longitud'    => '-74.2973',
        ];

        $response = $this->actingAs($this->usuario)->withSession([
            'emp_id' => $this->empresa->emp_id,
            'nit'    => $this->empresa->emp_nit,
            'rol'    => 3
        ])->post(route('empresa.proyectos.store'), $projectData);

        $response->assertRedirect(route('empresa.proyectos'));
        $this->assertDatabaseHas('proyecto', [
            'pro_titulo_proyecto' => 'Nuevo Proyecto de Prueba',
            'emp_nit'             => $this->empresa->emp_nit,
            'pro_latitud'         => '4.5709'
        ]);
    }

    #[Test]
    public function empresa_can_update_project()
    {
        $proyecto = Proyecto::create([
            'emp_nit'                    => $this->empresa->emp_nit,
            'pro_titulo_proyecto'        => 'Proyecto Original',
            'pro_categoria'              => 'Categoría',
            'pro_descripcion'            => 'Descripción',
            'pro_requisitos_especificos' => 'Requisitos',
            'pro_habilidades_requerida'  => 'Habilidades',
            'pro_fecha_publi'            => now()->format('Y-m-d'),
            'pro_duracion_estimada'      => 180,
            'pro_estado'                 => 'Activo',
        ]);

        $updateData = [
            'titulo'      => 'Proyecto Actualizado',
            'categoria'   => 'Nueva Categoría',
            'descripcion' => 'Nueva Descripción',
            'requisitos'  => 'Nuevos Requisitos',
            'habilidades' => 'Nuevas Habilidades',
            'fecha_publi' => now()->format('Y-m-d'),
        ];

        $response = $this->actingAs($this->usuario)->withSession([
            'emp_id' => $this->empresa->emp_id,
            'nit'    => $this->empresa->emp_nit,
            'rol'    => 3
        ])->put(route('empresa.proyectos.update', $proyecto->pro_id), $updateData);

        $response->assertRedirect(route('empresa.proyectos'));
        $this->assertDatabaseHas('proyecto', [
            'pro_id'              => $proyecto->pro_id,
            'pro_titulo_proyecto' => 'Proyecto Actualizado'
        ]);
    }

    #[Test]
    public function empresa_can_delete_project()
    {
        $proyecto = Proyecto::create([
            'emp_nit'                    => $this->empresa->emp_nit,
            'pro_titulo_proyecto'        => 'Proyecto a Eliminar',
            'pro_categoria'              => 'Categoría',
            'pro_descripcion'            => 'Descripción',
            'pro_requisitos_especificos' => 'Requisitos',
            'pro_habilidades_requerida'  => 'Habilidades',
            'pro_fecha_publi'            => now()->format('Y-m-d'),
            'pro_duracion_estimada'      => 180,
            'pro_estado'                 => 'Activo',
        ]);

        $response = $this->actingAs($this->usuario)->withSession([
            'emp_id' => $this->empresa->emp_id,
            'nit'    => $this->empresa->emp_nit,
            'rol'    => 3
        ])->delete(route('empresa.proyectos.destroy', $proyecto->pro_id));

        $response->assertRedirect(route('empresa.proyectos'));
        $this->assertDatabaseMissing('proyecto', ['pro_id' => $proyecto->pro_id]);
    }

    #[Test]
    public function empresa_can_update_profile()
    {
        $profileData = [
            'nombre_empresa' => 'Empresa Nombre Nuevo',
            'representante'  => 'Nuevo Representante',
        ];

        $response = $this->actingAs($this->usuario)->withSession([
            'emp_id' => $this->empresa->emp_id,
            'nit'    => $this->empresa->emp_nit,
            'rol'    => 3
        ])->put(route('empresa.perfil.update'), $profileData);

        $response->assertStatus(302);
        $this->assertDatabaseHas('empresa', [
            'emp_id'     => $this->empresa->emp_id,
            'emp_nombre' => 'Empresa Nombre Nuevo'
        ]);
    }
}
