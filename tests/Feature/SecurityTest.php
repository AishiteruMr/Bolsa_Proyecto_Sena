<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SecurityTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->setUpRoles();
    }

    #[Test]
    public function guest_cannot_access_protected_routes()
    {
        $protectedRoutes = [
            'aprendiz.dashboard',
            'instructor.dashboard',
            'empresa.dashboard',
            'admin.dashboard',
        ];

        foreach ($protectedRoutes as $route) {
            $response = $this->get(route($route));
            $response->assertStatus(302);
            $response->assertRedirect(route('login'));
        }
    }

    #[Test]
    public function user_cannot_access_other_role_dashboard()
    {
        $usrId = DB::table('usuarios')->insertGetId([
            'numero_documento' => 111111,
            'correo'           => 'test_sec@gmail.com',
            'contrasena'       => Hash::make('password123'),
            'rol_id'           => 1,
            'created_at'       => now(),
            'updated_at'       => now(),
        ]);
        DB::table('aprendices')->insert([
            'usuario_id'         => $usrId,
            'nombres'            => 'Test',
            'apellidos'          => 'User',
            'programa_formacion' => 'ADSO',
            'activo'             => true,
            'created_at'         => now(),
            'updated_at'         => now(),
        ]);

        $response = $this->withSession([
            'usr_id' => $usrId,
            'rol'    => 1,
            'nombre' => 'Test',
        ])->get(route('admin.dashboard'));

        $response->assertStatus(403);
    }

    #[Test]
    public function login_validation_fails_with_empty_data()
    {
        $response = $this->post(route('login.post'), [
            'correo' => '',
            'password' => ''
        ]);

        $response->assertSessionHasErrors(['correo', 'password']);
    }

    #[Test]
    public function login_validation_fails_with_invalid_email()
    {
        $response = $this->post(route('login.post'), [
            'correo' => 'invalid-email',
            'password' => 'password123'
        ]);

        $response->assertSessionHasErrors(['correo']);
    }

    #[Test]
    public function registration_validation_fails_with_short_password()
    {
        $response = $this->post(route('registro.aprendiz.post'), [
            'nombre' => 'Test',
            'apellido' => 'User',
            'documento' => '12345678',
            'programa' => 'ADSO',
            'correo' => 'test@gmail.com',
            'password' => '123',
            'password_confirmation' => '123',
            'terminos' => 'on'
        ]);

        $response->assertSessionHasErrors(['password']);
    }

    #[Test]
    public function registration_validation_fails_with_duplicate_email()
    {
        DB::table('usuarios')->insert([
            'numero_documento' => 222222,
            'correo'           => 'duplicate@gmail.com',
            'contrasena'       => Hash::make('password123'),
            'rol_id'           => 1,
            'created_at'       => now(),
            'updated_at'       => now(),
        ]);

        $response = $this->post(route('registro.aprendiz.post'), [
            'nombre' => 'Test',
            'apellido' => 'User',
            'documento' => '333333',
            'programa' => 'ADSO',
            'correo' => 'duplicate@gmail.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'terminos' => 'on'
        ]);

        $response->assertSessionHasErrors(['correo']);
    }

    #[Test]
    public function deactivated_account_cannot_login()
    {
        $usrId = DB::table('usuarios')->insertGetId([
            'numero_documento' => 444444,
            'correo'           => 'deactivated@gmail.com',
            'contrasena'       => Hash::make('password123'),
            'rol_id'           => 1,
            'created_at'       => now(),
            'updated_at'       => now(),
        ]);
        DB::table('aprendices')->insert([
            'usuario_id'         => $usrId,
            'nombres'            => 'A',
            'apellidos'          => 'B',
            'programa_formacion' => 'P',
            'activo'             => false,
            'created_at'         => now(),
            'updated_at'         => now(),
        ]);

        $response = $this->post(route('login.post'), [
            'correo' => 'deactivated@gmail.com',
            'password' => 'password123'
        ]);

        $response->assertSessionHas('error');
        $this->assertStringContainsString('cuenta está pendiente de activación', session('error'));
    }
}
