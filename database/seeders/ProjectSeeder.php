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
        $companyTaxId    = DB::table('empresas')->where('correo_contacto', 'camilopineda182@gmail.com')->value('nit');
        // Obtenemos el usuario_id del instructor demo
        $instructorUserId = DB::table('usuarios')->where('correo', 'sherelynrocha939@gmail.com')->value('id');

$projects = [
            [
                'titulo'                 => 'Sistema de Gestión de Inventarios Inteligente',
                'descripcion'            => 'Desarrollo de una plataforma web para el control de stock en tiempo real utilizando Laravel y Vue.js. El sistema debe incluir alertas de bajo inventario y reportes predictivos con análisis de datos históricos para optimización de compras.',
                'categoria'              => 'tecnologia',
                'estado'                 => 'en_progreso',
                'calidad_aprobada'        => true,
                'duracion_estimada_dias' => 90,
                'requisitos_especificos' => 'Conocimientos en PHP, Laravel, Vue.js y bases de datos relacionales. Experiencia con APIs REST.',
                'habilidades_requeridas' => 'Programación Web, SQL, Trabajo en equipo, Comunicación',
                'imagen_url'             => 'https://images.unsplash.com/photo-1586769852044-692d6e3703f0?q=80&w=800',
            ],
            [
                'titulo'                 => 'Rediseño de Identidad Visual Corporativa',
                'descripcion'            => 'Creación de un manual de identidad corporativa completo, incluyendo logo, paleta de colores, tipografía y aplicaciones en papelería institucional y digital.',
                'categoria'              => 'diseño',
                'estado'                 => 'completado',
                'calidad_aprobada'        => true,
                'duracion_estimada_dias' => 45,
                'requisitos_especificos' => 'Manejo avanzado de Adobe Illustrator, Photoshop eInDesign.',
                'habilidades_requeridas' => 'Diseño Gráfico, Branding, Creatividad, Pensamiento Visual',
                'imagen_url'             => 'https://images.unsplash.com/photo-1572044162444-ad60f128b7fa?q=80&w=800',
            ],
            [
                'titulo'                 => 'Campaña de Marketing Digital SENA 2026',
                'descripcion'            => 'Diseño y ejecución de una estrategia integral de redes sociales para aumentar el engagement en Instagram, LinkedIn y TikTok. includes	content marketing y analytics.',
                'categoria'              => 'marketing',
                'estado'                 => 'en_progreso',
                'calidad_aprobada'        => true,
                'duracion_estimada_dias' => 60,
                'requisitos_especificos' => 'Certificación en Google Ads o Meta Blueprint. Experiencia con herramientas de scheduling.',
                'habilidades_requeridas' => 'Copywriting, Analytics, Estrategia Digital, Creación de Contenido',
                'imagen_url'             => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?q=80&w=800',
            ],
            [
                'titulo'                 => 'App Móvil para Control de Asistencia',
                'descripcion'            => 'Creación de una aplicación móvil híbrida para registro de entrada y salida mediante geolocalización. Incluye módulo de reportes y notificaciones push.',
                'categoria'              => 'tecnologia',
                'estado'                 => 'aprobado',
                'calidad_aprobada'        => true,
                'duracion_estimada_dias' => 120,
                'requisitos_especificos' => 'Experiencia previa con frameworks móviles como Ionic o Flutter.',
                'habilidades_requeridas' => 'Mobile Development, APIs REST, Firebase, Geolocalización',
                'imagen_url'             => 'https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?q=80&w=800',
            ],
            [
                'titulo'                 => 'Documental Institucional "Talento de Oro"',
                'descripcion'            => 'Producción audiovisual de 15 minutos capturando historias de éxito de los aprendices SENA. Incluye entrevistas, grabaciones en locación y postproducción.',
                'categoria'              => 'comunicacion',
                'estado'                 => 'cerrado',
                'calidad_aprobada'        => true,
                'duracion_estimada_dias' => 75,
                'requisitos_especificos' => 'Conocimientos en edición de video (Premiere/DaVinci Resolve) y dirección audiovisual.',
                'habilidades_requeridas' => 'Edición de Video, Fotografía, Narrativa Audiovisual, Dirección',
                'imagen_url'             => 'https://images.unsplash.com/photo-1485846234645-a62644f84728?q=80&w=800',
            ],
            [
                'titulo'                 => 'Plataforma E-commerce para Artesanos',
                'descripcion'            => 'Tienda en línea para artesanos locales con implementación de pasarelas de pago nacionales. Incluye panel de administración y gestión de inventario.',
                'categoria'              => 'tecnologia',
                'estado'                 => 'aprobado',
                'calidad_aprobada'        => true,
                'duracion_estimada_dias' => 100,
                'requisitos_especificos' => 'Entendimiento de flujos de pago y seguridad web. Conocimiento en Laravel o similar.',
                'habilidades_requeridas' => 'Web Development, UX/UI, Pasarelas de Pago, MySQL',
                'imagen_url'             => 'https://images.unsplash.com/photo-1557821552-17105176677c?q=80&w=800',
            ],
            [
                'titulo'                 => 'Automatización de Procesos con Python',
                'descripcion'            => 'Scripts para automatizar la extracción de datos de reportes Excel y su carga en CRM corporativo. Incluye dashboard de métricas.',
                'categoria'              => 'tecnologia',
                'estado'                 => 'aprobado',
                'calidad_aprobada'        => true,
                'duracion_estimada_dias' => 30,
                'requisitos_especificos' => 'Dominio de Python con librerías Pandas y Openpyxl.',
                'habilidades_requeridas' => 'Python, Automatización, Ciencia de Datos, Excel Avanzado',
                'imagen_url'             => 'https://images.unsplash.com/photo-1526374965328-7f61d4dc18c5?q=80&w=800',
            ],
            [
                'titulo'                 => 'Modelado 3D para Planta Industrial',
                'descripcion'            => 'Modelado tridimensional de una nueva ala de producción para simulaciones de seguridad y logística interna. Include renderizados y walkthrough virtual.',
                'categoria'              => 'ingenieria',
                'estado'                 => 'pendiente',
                'calidad_aprobada'        => false,
                'duracion_estimada_dias' => 80,
                'requisitos_especificos' => 'Conocimiento en AutoCAD 3D o Blender avanzado.',
                'habilidades_requeridas' => 'Modelado 3D, Planimetría, Renderizado, Visualización',
                'imagen_url'             => 'https://images.unsplash.com/photo-1581094794329-c8112a89af12?q=80&w=800',
            ],
            [
                'titulo'                 => 'Sistema de Gestión de Pedidos Restaurant',
                'descripcion'            => 'App web para toma de pedidos en restaurantes con cocina digital y tracking de delivery.',
                'categoria'              => 'tecnologia',
                'estado'                 => 'pendiente',
                'calidad_aprobada'        => false,
                'duracion_estimada_dias' => 60,
                'requisitos_especificos' => 'Conocimientos en Laravel y SQLite.',
                'habilidades_requeridas' => 'Desarrollo Web, UI/UX',
            ],
            [
                'titulo'                 => 'SEO y Posicionamiento Web',
                'descripcion'            => 'Optimización SEO del sitio actual con auditoría técnica y contenido.',
                'categoria'              => 'marketing',
                'estado'                 => 'rechazado',
                'calidad_aprobada'        => false,
                'duracion_estimada_dias' => 30,
                'requisitos_especificos' => 'Experiencia comprobable en SEO.',
                'habilidades_requeridas' => 'SEO, Google Analytics',
            ],
            [
                'titulo'                 => 'Portal de Cursos Online',
                'descripcion'            => 'Plataforma de formación virtual con vidéos y evaluaciones.',
                'categoria'              => 'tecnologia',
                'estado'                 => 'pendiente',
                'calidad_aprobada'        => false,
                'duracion_estimada_dias' => 90,
            ],
        ];

        foreach ($projects as $data) {
            $estado = $data['estado'];
            $asignarInstructor = in_array($estado, ['aprobado', 'en_progreso', 'completado', 'cerrado']);
            
            DB::table('proyectos')->insertOrIgnore(array_merge($data, [
                'empresa_nit'           => $companyTaxId,
                'instructor_usuario_id' => $asignarInstructor ? $instructorUserId : null,
                'fecha_publicacion'     => Carbon::now()->toDateString(),
                'numero_postulantes'    => 0,
                'created_at'            => now(),
                'updated_at'            => now(),
            ]));
        }

        $this->command->info('✅ '.count($projects).' Proyectos de ejemplo insertados correctamente.');
    }
}
