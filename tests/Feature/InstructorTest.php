<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
        $this->setUpRoles();

        $usrId = DB::table('usuarios')->insertGetId([
            'numero_documento' => 555666777,
            'correo'           => 'test_instructor@gmail.com',
            'contrasena'       => Hash::make('password123'),
            'rol_id'           => 2,
            'created_at'       => now(),
            'updated_at'       => now(),
        ]);

        $this->usuario = DB::table('usuarios')->where('id', $usrId)->first();

        DB::table('instructores')->insert([
            'usuario_id'   => $usrId,
            'nombres'      => 'Instructor',
            'apellidos'    => 'Test',
            'especialidad' => 'Software',
            'activo'       => true,
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);

        $this->instructor = DB::table('instructores')->where('usuario_id', $usrId)->first();

        $empUsrId = DB::table('usuarios')->insertGetId([
            'numero_documento' => 111000111,
            'correo'           => 'empresa_inst@gmail.com',
            'contrasena'       => Hash::make('password123'),
            'rol_id'           => 3,
            'created_at'       => now(),
            'updated_at'       => now(),
        ]);

        DB::table('empresas')->insert([
            'usuario_id'      => $empUsrId,
            'nit'             => 123456781,
            'nombre'          => 'Empresa Inst',
            'representante'   => 'Rep',
            'correo_contacto' => 'empresa_inst@gmail.com',
            'activo'          => true,
            'created_at'      => now(),
            'updated_at'      => now(),
        ]);

        $proId = DB::table('proyectos')->insertGetId([
            'empresa_nit'           => 123456781,
            'titulo'                => 'Proyecto Instructor',
            'categoria'             => 'Web',
            'descripcion'           => 'Desc',
            'requisitos_especificos'=> 'Req',
            'habilidades_requeridas'=> 'Hab',
            'fecha_publicacion'     => now()->format('Y-m-d'),
            'duracion_estimada_dias'=> 180,
            'estado'                => 'en_progreso',
            'instructor_usuario_id' => $usrId,
            'created_at'            => now(),
            'updated_at'            => now(),
        ]);

        $this->proyecto = DB::table('proyectos')->where('id', $proId)->first();
    }

    #[Test]
    public function instructor_can_view_dashboard()
    {
        $response = $this->withSession([
            'usr_id'    => $this->usuario->id,
            'documento' => $this->usuario->numero_documento,
            'rol'       => 2,
            'nombre'    => 'Instructor',
            'ins_id'    => $this->instructor->id,
        ])->get(route('instructor.dashboard'));

        $response->assertStatus(200);
        $response->assertViewIs('instructor.dashboard');
    }

    #[Test]
    public function instructor_can_manage_stages()
    {
        $session = [
            'usr_id'    => $this->usuario->id,
            'documento' => $this->usuario->numero_documento,
            'rol'       => 2,
            'ins_id'    => $this->instructor->id,
        ];

        $stageData = [
            'nombre'      => 'Nueva Etapa',
            'descripcion' => 'Descripción de la etapa',
            'orden'       => 1
        ];

        $response = $this->withSession($session)->post(route('instructor.etapas.crear', $this->proyecto->id), $stageData);
        $response->assertStatus(302);
        $this->assertDatabaseHas('etapas', ['nombre' => 'Nueva Etapa', 'proyecto_id' => $this->proyecto->id]);

        $etaId = DB::table('etapas')->where('nombre', 'Nueva Etapa')->value('id');

        $updateData = [
            'nombre'      => 'Etapa Actualizada',
            'descripcion' => 'Nueva desc',
            'orden'       => 2
        ];
        $response = $this->withSession($session)->put(route('instructor.etapas.editar', $etaId), $updateData);
        $response->assertStatus(302);
        $this->assertDatabaseHas('etapas', ['id' => $etaId, 'nombre' => 'Etapa Actualizada']);

        $response = $this->withSession($session)->delete(route('instructor.etapas.eliminar', $etaId));
        $response->assertStatus(302);
        $this->assertDatabaseMissing('etapas', ['id' => $etaId]);
    }

    #[Test]
    public function instructor_can_grade_evidence()
    {
        $etaId = DB::table('etapas')->insertGetId([
            'proyecto_id' => $this->proyecto->id,
            'orden'       => 1,
            'nombre'      => 'Etapa 1',
            'descripcion' => 'Desc',
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        $aprUsrId = DB::table('usuarios')->insertGetId([
            'numero_documento' => 222333444,
            'correo'           => 'apr_test@gmail.com',
            'contrasena'       => Hash::make('password123'),
            'rol_id'           => 1,
            'created_at'       => now(),
            'updated_at'       => now(),
        ]);
        $aprId = DB::table('aprendices')->insertGetId([
            'usuario_id'         => $aprUsrId,
            'nombres'            => 'A',
            'apellidos'          => 'B',
            'programa_formacion' => 'P',
            'activo'             => true,
            'created_at'         => now(),
            'updated_at'         => now(),
        ]);

        $evidId = DB::table('evidencias')->insertGetId([
            'aprendiz_id'  => $aprId,
            'etapa_id'     => $etaId,
            'proyecto_id'  => $this->proyecto->id,
            'ruta_archivo' => 'path/to/file.pdf',
            'fecha_envio'  => now(),
            'estado'       => 'pendiente',
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);

        $gradeData = [
            'estado'     => 'aceptada',
            'comentario' => 'Buen trabajo'
        ];

        $response = $this->withSession([
            'usr_id'    => $this->usuario->id,
            'documento' => $this->usuario->numero_documento,
            'rol'       => 2,
            'ins_id'    => $this->instructor->id,
        ])->put(route('instructor.evidencias.calificar', $evidId), $gradeData);

        $response->assertStatus(302);
        $this->assertDatabaseHas('evidencias', [
            'id'                   => $evidId,
            'estado'               => 'aceptada',
            'comentario_instructor'=> 'Buen trabajo'
        ]);
    }
}
