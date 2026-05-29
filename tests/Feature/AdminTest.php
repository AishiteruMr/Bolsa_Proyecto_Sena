<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    protected $usuario;

    protected function setUp(): void
    {
        parent::setUp();
        $this->setUpRoles();
        Mail::fake();

        $usrId = DB::table('usuarios')->insertGetId([
            'numero_documento' => 123123123,
            'correo'           => 'admin@gmail.com',
            'contrasena'       => Hash::make('password123'),
            'rol_id'           => 4,
            'created_at'       => now(),
            'updated_at'       => now(),
        ]);

        $this->usuario = DB::table('usuarios')->where('id', $usrId)->first();
    }

    #[Test]
    public function admin_can_view_dashboard()
    {
        $response = $this->withSession([
            'usr_id' => $this->usuario->id,
            'rol'    => 4
        ])->get(route('admin.dashboard'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.dashboard');
    }

    #[Test]
    public function admin_can_change_user_status()
    {
        $aprUsrId = DB::table('usuarios')->insertGetId([
            'numero_documento' => 321321321,
            'correo'           => 'apr_admin_test@gmail.com',
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

        $response = $this->withSession([
            'usr_id' => $this->usuario->id,
            'rol'    => 4
        ])->post(route('admin.usuarios.estado', $aprId), [
            'tipo' => 'aprendiz',
            'estado' => 0
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('aprendices', ['id' => $aprId, 'activo' => 0]);
    }

    #[Test]
    public function admin_can_change_company_status()
    {
        $empUsrId = DB::table('usuarios')->insertGetId([
            'numero_documento' => 456456456,
            'correo'           => 'emp_admin_test@gmail.com',
            'contrasena'       => Hash::make('password123'),
            'rol_id'           => 3,
            'created_at'       => now(),
            'updated_at'       => now(),
        ]);
        $empId = DB::table('empresas')->insertGetId([
            'usuario_id'      => $empUsrId,
            'nit'             => 999000999,
            'nombre'          => 'E',
            'representante'   => 'R',
            'correo_contacto' => 'e@e.com',
            'activo'          => true,
            'created_at'      => now(),
            'updated_at'      => now(),
        ]);

        $response = $this->withSession([
            'usr_id' => $this->usuario->id,
            'rol'    => 4
        ])->post(route('admin.empresas.estado', $empId), [
            'estado' => 0
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('empresas', ['id' => $empId, 'activo' => 0]);
    }

    #[Test]
    public function admin_can_assign_instructor_to_project()
    {
        $insUsrId = DB::table('usuarios')->insertGetId([
            'numero_documento' => 789789789,
            'correo'           => 'ins_admin_test@gmail.com',
            'contrasena'       => Hash::make('password123'),
            'rol_id'           => 2,
            'created_at'       => now(),
            'updated_at'       => now(),
        ]);
        DB::table('instructores')->insert([
            'usuario_id'   => $insUsrId,
            'nombres'      => 'I',
            'apellidos'    => 'T',
            'especialidad' => 'S',
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);

        $empUsrId = DB::table('usuarios')->insertGetId([
            'numero_documento' => 888777666,
            'correo'           => 'emp_assign@gmail.com',
            'contrasena'       => Hash::make('password123'),
            'rol_id'           => 3,
            'created_at'       => now(),
            'updated_at'       => now(),
        ]);
        DB::table('empresas')->insert([
            'usuario_id'      => $empUsrId,
            'nit'             => 555666555,
            'nombre'          => 'E',
            'representante'   => 'R',
            'correo_contacto' => 'e_assign@e.com',
            'activo'          => true,
            'created_at'      => now(),
            'updated_at'      => now(),
        ]);

        $proId = DB::table('proyectos')->insertGetId([
            'empresa_nit'           => 555666555,
            'titulo'                => 'P',
            'categoria'             => 'C',
            'descripcion'           => 'D',
            'requisitos_especificos'=> 'R',
            'habilidades_requeridas'=> 'H',
            'fecha_publicacion'     => now()->format('Y-m-d'),
            'duracion_estimada_dias'=> 10,
            'estado'                => 'pendiente',
            'created_at'            => now(),
            'updated_at'            => now(),
        ]);

        $response = $this->withSession([
            'usr_id' => $this->usuario->id,
            'rol'    => 4
        ])->post(route('admin.proyectos.asignar', $proId), [
            'instructor_usuario_id' => $insUsrId
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('proyectos', [
            'id' => $proId,
            'instructor_usuario_id' => $insUsrId
        ]);
    }
}
