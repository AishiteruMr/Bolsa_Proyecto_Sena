<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $companies = DB::table('empresas')->pluck('correo_contacto', 'nit')->toArray();
        $instructors = DB::table('usuarios')
            ->join('instructores', 'usuarios.id', '=', 'instructores.usuario_id')
            ->pluck('correo', 'usuarios.id')
            ->toArray();
        $instructorEmails = array_values($instructors);

        $projectTemplates = [
            'tecnologia' => [
                ['Sistema de Gestión Empresarial ERP', 'Implementación de un sistema ERP modular con módulos de facturación, inventario, compras y reporting usando Laravel y Livewire.', 'PHP, Laravel, SQL, UI/UX, Trabajo en equipo'],
                ['Plataforma de E-learning con IA', 'Plataforma educativa adaptativa que recomienda contenido según el progreso del aprendiz usando machine learning.', 'Python, Machine Learning, APIs, JavaScript, MongoDB'],
                ['App Móvil de Delivery Local', 'Aplicación híbrida para pedidos de restaurantes locales con geolocalización en tiempo real y pasarela de pagos.', 'Flutter, Firebase, APIs REST, UX/UI, Geolocalización'],
                ['Sistema de Facturación Electrónica', 'Plataforma web para generación y envío de facturas electrónicas con firma digital y validación DIAN.', 'PHP, Laravel, XML, APIs SOAP, Seguridad'],
                ['CRM de Ventas Personalizado', 'Sistema de gestión de relaciones con clientes con pipeline de ventas, reportes y automatización de correos.', 'Laravel, Vue.js, MySQL, APIs REST, Email Marketing'],
                ['Dashboard de Analítica Web', 'Tablero de visualización de datos con gráficos interactivos para métricas de tráfico web y conversiones.', 'Python, Django, Chart.js, SQL, Data Analytics'],
                ['Chatbot de Atención al Cliente', 'Bot conversacional con NLP para resolver dudas frecuentes y escalar casos complejos a agentes humanos.', 'Python, TensorFlow, NLP, APIs, Dialogflow'],
                ['Sistema de Reservas Online', 'Motor de reservas para hoteles y restaurantes con disponibilidad en tiempo real y notificaciones.', 'Vue.js, Laravel, MySQL, WebSockets, UI/UX'],
                ['Marketplace de Servicios Freelance', 'Plataforma que conecta freelancers con clientes, incluye perfiles, contratos y pagos seguros.', 'Laravel, Vue.js, Stripe, SQL, UX/UI'],
                ['Sistema de Control de Versiones Web', 'Herramienta web simplificada para gestión de versiones de documentos colaborativos.', 'JavaScript, Node.js, MongoDB, Git, WebSockets'],
            ],
            'diseño' => [
                ['Identidad Visual para Marca de Café', 'Creación de branding completo para cafetería de especialidad: logo, etiquetas, menú y empaques.', 'Illustrator, Photoshop, Branding, Packaging, Creatividad'],
                ['Diseño de Interfaz para App Financiera', 'UI/UX design para app de finanzas personales con modo oscuro, gráficos y onboarding.', 'Figma, UX Research, Prototyping, Design Systems'],
                ['Catálogo Digital de Productos', 'Diseño y maquetación de catálogo interactivo para tienda de muebles con realidad aumentada.', 'InDesign, Photoshop, AR, Fotografía, Maquetación'],
                ['Manual de Marca Corporativo', 'Creación de guideline completo con aplicaciones en papelería, digital y señalética.', 'Illustrator, Branding, Tipografía, Comunicación Visual'],
            ],
            'marketing' => [
                ['Estrategia de Contenido para Redes Sociales', 'Plan de contenido orgánico y pautado para Instagram, TikTok y LinkedIn con calendario editorial.', 'Copywriting, Analytics, Meta Ads, Creatividad, Video'],
                ['Campaña de Email Marketing Automatizado', 'Setup de secuencias de correos con HubSpot para nurturing de leads y automatización.', 'HubSpot, Copywriting, Analytics, HTML Email, Segmentación'],
                ['SEO Técnico y de Contenido', 'Auditoría SEO completa con recomendaciones técnicas y de contenido para mejorar posicionamiento.', 'SEO, Google Analytics, SEMrush, HTML, Content Strategy'],
                ['Lanzamiento de Producto Digital', 'Estrategia go-to-market para app nueva incluyendo PR, influencers y ads.', 'PR, Community Management, Analytics, Ads, Copywriting'],
            ],
            'comunicacion' => [
                ['Video Corporativo Institucional', 'Producción de video de 8 minutos con entrevistas, tomas corporativas y animación de datos.', 'Edición de Video, Guionismo, Fotografía, Postproducción'],
                ['Podcast Empresarial Serie 8 Episodios', 'Producción completa de podcast con entrevistas a líderes de la industria.', 'Edición de Audio, Guionismo, Entrevistas, Comunicación'],
                ['Newsletter Semanal Corporativa', 'Diseño y redacción de newsletter con curaduría de contenido y métricas de apertura.', 'Copywriting, Email Marketing, Diseño Editorial, Curación'],
            ],
            'ingenieria' => [
                ['Diseño Estructural de Bodega Industrial', 'Planos estructurales y memorias de cálculo para bodega de 2000m2.', 'AutoCAD, Cálculo Estructural, Normas NSR-10, Planimetría'],
                ['Levantamiento Topográfico con Dron', 'Mapeo aéreo de terreno de 5 hectáreas con procesamiento de ortofotos y curvas de nivel.', 'Drones, Fotogrametría, AutoCAD, GIS, Procesamiento'],
                ['Diseño de Red Hidrosanitaria', 'Planos de redes de agua potable y alcantarillado para conjunto residencial.', 'AutoCAD, Hidráulica, Normatividad, PVC, Cálculos'],
            ],
            'electricidad' => [
                ['Diagnóstico Energético Industrial', 'Estudio de eficiencia energética con recomendaciones de ahorro para planta de producción.', 'Eficiencia Energética, Electricidad, Instrumentación, Reportes'],
                ['Diseño de Sistema Fotovoltaico', 'Dimensionamiento e instalación de paneles solares para edificio corporativo de 5 pisos.', 'Energía Solar, Electricidad, Cálculos, Normatividad RETIE'],
                ['Mantenimiento de Subestación Eléctrica', 'Plan de mantenimiento preventivo para subestación de 115kV con protocolos de seguridad.', 'Alta Tensión, Mantenimiento, Seguridad Eléctrica, Normas'],
            ],
            'automatizacion' => [
                ['Control de Temperatura con PLC', 'Sistema automatizado para control de temperatura en horno industrial con PID.', 'PLC, Automatización, PID, HMI, Instrumentación'],
                ['Línea de Ensamble Automatizada', 'Diseño e implementación de línea robótica para ensamble de componentes electrónicos.', 'Robótica, PLC, Neumática, Sensores, Programación'],
                ['SCADA para Planta de Tratamiento', 'Sistema de supervisión y adquisición de datos para PTAR con alarmas y reportes.', 'SCADA, PLC, HMI, Redes Industriales, Base de Datos'],
            ],
            'logistica' => [
                ['Sistema de Gestión de Inventarios WMS', 'Software de warehouse management con códigos de barras y picking optimizado.', 'Logística, Bases de Datos, UI/UX, Códigos de Barras'],
                ['Optimización de Rutas de Delivery', 'Algoritmo genético para optimización de rutas de reparto urbano con restricciones de tiempo.', 'Python, Algoritmos, Logística, Maps API, Data Science'],
                ['Dashboard de Cadena de Suministro', 'Visualización en tiempo real de KPIs de supply chain con alertas predictivas.', 'Power BI, SQL, Logística, DataViz, Python'],
            ],
            'financiero' => [
                ['Sistema de Presupuestos y Proyecciones', 'Herramienta web para elaboración de presupuestos anuales con proyecciones financieras.', 'PHP, Laravel, Finanzas, Excel, SQL'],
                ['Módulo de Conciliación Bancaria', 'Automatización de conciliación bancaria con carga de extractos y detección de diferencias.', 'Python, Pandas, SQL, Finanzas, Automatización'],
                ['Plataforma de Crowdfunding', 'Plataforma de financiación colectiva con perfiles de proyectos y pasarela de pagos.', 'Laravel, Vue.js, Pasarelas de Pago, Seguridad, UX/UI'],
            ],
            'salud' => [
                ['Historia Clínica Electrónica', 'Sistema de historias clínicas digitales con módulo de citas y recetas médicas.', 'PHP, Laravel, SQL, Seguridad, UI/UX'],
                ['App de Telemedicina', 'Aplicación para consultas médicas virtuales con videollamada y recetario digital.', 'Flutter, WebRTC, Firebase, UX/UI, Seguridad'],
            ],
            'educacion' => [
                ['Plataforma de Cursos Virtuales', 'LMS con reproducción de video, evaluaciones, foros y certificados automáticos.', 'Laravel, Vue.js, Video Streaming, SQL, UX/UI'],
                ['Sistema de Gestión Académica', 'Gestión de notas, horarios, asistencias y reportes para instituciones educativas.', 'PHP, Laravel, SQL, Reportes, UI/UX'],
            ],
        ];

        $projectCategories = [
            'tecnologia', 'diseño', 'marketing', 'comunicacion', 'ingenieria',
            'electricidad', 'automatizacion', 'logistica', 'financiero', 'salud', 'educacion',
        ];

        $estados = ['pendiente', 'aprobado', 'rechazado', 'en_progreso', 'completado', 'cerrado'];
        $ofertas = ['contrato_aprendizaje', 'pasantias', 'auxilio_transporte', 'otro', null];

        // Reference date: the app started in early 2024
        $appStartDate = Carbon::create(2024, 2, 1);
        $now = Carbon::now();

        $count = 0;

        foreach ($companies as $nit => $email) {
            $numProjects = rand(3, 7);

            for ($p = 0; $p < $numProjects; $p++) {
                $cat = $projectCategories[array_rand($projectCategories)];
                $template = $projectTemplates[$cat][array_rand($projectTemplates[$cat])];

                $estado = $estados[array_rand($estados)];
                $calidadAprobada = in_array($estado, ['aprobado', 'en_progreso', 'completado', 'cerrado']);
                $asignarInstructor = in_array($estado, ['aprobado', 'en_progreso', 'completado', 'cerrado']);

                $instructorId = null;
                if ($asignarInstructor && count($instructorEmails) > 0) {
                    $instructorEmail = $instructorEmails[array_rand($instructorEmails)];
                    $instructorId = DB::table('usuarios')->where('correo', $instructorEmail)->value('id');
                }

                $oferta = $ofertas[array_rand($ofertas)];

                // Pick a random date between app start and now
                $daysSinceStart = $appStartDate->diffInDays($now);
                $randomDays = rand(0, $daysSinceStart);
                $pubDate = (clone $appStartDate)->addDays($randomDays);
                $createdAt = (clone $pubDate)->subDays(rand(0, 5));

                DB::table('proyectos')->insertOrIgnore([
                    'titulo'                => $template[0],
                    'descripcion'           => $template[1],
                    'categoria'             => $cat,
                    'estado'                => $estado,
                    'calidad_aprobada'      => $calidadAprobada,
                    'duracion_estimada_dias'=> rand(20, 150),
                    'requisitos_especificos'=> 'Conocimientos en ' . explode(',', $template[2])[0] . '. Responsabilidad y trabajo en equipo.',
                    'habilidades_requeridas'=> $template[2],
                    'imagen_url'            => null,
                    'oferta'                => $oferta === 'otro' ? null : $oferta,
                    'oferta_otro'           => $oferta === 'otro' ? 'Bonificación por desempeño' : null,
                    'empresa_nit'           => $nit,
                    'instructor_usuario_id' => $instructorId,
                    'fecha_publicacion'     => $pubDate->toDateString(),
                    'numero_postulantes'    => 0,
                    'created_at'            => $createdAt,
                    'updated_at'            => (clone $createdAt)->addDays(rand(0, 30)),
                ]);
                $count++;
            }
        }

        $this->command->info($count.' Proyectos de ejemplo insertados correctamente.');
    }
}
