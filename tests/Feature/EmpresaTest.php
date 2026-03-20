<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class EmpresaTest extends TestCase
{
    use RefreshDatabase;

    protected $empresa;
    protected $usuario;

    protected function setUp(): void
    {
        parent::setUp();

        // Crear usuario con rol empresa (3)
        $usrId = DB::table('usuario')->insertGetId([
            'usr_documento' => 123456789,
            'usr_correo'    => 'test_empresa@gmail.com',
            'usr_contrasena'=> Hash::make('password123'),
            'rol_id'        => 3,
            'usr_fecha_creacion' => now(),
        ]);

        $this->usuario = DB::table('usuario')->where('usr_id', $usrId)->first();

        // Crear perfil de empresa
        DB::table('empresa')->insert([
            'usr_id'           => $usrId,
            'emp_nit'          => 900112233,
            'emp_nombre'       => 'Empresa Test SAS',
            'emp_representante'=> 'Representante Test',
            'emp_correo'       => 'test_empresa@gmail.com',
            'emp_contrasena'   => Hash::make('password123'),
            'emp_estado'       => 1,
        ]);

        $this->empresa = DB::table('empresa')->where('usr_id', $usrId)->first();
    }

    #[Test]
    public function empresa_can_view_dashboard()
    {
        $response = $this->withSession([
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
        ];

        $response = $this->withSession([
            'emp_id' => $this->empresa->emp_id,
            'nit'    => $this->empresa->emp_nit,
            'rol'    => 3
        ])->post(route('empresa.proyectos.store'), $projectData);

        $response->assertRedirect(route('empresa.proyectos'));
        $this->assertDatabaseHas('proyecto', [
            'pro_titulo_proyecto' => 'Nuevo Proyecto de Prueba',
            'emp_nit'             => $this->empresa->emp_nit
        ]);
    }

    #[Test]
    public function empresa_can_update_project()
    {
        // Primero creamos un proyecto
        $proId = DB::table('proyecto')->insertGetId([
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

        $response = $this->withSession([
            'emp_id' => $this->empresa->emp_id,
            'nit'    => $this->empresa->emp_nit,
            'rol'    => 3
        ])->put(route('empresa.proyectos.update', $proId), $updateData);

        $response->assertRedirect(route('empresa.proyectos'));
        $this->assertDatabaseHas('proyecto', [
            'pro_id'              => $proId,
            'pro_titulo_proyecto' => 'Proyecto Actualizado'
        ]);
    }

    #[Test]
    public function empresa_can_delete_project()
    {
        $proId = DB::table('proyecto')->insertGetId([
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

        $response = $this->withSession([
            'emp_id' => $this->empresa->emp_id,
            'nit'    => $this->empresa->emp_nit,
            'rol'    => 3
        ])->delete(route('empresa.proyectos.destroy', $proId));

        $response->assertRedirect(route('empresa.proyectos'));
        $this->assertDatabaseMissing('proyecto', ['pro_id' => $proId]);
    }

    #[Test]
    public function empresa_can_update_profile()
    {
        $profileData = [
            'nombre_empresa' => 'Empresa Nombre Nuevo',
            'representante'  => 'Nuevo Representante',
        ];

        $response = $this->withSession([
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
