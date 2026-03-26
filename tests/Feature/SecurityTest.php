<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SecurityTest extends TestCase
{
    use RefreshDatabase;

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
        // 1. Crear un aprendiz completo (usuario + perfil aprendiz)
        $usrId = DB::table('usuario')->insertGetId([
            'usr_documento' => 111111,
            'usr_correo'    => 'test_sec@gmail.com',
            'usr_contrasena'=> Hash::make('password123'),
            'rol_id'        => 1, // Aprendiz
            'usr_fecha_creacion' => now(),
        ]);
        DB::table('aprendiz')->insert([
            'usr_id'       => $usrId,
            'apr_nombre'   => 'Test',
            'apr_apellido' => 'Sec',
            'apr_programa' => 'ADSO',
            'apr_estado'   => 1,
        ]);

        // Intentar acceder a admin dashboard como aprendiz
        // AuthMiddleware pasa (perfil existe), pero RolMiddleware lanza abort(403)
        $response = $this->withSession([
            'usr_id' => $usrId,
            'rol'    => 1
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
        // 1. Crear un usuario existente
        DB::table('usuario')->insert([
            'usr_documento' => 222222,
            'usr_correo'    => 'duplicate@gmail.com',
            'usr_contrasena'=> Hash::make('password123'),
            'rol_id'        => 1,
        ]);

        $response = $this->post(route('registro.aprendiz.post'), [
            'nombre' => 'Test',
            'apellido' => 'User',
            'documento' => '333333',
            'programa' => 'ADSO',
            'correo' => 'duplicate@gmail.com', // Duplicado
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'terminos' => 'on'
        ]);

        $response->assertSessionHasErrors(['correo']);
    }

    #[Test]
    public function deactivated_account_cannot_login()
    {
        // 1. Crear usuario desactivado
        $usrId = DB::table('usuario')->insertGetId([
            'usr_documento' => 444444,
            'usr_correo'    => 'deactivated@gmail.com',
            'usr_contrasena'=> Hash::make('password123'),
            'rol_id'        => 1,
        ]);
        DB::table('aprendiz')->insert([
            'usr_id' => $usrId,
            'apr_nombre' => 'A', 'apr_apellido' => 'B', 'apr_programa' => 'P',
            'apr_estado' => 0 // Desactivado
        ]);

        $response = $this->post(route('login.post'), [
            'correo' => 'deactivated@gmail.com',
            'password' => 'password123'
        ]);

        $response->assertSessionHas('error');
        $this->assertStringContainsString('cuenta está desactivada', session('error'));
    }
}
