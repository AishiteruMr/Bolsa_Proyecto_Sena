<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Aprendiz;
use App\Models\Empresa;
use App\Models\Instructor;
use App\Models\Proyecto;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    protected $usuario;

    protected function setUp(): void
    {
        parent::setUp();
        Mail::fake();

        // Crear usuario con rol admin (4)
        $this->usuario = User::factory()->create(['rol_id' => 4]);
    }

    #[Test]
    public function admin_can_view_dashboard()
    {
        $response = $this->actingAs($this->usuario)->withSession([
            'usr_id' => $this->usuario->usr_id,
            'rol'    => 4,
            'nombre' => 'Admin'
        ])->get(route('admin.dashboard'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.dashboard');
    }

    #[Test]
    public function admin_can_change_user_status()
    {
        // 1. Crear un aprendiz usando factory
        $aprendiz = Aprendiz::factory()->create();

        $response = $this->actingAs($this->usuario)->withSession([
            'usr_id' => $this->usuario->usr_id,
            'rol'    => 4
        ])->post(route('admin.usuarios.estado', $aprendiz->apr_id), [
            'tipo' => 'aprendiz',
            'estado' => 0
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('aprendiz', ['apr_id' => $aprendiz->apr_id, 'apr_estado' => 0]);
    }

    #[Test]
    public function admin_can_change_company_status()
    {
        $empresa = Empresa::factory()->create();

        $response = $this->actingAs($this->usuario)->withSession([
            'usr_id' => $this->usuario->usr_id,
            'rol'    => 4
        ])->post(route('admin.empresas.estado', $empresa->emp_id), [
            'estado' => 0
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('empresa', ['emp_id' => $empresa->emp_id, 'emp_estado' => 0]);
    }

    #[Test]
    public function admin_can_assign_instructor_to_project()
    {
        // 1. Crear instructor usando factory
        $instructor = Instructor::factory()->create();
        
        // 2. Crear proyecto usando factory
        $proyecto = Proyecto::factory()->create(['pro_estado' => 'Activo']);

        $response = $this->actingAs($this->usuario)->from(route('admin.proyectos'))->withSession([
            'usr_id' => $this->usuario->usr_id,
            'rol'    => 4
        ])->post(route('admin.proyectos.asignar', $proyecto->pro_id), [
            'ins_usr_documento' => $instructor->usuario->usr_documento
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('proyecto', [
            'pro_id' => $proyecto->pro_id,
            'ins_usr_documento' => $instructor->usuario->usr_documento
        ]);
    }

    #[Test]
    public function admin_can_approve_project()
    {
        // 1. Crear proyecto pendiente usando factory
        $proyecto = Proyecto::factory()->create(['pro_estado' => 'Pendiente']);

        $response = $this->actingAs($this->usuario)->from(route('admin.proyectos'))->withSession([
            'usr_id' => $this->usuario->usr_id,
            'rol'    => 4
        ])->post(route('admin.proyectos.aprobar', $proyecto->pro_id));

        $response->assertStatus(302);
        $this->assertDatabaseHas('proyecto', ['pro_id' => $proyecto->pro_id, 'pro_estado' => 'Aprobado']);
    }

    #[Test]
    public function admin_can_reject_project()
    {
        // 1. Crear proyecto pendiente usando factory
        $proyecto = Proyecto::factory()->create(['pro_estado' => 'Pendiente']);

        $response = $this->actingAs($this->usuario)->from(route('admin.proyectos'))->withSession([
            'usr_id' => $this->usuario->usr_id,
            'rol'    => 4
        ])->post(route('admin.proyectos.rechazar', $proyecto->pro_id));

        $response->assertStatus(302);
        $this->assertDatabaseHas('proyecto', ['pro_id' => $proyecto->pro_id, 'pro_estado' => 'Rechazado']);
    }
}
