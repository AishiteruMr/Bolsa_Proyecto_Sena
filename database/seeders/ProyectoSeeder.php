<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProyectoSeeder extends Seeder
{
    public function run(): void
    {
        $emp_nit = 12345475784;
        $ins_doc = 3;

        $proyectos = [
            [
                'pro_titulo_proyecto' => 'Sistema de Gestión de Inventarios Inteligente',
                'pro_descripcion' => 'Desarrollo de una plataforma web para el control de stock en tiempo real utilizando Laravel y Vue.js. El sistema debe incluir alertas de bajo inventario y reportes predictivos.',
                'pro_categoria' => 'Software',
                'pro_estado' => 'Activo',
                'pro_duracion_estimada' => 90,
                'pro_requisitos_especificos' => 'Conocimientos en PHP, Laravel, y bases de datos relacionales.',
                'pro_habilidades_requerida' => 'Programación Web, SQL, Trabajo en equipo',
                'pro_imagen_url' => 'https://images.unsplash.com/photo-1586769852044-692d6e3703f0?q=80&w=800',
            ],
            [
                'pro_titulo_proyecto' => 'Rediseño de Identidad Visual Corp',
                'pro_descripcion' => 'Creación de un manual de identidad corporativa completo, incluyendo logo, paleta de colores, tipografía y aplicaciones en papelería para una empresa de tecnología.',
                'pro_categoria' => 'Diseño',
                'pro_estado' => 'Activo',
                'pro_duracion_estimada' => 45,
                'pro_requisitos_especificos' => 'Manejo avanzado de Adobe Illustrator y Photoshop.',
                'pro_habilidades_requerida' => 'Diseño Gráfico, Branding, Creatividad',
                'pro_imagen_url' => 'https://images.unsplash.com/photo-1572044162444-ad60f128b7fa?q=80&w=800',
            ],
            [
                'pro_titulo_proyecto' => 'Campaña de Marketing Digital "SENA 2026"',
                'pro_descripcion' => 'Diseño y ejecución de una estrategia de redes sociales para aumentar el engagement en Instagram y LinkedIn. Incluye pauta digital y creación de contenido.',
                'pro_categoria' => 'Marketing',
                'pro_estado' => 'Activo',
                'pro_duracion_estimada' => 60,
                'pro_requisitos_especificos' => 'Certificación en Google Ads o Meta Blueprint preferible.',
                'pro_habilidades_requerida' => 'Copywriting, Analytics, Estrategia Digital',
                'pro_imagen_url' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?q=80&w=800',
            ],
            [
                'pro_titulo_proyecto' => 'App Móvil para Control de Asistencia',
                'pro_descripcion' => 'Creación de una aplicación móvil híbrida (Flutter/React Native) para que el personal pueda registrar su entrada y salida mediante geolocalización.',
                'pro_categoria' => 'Software',
                'pro_estado' => 'Activo',
                'pro_duracion_estimada' => 120,
                'pro_requisitos_especificos' => 'Experiencia previa con frameworks móviles.',
                'pro_habilidades_requerida' => 'Mobile Development, APIs REST, Firebase',
                'pro_imagen_url' => 'https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?q=80&w=800',
            ],
            [
                'pro_titulo_proyecto' => 'Documental Institucional "Talento de Oro"',
                'pro_descripcion' => 'Producción audiovisual de 15 minutos capturando las historias de éxito de los aprendices SENA en la industria. Requiere pre-producción, rodaje y edición.',
                'pro_categoria' => 'Media',
                'pro_estado' => 'Activo',
                'pro_duracion_estimada' => 75,
                'pro_requisitos_especificos' => 'Conocimientos en edición de video (Premiere/DaVinci Resolve).',
                'pro_habilidades_requerida' => 'Edición de Video, Fotografía, Narrativa Audiovisual',
                'pro_imagen_url' => 'https://images.unsplash.com/photo-1485846234645-a62644f84728?q=80&w=800',
            ],
            [
                'pro_titulo_proyecto' => 'Plataforma E-commerce para Artesanos',
                'pro_descripcion' => 'Desarrollo de una tienda en línea para que artesanos locales puedan vender sus productos a nivel nacional. Implementación de pasarelas de pago.',
                'pro_categoria' => 'Software',
                'pro_estado' => 'Activo',
                'pro_duracion_estimada' => 100,
                'pro_requisitos_especificos' => 'Entendimiento de flujos de pago y seguridad web.',
                'pro_habilidades_requerida' => 'Web Development, UX/UI, Pasarelas de Pago',
                'pro_imagen_url' => 'https://images.unsplash.com/photo-1557821552-17105176677c?q=80&w=800',
            ],
            [
                'pro_titulo_proyecto' => 'Automatización de Procesos con Python',
                'pro_descripcion' => 'Creación de scripts para automatizar la extracción de datos de reportes Excel y su carga en CRM corporativo.',
                'pro_categoria' => 'Software',
                'pro_estado' => 'Activo',
                'pro_duracion_estimada' => 30,
                'pro_requisitos_especificos' => 'Dominio de Python (Pandas, Openpyxl).',
                'pro_habilidades_requerida' => 'Python, Automatización, Ciencia de Datos',
                'pro_imagen_url' => 'https://images.unsplash.com/photo-1526374965328-7f61d4dc18c5?q=80&w=800',
            ],
            [
                'pro_titulo_proyecto' => 'Modelado 3D para Planta Industrial',
                'pro_descripcion' => 'Modelado tridimensional de la nueva ala de producción para simulaciones de seguridad y eficiencia logística.',
                'pro_categoria' => 'Diseño',
                'pro_estado' => 'Activo',
                'pro_duracion_estimada' => 80,
                'pro_requisitos_especificos' => 'Conocimiento en AutoCAD o Blender.',
                'pro_habilidades_requerida' => 'Modelado 3D, Planimetría, Renderizado',
                'pro_imagen_url' => 'https://images.unsplash.com/photo-1581094794329-c8112a89af12?q=80&w=800',
            ],
        ];

        foreach ($proyectos as $data) {
            DB::table('proyecto')->insertOrIgnore(array_merge($data, [
                'emp_nit' => $emp_nit,
                'ins_usr_documento' => $ins_doc,
                'pro_fecha_publi' => Carbon::now(),
                'pro_fecha_finalizacion' => Carbon::now()->addDays($data['pro_duracion_estimada'] + 7),
                'pro_num_postulantes' => 0,
            ]));
        }

        $this->command->info('    8 Proyectos de ejemplo insertados correctamente.');
    }
}
