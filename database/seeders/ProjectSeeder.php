<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

/**
 * ProjectSeeder
 * Inserta proyectos de ejemplo en la bolsa.
 */
class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        // Obtenemos el NIT de la empresa demo creada en DatabaseSeeder
        $companyTaxId    = DB::table('empresas')->where('correo_contacto', 'empresa@gmail.com')->value('nit');
        // Obtenemos el usuario_id del instructor demo
        $instructorUserId = DB::table('usuarios')->where('correo', 'instructor@gmail.com')->value('id');

        $projects = [
            [
                'titulo'                 => 'Sistema de Gestión de Inventarios Inteligente',
                'descripcion'            => 'Desarrollo de una plataforma web para el control de stock en tiempo real utilizando Laravel y Vue.js. El sistema debe incluir alertas de bajo inventario y reportes predictivos.',
                'categoria'              => 'Software',
                'estado'                 => 'aprobado',
                'duracion_estimada_dias' => 90,
                'requisitos_especificos' => 'Conocimientos en PHP, Laravel, y bases de datos relacionales.',
                'habilidades_requeridas' => 'Programación Web, SQL, Trabajo en equipo',
                'imagen_url'             => 'https://images.unsplash.com/photo-1586769852044-692d6e3703f0?q=80&w=800',
            ],
            [
                'titulo'                 => 'Rediseño de Identidad Visual Corporativa',
                'descripcion'            => 'Creación de un manual de identidad corporativa completo, incluyendo logo, paleta de colores, tipografía y aplicaciones en papelería.',
                'categoria'              => 'Diseño',
                'estado'                 => 'aprobado',
                'duracion_estimada_dias' => 45,
                'requisitos_especificos' => 'Manejo avanzado de Adobe Illustrator y Photoshop.',
                'habilidades_requeridas' => 'Diseño Gráfico, Branding, Creatividad',
                'imagen_url'             => 'https://images.unsplash.com/photo-1572044162444-ad60f128b7fa?q=80&w=800',
            ],
            [
                'titulo'                 => 'Campaña de Marketing Digital SENA 2026',
                'descripcion'            => 'Diseño y ejecución de una estrategia de redes sociales para aumentar el engagement en Instagram y LinkedIn.',
                'categoria'              => 'Marketing',
                'estado'                 => 'aprobado',
                'duracion_estimada_dias' => 60,
                'requisitos_especificos' => 'Certificación en Google Ads o Meta Blueprint preferible.',
                'habilidades_requeridas' => 'Copywriting, Analytics, Estrategia Digital',
                'imagen_url'             => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?q=80&w=800',
            ],
            [
                'titulo'                 => 'App Móvil para Control de Asistencia',
                'descripcion'            => 'Creación de una aplicación móvil híbrida para registro de entrada y salida mediante geolocalización.',
                'categoria'              => 'Software',
                'estado'                 => 'pendiente',
                'duracion_estimada_dias' => 120,
                'requisitos_especificos' => 'Experiencia previa con frameworks móviles.',
                'habilidades_requeridas' => 'Mobile Development, APIs REST, Firebase',
                'imagen_url'             => 'https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?q=80&w=800',
            ],
            [
                'titulo'                 => 'Documental Institucional "Talento de Oro"',
                'descripcion'            => 'Producción audiovisual de 15 minutos capturando historias de éxito de los aprendices SENA.',
                'categoria'              => 'Media',
                'estado'                 => 'aprobado',
                'duracion_estimada_dias' => 75,
                'requisitos_especificos' => 'Conocimientos en edición de video (Premiere/DaVinci Resolve).',
                'habilidades_requeridas' => 'Edición de Video, Fotografía, Narrativa Audiovisual',
                'imagen_url'             => 'https://images.unsplash.com/photo-1485846234645-a62644f84728?q=80&w=800',
            ],
            [
                'titulo'                 => 'Plataforma E-commerce para Artesanos',
                'descripcion'            => 'Tienda en línea para artesanos locales con implementación de pasarelas de pago nacionales.',
                'categoria'              => 'Software',
                'estado'                 => 'aprobado',
                'duracion_estimada_dias' => 100,
                'requisitos_especificos' => 'Entendimiento de flujos de pago y seguridad web.',
                'habilidades_requeridas' => 'Web Development, UX/UI, Pasarelas de Pago',
                'imagen_url'             => 'https://images.unsplash.com/photo-1557821552-17105176677c?q=80&w=800',
            ],
            [
                'titulo'                 => 'Automatización de Procesos con Python',
                'descripcion'            => 'Scripts para automatizar la extracción de datos de reportes Excel y su carga en CRM corporativo.',
                'categoria'              => 'Software',
                'estado'                 => 'aprobado',
                'duracion_estimada_dias' => 30,
                'requisitos_especificos' => 'Dominio de Python (Pandas, Openpyxl).',
                'habilidades_requeridas' => 'Python, Automatización, Ciencia de Datos',
                'imagen_url'             => 'https://images.unsplash.com/photo-1526374965328-7f61d4dc18c5?q=80&w=800',
            ],
            [
                'titulo'                 => 'Modelado 3D para Planta Industrial',
                'descripcion'            => 'Modelado tridimensional de una nueva ala de producción para simulaciones de seguridad y logística.',
                'categoria'              => 'Diseño',
                'estado'                 => 'pendiente',
                'duracion_estimada_dias' => 80,
                'requisitos_especificos' => 'Conocimiento en AutoCAD o Blender.',
                'habilidades_requeridas' => 'Modelado 3D, Planimetría, Renderizado',
                'imagen_url'             => 'https://images.unsplash.com/photo-1581094794329-c8112a89af12?q=80&w=800',
            ],
        ];

        foreach ($projects as $data) {
            DB::table('proyectos')->insertOrIgnore(array_merge($data, [
                'empresa_nit'           => $companyTaxId,
                'instructor_usuario_id' => $instructorUserId,
                'fecha_publicacion'     => Carbon::now()->toDateString(),
                'numero_postulantes'    => 0,
                'created_at'            => now(),
                'updated_at'            => now(),
            ]));
        }

        $this->command->info('✅ 8 Proyectos de ejemplo insertados correctamente.');
    }
}
