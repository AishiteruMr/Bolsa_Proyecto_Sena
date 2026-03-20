<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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
    protected $empresa;
    protected $proyecto;

    protected function setUp(): void
    {
        parent::setUp();

        // 1. Crear usuario con rol aprendiz (1)
        $usrId = DB::table('usuario')->insertGetId([
            'usr_documento' => 111222333,
            'usr_correo'    => 'test_aprendiz@gmail.com',
            'usr_contrasena'=> Hash::make('password123'),
            'rol_id'        => 1,
            'usr_fecha_creacion' => now(),
        ]);

        $this->usuario = DB::table('usuario')->where('usr_id', $usrId)->first();

        // 2. Crear perfil de aprendiz
        $aprId = DB::table('aprendiz')->insertGetId([
            'usr_id'       => $usrId,
            'apr_nombre'   => 'Aprendiz',
            'apr_apellido' => 'Test',
            'apr_programa' => 'ADSO',
            'apr_estado'   => 1,
        ]);

        $this->aprendiz = DB::table('aprendiz')->where('apr_id', $aprId)->first();

        // 3. Crear empresa para tener proyectos
        $empUsrId = DB::table('usuario')->insertGetId([
            'usr_documento' => 999888777,
            'usr_correo'    => 'empresa_test@gmail.com',
            'usr_contrasena'=> Hash::make('password123'),
            'rol_id'        => 3,
            'usr_fecha_creacion' => now(),
        ]);

        DB::table('empresa')->insert([
            'usr_id'           => $empUsrId,
            'emp_nit'          => 123456780,
            'emp_nombre'       => 'Empresa Proyectos',
            'emp_representante'=> 'Representante',
            'emp_correo'       => 'empresa_test@gmail.com',
            'emp_contrasena'   => Hash::make('password123'),
        ]);

        $this->empresa = DB::table('empresa')->where('usr_id', $empUsrId)->first();

        // 4. Crear un proyecto activo
        $proId = DB::table('proyecto')->insertGetId([
            'emp_nit'                    => 123456780,
            'pro_titulo_proyecto'        => 'Proyecto para Postular',
            'pro_categoria'              => 'Web',
            'pro_descripcion'            => 'Desc',
            'pro_requisitos_especificos' => 'Req',
            'pro_habilidades_requerida'  => 'Hab',
            'pro_fecha_publi'            => now()->format('Y-m-d'),
            'pro_duracion_estimada'      => 180,
            'pro_estado'                 => 'Activo',
        ]);

        $this->proyecto = DB::table('proyecto')->where('pro_id', $proId)->first();
    }

    /** @test */
    public function aprendiz_can_view_dashboard()
    {
        $response = $this->withSession([
            'usr_id' => $this->usuario->usr_id,
            'rol'    => 1,
            'nombre' => $this->aprendiz->apr_nombre
        ])->get(route('aprendiz.dashboard'));

        $response->assertStatus(200);
        $response->assertViewIs('aprendiz.dashboard');
    }

    /** @test */
    public function aprendiz_can_apply_to_project()
    {
        $response = $this->withSession([
            'usr_id' => $this->usuario->usr_id,
            'rol'    => 1
        ])->post(route('aprendiz.postular', $this->proyecto->pro_id));

        $response->assertStatus(302);
        $this->assertDatabaseHas('postulacion', [
            'apr_id' => $this->aprendiz->apr_id,
            'pro_id' => $this->proyecto->pro_id,
            'pos_estado' => 'Pendiente'
        ]);
    }

    /** @test */
    public function aprendiz_can_send_evidence_if_approved()
    {
        // 1. Aprobar postulación
        DB::table('postulacion')->insert([
            'apr_id' => $this->aprendiz->apr_id,
            'pro_id' => $this->proyecto->pro_id,
            'pos_estado' => 'Aprobada',
            'pos_fecha' => now()
        ]);

        // 2. Crear una etapa para el proyecto
        $etaId = DB::table('etapa')->insertGetId([
            'eta_pro_id' => $this->proyecto->pro_id,
            'eta_orden'  => 1,
            'eta_nombre' => 'Etapa 1',
            'eta_descripcion' => 'Desc etapa'
        ]);

        $evidenceData = [
            'descripcion' => 'Mi primera evidencia',
            'archivo'     => UploadedFile::fake()->create('evidencia.pdf', 500),
        ];

        $response = $this->withSession([
            'usr_id' => $this->usuario->usr_id,
            'rol'    => 1
        ])->post(route('aprendiz.evidencia.enviar', ['proId' => $this->proyecto->pro_id, 'etaId' => $etaId]), $evidenceData);

        $response->assertStatus(302);
        $this->assertDatabaseHas('evidencia', [
            'evid_apr_id' => $this->aprendiz->apr_id,
            'evid_eta_id' => $etaId,
            'evid_pro_id' => $this->proyecto->pro_id,
            'evid_estado' => 'Pendiente'
        ]);
    }

    /** @test */
    public function aprendiz_can_update_profile()
    {
        $profileData = [
            'nombre'   => 'Aprendiz Nuevo',
            'apellido' => 'Apellido Nuevo',
            'programa' => 'Nuevo Programa',
        ];

        $response = $this->withSession([
            'usr_id' => $this->usuario->usr_id,
            'rol'    => 1
        ])->put(route('aprendiz.perfil.update'), $profileData);

        $response->assertStatus(302);
        $this->assertDatabaseHas('aprendiz', [
            'apr_id'     => $this->aprendiz->apr_id,
            'apr_nombre' => 'Aprendiz Nuevo'
        ]);
    }
}
