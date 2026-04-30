<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class GeneratedAuditTests extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_notificaciones() {
        $this->get('/notificaciones')->assertStatus(302);
    }

    public function test_guest_cannot_access_aprendiz_dashboard() {
        $this->get('/aprendiz/dashboard')->assertStatus(302);
    }

    public function test_wrong_role_cannot_access_aprendiz_dashboard() {
        $user = User::factory()->create(['rol_id' => 99]);
        $this->actingAs($user)->get('/aprendiz/dashboard')->assertStatus(403);
    }

    public function test_guest_cannot_access_aprendiz_proyectos() {
        $this->get('/aprendiz/proyectos')->assertStatus(302);
    }

    public function test_wrong_role_cannot_access_aprendiz_proyectos() {
        $user = User::factory()->create(['rol_id' => 99]);
        $this->actingAs($user)->get('/aprendiz/proyectos')->assertStatus(403);
    }

    public function test_guest_cannot_access_aprendiz_mis_postulaciones() {
        $this->get('/aprendiz/mis-postulaciones')->assertStatus(302);
    }

    public function test_wrong_role_cannot_access_aprendiz_mis_postulaciones() {
        $user = User::factory()->create(['rol_id' => 99]);
        $this->actingAs($user)->get('/aprendiz/mis-postulaciones')->assertStatus(403);
    }

    public function test_guest_cannot_access_aprendiz_historial() {
        $this->get('/aprendiz/historial')->assertStatus(302);
    }

    public function test_wrong_role_cannot_access_aprendiz_historial() {
        $user = User::factory()->create(['rol_id' => 99]);
        $this->actingAs($user)->get('/aprendiz/historial')->assertStatus(403);
    }

    public function test_guest_cannot_access_aprendiz_mis_entregas() {
        $this->get('/aprendiz/mis-entregas')->assertStatus(302);
    }

    public function test_wrong_role_cannot_access_aprendiz_mis_entregas() {
        $user = User::factory()->create(['rol_id' => 99]);
        $this->actingAs($user)->get('/aprendiz/mis-entregas')->assertStatus(403);
    }

    public function test_guest_cannot_access_aprendiz_perfil() {
        $this->get('/aprendiz/perfil')->assertStatus(302);
    }

    public function test_wrong_role_cannot_access_aprendiz_perfil() {
        $user = User::factory()->create(['rol_id' => 99]);
        $this->actingAs($user)->get('/aprendiz/perfil')->assertStatus(403);
    }

    public function test_guest_cannot_access_empresa_dashboard() {
        $this->get('/empresa/dashboard')->assertStatus(302);
    }

    public function test_wrong_role_cannot_access_empresa_dashboard() {
        $user = User::factory()->create(['rol_id' => 99]);
        $this->actingAs($user)->get('/empresa/dashboard')->assertStatus(403);
    }

    public function test_guest_cannot_access_empresa_proyectos() {
        $this->get('/empresa/proyectos')->assertStatus(302);
    }

    public function test_wrong_role_cannot_access_empresa_proyectos() {
        $user = User::factory()->create(['rol_id' => 99]);
        $this->actingAs($user)->get('/empresa/proyectos')->assertStatus(403);
    }

    public function test_guest_cannot_access_empresa_proyectos_crear() {
        $this->get('/empresa/proyectos/crear')->assertStatus(302);
    }

    public function test_wrong_role_cannot_access_empresa_proyectos_crear() {
        $user = User::factory()->create(['rol_id' => 99]);
        $this->actingAs($user)->get('/empresa/proyectos/crear')->assertStatus(403);
    }

    public function test_guest_cannot_access_empresa_perfil() {
        $this->get('/empresa/perfil')->assertStatus(302);
    }

    public function test_wrong_role_cannot_access_empresa_perfil() {
        $user = User::factory()->create(['rol_id' => 99]);
        $this->actingAs($user)->get('/empresa/perfil')->assertStatus(403);
    }

    public function test_guest_cannot_access_instructor_dashboard() {
        $this->get('/instructor/dashboard')->assertStatus(302);
    }

    public function test_wrong_role_cannot_access_instructor_dashboard() {
        $user = User::factory()->create(['rol_id' => 99]);
        $this->actingAs($user)->get('/instructor/dashboard')->assertStatus(403);
    }

    public function test_guest_cannot_access_instructor_proyectos() {
        $this->get('/instructor/proyectos')->assertStatus(302);
    }

    public function test_wrong_role_cannot_access_instructor_proyectos() {
        $user = User::factory()->create(['rol_id' => 99]);
        $this->actingAs($user)->get('/instructor/proyectos')->assertStatus(403);
    }

    public function test_guest_cannot_access_instructor_historial() {
        $this->get('/instructor/historial')->assertStatus(302);
    }

    public function test_wrong_role_cannot_access_instructor_historial() {
        $user = User::factory()->create(['rol_id' => 99]);
        $this->actingAs($user)->get('/instructor/historial')->assertStatus(403);
    }

    public function test_guest_cannot_access_instructor_aprendices() {
        $this->get('/instructor/aprendices')->assertStatus(302);
    }

    public function test_wrong_role_cannot_access_instructor_aprendices() {
        $user = User::factory()->create(['rol_id' => 99]);
        $this->actingAs($user)->get('/instructor/aprendices')->assertStatus(403);
    }

    public function test_guest_cannot_access_instructor_perfil() {
        $this->get('/instructor/perfil')->assertStatus(302);
    }

    public function test_wrong_role_cannot_access_instructor_perfil() {
        $user = User::factory()->create(['rol_id' => 99]);
        $this->actingAs($user)->get('/instructor/perfil')->assertStatus(403);
    }

    public function test_guest_cannot_access_admin_dashboard() {
        $this->get('/admin/dashboard')->assertStatus(302);
    }

    public function test_wrong_role_cannot_access_admin_dashboard() {
        $user = User::factory()->create(['rol_id' => 99]);
        $this->actingAs($user)->get('/admin/dashboard')->assertStatus(403);
    }

    public function test_guest_cannot_access_admin_usuarios() {
        $this->get('/admin/usuarios')->assertStatus(302);
    }

    public function test_wrong_role_cannot_access_admin_usuarios() {
        $user = User::factory()->create(['rol_id' => 99]);
        $this->actingAs($user)->get('/admin/usuarios')->assertStatus(403);
    }

    public function test_guest_cannot_access_admin_empresas() {
        $this->get('/admin/empresas')->assertStatus(302);
    }

    public function test_wrong_role_cannot_access_admin_empresas() {
        $user = User::factory()->create(['rol_id' => 99]);
        $this->actingAs($user)->get('/admin/empresas')->assertStatus(403);
    }

    public function test_guest_cannot_access_admin_proyectos() {
        $this->get('/admin/proyectos')->assertStatus(302);
    }

    public function test_wrong_role_cannot_access_admin_proyectos() {
        $user = User::factory()->create(['rol_id' => 99]);
        $this->actingAs($user)->get('/admin/proyectos')->assertStatus(403);
    }

    public function test_guest_cannot_access_admin_exportar_proyectos() {
        $this->get('/admin/exportar/proyectos')->assertStatus(302);
    }

    public function test_wrong_role_cannot_access_admin_exportar_proyectos() {
        $user = User::factory()->create(['rol_id' => 99]);
        $this->actingAs($user)->get('/admin/exportar/proyectos')->assertStatus(403);
    }

    public function test_guest_cannot_access_admin_exportar_usuarios() {
        $this->get('/admin/exportar/usuarios')->assertStatus(302);
    }

    public function test_wrong_role_cannot_access_admin_exportar_usuarios() {
        $user = User::factory()->create(['rol_id' => 99]);
        $this->actingAs($user)->get('/admin/exportar/usuarios')->assertStatus(403);
    }

    public function test_guest_cannot_access_admin_exportar_empresas() {
        $this->get('/admin/exportar/empresas')->assertStatus(302);
    }

    public function test_wrong_role_cannot_access_admin_exportar_empresas() {
        $user = User::factory()->create(['rol_id' => 99]);
        $this->actingAs($user)->get('/admin/exportar/empresas')->assertStatus(403);
    }

    public function test_guest_cannot_access_admin_exportar_aprendices() {
        $this->get('/admin/exportar/aprendices')->assertStatus(302);
    }

    public function test_wrong_role_cannot_access_admin_exportar_aprendices() {
        $user = User::factory()->create(['rol_id' => 99]);
        $this->actingAs($user)->get('/admin/exportar/aprendices')->assertStatus(403);
    }

    public function test_guest_cannot_access_admin_exportar_instructores() {
        $this->get('/admin/exportar/instructores')->assertStatus(302);
    }

    public function test_wrong_role_cannot_access_admin_exportar_instructores() {
        $user = User::factory()->create(['rol_id' => 99]);
        $this->actingAs($user)->get('/admin/exportar/instructores')->assertStatus(403);
    }

    public function test_guest_cannot_access_admin_audit() {
        $this->get('/admin/audit')->assertStatus(302);
    }

    public function test_wrong_role_cannot_access_admin_audit() {
        $user = User::factory()->create(['rol_id' => 99]);
        $this->actingAs($user)->get('/admin/audit')->assertStatus(403);
    }

    public function test_guest_cannot_access_admin_mensajes_soporte() {
        $this->get('/admin/mensajes-soporte')->assertStatus(302);
    }

    public function test_wrong_role_cannot_access_admin_mensajes_soporte() {
        $user = User::factory()->create(['rol_id' => 99]);
        $this->actingAs($user)->get('/admin/mensajes-soporte')->assertStatus(403);
    }

    public function test_guest_cannot_access_admin_backup() {
        $this->get('/admin/backup')->assertStatus(302);
    }

    public function test_wrong_role_cannot_access_admin_backup() {
        $user = User::factory()->create(['rol_id' => 99]);
        $this->actingAs($user)->get('/admin/backup')->assertStatus(403);
    }

    public function test_guest_cannot_access_admin_backup_exportar() {
        $this->get('/admin/backup/exportar')->assertStatus(302);
    }

    public function test_wrong_role_cannot_access_admin_backup_exportar() {
        $user = User::factory()->create(['rol_id' => 99]);
        $this->actingAs($user)->get('/admin/backup/exportar')->assertStatus(403);
    }

    public function test_guest_cannot_access_api_admin_stats() {
        $this->get('/api/admin/stats')->assertStatus(302);
    }

    public function test_wrong_role_cannot_access_api_admin_stats() {
        $user = User::factory()->create(['rol_id' => 99]);
        $this->actingAs($user)->get('/api/admin/stats')->assertStatus(403);
    }

    public function test_guest_cannot_access_api_infinite_proyectos() {
        $this->get('/api/infinite/proyectos')->assertStatus(302);
    }

    public function test_guest_cannot_access_api_infinite_aprendices() {
        $this->get('/api/infinite/aprendices')->assertStatus(302);
    }

    public function test_guest_cannot_access_api_infinite_proyectos_empresa() {
        $this->get('/api/infinite/proyectos-empresa')->assertStatus(302);
    }

    public function test_wrong_role_cannot_access_api_infinite_proyectos_empresa() {
        $user = User::factory()->create(['rol_id' => 99]);
        $this->actingAs($user)->get('/api/infinite/proyectos-empresa')->assertStatus(403);
    }

}
