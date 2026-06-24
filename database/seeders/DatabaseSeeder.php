<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(RoleSeeder::class);

        $adminRoleId      = DB::table('roles')->where('nombre', 'administrador')->value('id');
        $companyRoleId    = DB::table('roles')->where('nombre', 'empresa')->value('id');
        $instructorRoleId = DB::table('roles')->where('nombre', 'instructor')->value('id');
        $apprenticeRoleId = DB::table('roles')->where('nombre', 'aprendiz')->value('id');

        $credentials = [];

        // ─── Admins (5) ────────────────────────────────────────────
        $admins = [
            ['doc' => 1043277456, 'email' => 'geniszully@gmail.com', 'pass' => 'Admin123@', 'name' => 'Admin', 'last' => 'SENA'],
            ['doc' => 1043277457, 'email' => 'admin.sistema@sena.edu.co', 'pass' => 'Admin123@', 'name' => 'Carlos', 'last' => 'Martínez'],
            ['doc' => 1043277458, 'email' => 'admin.principal@sena.edu.co', 'pass' => 'Admin123@', 'name' => 'María', 'last' => 'González'],
            ['doc' => 1043277459, 'email' => 'admin.soporte@sena.edu.co', 'pass' => 'Admin123@', 'name' => 'Andrés', 'last' => 'López'],
            ['doc' => 1043277460, 'email' => 'admin.bolsa@sena.edu.co', 'pass' => 'Admin123@', 'name' => 'Diana', 'last' => 'Rodríguez'],
        ];
        foreach ($admins as $a) {
            $uid = $this->ensureUser($a['doc'], $a['email'], $a['pass'], $adminRoleId);
            $this->ensureProfile('administradores', ['usuario_id' => $uid, 'nombres' => $a['name'], 'apellidos' => $a['last'], 'activo' => true]);
            $credentials[] = "   -> {$a['email']} / {$a['pass']}";
        }

        // ─── Empresas (75) ─────────────────────────────────────────
        $companies = [
            // Tech & Software
            ['doc' => 12345475784, 'email' => 'camilopineda182@gmail.com', 'pass' => 'Camilo123@', 'name' => 'Cristian Padilla', 'rep' => 'Cristian Padilla', 'contact' => 'camilopineda182@gmail.com', 'loc' => 'Bogotá D.C., Colombia', 'lat' => 4.711, 'lng' => -74.0721],
            ['doc' => 900123456, 'email' => 'contacto@techsolutions.co', 'pass' => 'Empresa123@', 'name' => 'TechSolutions Colombia SAS', 'rep' => 'Roberto Méndez', 'contact' => 'contacto@techsolutions.co', 'loc' => 'Bogotá D.C., Colombia', 'lat' => 4.668, 'lng' => -74.058],
            ['doc' => 900234567, 'email' => 'info@disenastudio.co', 'pass' => 'Empresa123@', 'name' => 'Diseña Estudio Creativo SAS', 'rep' => 'Laura Castillo', 'contact' => 'info@disenastudio.co', 'loc' => 'Medellín, Colombia', 'lat' => 6.247, 'lng' => -75.566],
            ['doc' => 900345678, 'email' => 'proyectos@ingepro.co', 'pass' => 'Empresa123@', 'name' => 'IngePro Ingeniería SAS', 'rep' => 'Pedro Infante', 'contact' => 'proyectos@ingepro.co', 'loc' => 'Cali, Colombia', 'lat' => 3.451, 'lng' => -76.532],
            ['doc' => 900456789, 'email' => 'ventas@softfactory.co', 'pass' => 'Empresa123@', 'name' => 'SoftFactory Colombia SAS', 'rep' => 'Ana María Ruiz', 'contact' => 'ventas@softfactory.co', 'loc' => 'Bogotá D.C., Colombia', 'lat' => 4.691, 'lng' => -74.045],
            ['doc' => 900567890, 'email' => 'info@codecraft.co', 'pass' => 'Empresa123@', 'name' => 'CodeCraft Developers SAS', 'rep' => 'Felipe Aguilar', 'contact' => 'info@codecraft.co', 'loc' => 'Medellín, Colombia', 'lat' => 6.251, 'lng' => -75.573],
            ['doc' => 900678901, 'email' => 'contacto@innovasoft.co', 'pass' => 'Empresa123@', 'name' => 'Innovasoft Solutions SAS', 'rep' => 'Carolina Pardo', 'contact' => 'contacto@innovasoft.co', 'loc' => 'Barranquilla, Colombia', 'lat' => 10.968, 'lng' => -74.781],
            ['doc' => 900789012, 'email' => 'info@webpro.co', 'pass' => 'Empresa123@', 'name' => 'WebPro Agencia Digital SAS', 'rep' => 'Jorge Hernández', 'contact' => 'info@webpro.co', 'loc' => 'Bogotá D.C., Colombia', 'lat' => 4.634, 'lng' => -74.084],
            ['doc' => 900890123, 'email' => 'contacto@datasys.co', 'pass' => 'Empresa123@', 'name' => 'DataSys Analytics SAS', 'rep' => 'Mónica Rincón', 'contact' => 'contacto@datasys.co', 'loc' => 'Cali, Colombia', 'lat' => 3.425, 'lng' => -76.542],
            ['doc' => 900901234, 'email' => 'info@cloudnet.co', 'pass' => 'Empresa123@', 'name' => 'CloudNet Servicios TI SAS', 'rep' => 'Diego Moreno', 'contact' => 'info@cloudnet.co', 'loc' => 'Medellín, Colombia', 'lat' => 6.229, 'lng' => -75.590],
            ['doc' => 901012345, 'email' => 'ventas@bitlogic.co', 'pass' => 'Empresa123@', 'name' => 'BitLogic Software SAS', 'rep' => 'Sandra Vargas', 'contact' => 'ventas@bitlogic.co', 'loc' => 'Bogotá D.C., Colombia', 'lat' => 4.650, 'lng' => -74.065],
            ['doc' => 901123456, 'email' => 'info@nextgen.co', 'pass' => 'Empresa123@', 'name' => 'NextGen Technologies SAS', 'rep' => 'Andrés Torres', 'contact' => 'info@nextgen.co', 'loc' => 'Pereira, Colombia', 'lat' => 4.813, 'lng' => -75.696],
            ['doc' => 901234567, 'email' => 'contacto@devsolutions.co', 'pass' => 'Empresa123@', 'name' => 'DevSolutions Colombia SAS', 'rep' => 'Patricia Jiménez', 'contact' => 'contacto@devsolutions.co', 'loc' => 'Manizales, Colombia', 'lat' => 5.070, 'lng' => -75.520],
            ['doc' => 901345678, 'email' => 'info@cybersec.co', 'pass' => 'Empresa123@', 'name' => 'CyberSec Colombia SAS', 'rep' => 'Mauricio Orozco', 'contact' => 'info@cybersec.co', 'loc' => 'Bogotá D.C., Colombia', 'lat' => 4.675, 'lng' => -74.051],
            ['doc' => 901456789, 'email' => 'ventas@appdev.co', 'pass' => 'Empresa123@', 'name' => 'AppDev Mobile SAS', 'rep' => 'Catalina Suárez', 'contact' => 'ventas@appdev.co', 'loc' => 'Cúcuta, Colombia', 'lat' => 7.894, 'lng' => -72.507],

            // Construction & Engineering
            ['doc' => 901567890, 'email' => 'info@constructoraalfa.co', 'pass' => 'Empresa123@', 'name' => 'Constructora Alfa SAS', 'rep' => 'Luis Fernando Díaz', 'contact' => 'info@constructoraalfa.co', 'loc' => 'Bogotá D.C., Colombia', 'lat' => 4.720, 'lng' => -74.100],
            ['doc' => 901678901, 'email' => 'contacto@obracivil.co', 'pass' => 'Empresa123@', 'name' => 'Obra Civil Ingeniería SAS', 'rep' => 'Humberto Rojas', 'contact' => 'contacto@obracivil.co', 'loc' => 'Medellín, Colombia', 'lat' => 6.267, 'lng' => -75.580],
            ['doc' => 901789012, 'email' => 'info@arquitecton.co', 'pass' => 'Empresa123@', 'name' => 'Arquitectón Diseño y Construcción SAS', 'rep' => 'Fernanda Lozano', 'contact' => 'info@arquitecton.co', 'loc' => 'Cali, Colombia', 'lat' => 3.470, 'lng' => -76.500],
            ['doc' => 901890123, 'email' => 'ventas@construyamos.co', 'pass' => 'Empresa123@', 'name' => 'Construyamos Colombia SAS', 'rep' => 'Óscar Ramírez', 'contact' => 'ventas@construyamos.co', 'loc' => 'Barranquilla, Colombia', 'lat' => 10.990, 'lng' => -74.790],
            ['doc' => 901901234, 'email' => 'info@edificamos.co', 'pass' => 'Empresa123@', 'name' => 'Edificamos Ingeniería SAS', 'rep' => 'Gloria Peña', 'contact' => 'info@edificamos.co', 'loc' => 'Cartagena, Colombia', 'lat' => 10.393, 'lng' => -75.514],

            // Manufacturing & Industrial
            ['doc' => 902012345, 'email' => 'contacto@industriasmetal.co', 'pass' => 'Empresa123@', 'name' => 'Industrias Metalmecánicas SAS', 'rep' => 'Alberto Mendoza', 'contact' => 'contacto@industriasmetal.co', 'loc' => 'Bogotá D.C., Colombia', 'lat' => 4.610, 'lng' => -74.110],
            ['doc' => 902123456, 'email' => 'info@plasticoindustrial.co', 'pass' => 'Empresa123@', 'name' => 'Plásticos Industriales de Colombia SAS', 'rep' => 'Rosa María Duarte', 'contact' => 'info@plasticoindustrial.co', 'loc' => 'Medellín, Colombia', 'lat' => 6.275, 'lng' => -75.560],
            ['doc' => 902234567, 'email' => 'ventas@automatizamos.co', 'pass' => 'Empresa123@', 'name' => 'AutoMatiza Soluciones Industriales SAS', 'rep' => 'Julián Cárdenas', 'contact' => 'ventas@automatizamos.co', 'loc' => 'Cali, Colombia', 'lat' => 3.440, 'lng' => -76.510],
            ['doc' => 902345678, 'email' => 'info@textilescolombia.co', 'pass' => 'Empresa123@', 'name' => 'Textiles Colombia SAS', 'rep' => 'Beatriz Uribe', 'contact' => 'info@textilescolombia.co', 'loc' => 'Medellín, Colombia', 'lat' => 6.240, 'lng' => -75.575],
            ['doc' => 902456789, 'email' => 'contacto@alimentosnutrir.co', 'pass' => 'Empresa123@', 'name' => 'Alimentos Nutrir SAS', 'rep' => 'Ricardo Gómez', 'contact' => 'contacto@alimentosnutrir.co', 'loc' => 'Bogotá D.C., Colombia', 'lat' => 4.695, 'lng' => -74.035],

            // Commerce & Retail
            ['doc' => 902567890, 'email' => 'info@distribuidoramax.co', 'pass' => 'Empresa123@', 'name' => 'Distribuidora Max SAS', 'rep' => 'Lucía Fernández', 'contact' => 'info@distribuidoramax.co', 'loc' => 'Bogotá D.C., Colombia', 'lat' => 4.640, 'lng' => -74.080],
            ['doc' => 902678901, 'email' => 'ventas@comercialplus.co', 'pass' => 'Empresa123@', 'name' => 'Comercial Plus SAS', 'rep' => 'Fernando Herrera', 'contact' => 'ventas@comercialplus.co', 'loc' => 'Medellín, Colombia', 'lat' => 6.230, 'lng' => -75.555],
            ['doc' => 902789012, 'email' => 'info@tiendaselcampo.co', 'pass' => 'Empresa123@', 'name' => 'Tiendas El Campo SAS', 'rep' => 'Ángela Ruiz', 'contact' => 'info@tiendaselcampo.co', 'loc' => 'Pereira, Colombia', 'lat' => 4.820, 'lng' => -75.700],
            ['doc' => 902890123, 'email' => 'contacto@importamos.co', 'pass' => 'Empresa123@', 'name' => 'Importamos Colombia SAS', 'rep' => 'Javier Cantillo', 'contact' => 'contacto@importamos.co', 'loc' => 'Barranquilla, Colombia', 'lat' => 10.950, 'lng' => -74.770],

            // Services & Consulting
            ['doc' => 902901234, 'email' => 'info@consultoriagerencial.co', 'pass' => 'Empresa123@', 'name' => 'Consultoría Gerencial SAS', 'rep' => 'Helena Vargas', 'contact' => 'info@consultoriagerencial.co', 'loc' => 'Bogotá D.C., Colombia', 'lat' => 4.660, 'lng' => -74.060],
            ['doc' => 903012345, 'email' => 'contacto@servicioslegales.co', 'pass' => 'Empresa123@', 'name' => 'Servicios Legales Corporativos SAS', 'rep' => 'Rodrigo Pardo', 'contact' => 'contacto@servicioslegales.co', 'loc' => 'Medellín, Colombia', 'lat' => 6.260, 'lng' => -75.565],
            ['doc' => 903123456, 'email' => 'info@contadoresasociados.co', 'pass' => 'Empresa123@', 'name' => 'Contadores Asociados SAS', 'rep' => 'María Teresa López', 'contact' => 'info@contadoresasociados.co', 'loc' => 'Cali, Colombia', 'lat' => 3.460, 'lng' => -76.520],
            ['doc' => 903234567, 'email' => 'ventas@recursoshumanos.co', 'pass' => 'Empresa123@', 'name' => 'RRHH Integral SAS', 'rep' => 'Daniela Castro', 'contact' => 'ventas@recursoshumanos.co', 'loc' => 'Bogotá D.C., Colombia', 'lat' => 4.680, 'lng' => -74.042],

            // Marketing & Advertising
            ['doc' => 903345678, 'email' => 'info@publicidadcreativa.co', 'pass' => 'Empresa123@', 'name' => 'Publicidad Creativa SAS', 'rep' => 'Esteban Morales', 'contact' => 'info@publicidadcreativa.co', 'loc' => 'Bogotá D.C., Colombia', 'lat' => 4.645, 'lng' => -74.075],
            ['doc' => 903456789, 'email' => 'contacto@agenciamarketing.co', 'pass' => 'Empresa123@', 'name' => 'Agencia Marketing Total SAS', 'rep' => 'Valentina Restrepo', 'contact' => 'contacto@agenciamarketing.co', 'loc' => 'Medellín, Colombia', 'lat' => 6.245, 'lng' => -75.570],
            ['doc' => 903567890, 'email' => 'info@redessocialespro.co', 'pass' => 'Empresa123@', 'name' => 'Redes Sociales Pro SAS', 'rep' => 'Camila Ríos', 'contact' => 'info@redessocialespro.co', 'loc' => 'Cali, Colombia', 'lat' => 3.445, 'lng' => -76.535],
            ['doc' => 903678901, 'email' => 'ventas@brandingstudio.co', 'pass' => 'Empresa123@', 'name' => 'Branding Studio Colombia SAS', 'rep' => 'Tomás Gil', 'contact' => 'ventas@brandingstudio.co', 'loc' => 'Bogotá D.C., Colombia', 'lat' => 4.635, 'lng' => -74.090],

            // Health & Wellness
            ['doc' => 903789012, 'email' => 'info@saludtotal.co', 'pass' => 'Empresa123@', 'name' => 'Salud Total IPS SAS', 'rep' => 'Alejandra Medina', 'contact' => 'info@saludtotal.co', 'loc' => 'Bogotá D.C., Colombia', 'lat' => 4.705, 'lng' => -74.055],
            ['doc' => 903890123, 'email' => 'contacto@bienestarfisico.co', 'pass' => 'Empresa123@', 'name' => 'Bienestar Físico Colombia SAS', 'rep' => 'Santiago Botero', 'contact' => 'contacto@bienestarfisico.co', 'loc' => 'Medellín, Colombia', 'lat' => 6.255, 'lng' => -75.585],
            ['doc' => 903901234, 'email' => 'info@vidasaludable.co', 'pass' => 'Empresa123@', 'name' => 'Vida Saludable SAS', 'rep' => 'Andrea Cardona', 'contact' => 'info@vidasaludable.co', 'loc' => 'Cali, Colombia', 'lat' => 3.465, 'lng' => -76.515],

            // Logistics & Transport
            ['doc' => 904012345, 'email' => 'info@transportesrapidos.co', 'pass' => 'Empresa123@', 'name' => 'Transportes Rápidos SAS', 'rep' => 'Manuel Vega', 'contact' => 'info@transportesrapidos.co', 'loc' => 'Bogotá D.C., Colombia', 'lat' => 4.625, 'lng' => -74.095],
            ['doc' => 904123456, 'email' => 'contacto@logisticaplus.co', 'pass' => 'Empresa123@', 'name' => 'Logística Plus Colombia SAS', 'rep' => 'Paola Santos', 'contact' => 'contacto@logisticaplus.co', 'loc' => 'Barranquilla, Colombia', 'lat' => 10.960, 'lng' => -74.780],
            ['doc' => 904234567, 'email' => 'info@entregasmismo.co', 'pass' => 'Empresa123@', 'name' => 'Entregas Mismo Día SAS', 'rep' => 'Cristian Duque', 'contact' => 'info@entregasmismo.co', 'loc' => 'Medellín, Colombia', 'lat' => 6.235, 'lng' => -75.550],

            // Agriculture & Environment
            ['doc' => 904345678, 'email' => 'info@agrocolombia.co', 'pass' => 'Empresa123@', 'name' => 'AgroColombia SAS', 'rep' => 'Juan Carlos Pérez', 'contact' => 'info@agrocolombia.co', 'loc' => 'Bogotá D.C., Colombia', 'lat' => 4.600, 'lng' => -74.120],
            ['doc' => 904456789, 'email' => 'contacto@ecoverde.co', 'pass' => 'Empresa123@', 'name' => 'EcoVerde Sostenible SAS', 'rep' => 'Diana María Silva', 'contact' => 'contacto@ecoverde.co', 'loc' => 'Manizales, Colombia', 'lat' => 5.075, 'lng' => -75.525],
            ['doc' => 904567890, 'email' => 'info@campocolombiano.co', 'pass' => 'Empresa123@', 'name' => 'Campo Colombiano SAS', 'rep' => 'Héctor Pinto', 'contact' => 'info@campocolombiano.co', 'loc' => 'Pereira, Colombia', 'lat' => 4.830, 'lng' => -75.710],

            // Energy & Utilities
            ['doc' => 904678901, 'email' => 'contacto@energiaslimpias.co', 'pass' => 'Empresa123@', 'name' => 'Energías Limpias Colombia SAS', 'rep' => 'Sebastián Ospina', 'contact' => 'contacto@energiaslimpias.co', 'loc' => 'Cali, Colombia', 'lat' => 3.435, 'lng' => -76.545],
            ['doc' => 904789012, 'email' => 'info@electricaindustrial.co', 'pass' => 'Empresa123@', 'name' => 'Eléctrica Industrial SAS', 'rep' => 'Jorge Luis Ayala', 'contact' => 'info@electricaindustrial.co', 'loc' => 'Bogotá D.C., Colombia', 'lat' => 4.615, 'lng' => -74.115],

            // Education & Training
            ['doc' => 904890123, 'email' => 'info@capacitamos.co', 'pass' => 'Empresa123@', 'name' => 'Capacitamos Colombia SAS', 'rep' => 'Claudia Jiménez', 'contact' => 'info@capacitamos.co', 'loc' => 'Medellín, Colombia', 'lat' => 6.265, 'lng' => -75.560],
            ['doc' => 904901234, 'email' => 'contacto@formacionplus.co', 'pass' => 'Empresa123@', 'name' => 'Formación Plus SAS', 'rep' => 'Luis Eduardo Mora', 'contact' => 'contacto@formacionplus.co', 'loc' => 'Bogotá D.C., Colombia', 'lat' => 4.670, 'lng' => -74.070],

            // Hospitality & Tourism
            ['doc' => 905012345, 'email' => 'info@hotelesbogota.co', 'pass' => 'Empresa123@', 'name' => 'Hoteles Bogotá SAS', 'rep' => 'Martha Cifuentes', 'contact' => 'info@hotelesbogota.co', 'loc' => 'Bogotá D.C., Colombia', 'lat' => 4.710, 'lng' => -74.068],
            ['doc' => 905123456, 'email' => 'contacto@turismocolombia.co', 'pass' => 'Empresa123@', 'name' => 'Turismo Colombia SAS', 'rep' => 'Felipe Rincón', 'contact' => 'contacto@turismocolombia.co', 'loc' => 'Cartagena, Colombia', 'lat' => 10.400, 'lng' => -75.520],
            ['doc' => 905234567, 'email' => 'info@viajesya.co', 'pass' => 'Empresa123@', 'name' => 'Viajes YA SAS', 'rep' => 'Natalia Gómez', 'contact' => 'info@viajesya.co', 'loc' => 'Medellín, Colombia', 'lat' => 6.250, 'lng' => -75.568],

            // Media & Entertainment
            ['doc' => 905345678, 'email' => 'info@produccionesaudiovisuales.co', 'pass' => 'Empresa123@', 'name' => 'Producciones Audiovisuales SAS', 'rep' => 'Camilo Andrés Roa', 'contact' => 'info@produccionesaudiovisuales.co', 'loc' => 'Bogotá D.C., Colombia', 'lat' => 4.648, 'lng' => -74.078],
            ['doc' => 905456789, 'email' => 'contacto@medianet.co', 'pass' => 'Empresa123@', 'name' => 'MediaNet Colombia SAS', 'rep' => 'Katherine Rojas', 'contact' => 'contacto@medianet.co', 'loc' => 'Medellín, Colombia', 'lat' => 6.242, 'lng' => -75.572],

            // Financial Services
            ['doc' => 905567890, 'email' => 'info@financieraplus.co', 'pass' => 'Empresa123@', 'name' => 'Financiera Plus SAS', 'rep' => 'Alberto Camacho', 'contact' => 'info@financieraplus.co', 'loc' => 'Bogotá D.C., Colombia', 'lat' => 4.690, 'lng' => -74.048],
            ['doc' => 905678901, 'email' => 'contacto@segurosconfianza.co', 'pass' => 'Empresa123@', 'name' => 'Seguros Confianza SAS', 'rep' => 'Patricia Amaya', 'contact' => 'contacto@segurosconfianza.co', 'loc' => 'Medellín, Colombia', 'lat' => 6.225, 'lng' => -75.555],

            // More Tech
            ['doc' => 905789012, 'email' => 'info@aitechsolutions.co', 'pass' => 'Empresa123@', 'name' => 'AI Tech Solutions SAS', 'rep' => 'David Guzmán', 'contact' => 'info@aitechsolutions.co', 'loc' => 'Bogotá D.C., Colombia', 'lat' => 4.655, 'lng' => -74.062],
            ['doc' => 905890123, 'email' => 'contacto@blockchaincol.co', 'pass' => 'Empresa123@', 'name' => 'BlockChain Colombia SAS', 'rep' => 'Nicolás Avendaño', 'contact' => 'contacto@blockchaincol.co', 'loc' => 'Medellín, Colombia', 'lat' => 6.238, 'lng' => -75.578],
            ['doc' => 905901234, 'email' => 'info@iotcolombia.co', 'pass' => 'Empresa123@', 'name' => 'IoT Colombia Conectada SAS', 'rep' => 'Verónica Zapata', 'contact' => 'info@iotcolombia.co', 'loc' => 'Cali, Colombia', 'lat' => 3.455, 'lng' => -76.530],
            ['doc' => 906012345, 'email' => 'ventas@roboticasas.co', 'pass' => 'Empresa123@', 'name' => 'Robótica Educativa SAS', 'rep' => 'Óscar David Torres', 'contact' => 'ventas@roboticasas.co', 'loc' => 'Bogotá D.C., Colombia', 'lat' => 4.665, 'lng' => -74.055],
            ['doc' => 906123456, 'email' => 'info@videojuegosdev.co', 'pass' => 'Empresa123@', 'name' => 'VideoJuegos Dev Studio SAS', 'rep' => 'Ana Sofía Londoño', 'contact' => 'info@videojuegosdev.co', 'loc' => 'Medellín, Colombia', 'lat' => 6.253, 'lng' => -75.565],

            // More diverse
            ['doc' => 906234567, 'email' => 'info@ceramicaartesanal.co', 'pass' => 'Empresa123@', 'name' => 'Cerámica Artesanal Colombia SAS', 'rep' => 'María Elena Ortiz', 'contact' => 'info@ceramicaartesanal.co', 'loc' => 'Barranquilla, Colombia', 'lat' => 10.970, 'lng' => -74.775],
            ['doc' => 906345678, 'email' => 'contacto@mueblesfinos.co', 'pass' => 'Empresa123@', 'name' => 'Muebles Finos SAS', 'rep' => 'Carlos Arturo Reyes', 'contact' => 'contacto@mueblesfinos.co', 'loc' => 'Bogotá D.C., Colombia', 'lat' => 4.605, 'lng' => -74.105],
            ['doc' => 906456789, 'email' => 'info@joyeriapremium.co', 'pass' => 'Empresa123@', 'name' => 'Joyería Premium Colombia SAS', 'rep' => 'Tatiana López', 'contact' => 'info@joyeriapremium.co', 'loc' => 'Medellín, Colombia', 'lat' => 6.248, 'lng' => -75.562],
            ['doc' => 906567890, 'email' => 'contacto@bicicletascol.co', 'pass' => 'Empresa123@', 'name' => 'Bicicletas Colombia SAS', 'rep' => 'Andrés Felipe Marín', 'contact' => 'contacto@bicicletascol.co', 'loc' => 'Cali, Colombia', 'lat' => 3.458, 'lng' => -76.525],
            ['doc' => 906678901, 'email' => 'info@cosmeticosnaturales.co', 'pass' => 'Empresa123@', 'name' => 'Cosméticos Naturales SAS', 'rep' => 'Adriana Cruz', 'contact' => 'info@cosmeticosnaturales.co', 'loc' => 'Bogotá D.C., Colombia', 'lat' => 4.685, 'lng' => -74.038],
            ['doc' => 906789012, 'email' => 'ventas@panaderiaindustrial.co', 'pass' => 'Empresa123@', 'name' => 'Panadería Industrial SAS', 'rep' => 'Jorge Enrique Díaz', 'contact' => 'ventas@panaderiaindustrial.co', 'loc' => 'Pereira, Colombia', 'lat' => 4.815, 'lng' => -75.705],
            ['doc' => 906890123, 'email' => 'info@bebidasnaturales.co', 'pass' => 'Empresa123@', 'name' => 'Bebidas Naturales Colombia SAS', 'rep' => 'Lina María García', 'contact' => 'info@bebidasnaturales.co', 'loc' => 'Manizales, Colombia', 'lat' => 5.065, 'lng' => -75.515],
            ['doc' => 906901234, 'email' => 'contacto@empaqueseco.co', 'pass' => 'Empresa123@', 'name' => 'Empaques Ecológicos SAS', 'rep' => 'José Daniel Moreno', 'contact' => 'contacto@empaqueseco.co', 'loc' => 'Bogotá D.C., Colombia', 'lat' => 4.630, 'lng' => -74.100],
            ['doc' => 907012345, 'email' => 'info@autopartescol.co', 'pass' => 'Empresa123@', 'name' => 'Autopartes Colombia SAS', 'rep' => 'Hilda Rincón', 'contact' => 'info@autopartescol.co', 'loc' => 'Medellín, Colombia', 'lat' => 6.272, 'lng' => -75.575],
            ['doc' => 907123456, 'email' => 'contacto@energiasolar.co', 'pass' => 'Empresa123@', 'name' => 'Energía Solar Colombia SAS', 'rep' => 'Luis Carlos Vargas', 'contact' => 'contacto@energiasolar.co', 'loc' => 'Cúcuta, Colombia', 'lat' => 7.880, 'lng' => -72.500],
        ];

        foreach ($companies as $c) {
            $uid = $this->ensureUser($c['doc'], $c['email'], $c['pass'], $companyRoleId);
            $this->ensureProfile('empresas', [
                'nit' => $c['doc'], 'usuario_id' => $uid, 'nombre' => $c['name'],
                'representante' => $c['rep'], 'correo_contacto' => $c['contact'],
                'ubicacion' => $c['loc'], 'latitud' => $c['lat'], 'longitud' => $c['lng'], 'activo' => true,
            ], 'nit');
            $credentials[] = "   -> {$c['email']} / {$c['pass']}";
        }

        // ─── Instructors (50) ──────────────────────────────────────
        $instructorNames = [
            ['n' => 'Sherelyn', 'a' => 'Rocha', 'e' => 'sherelynrocha939@gmail.com', 's' => 'Desarrollo de Software'],
            ['n' => 'Andrea', 'a' => 'Patiño', 'e' => 'andrea.patino@sena.edu.co', 's' => 'Diseño Gráfico'],
            ['n' => 'Carlos', 'a' => 'Mendoza', 'e' => 'carlos.mendoza@sena.edu.co', 's' => 'Redes de Datos'],
            ['n' => 'Roberto', 'a' => 'Vega', 'e' => 'roberto.vega@sena.edu.co', 's' => 'Electricidad Industrial'],
            ['n' => 'Mónica', 'a' => 'Cárdenas', 'e' => 'monica.cardenas@sena.edu.co', 's' => 'Gestión Empresarial'],
            ['n' => 'Fernando', 'a' => 'Giraldo', 'e' => 'fernando.giraldo@sena.edu.co', 's' => 'Programación de Software'],
            ['n' => 'Lucía', 'a' => 'Ramírez', 'e' => 'lucia.ramirez@sena.edu.co', 's' => 'Bases de Datos'],
            ['n' => 'Jorge', 'a' => 'Salcedo', 'e' => 'jorge.salcedo@sena.edu.co', 's' => 'Automatización Industrial'],
            ['n' => 'Patricia', 'a' => 'Londoño', 'e' => 'patricia.londono@sena.edu.co', 's' => 'Marketing Digital'],
            ['n' => 'Alberto', 'a' => 'Castro', 'e' => 'alberto.castro@sena.edu.co', 's' => 'Mecatrónica'],
            ['n' => 'Diana', 'a' => 'Moreno', 'e' => 'diana.moreno@sena.edu.co', 's' => 'Contabilidad'],
            ['n' => 'Héctor', 'a' => 'Santos', 'e' => 'hector.santos@sena.edu.co', 's' => 'Logística'],
            ['n' => 'Gloria', 'a' => 'Peñalosa', 'e' => 'gloria.penalosa@sena.edu.co', 's' => 'Recursos Humanos'],
            ['n' => 'Ricardo', 'a' => 'Álvarez', 'e' => 'ricardo.alvarez@sena.edu.co', 's' => 'Desarrollo Web'],
            ['n' => 'Carolina', 'a' => 'Suárez', 'e' => 'carolina.suarez@sena.edu.co', 's' => 'Diseño de Modas'],
            ['n' => 'Óscar', 'a' => 'Beltrán', 'e' => 'oscar.beltran@sena.edu.co', 's' => 'Seguridad Informática'],
            ['n' => 'Lina', 'a' => 'Medina', 'e' => 'lina.medina@sena.edu.co', 's' => 'Análisis de Datos'],
            ['n' => 'Pedro', 'a' => 'Infante', 'e' => 'pedro.infante@sena.edu.co', 's' => 'Construcción Civil'],
            ['n' => 'Natalia', 'a' => 'Orozco', 'e' => 'natalia.orozco@sena.edu.co', 's' => 'Producción Multimedia'],
            ['n' => 'Mauricio', 'a' => 'Toro', 'e' => 'mauricio.toro@sena.edu.co', 's' => 'Telecomunicaciones'],
            ['n' => 'Adriana', 'a' => 'Rojas', 'e' => 'adriana.rojas@sena.edu.co', 's' => 'Administración'],
            ['n' => 'Daniel', 'a' => 'Cifuentes', 'e' => 'daniel.cifuentes@sena.edu.co', 's' => 'Desarrollo Móvil'],
            ['n' => 'Beatriz', 'a' => 'Nieto', 'e' => 'beatriz.nieto@sena.edu.co', 's' => 'Gestión Documental'],
            ['n' => 'Felipe', 'a' => 'Espitia', 'e' => 'felipe.espitia@sena.edu.co', 's' => 'Electrónica'],
            ['n' => 'Julia', 'a' => 'Parra', 'e' => 'julia.parra@sena.edu.co', 's' => 'Guianza Turística'],
            ['n' => 'Camilo', 'a' => 'Vargas', 'e' => 'camilo.vargas@sena.edu.co', 's' => 'Soldadura'],
            ['n' => 'Marcela', 'a' => 'Ríos', 'e' => 'marcela.rios@sena.edu.co', 's' => 'Panadería'],
            ['n' => 'Rafael', 'a' => 'Camacho', 'e' => 'rafael.camacho@sena.edu.co', 's' => 'Mecánica Dental'],
            ['n' => 'Sandra', 'a' => 'Lara', 'e' => 'sandra.lara@sena.edu.co', 's' => 'Gestión Ambiental'],
            ['n' => 'Hugo', 'a' => 'Córdoba', 'e' => 'hugo.cordoba@sena.edu.co', 's' => 'Maquinaria Pesada'],
            ['n' => 'Elena', 'a' => 'Quintero', 'e' => 'elena.quintero@sena.edu.co', 's' => 'Idiomas'],
            ['n' => 'Iván', 'a' => 'Duarte', 'e' => 'ivan.duarte@sena.edu.co', 's' => 'Metalmecánica'],
            ['n' => 'Rosa', 'a' => 'Mora', 'e' => 'rosa.mora@sena.edu.co', 's' => 'Agroindustria'],
            ['n' => 'Pablo', 'a' => 'Mejía', 'e' => 'pablo.mejia@sena.edu.co', 's' => 'Energía Solar'],
            ['n' => 'Liliana', 'a' => 'Bermúdez', 'e' => 'liliana.bermudez@sena.edu.co', 's' => 'Joyas y Bisutería'],
            ['n' => 'Jairo', 'a' => 'Cortés', 'e' => 'jairo.cortes@sena.edu.co', 's' => 'Refrigeración'],
            ['n' => 'Angélica', 'a' => 'Pineda', 'e' => 'angelica.pineda@sena.edu.co', 's' => 'Fotografía'],
            ['n' => 'Diego', 'a' => 'Rosero', 'e' => 'diego.rosero@sena.edu.co', 's' => 'Redes Eléctricas'],
            ['n' => 'Tatiana', 'a' => 'Cely', 'e' => 'tatiana.cely@sena.edu.co', 's' => 'Mercadeo'],
            ['n' => 'Edwin', 'a' => 'Galindo', 'e' => 'edwin.galindo@sena.edu.co', 's' => 'Mantenimiento Industrial'],
            ['n' => 'Paola', 'a' => 'Rincón', 'e' => 'paola.rincon@sena.edu.co', 's' => 'Calidad'],
            ['n' => 'Gustavo', 'a' => 'Arias', 'e' => 'gustavo.arias@sena.edu.co', 's' => 'Sistemas'],
            ['n' => 'Marisol', 'a' => 'Valencia', 'e' => 'marisol.valencia@sena.edu.co', 's' => 'Biotecnología'],
            ['n' => 'Julián', 'a' => 'Zapata', 'e' => 'julian.zapata@sena.edu.co', 's' => 'Mecánica Automotriz'],
            ['n' => 'Katherine', 'a' => 'Moreno', 'e' => 'katherine.moreno@sena.edu.co', 's' => 'Atención al Cliente'],
            ['n' => 'Leonardo', 'a' => 'Pérez', 'e' => 'leonardo.perez@sena.edu.co', 's' => 'IoT e Industria 4.0'],
            ['n' => 'Fernanda', 'a' => 'Castaño', 'e' => 'fernanda.castano@sena.edu.co', 's' => 'Textiles'],
            ['n' => 'Armando', 'a' => 'Rivas', 'e' => 'armando.rivas@sena.edu.co', 's' => 'Carpintería'],
            ['n' => 'Yenny', 'a' => 'García', 'e' => 'yenny.garcia@sena.edu.co', 's' => 'Cosmetología'],
            ['n' => 'Esteban', 'a' => 'Henao', 'e' => 'esteban.henao@sena.edu.co', 's' => 'Ciberseguridad'],
        ];

        foreach ($instructorNames as $i) {
            $doc = 200000 + count($credentials);
            $uid = $this->ensureUser($doc, $i['e'], 'Instructor123@', $instructorRoleId);
            $this->ensureProfile('instructores', [
                'usuario_id' => $uid, 'nombres' => $i['n'], 'apellidos' => $i['a'],
                'especialidad' => $i['s'], 'activo' => true, 'disponibilidad' => 'disponible',
            ]);
            $credentials[] = "   -> {$i['e']} / Instructor123@";
        }

        // ─── Apprentices / Estudiantes (280) ───────────────────────
        $firstNames = [
            'Carlos', 'María', 'Juan', 'Ana', 'Luis', 'Sofía', 'Diego', 'Valentina', 'Andrés', 'Camila',
            'Jorge', 'Laura', 'Pedro', 'Daniela', 'Felipe', 'Carolina', 'Oscar', 'Natalia', 'Santiago', 'Mariana',
            'Cristian', 'Paola', 'David', 'Alejandra', 'Miguel', 'Andrea', 'Ricardo', 'Lina', 'Javier', 'Isabel',
            'Manuel', 'Gabriela', 'Alberto', 'Juliana', 'Fernando', 'Tatiana', 'Gustavo', 'Viviana', 'Pablo', 'Diana',
            'Sergio', 'Catalina', 'Héctor', 'Rosa', 'Iván', 'Verónica', 'Edwin', 'Gloria', 'Mauricio', 'Lorena',
            'Adrián', 'Manuela', 'Eduardo', 'Angélica', 'José', 'Sara', 'Rafael', 'Yenny', 'Humberto', 'Beatriz',
            'Leonardo', 'Patricia', 'Hugo', 'Lucía', 'Luis Fernando', 'Martha', 'Julián', 'Liliana', 'Alex', 'Claudia',
            'William', 'Mónica', 'Armando', 'Elena', 'Martín', 'Adriana', 'Esteban', 'Nelly', 'Alfonso', 'Ruth',
            'Francisco', 'Mery', 'César', 'Rocío', 'Roberto', 'Amanda', 'Jaime', 'Olga', 'Vicente', 'Esperanza',
        ];

        $lastNames = [
            'García', 'Rodríguez', 'Martínez', 'Hernández', 'López', 'González', 'Pérez', 'Sánchez', 'Ramírez', 'Torres',
            'Flores', 'Rivera', 'Gómez', 'Díaz', 'Moreno', 'Jiménez', 'Ruiz', 'Álvarez', 'Romero', 'Castro',
            'Ortiz', 'Silva', 'Vargas', 'Mendoza', 'Lozano', 'Rincón', 'Pardo', 'Cárdenas', 'Castillo', 'Rojas',
            'Correa', 'Peña', 'Suárez', 'Navarro', 'Giraldo', 'Arias', 'Vega', 'Cruz', 'Cano', 'Medina',
            'Aguilar', 'Mora', 'Valencia', 'Quintero', 'Duarte', 'Salazar', 'Ospina', 'Reyes', 'Maldonado', 'Osorio',
        ];

        $programs = [
            'Análisis y desarrollo de software (ADSO)',
            'Desarrollo web',
            'Bases de datos',
            'Programación de software',
            'Instalaciones eléctricas industriales',
            'Configuración de redes de datos',
            'Electricidad residencial, comercial y de sistemas fotovoltaicos',
            'Gestión empresarial',
            'Contabilidad y finanzas',
            'Diseño gráfico',
            'Marketing digital',
            'Mecatrónica',
            'Automatización industrial',
            'Gestión de recursos humanos',
            'Logística',
            'Administración de empresas',
            'Desarrollo de aplicaciones móviles',
            'Seguridad informática',
            'Análisis de datos',
            'Producción multimedia',
            'Mantenimiento industrial',
            'Soldadura',
            'Mecánica automotriz',
            'Telecomunicaciones',
            'Electrónica',
            'Gestión ambiental',
            'Agroindustria',
            'Guianza turística',
            'Panadería',
            'Construcción civil',
        ];

        $idCounter = 1016555423;
        $estudianteCount = 0;
        for ($i = 0; $i < 280; $i++) {
            $firstName = $firstNames[array_rand($firstNames)];
            $lastName = $lastNames[array_rand($lastNames)];
            $lastName2 = $lastNames[array_rand($lastNames)];
            $program = $programs[array_rand($programs)];
            $docNum = $idCounter + $i;
            $safeEmail = strtolower(str_replace(' ', '', $firstName . '_' . $lastName . $lastName2 . $i . '@soy.sena.edu.co'));
            $pass = 'Aprendiz123@';

            $uid = $this->ensureUser($docNum, $safeEmail, $pass, $apprenticeRoleId);
            $this->ensureProfile('aprendices', [
                'usuario_id' => $uid, 'nombres' => $firstName, 'apellidos' => "$lastName $lastName2",
                'programa_formacion' => $program, 'activo' => true,
            ]);
            $estudianteCount++;
            if ($estudianteCount <= 5) {
                $credentials[] = "   -> {$safeEmail} / {$pass}";
            }
        }

        $this->call(ProjectSeeder::class);
        $this->call(PostulacionSeeder::class);
        $this->call(EtapaSeeder::class);
        $this->call(EvidenciaSeeder::class);
        $this->call(EntregaEtapaSeeder::class);

        $this->command->info('Datos de ejemplo insertados correctamente.');
        foreach ($credentials as $line) {
            $this->command->info($line);
        }
    }

    private function ensureUser($numDoc, $correo, $pass, $rolId): int
    {
        $id = DB::table('usuarios')->where('correo', $correo)->value('id');
        if (!$id) {
            $id = DB::table('usuarios')->insertGetId([
                'numero_documento'  => $numDoc,
                'correo'            => $correo,
                'contrasena'        => Hash::make($pass),
                'rol_id'            => $rolId,
                'email_verified_at' => now(),
                'created_at'        => now(),
                'updated_at'        => now(),
            ]);
        }
        return $id;
    }

    private function ensureProfile(string $table, array $data, string $lookupKey = 'usuario_id'): void
    {
        $value = $data[$lookupKey] ?? null;
        $exists = $value ? DB::table($table)->where($lookupKey, $value)->exists() : false;
        if (!$exists) {
            DB::table($table)->insert(array_merge($data, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
