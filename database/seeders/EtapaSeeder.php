<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EtapaSeeder extends Seeder
{
    public function run(): void
    {
        $etapas = [
            // Proyecto: Sistema de Gestión de Inventarios Inteligente
            ['proyecto_titulo' => 'Sistema de Gestión de Inventarios Inteligente', 'orden' => 1, 'nombre' => 'Análisis de Requisitos', 'descripcion' => 'Levantamiento de requerimientos funcionales y técnicos con el cliente. Definición de alcance y entregables.'],
            ['proyecto_titulo' => 'Sistema de Gestión de Inventarios Inteligente', 'orden' => 2, 'nombre' => 'Diseño de Base de Datos', 'descripcion' => 'Modelado entidad-relación, definición de esquemas, índices y migraciones en Laravel.'],
            ['proyecto_titulo' => 'Sistema de Gestión de Inventarios Inteligente', 'orden' => 3, 'nombre' => 'Desarrollo del Backend', 'descripcion' => 'Implementación de API REST con Laravel: controladores, servicios, autenticación y lógica de negocio.'],
            ['proyecto_titulo' => 'Sistema de Gestión de Inventarios Inteligente', 'orden' => 4, 'nombre' => 'Desarrollo del Frontend', 'descripcion' => 'Construcción de interfaz de usuario con Vue.js: paneles, tableros y componentes interactivos.'],
            ['proyecto_titulo' => 'Sistema de Gestión de Inventarios Inteligente', 'orden' => 5, 'nombre' => 'Pruebas y Despliegue', 'descripcion' => 'Pruebas unitarias, de integración y despliegue en entorno de producción.'],

            // Proyecto: Campaña de Marketing Digital SENA 2026
            ['proyecto_titulo' => 'Campaña de Marketing Digital SENA 2026', 'orden' => 1, 'nombre' => 'Investigación de Mercado', 'descripcion' => 'Análisis de audiencia, competencia y tendencias. Definición de buyer persona y KPIs.'],
            ['proyecto_titulo' => 'Campaña de Marketing Digital SENA 2026', 'orden' => 2, 'nombre' => 'Creación de Contenido', 'descripcion' => 'Producción de piezas gráficas, copys, videos y material para redes sociales.'],
            ['proyecto_titulo' => 'Campaña de Marketing Digital SENA 2026', 'orden' => 3, 'nombre' => 'Ejecución de Campaña', 'descripcion' => 'Programación y publicación de contenido, configuración de anuncios y segmentación.'],
            ['proyecto_titulo' => 'Campaña de Marketing Digital SENA 2026', 'orden' => 4, 'nombre' => 'Monitoreo y Reportes', 'descripcion' => 'Seguimiento de métricas, análisis de resultados y elaboración de informe final.'],

            // Proyecto: App Móvil para Control de Asistencia
            ['proyecto_titulo' => 'App Móvil para Control de Asistencia', 'orden' => 1, 'nombre' => 'Definición de Alcance', 'descripcion' => 'Especificación de funcionalidades, flujos de usuario y tecnología a utilizar.'],
            ['proyecto_titulo' => 'App Móvil para Control de Asistencia', 'orden' => 2, 'nombre' => 'Prototipado', 'descripcion' => 'Diseño de wireframes y prototipo interactivo en Figma. Validación con el cliente.'],
            ['proyecto_titulo' => 'App Móvil para Control de Asistencia', 'orden' => 3, 'nombre' => 'Desarrollo', 'descripcion' => 'Implementación de la aplicación con Ionic/Flutter. Integración de geolocalización y notificaciones.'],
            ['proyecto_titulo' => 'App Móvil para Control de Asistencia', 'orden' => 4, 'nombre' => 'Testing y Despliegue', 'descripcion' => 'Pruebas funcionales, corrección de errores y publicación en tiendas.'],

            // Proyecto: Automatización de Procesos con Python
            ['proyecto_titulo' => 'Automatización de Procesos con Python', 'orden' => 1, 'nombre' => 'Diagnóstico de Procesos', 'descripcion' => 'Identificación de procesos manuales automatizables y mapeo de flujos de datos.'],
            ['proyecto_titulo' => 'Automatización de Procesos con Python', 'orden' => 2, 'nombre' => 'Desarrollo de Scripts', 'descripcion' => 'Programación de scripts de extracción, transformación y carga (ETL) usando Pandas.'],
            ['proyecto_titulo' => 'Automatización de Procesos con Python', 'orden' => 3, 'nombre' => 'Dashboard de Métricas', 'descripcion' => 'Desarrollo de tablero de visualización con datos en tiempo real.'],

            // Proyecto: Automatización PLC para Línea de Producción
            ['proyecto_titulo' => 'Automatización PLC para Línea de Producción', 'orden' => 1, 'nombre' => 'Ingeniería Básica', 'descripcion' => 'Diagrama de proceso, selección de sensores y actuadores, esquema eléctrico.'],
            ['proyecto_titulo' => 'Automatización PLC para Línea de Producción', 'orden' => 2, 'nombre' => 'Programación PLC', 'descripcion' => 'Desarrollo de lógica de control en ladder/FBD. Configuración de entradas y salidas.'],
            ['proyecto_titulo' => 'Automatización PLC para Línea de Producción', 'orden' => 3, 'nombre' => 'Diseño de HMI', 'descripcion' => 'Interfaz hombre-máquina para monitoreo y control del proceso.'],
            ['proyecto_titulo' => 'Automatización PLC para Línea de Producción', 'orden' => 4, 'nombre' => 'Pruebas y Puesta en Marcha', 'descripcion' => 'Integración, pruebas de funcionamiento y ajustes finales en planta.'],
        ];

        $count = 0;
        foreach ($etapas as $e) {
            $proyectoId = DB::table('proyectos')->where('titulo', $e['proyecto_titulo'])->value('id');
            if (!$proyectoId) continue;

            DB::table('etapas')->insertOrIgnore([
                'proyecto_id' => $proyectoId,
                'orden'       => $e['orden'],
                'nombre'      => $e['nombre'],
                'descripcion' => $e['descripcion'],
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
            $count++;
        }

        $this->command->info($count.' Etapas de ejemplo insertadas correctamente.');
    }
}
