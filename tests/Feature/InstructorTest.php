<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Instructor;
use App\Models\Empresa;
use App\Models\Proyecto;
use App\Models\Etapa;
use App\Models\Aprendiz;
use App\Models\Evidencia;
use Illuminate\Support\Facades\Hash;

class InstructorTest extends TestCase
{
    use RefreshDatabase;

    protected $usuario;
    protected $instructor;
    protected $proyecto;

    protected function setUp(): void
    {
        parent::setUp();

        // 1. Crear usuario con rol instructor (2)
        $this->usuario = User::create([
            'usr_documento' => 555666777,
            'usr_correo'    => 'test_instructor@gmail.com',
            'usr_contrasena' => Hash::make('password123'),
            'rol_id'        => 2,
            'usr_fecha_creacion' => now(),
        ]);

        // 2. Crear perfil de instructor
        $this->instructor = Instructor::create([
            'usr_id'           => $this->usuario->usr_id,
            'ins_nombre'       => 'Instructor',
            'ins_apellido'     => 'Test',
            'ins_especialidad' => 'Software',
            'ins_estado'       => 1,
        ]);

        // 3. Crear empresa
        $empUsr = User::create([
            'usr_documento' => 111000111,
            'usr_correo'    => 'empresa_inst@gmail.com',
            'usr_contrasena' => Hash::make('password123'),
            'rol_id'        => 3,
        ]);

        $empresa = Empresa::create([
            'usr_id'           => $empUsr->usr_id,
            'emp_nit'          => 123456781,
            'emp_nombre'       => 'Empresa Inst',
            'emp_representante'=> 'Rep',
            'emp_correo'       => 'empresa_inst@gmail.com',
            'emp_contrasena'   => Hash::make('password123'),
        ]);

        // 4. Crear un proyecto ASIGNADO al instructor
        $this->proyecto = Proyecto::create([
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
    }

    #[Test]
    public function instructor_can_view_dashboard()
    {
        $response = $this->actingAs($this->usuario)->withSession([
            'usr_id'    => $this->usuario->usr_id,
            'documento' => $this->usuario->usr_documento,
            'rol'       => 2,
            'nombre'    => 'Instructor'
        ])->get(route('instructor.dashboard'));

        $response->assertStatus(200);
        $response->assertViewIs('instructor.dashboard');
    }

    #[Test]
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

        $response = $this->actingAs($this->usuario)->withSession($session)
            ->post(route('instructor.etapas.crear', $this->proyecto->pro_id), $stageData);
        
        $response->assertStatus(302);
        $this->assertDatabaseHas('etapa', ['eta_nombre' => 'Nueva Etapa', 'eta_pro_id' => $this->proyecto->pro_id]);

        $etapa = Etapa::where('eta_nombre', 'Nueva Etapa')->first();

        // 2. Editar etapa
        $updateData = [
            'nombre'      => 'Etapa Actualizada',
            'descripcion' => 'Nueva desc',
            'orden'       => 2
        ];
        $response = $this->actingAs($this->usuario)->withSession($session)
            ->put(route('instructor.etapas.editar', $etapa->eta_id), $updateData);
        
        $response->assertStatus(302);
        $this->assertDatabaseHas('etapa', ['eta_id' => $etapa->eta_id, 'eta_nombre' => 'Etapa Actualizada']);

        // 3. Eliminar etapa
        $response = $this->actingAs($this->usuario)->withSession($session)
            ->delete(route('instructor.etapas.eliminar', $etapa->eta_id));
        
        $response->assertStatus(302);
        $this->assertDatabaseMissing('etapa', ['eta_id' => $etapa->eta_id]);
    }

    #[Test]
    public function instructor_can_grade_evidence()
    {
        // 1. Crear etapa
        $etapa = Etapa::create([
            'eta_pro_id' => $this->proyecto->pro_id,
            'eta_orden'  => 1,
            'eta_nombre' => 'Etapa 1',
            'eta_descripcion' => 'Desc'
        ]);

        // 2. Crear aprendiz y evidencia
        $aprUsr = User::create([
            'usr_documento' => 222333444,
            'usr_correo'    => 'apr_test@gmail.com',
            'usr_contrasena' => Hash::make('password123'),
            'rol_id'        => 1,
        ]);
        
        $aprendiz = Aprendiz::create([
            'usr_id' => $aprUsr->usr_id,
            'apr_nombre' => 'A', 'apr_apellido' => 'B', 'apr_programa' => 'P'
        ]);

        $evidencia = Evidencia::create([
            'evid_apr_id' => $aprendiz->apr_id,
            'evid_eta_id' => $etapa->eta_id,
            'evid_pro_id' => $this->proyecto->pro_id,
            'evid_archivo' => 'path/to/file.pdf',
            'evid_fecha' => now(),
            'evid_estado' => 'Pendiente'
        ]);

        $gradeData = [
            'estado' => 'Aprobada',
            'comentario' => 'Buen trabajo'
        ];

        $response = $this->actingAs($this->usuario)->withSession([
            'usr_id'    => $this->usuario->usr_id,
            'documento' => $this->usuario->usr_documento,
            'rol'       => 2
        ])->put(route('instructor.evidencias.calificar', $evidencia->evid_id), $gradeData);

        $response->assertStatus(302);
        $this->assertDatabaseHas('evidencia', [
            'evid_id' => $evidencia->evid_id,
            'evid_estado' => 'Aprobada',
            'evid_comentario' => 'Buen trabajo'
        ]);
    }
}
