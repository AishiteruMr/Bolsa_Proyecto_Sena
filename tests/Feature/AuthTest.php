<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Mail::fake(); // Evitar envío real de correos
    }

    // ─── LOGIN ───────────────────────────────────────────────────────────────

    #[Test]
    public function login_page_loads_correctly()
    {
        $response = $this->get(route('login'));
        $response->assertStatus(200);
        $response->assertViewIs('auth.login');
    }

    #[Test]
    public function aprendiz_can_login_successfully()
    {
        $usrId = DB::table('usuario')->insertGetId([
            'usr_documento' => 10001001,
            'usr_correo'    => 'aprendiz@test.com',
            'usr_contrasena'=> Hash::make('secret123'),
            'rol_id'        => 1,
            'usr_fecha_creacion' => now(),
        ]);
        DB::table('aprendiz')->insert([
            'usr_id'       => $usrId,
            'apr_nombre'   => 'Juan',
            'apr_apellido' => 'Perez',
            'apr_programa' => 'ADSO',
            'apr_estado'   => 1,
        ]);

        $response = $this->post(route('login.post'), [
            'correo'   => 'aprendiz@test.com',
            'password' => 'secret123',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('aprendiz.dashboard'));
        $this->assertEquals(1, session('rol'));
    }

    #[Test]
    public function instructor_can_login_successfully()
    {
        $usrId = DB::table('usuario')->insertGetId([
            'usr_documento' => 20002002,
            'usr_correo'    => 'instructor@test.com',
            'usr_contrasena'=> Hash::make('secret123'),
            'rol_id'        => 2,
            'usr_fecha_creacion' => now(),
        ]);
        DB::table('instructor')->insert([
            'usr_id'           => $usrId,
            'ins_nombre'       => 'Carlos',
            'ins_apellido'     => 'Gomez',
            'ins_especialidad' => 'Sistemas',
            'ins_estado'       => 1,
            'ins_estado_dis'   => 'Disponible',
        ]);

        $response = $this->post(route('login.post'), [
            'correo'   => 'instructor@test.com',
            'password' => 'secret123',
        ]);

        $response->assertRedirect(route('instructor.dashboard'));
        $this->assertEquals(2, session('rol'));
    }

    #[Test]
    public function empresa_can_login_successfully()
    {
        $usrId = DB::table('usuario')->insertGetId([
            'usr_documento' => 30003003,
            'usr_correo'    => 'empresa@test.com',
            'usr_contrasena'=> Hash::make('secret123'),
            'rol_id'        => 3,
            'usr_fecha_creacion' => now(),
        ]);
        DB::table('empresa')->insert([
            'usr_id'            => $usrId,
            'emp_nit'           => 30003003,
            'emp_nombre'        => 'Tech SAS',
            'emp_representante' => 'Ana Lopez',
            'emp_correo'        => 'empresa@test.com',
            'emp_contrasena'    => Hash::make('secret123'),
            'emp_estado'        => 1,
        ]);

        $response = $this->post(route('login.post'), [
            'correo'   => 'empresa@test.com',
            'password' => 'secret123',
        ]);

        $response->assertRedirect(route('empresa.dashboard'));
        $this->assertEquals(3, session('rol'));
    }

    #[Test]
    public function login_fails_with_wrong_password()
    {
        DB::table('usuario')->insertGetId([
            'usr_documento' => 40004004,
            'usr_correo'    => 'wrongpass@test.com',
            'usr_contrasena'=> Hash::make('correctpass'),
            'rol_id'        => 1,
            'usr_fecha_creacion' => now(),
        ]);

        $response = $this->post(route('login.post'), [
            'correo'   => 'wrongpass@test.com',
            'password' => 'wrongpass',
        ]);

        $response->assertSessionHas('error');
        $this->assertStringContainsString('incorrecta', session('error'));
    }

    #[Test]
    public function login_fails_for_nonexistent_user()
    {
        $response = $this->post(route('login.post'), [
            'correo'   => 'noexiste@test.com',
            'password' => 'anypassword',
        ]);

        $response->assertSessionHas('error');
        $this->assertStringContainsString('no registrado', session('error'));
    }

    #[Test]
    public function authenticated_user_is_redirected_away_from_login()
    {
        $response = $this->withSession([
            'usr_id' => 1,
            'rol'    => 1,
        ])->get(route('login'));

        $response->assertStatus(302);
        $response->assertRedirect(route('aprendiz.dashboard'));
    }

    #[Test]
    public function logout_destroys_session()
    {
        $response = $this->withSession([
            'usr_id' => 1,
            'rol'    => 1,
        ])->post(route('logout'));

        $response->assertRedirect(route('login'));
        $response->assertSessionHas('success');
        $this->assertNull(session('usr_id'));
    }

    // ─── REGISTRO APRENDIZ ───────────────────────────────────────────────────

    #[Test]
    public function aprendiz_registration_page_loads()
    {
        $response = $this->get(route('registro.aprendiz'));
        $response->assertStatus(200);
        $response->assertViewIs('auth.registro-aprendiz');
    }

    #[Test]
    public function aprendiz_can_register_successfully()
    {
        $response = $this->post(route('registro.aprendiz.post'), [
            'nombre'               => 'Laura',
            'apellido'             => 'Martinez',
            'documento'            => '55556666',
            'programa'             => 'ADSO',
            'correo'               => 'laura@test.com',
            'password'             => 'password123',
            'password_confirmation'=> 'password123',
            'terminos'             => 'on',
        ]);

        $response->assertRedirect(route('login'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('usuario', ['usr_correo' => 'laura@test.com', 'rol_id' => 1]);
        $this->assertDatabaseHas('aprendiz', ['apr_nombre' => 'Laura', 'apr_apellido' => 'Martinez']);
    }

    #[Test]
    public function registration_fails_with_mismatched_passwords()
    {
        $response = $this->post(route('registro.aprendiz.post'), [
            'nombre'               => 'Pedro',
            'apellido'             => 'Gil',
            'documento'            => '77778888',
            'programa'             => 'ADSO',
            'correo'               => 'pedro@test.com',
            'password'             => 'password123',
            'password_confirmation'=> 'different123',
            'terminos'             => 'on',
        ]);

        $response->assertSessionHasErrors(['password']);
        $this->assertDatabaseMissing('usuario', ['usr_correo' => 'pedro@test.com']);
    }

    // ─── REGISTRO EMPRESA ───────────────────────────────────────────────────

    #[Test]
    public function empresa_registration_page_loads()
    {
        $response = $this->get(route('registro.empresa'));
        $response->assertStatus(200);
        $response->assertViewIs('auth.registro-empresa');
    }

    #[Test]
    public function empresa_can_register_successfully()
    {
        $response = $this->post(route('registro.empresa.post'), [
            'nombre_empresa'       => 'SENA Tech',
            'representante'        => 'Maria Garcia',
            'nit'                  => '900123456',
            'correo'               => 'senatech@test.com',
            'password'             => 'password123',
            'password_confirmation'=> 'password123',
            'terminos'             => 'on',
        ]);

        $response->assertRedirect(route('login'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('empresa', ['emp_nombre' => 'SENA Tech']);
    }

    // ─── REGISTRO INSTRUCTOR ─────────────────────────────────────────────────

    #[Test]
    public function instructor_registration_page_loads()
    {
        $response = $this->get(route('registro.instructor'));
        $response->assertStatus(200);
        $response->assertViewIs('auth.registro-instructor');
    }

    #[Test]
    public function instructor_can_register_successfully()
    {
        $response = $this->post(route('registro.instructor.post'), [
            'nombre'               => 'Luis',
            'apellido'             => 'Herrera',
            'documento'            => '99998888',
            'especialidad'         => 'Desarrollo Web',
            'correo'               => 'luis@test.com',
            'password'             => 'password123',
            'password_confirmation'=> 'password123',
            'terminos'             => 'on',
        ]);

        $response->assertRedirect(route('login'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('instructor', ['ins_nombre' => 'Luis', 'ins_especialidad' => 'Desarrollo Web']);
    }
}
