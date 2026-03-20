<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class InstructorTest extends TestCase
{
    use RefreshDatabase;

    protected $instructor;
    protected $usuario;
    protected $empresa;
    protected $proyecto;

    protected function setUp(): void
    {
        parent::setUp();

        // 1. Crear usuario con rol instructor (2)
        $usrId = DB::table('usuario')->insertGetId([
            'usr_documento' => 555666777,
            'usr_correo'    => 'test_instructor@gmail.com',
            'usr_contrasena'=> Hash::make('password123'),
            'rol_id'        => 2,
            'usr_fecha_creacion' => now(),
        ]);

        $this->usuario = DB::table('usuario')->where('usr_id', $usrId)->first();

        // 2. Crear perfil de instructor
        DB::table('instructor')->insert([
            'usr_id'           => $usrId,
            'ins_nombre'       => 'Instructor',
            'ins_apellido'     => 'Test',
            'ins_especialidad' => 'Software',
            'ins_estado'       => 1,
        ]);

        $this->instructor = DB::table('instructor')->where('usr_id', $usrId)->first();

        // 3. Crear empresa
        $empUsrId = DB::table('usuario')->insertGetId([
            'usr_documento' => 111000111,
            'usr_correo'    => 'empresa_inst@gmail.com',
            'usr_contrasena'=> Hash::make('password123'),
            'rol_id'        => 3,
            'usr_fecha_creacion' => now(),
        ]);

        DB::table('empresa')->insert([
            'usr_id'           => $empUsrId,
            'emp_nit'          => 123456781,
            'emp_nombre'       => 'Empresa Inst',
            'emp_representante'=> 'Rep',
            'emp_correo'       => 'empresa_inst@gmail.com',
            'emp_contrasena'   => Hash::make('password123'),
        ]);

        // 4. Crear un proyecto ASIGNADO al instructor
        $proId = DB::table('proyecto')->insertGetId([
            'emp_nit'                    => 123456781,
            'pro_titulo_proyecto'        => 'Proyecto Instructor',
            'pro_categoria'              => 'Web',
            'pro_descripcion'            => 'Desc',
            'pro_requisitos_especificos' => 'Req',
            'pro_habilidades_requerida'  => 'Hab',
            'pro_fecha_publi'            => now()->format('Y-m-d'),
            'pro_duracion_estimada'      => 180,
            'pro_estado'                 => 'Activo',
            'ins_usr_documento'          => 555666777,
        ]);

        $this->proyecto = DB::table('proyecto')->where('pro_id', $proId)->first();
    }

    /** @test */
    public function instructor_can_view_dashboard()
    {
        $response = $this->withSession([
            'usr_id'    => $this->usuario->usr_id,
            'documento' => $this->usuario->usr_documento,
            'rol'       => 2,
            'nombre'    => 'Instructor'
        ])->get(route('instructor.dashboard'));

        $response->assertStatus(200);
        $response->assertViewIs('instructor.dashboard');
    }

    /** @test */
    public function instructor_can_manage_stages()
    {
        $session = [
            'usr_id'    => $this->usuario->usr_id,
            'documento' => $this->usuario->usr_documento,
            'rol'       => 2
        ];

        // 1. Crear etapa
        $stageData = [
            'nombre'      => 'Nueva Etapa',
            'descripcion' => 'Descripción de la etapa',
            'orden'       => 1
        ];

        $response = $this->withSession($session)->post(route('instructor.etapas.crear', $this->proyecto->pro_id), $stageData);
        $response->assertStatus(302);
        $this->assertDatabaseHas('etapa', ['eta_nombre' => 'Nueva Etapa', 'eta_pro_id' => $this->proyecto->pro_id]);

        $etaId = DB::table('etapa')->where('eta_nombre', 'Nueva Etapa')->value('eta_id');

        // 2. Editar etapa
        $updateData = [
            'nombre'      => 'Etapa Actualizada',
            'descripcion' => 'Nueva desc',
            'orden'       => 2
        ];
        $response = $this->withSession($session)->put(route('instructor.etapas.editar', $etaId), $updateData);
        $response->assertStatus(302);
        $this->assertDatabaseHas('etapa', ['eta_id' => $etaId, 'eta_nombre' => 'Etapa Actualizada']);

        // 3. Eliminar etapa
        $response = $this->withSession($session)->delete(route('instructor.etapas.eliminar', $etaId));
        $response->assertStatus(302);
        $this->assertDatabaseMissing('etapa', ['eta_id' => $etaId]);
    }

    /** @test */
    public function instructor_can_grade_evidence()
    {
        // 1. Crear etapa
        $etaId = DB::table('etapa')->insertGetId([
            'eta_pro_id' => $this->proyecto->pro_id,
            'eta_orden'  => 1,
            'eta_nombre' => 'Etapa 1',
            'eta_descripcion' => 'Desc'
        ]);

        // 2. Crear aprendiz y evidencia
        $aprUsrId = DB::table('usuario')->insertGetId([
            'usr_documento' => 222333444,
            'usr_correo'    => 'apr_test@gmail.com',
            'usr_contrasena'=> Hash::make('password123'),
            'rol_id'        => 1,
            'usr_fecha_creacion' => now(),
        ]);
        $aprId = DB::table('aprendiz')->insertGetId([
            'usr_id' => $aprUsrId,
            'apr_nombre' => 'A', 'apr_apellido' => 'B', 'apr_programa' => 'P'
        ]);

        $evidId = DB::table('evidencia')->insertGetId([
            'evid_apr_id' => $aprId,
            'evid_eta_id' => $etaId,
            'evid_pro_id' => $this->proyecto->pro_id,
            'evid_archivo' => 'path/to/file.pdf',
            'evid_fecha' => now(),
            'evid_estado' => 'Pendience'
        ]);

        $gradeData = [
            'estado' => 'Aprobada',
            'comentario' => 'Buen trabajo'
        ];

        $response = $this->withSession([
            'usr_id'    => $this->usuario->usr_id,
            'documento' => $this->usuario->usr_documento,
            'rol'       => 2
        ])->put(route('instructor.evidencias.calificar', $evidId), $gradeData);

        $response->assertStatus(302);
        $this->assertDatabaseHas('evidencia', [
            'evid_id' => $evidId,
            'evid_estado' => 'Aprobada',
            'evid_comentario' => 'Buen trabajo'
        ]);
    }
}
