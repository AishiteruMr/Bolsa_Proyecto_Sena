<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $usuario;

    protected function setUp(): void
    {
        parent::setUp();
        Mail::fake();

        // Crear usuario con rol admin (4)
        $usrId = DB::table('usuario')->insertGetId([
            'usr_documento' => 123123123,
            'usr_correo'    => 'admin@gmail.com',
            'usr_contrasena'=> Hash::make('password123'),
            'rol_id'        => 4,
            'usr_fecha_creacion' => now(),
        ]);

        $this->usuario = DB::table('usuario')->where('usr_id', $usrId)->first();
    }

    /** @test */
    public function admin_can_view_dashboard()
    {
        $response = $this->withSession([
            'usr_id' => $this->usuario->usr_id,
            'rol'    => 4
        ])->get(route('admin.dashboard'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.dashboard');
    }

    /** @test */
    public function admin_can_change_user_status()
    {
        // 1. Crear un aprendiz
        $aprUsrId = DB::table('usuario')->insertGetId([
            'usr_documento' => 321321321,
            'usr_correo'    => 'apr_admin_test@gmail.com',
            'usr_contrasena'=> Hash::make('password123'),
            'rol_id'        => 1,
            'usr_fecha_creacion' => now(),
        ]);
        $aprId = DB::table('aprendiz')->insertGetId([
            'usr_id' => $aprUsrId,
            'apr_nombre' => 'A', 'apr_apellido' => 'B', 'apr_programa' => 'P', 'apr_estado' => 1
        ]);

        $response = $this->withSession([
            'usr_id' => $this->usuario->usr_id,
            'rol'    => 4
        ])->post(route('admin.usuarios.estado', $aprId), [
            'tipo' => 'aprendiz',
            'estado' => 0
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('aprendiz', ['apr_id' => $aprId, 'apr_estado' => 0]);
    }

    /** @test */
    public function admin_can_change_company_status()
    {
        $empUsrId = DB::table('usuario')->insertGetId([
            'usr_documento' => 456456456,
            'usr_correo'    => 'emp_admin_test@gmail.com',
            'usr_contrasena'=> Hash::make('password123'),
            'rol_id'        => 3,
            'usr_fecha_creacion' => now(),
        ]);
        $empId = DB::table('empresa')->insertGetId([
            'usr_id' => $empUsrId,
            'emp_nit' => 999000999,
            'emp_nombre' => 'E', 'emp_representante' => 'R', 'emp_correo' => 'e@e.com',
            'emp_contrasena' => 'x', 'emp_estado' => 1
        ]);

        $response = $this->withSession([
            'usr_id' => $this->usuario->usr_id,
            'rol'    => 4
        ])->post(route('admin.empresas.estado', $empId), [
            'estado' => 0
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('empresa', ['emp_id' => $empId, 'emp_estado' => 0]);
    }

    /** @test */
    public function admin_can_assign_instructor_to_project()
    {
        // 1. Crear instructor
        $insUsrId = DB::table('usuario')->insertGetId([
            'usr_documento' => 789789789,
            'usr_correo'    => 'ins_admin_test@gmail.com',
            'usr_contrasena'=> Hash::make('password123'),
            'rol_id'        => 2,
            'usr_fecha_creacion' => now(),
        ]);
        DB::table('instructor')->insert([
            'usr_id' => $insUsrId,
            'ins_nombre' => 'I', 'ins_apellido' => 'T', 'ins_especialidad' => 'S'
        ]);

        // 2. Crear empresa (necesaria para el proyecto)
        $empUsrId = DB::table('usuario')->insertGetId([
            'usr_documento' => 888777666,
            'usr_correo'    => 'emp_assign@gmail.com',
            'usr_contrasena'=> Hash::make('password123'),
            'rol_id'        => 3,
            'usr_fecha_creacion' => now(),
        ]);
        DB::table('empresa')->insert([
            'usr_id' => $empUsrId,
            'emp_nit' => 555666555,
            'emp_nombre' => 'E', 'emp_representante' => 'R', 'emp_correo' => 'e_assign@e.com',
            'emp_contrasena' => 'x', 'emp_estado' => 1
        ]);

        // 3. Crear proyecto
        $proId = DB::table('proyecto')->insertGetId([
            'emp_nit' => 555666555,
            'pro_titulo_proyecto' => 'P', 'pro_categoria' => 'C', 'pro_descripcion' => 'D',
            'pro_requisitos_especificos' => 'R', 'pro_habilidades_requerida' => 'H',
            'pro_fecha_publi' => now(), 'pro_duracion_estimada' => 10, 'pro_estado' => 'Activo'
        ]);

        $response = $this->withSession([
            'usr_id' => $this->usuario->usr_id,
            'rol'    => 4
        ])->post(route('admin.proyectos.asignar', $proId), [
            'ins_usr_documento' => 789789789
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('proyecto', [
            'pro_id' => $proId,
            'ins_usr_documento' => 789789789
        ]);
    }
}
