<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Aprendiz;
use App\Models\Proyecto;
use App\Models\Empresa;
use App\Models\Postulacion;
use App\Models\Etapa;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class AprendizTest extends TestCase
{
    use RefreshDatabase;

    protected $usuario;
    protected $aprendiz;
    protected $proyecto;

    protected function setUp(): void
    {
        parent::setUp();

        // 1. Crear usuario con rol aprendiz (1) y su perfil
        $this->aprendiz = Aprendiz::factory()->create([
            'usr_id' => User::factory()->create(['rol_id' => 1])->usr_id
        ]);
        $this->usuario = $this->aprendiz->usuario;

        // 2. Crear empresa y proyecto para pruebas usando factories
        $this->proyecto = Proyecto::factory()->create([
            'pro_estado' => 'Aprobado'
        ]);
    }

    #[Test]
    public function aprendiz_can_view_dashboard()
    {
        $response = $this->actingAs($this->usuario)->withSession([
            'usr_id'    => $this->usuario->usr_id,
            'documento' => $this->usuario->usr_documento,
            'rol'       => 1,
            'nombre'    => 'Aprendiz'
        ])->get(route('aprendiz.dashboard'));

        $response->assertStatus(200);
        $response->assertViewIs('aprendiz.dashboard');
    }

    #[Test]
    public function aprendiz_can_search_projects()
    {
        $response = $this->actingAs($this->usuario)->withSession([
            'usr_id'    => $this->usuario->usr_id,
            'documento' => $this->usuario->usr_documento,
            'rol'       => 1
        ])->get(route('aprendiz.proyectos', ['buscar' => $this->proyecto->pro_titulo_proyecto]));

        $response->assertStatus(200);
        $response->assertSee($this->proyecto->pro_titulo_proyecto);
    }

    #[Test]
    public function aprendiz_can_postulate_to_project()
    {
        $response = $this->actingAs($this->usuario)->withSession([
            'usr_id'    => $this->usuario->usr_id,
            'documento' => $this->usuario->usr_documento,
            'rol'       => 1
        ])->post(route('aprendiz.postular', $this->proyecto->pro_id));

        $response->assertStatus(302);
        $this->assertDatabaseHas('postulacion', [
            'apr_id' => $this->aprendiz->apr_id,
            'pro_id' => $this->proyecto->pro_id
        ]);
    }

    #[Test]
    public function aprendiz_can_send_evidence_if_approved()
    {
        // 1. Aprobar postulación
        Postulacion::create([
            'apr_id' => $this->aprendiz->apr_id,
            'pro_id' => $this->proyecto->pro_id,
            'pos_estado' => 'Aprobada',
            'pos_fecha' => now()
        ]);

        // 2. Crear una etapa para el proyecto
        $etapa = Etapa::create([
            'eta_pro_id' => $this->proyecto->pro_id,
            'eta_orden'  => 1,
            'eta_nombre' => 'Etapa 1',
            'eta_descripcion' => 'Desc etapa'
        ]);

        Storage::fake('public');
        $evidenceData = [
            'descripcion' => 'Mi primera evidencia',
            'archivo'     => UploadedFile::fake()->create('evidencia.pdf', 500),
        ];

        $response = $this->actingAs($this->usuario)->withSession([
            'usr_id'    => $this->usuario->usr_id,
            'documento' => $this->usuario->usr_documento,
            'rol'       => 1
        ])->post(route('aprendiz.evidencia.enviar', ['proId' => $this->proyecto->pro_id, 'etaId' => $etapa->eta_id]), $evidenceData);

        $response->assertStatus(302);
        $this->assertDatabaseHas('evidencia', [
            'evid_apr_id' => $this->aprendiz->apr_id,
            'evid_eta_id' => $etapa->eta_id,
            'evid_pro_id' => $this->proyecto->pro_id,
            'evid_estado' => 'Pendiente'
        ]);
    }

    #[Test]
    public function aprendiz_can_update_profile()
    {
        $updateData = [
            'nombre'   => 'Aprendiz Actualizado',
            'apellido' => 'Test Actualizado',
            'programa' => 'Nuevo Programa',
        ];

        $response = $this->actingAs($this->usuario)->withSession([
            'usr_id'    => $this->usuario->usr_id,
            'documento' => $this->usuario->usr_documento,
            'rol'       => 1
        ])->put(route('aprendiz.perfil.update'), $updateData);

        $response->assertStatus(302);
        $this->assertDatabaseHas('aprendiz', [
            'apr_id'     => $this->aprendiz->apr_id,
            'apr_nombre' => 'Aprendiz Actualizado'
        ]);
    }
}
