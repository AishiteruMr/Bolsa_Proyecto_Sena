<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class GeneratedAuditTests extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->setUpRoles();
    }

    private function createUserWithRole(int $rolId): User
    {
        return User::factory()->create(['rol_id' => $rolId]);
    }

    private function sessionForUser(User $user): array
    {
        return [
            'usr_id' => $user->id,
            'rol'    => $user->rol_id,
        ];
    }

    // ── GUEST ACCESS ────────────────────────────────────

    public function test_guest_cannot_access_notificaciones() {
        $this->get('/notificaciones')->assertStatus(302);
    }

    public function test_guest_cannot_access_aprendiz_routes() {
        $routes = ['/aprendiz/dashboard', '/aprendiz/proyectos', '/aprendiz/mis-postulaciones',
                    '/aprendiz/historial', '/aprendiz/mis-entregas', '/aprendiz/perfil'];
        foreach ($routes as $r) { $this->get($r)->assertStatus(302); }
    }

    public function test_guest_cannot_access_empresa_routes() {
        $routes = ['/empresa/dashboard', '/empresa/proyectos', '/empresa/proyectos/crear', '/empresa/perfil'];
        foreach ($routes as $r) { $this->get($r)->assertStatus(302); }
    }

    public function test_guest_cannot_access_instructor_routes() {
        $routes = ['/instructor/dashboard', '/instructor/proyectos', '/instructor/historial',
                    '/instructor/aprendices', '/instructor/perfil'];
        foreach ($routes as $r) { $this->get($r)->assertStatus(302); }
    }

    public function test_guest_cannot_access_admin_routes() {
        $routes = ['/admin/dashboard', '/admin/usuarios', '/admin/empresas', '/admin/proyectos',
                    '/admin/historial', '/admin/mensajes-soporte', '/admin/backup'];
        foreach ($routes as $r) { $this->get($r)->assertStatus(302); }
    }

    public function test_guest_cannot_access_api_routes() {
        $this->get('/api/admin/stats')->assertStatus(302);
        $this->get('/api/infinite/proyectos')->assertStatus(302);
        $this->get('/api/infinite/aprendices')->assertStatus(302);
        $this->get('/api/infinite/proyectos-empresa')->assertStatus(302);
    }

    // ── WRONG ROLE ACCESS (expect 403) ──────────────────

    public function test_wrong_role_cannot_access_aprendiz_routes() {
        $user = $this->createUserWithRole(2);
        $session = $this->sessionForUser($user);
        $routes = ['/aprendiz/dashboard', '/aprendiz/proyectos', '/aprendiz/mis-postulaciones',
                    '/aprendiz/historial', '/aprendiz/mis-entregas', '/aprendiz/perfil'];
        foreach ($routes as $r) {
            $this->withSession($session)->get($r)->assertStatus(403);
        }
    }

    public function test_wrong_role_cannot_access_empresa_routes() {
        $user = $this->createUserWithRole(1);
        $session = $this->sessionForUser($user);
        $routes = ['/empresa/dashboard', '/empresa/proyectos', '/empresa/proyectos/crear', '/empresa/perfil'];
        foreach ($routes as $r) {
            $this->withSession($session)->get($r)->assertStatus(403);
        }
    }

    public function test_wrong_role_cannot_access_instructor_routes() {
        $user = $this->createUserWithRole(1);
        $session = $this->sessionForUser($user);
        $routes = ['/instructor/dashboard', '/instructor/proyectos', '/instructor/historial',
                    '/instructor/aprendices', '/instructor/perfil'];
        foreach ($routes as $r) {
            $this->withSession($session)->get($r)->assertStatus(403);
        }
    }

    public function test_wrong_role_cannot_access_admin_routes() {
        $user = $this->createUserWithRole(1);
        $session = $this->sessionForUser($user);
        $routes = ['/admin/dashboard', '/admin/usuarios', '/admin/empresas', '/admin/proyectos',
                    '/admin/historial', '/admin/mensajes-soporte', '/admin/backup',
                    '/admin/exportar/proyectos', '/admin/exportar/usuarios', '/admin/exportar/empresas',
                    '/admin/exportar/aprendices', '/admin/exportar/instructores'];
        foreach ($routes as $r) {
            $this->withSession($session)->get($r)->assertStatus(403);
        }
    }

    public function test_wrong_role_cannot_access_admin_export_api_routes() {
        $user = $this->createUserWithRole(1);
        $session = $this->sessionForUser($user);
        $this->withSession($session)->get('/api/admin/stats')->assertStatus(403);
    }

    public function test_wrong_role_cannot_access_api_infinite_proyectos_empresa() {
        $user = $this->createUserWithRole(1);
        $session = $this->sessionForUser($user);
        $this->withSession($session)->get('/api/infinite/proyectos-empresa')->assertStatus(403);
    }
}
