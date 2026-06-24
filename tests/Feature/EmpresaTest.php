<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EmpresaTest extends TestCase
{
    use RefreshDatabase;

    protected $empresa;
    protected $usuario;

    protected function setUp(): void
    {
        parent::setUp();
        $this->setUpRoles();

        $usrId = DB::table('usuarios')->insertGetId([
            'numero_documento' => 123456789,
            'correo'           => 'test_empresa@gmail.com',
            'contrasena'       => Hash::make('password123'),
            'rol_id'           => 3,
            'created_at'       => now(),
            'updated_at'       => now(),
        ]);

        $this->usuario = DB::table('usuarios')->where('id', $usrId)->first();

        DB::table('empresas')->insert([
            'usuario_id'      => $usrId,
            'nit'             => 900112233,
            'nombre'          => 'Empresa Test SAS',
            'representante'   => 'Representante Test',
            'correo_contacto' => 'test_empresa@gmail.com',
            'activo'          => true,
            'created_at'      => now(),
            'updated_at'      => now(),
        ]);

        $this->empresa = DB::table('empresas')->where('usuario_id', $usrId)->first();
    }

    private function baseSession(): array
    {
        return [
            'usr_id'  => $this->usuario->id,
            'correo'  => $this->usuario->correo,
            'documento' => $this->usuario->numero_documento,
            'emp_id'  => $this->empresa->id,
            'nit'     => $this->empresa->nit,
            'rol'     => 3,
            'nombre'  => $this->empresa->nombre,
        ];
    }

    #[Test]
    public function empresa_can_view_dashboard()
    {
        $response = $this->withSession($this->baseSession())
            ->get(route('empresa.dashboard'));

        $response->assertStatus(200);
        $response->assertViewIs('empresa.dashboard');
    }

    #[Test]
    public function empresa_can_create_project()
    {
        $projectData = [
            'titulo'      => 'Nuevo Proyecto de Prueba Web',
            'categoria'   => 'Sistemas y Desarrollo de Software',
            'descripcion' => 'Esta es una descripción detallada del proyecto de prueba que debe tener al menos ochenta caracteres para cumplir la validación del formulario.',
            'requisitos'  => 'Conocimientos en PHP y Laravel, manejo de bases de datos MySQL',
            'habilidades' => 'Trabajo en equipo, proactividad, comunicación',
            'fecha_publi' => now()->format('Y-m-d'),
            'oferta'      => 'pasantias',
        ];

        $response = $this->withSession($this->baseSession())
            ->post(route('empresa.proyectos.store'), $projectData);

        $response->assertRedirect(route('empresa.proyectos'));
        $this->assertDatabaseHas('proyectos', [
            'titulo'    => 'Nuevo Proyecto de Prueba Web',
            'empresa_nit' => $this->empresa->nit
        ]);
    }

    #[Test]
    public function empresa_can_update_project()
    {
        $proId = DB::table('proyectos')->insertGetId([
            'empresa_nit'           => $this->empresa->nit,
            'titulo'                => 'Proyecto Original',
            'categoria'             => 'Categoría',
            'descripcion'           => 'Descripción',
            'requisitos_especificos'=> 'Requisitos',
            'habilidades_requeridas'=> 'Habilidades',
            'fecha_publicacion'     => now()->format('Y-m-d'),
            'duracion_estimada_dias'=> 180,
            'estado'                => 'pendiente',
            'created_at'            => now(),
            'updated_at'            => now(),
        ]);

        $updateData = [
            'titulo'      => 'Proyecto Actualizado con Nuevos',
            'categoria'   => 'Sistemas y Desarrollo de Software',
            'descripcion' => 'Nueva descripción del proyecto actualizado que debe tener al menos ochenta caracteres para pasar la validación correctamente.',
            'requisitos'  => 'Nuevos requisitos actualizados para el proyecto',
            'habilidades' => 'Nuevas habilidades requeridas para el proyecto',
            'fecha_publi' => now()->format('Y-m-d'),
            'oferta'      => 'contrato_aprendizaje',
        ];

        $response = $this->withSession($this->baseSession())
            ->put(route('empresa.proyectos.update', $proId), $updateData);

        $response->assertRedirect(route('empresa.proyectos'));
        $this->assertDatabaseHas('proyectos', [
            'id'     => $proId,
            'titulo' => 'Proyecto Actualizado con Nuevos'
        ]);
    }

    #[Test]
    public function empresa_can_delete_project()
    {
        $proId = DB::table('proyectos')->insertGetId([
            'empresa_nit'           => $this->empresa->nit,
            'titulo'                => 'Proyecto a Eliminar',
            'categoria'             => 'Categoría',
            'descripcion'           => 'Descripción',
            'requisitos_especificos'=> 'Requisitos',
            'habilidades_requeridas'=> 'Habilidades',
            'fecha_publicacion'     => now()->format('Y-m-d'),
            'duracion_estimada_dias'=> 180,
            'estado'                => 'pendiente',
            'created_at'            => now(),
            'updated_at'            => now(),
        ]);

        $response = $this->withSession($this->baseSession())
            ->delete(route('empresa.proyectos.destroy', $proId));

        $response->assertRedirect(route('empresa.proyectos'));
        $this->assertDatabaseHas('proyectos', [
            'id'     => $proId,
            'estado' => 'cerrado'
        ]);
    }

    #[Test]
    public function empresa_can_update_profile()
    {
        $profileData = [
            'nombre_empresa' => 'Empresa Nombre Nuevo',
            'representante'  => 'Nuevo Representante',
        ];

        $response = $this->withSession($this->baseSession())
            ->put(route('empresa.perfil.update'), $profileData);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('empresas', [
            'id'           => $this->empresa->id,
            'nombre'       => 'Empresa Nombre Nuevo'
        ]);
    }

    #[Test]
    public function empresa_can_view_project_detail_with_approved_evidence()
    {
        $proId = DB::table('proyectos')->insertGetId([
            'empresa_nit'           => $this->empresa->nit,
            'titulo'                => 'Proyecto Detalle Empresa',
            'categoria'             => 'Web',
            'descripcion'           => 'Descripcion del proyecto',
            'requisitos_especificos'=> 'Req',
            'habilidades_requeridas'=> 'Hab',
            'fecha_publicacion'     => now()->format('Y-m-d'),
            'duracion_estimada_dias'=> 180,
            'estado'                => 'en_progreso',
            'created_at'            => now(),
            'updated_at'            => now(),
        ]);

        $etaId = DB::table('etapas')->insertGetId([
            'proyecto_id' => $proId,
            'orden'       => 1,
            'nombre'      => 'Etapa 1',
            'descripcion' => 'Desc',
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        $aprUsrId = DB::table('usuarios')->insertGetId([
            'numero_documento' => 777888999,
            'correo'           => 'apr_empresa_test@gmail.com',
            'contrasena'       => Hash::make('password123'),
            'rol_id'           => 1,
            'created_at'       => now(),
            'updated_at'       => now(),
        ]);
        $aprId = DB::table('aprendices')->insertGetId([
            'usuario_id'         => $aprUsrId,
            'nombres'            => 'Aprendiz',
            'apellidos'          => 'Empresa',
            'programa_formacion' => 'ADSO',
            'activo'             => true,
            'created_at'         => now(),
            'updated_at'         => now(),
        ]);

        DB::table('evidencias')->insert([
            'aprendiz_id'  => $aprId,
            'etapa_id'     => $etaId,
            'proyecto_id'  => $proId,
            'ruta_archivo' => 'path/to/file.pdf',
            'fecha_envio'  => now(),
            'estado'       => 'aceptada',
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);

        $response = $this->withSession($this->baseSession())
            ->get(route('empresa.proyectos.detalle', $proId));

        $response->assertStatus(200);
        $response->assertSee('Evidencias Aprobadas');
    }
}
