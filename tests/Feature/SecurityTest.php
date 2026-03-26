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
        // 1. Crear un aprendiz completo usando factory
        $aprendiz = \App\Models\Aprendiz::factory()->create();
        $user = $aprendiz->usuario;

        // Intentar acceder a admin dashboard como aprendiz
        $response = $this->actingAs($user)->get(route('admin.dashboard'));

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
        // 1. Crear un usuario existente usando factory
        $existingUser = \App\Models\User::factory()->create(['usr_correo' => 'duplicate@gmail.com']);

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
        // 1. Crear usuario desactivado usando factory
        $aprendiz = \App\Models\Aprendiz::factory()->create(['apr_estado' => 0]);
        $user = $aprendiz->usuario;

        $response = $this->post(route('login.post'), [
            'correo' => $user->usr_correo,
            'password' => 'password123'
        ]);

        $response->assertSessionHas('error');
        $this->assertStringContainsString('cuenta está desactivada', session('error'));
    }

    #[Test]
    public function company_cannot_edit_another_company_project()
    {
        // 1. Crear Empresa A
        $empresaA = \App\Models\Empresa::factory()->create(['emp_nit' => 111111111]);
        $userA = $empresaA->usuario;

        // 2. Crear Empresa B y su proyecto
        $empresaB = \App\Models\Empresa::factory()->create(['emp_nit' => 222222222]);
        $proyectoB = \App\Models\Proyecto::factory()->create(['emp_nit' => 222222222]);

        // Empresa A intenta editar proyecto de Empresa B
        $response = $this->actingAs($userA)
            ->withSession([
                'nit'    => 111111111,
                'rol'    => 3,
                'usr_id' => $userA->usr_id
            ])
            ->get(route('empresa.proyectos.edit', $proyectoB->pro_id));

        $response->assertStatus(404);
    }
}
