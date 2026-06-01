<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class AprendizTest extends TestCase
{
    use RefreshDatabase;

    protected $aprendiz;
    protected $usuario;

    protected function setUp(): void
    {
        parent::setUp();
        $this->setUpRoles();

        $usrId = DB::table('usuarios')->insertGetId([
            'numero_documento' => 111222333,
            'correo'           => 'test_aprendiz@gmail.com',
            'contrasena'       => Hash::make('password123'),
            'rol_id'           => 1,
            'created_at'       => now(),
            'updated_at'       => now(),
        ]);

        $this->usuario = DB::table('usuarios')->where('id', $usrId)->first();

        $aprId = DB::table('aprendices')->insertGetId([
            'usuario_id'         => $usrId,
            'nombres'            => 'Aprendiz',
            'apellidos'          => 'Test',
            'programa_formacion' => 'ADSO',
            'activo'             => true,
            'created_at'         => now(),
            'updated_at'         => now(),
        ]);

        $this->aprendiz = DB::table('aprendices')->where('id', $aprId)->first();

        $empUsrId = DB::table('usuarios')->insertGetId([
            'numero_documento' => 999888777,
            'correo'           => 'empresa_test@gmail.com',
            'contrasena'       => Hash::make('password123'),
            'rol_id'           => 3,
            'created_at'       => now(),
            'updated_at'       => now(),
        ]);

        DB::table('empresas')->insert([
            'usuario_id'      => $empUsrId,
            'nit'             => 123456780,
            'nombre'          => 'Empresa Proyectos',
            'representante'   => 'Representante',
            'correo_contacto' => 'empresa_test@gmail.com',
            'activo'          => true,
            'created_at'      => now(),
            'updated_at'      => now(),
        ]);
    }

    #[Test]
    public function aprendiz_can_view_dashboard()
    {
        $response = $this->withSession([
            'usr_id' => $this->usuario->id,
            'rol'    => 1,
            'nombre' => $this->aprendiz->nombres,
            'apr_id' => $this->aprendiz->id,
        ])->get(route('aprendiz.dashboard'));

        $response->assertStatus(200);
        $response->assertViewIs('aprendiz.dashboard');
    }

    #[Test]
    public function aprendiz_can_apply_to_project()
    {
        $proId = DB::table('proyectos')->insertGetId([
            'empresa_nit'           => 123456780,
            'titulo'                => 'Proyecto para Postular',
            'categoria'             => 'Web',
            'descripcion'           => 'Desc',
            'requisitos_especificos'=> 'Req',
            'habilidades_requeridas'=> 'Hab',
            'fecha_publicacion'     => now()->format('Y-m-d'),
            'duracion_estimada_dias'=> 180,
            'estado'                => 'aprobado',
            'created_at'            => now(),
            'updated_at'            => now(),
        ]);

        $response = $this->withSession([
            'usr_id' => $this->usuario->id,
            'rol'    => 1,
            'apr_id' => $this->aprendiz->id,
        ])->post(route('aprendiz.postular', $proId));

        $response->assertStatus(302);
        $this->assertDatabaseHas('postulaciones', [
            'aprendiz_id' => $this->aprendiz->id,
            'proyecto_id' => $proId,
            'estado'      => 'pendiente'
        ]);
    }

    #[Test]
    public function aprendiz_can_send_evidence_if_approved()
    {
        $proId = DB::table('proyectos')->insertGetId([
            'empresa_nit'           => 123456780,
            'titulo'                => 'Proyecto Evidencia',
            'categoria'             => 'Web',
            'descripcion'           => 'Desc',
            'requisitos_especificos'=> 'Req',
            'habilidades_requeridas'=> 'Hab',
            'fecha_publicacion'     => now()->format('Y-m-d'),
            'duracion_estimada_dias'=> 180,
            'estado'                => 'aprobado',
            'created_at'            => now(),
            'updated_at'            => now(),
        ]);

        DB::table('postulaciones')->insert([
            'aprendiz_id'      => $this->aprendiz->id,
            'proyecto_id'      => $proId,
            'estado'           => 'aceptada',
            'fecha_postulacion'=> now(),
            'created_at'       => now(),
            'updated_at'       => now(),
        ]);

        $etaId = DB::table('etapas')->insertGetId([
            'proyecto_id' => $proId,
            'orden'       => 1,
            'nombre'      => 'Etapa 1',
            'descripcion' => 'Desc etapa',
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        $evidenceData = [
            'descripcion' => 'Mi primera evidencia',
            'archivo'     => UploadedFile::fake()->create('evidencia.pdf', 500),
        ];

        $response = $this->withSession([
            'usr_id' => $this->usuario->id,
            'rol'    => 1,
            'apr_id' => $this->aprendiz->id,
        ])->post(route('aprendiz.evidencia.enviar', ['proId' => $proId, 'etaId' => $etaId]), $evidenceData);

        $response->assertStatus(302);
        $this->assertDatabaseHas('evidencias', [
            'aprendiz_id' => $this->aprendiz->id,
            'etapa_id'    => $etaId,
            'proyecto_id' => $proId,
            'estado'      => 'pendiente'
        ]);
    }

    #[Test]
    public function aprendiz_can_update_profile()
    {
        $profileData = [
            'nombre'   => 'Aprendiz Nuevo',
            'apellido' => 'Apellido Nuevo',
            'programa' => 'Nuevo Programa',
        ];

        $response = $this->withSession([
            'usr_id' => $this->usuario->id,
            'rol'    => 1,
            'apr_id' => $this->aprendiz->id,
        ])->put(route('aprendiz.perfil.update'), $profileData);

        $response->assertStatus(302);
        $this->assertDatabaseHas('aprendices', [
            'id'       => $this->aprendiz->id,
            'nombres'  => 'Aprendiz Nuevo'
        ]);
    }

    #[Test]
    public function aprendiz_cannot_send_evidence_if_already_evaluated()
    {
        $proId = DB::table('proyectos')->insertGetId([
            'empresa_nit'           => 123456780,
            'titulo'                => 'Proyecto Evidencia Cerrada',
            'categoria'             => 'Web',
            'descripcion'           => 'Desc',
            'requisitos_especificos'=> 'Req',
            'habilidades_requeridas'=> 'Hab',
            'fecha_publicacion'     => now()->format('Y-m-d'),
            'duracion_estimada_dias'=> 180,
            'estado'                => 'aprobado',
            'created_at'            => now(),
            'updated_at'            => now(),
        ]);

        DB::table('postulaciones')->insert([
            'aprendiz_id'      => $this->aprendiz->id,
            'proyecto_id'      => $proId,
            'estado'           => 'aceptada',
            'fecha_postulacion'=> now(),
            'created_at'       => now(),
            'updated_at'       => now(),
        ]);

        $etaId = DB::table('etapas')->insertGetId([
            'proyecto_id' => $proId,
            'orden'       => 1,
            'nombre'      => 'Etapa 1',
            'descripcion' => 'Desc etapa',
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        DB::table('evidencias')->insert([
            'aprendiz_id'  => $this->aprendiz->id,
            'etapa_id'     => $etaId,
            'proyecto_id'  => $proId,
            'ruta_archivo' => 'path/to/file.pdf',
            'fecha_envio'  => now(),
            'estado'       => 'aceptada',
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);

        $evidenceData = [
            'descripcion' => 'Intento de reenvío',
            'archivo'     => UploadedFile::fake()->create('evidencia.pdf', 500),
        ];

        $response = $this->withSession([
            'usr_id' => $this->usuario->id,
            'rol'    => 1,
            'apr_id' => $this->aprendiz->id,
        ])->post(route('aprendiz.evidencia.enviar', ['proId' => $proId, 'etaId' => $etaId]), $evidenceData);

        $response->assertStatus(302);
        $response->assertSessionHas('error');
    }

    #[Test]
    public function aprendiz_can_view_historial()
    {
        $response = $this->withSession([
            'usr_id' => $this->usuario->id,
            'rol'    => 1,
            'nombre' => $this->aprendiz->nombres,
            'apr_id' => $this->aprendiz->id,
        ])->get(route('aprendiz.historial'));

        $response->assertStatus(200);
        $response->assertViewIs('aprendiz.historial');
    }

    #[Test]
    public function aprendiz_can_view_project_detail()
    {
        $proId = DB::table('proyectos')->insertGetId([
            'empresa_nit'           => 123456780,
            'titulo'                => 'Proyecto Detalle',
            'categoria'             => 'Web',
            'descripcion'           => 'Descripcion detallada',
            'requisitos_especificos'=> 'Req',
            'habilidades_requeridas'=> 'Hab',
            'fecha_publicacion'     => now()->format('Y-m-d'),
            'duracion_estimada_dias'=> 180,
            'estado'                => 'aprobado',
            'created_at'            => now(),
            'updated_at'            => now(),
        ]);

        $response = $this->withSession([
            'usr_id' => $this->usuario->id,
            'rol'    => 1,
            'apr_id' => $this->aprendiz->id,
        ])->get(route('aprendiz.proyecto.detalle', $proId));

        $response->assertStatus(200);
    }
}
