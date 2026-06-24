# Bolsa de Proyectos SENA — Modern Edition

Plataforma integral premium para la conexión entre empresas, instructores y aprendices del SENA, mejorada con estándares modernos de seguridad, estabilidad y diseño sobre Laravel 11.x.

---

## Características

* Sistema de roles (Aprendiz, Empresa, Instructor, Administrador)
* Dashboard personalizado por perfil
* Gestión de proyectos y postulaciones
* Sistema de evidencias por etapas
* Notificaciones en tiempo real (Pusher + Laravel Echo)
* Seguridad avanzada con CSP, protección IDOR, y middleware de ownership
* Diseño Premium Glassmorphism
* API REST para proyectos
* Estadísticas y métricas en tiempo real (Chart.js)
* Scroll infinito para listados grandes
* Exportación de datos (CSV)
* Logging de auditoría completo
* Procesamiento de archivos seguros (validación MIME, magic bytes, malware scan)
* Validación de contraseñas robusta
* Middleware de seguridad personalizados
* Notificaciones por email (SMTP + queue)
* Emails transaccionales (bienvenida, OTP, recuperación, postulación, etapas)
* Verificación de email con OTP
* Sistema de soporte con tickets y respuestas
* Backup de base de datos (manual y automático)
* Auditoría de seguridad automatizada (audit probe)
* Monitoreo y recuperación de colas (queue:auto-recover)
* Programador de tareas (scheduler) con scripts PowerShell
* Generación de tests automáticos desde rutas
* Timeout de sesión (configurable por rol)
* Validación de firma en URLs
* Cifrado de cookies
* Gestión de consentimiento de datos
* Carga de metodología y documentos por empresa
* Asignación de instructores a proyectos
* Calificación de evidencias por instructores
* Reportes de seguimiento por proyecto

---

## Tecnologías

* PHP 8.4+
* Laravel 11.x
* Laravel Sanctum (autenticación API)
* Laravel Reverb (WebSocket server)
* Vite 8.x
* Blade Templates
* MySQL / MariaDB
* PHPMailer 6.x
* Pusher (WebSockets)
* Laravel Echo
* Chart.js 4.x
* Axios
* Intervention Image 3.x
* Resend (email API)
* PHPUnit 11.x

---

## Instalación

```bash
# Clonar repositorio
git clone https://github.com/AishiteruMr/Bolsa_Proyecto_Sena.git

# Entrar a la carpeta
cd Bolsa_Proyecto_Sena

# Instalar dependencias PHP
composer install

# Instalar dependencias Node
npm install

# Copiar archivo de entorno
cp .env.example .env

# Generar clave de aplicación
php artisan key:generate

# Crear enlace simbólico para storage
php artisan storage:link

# Ejecutar migrate y seed
php artisan migrate --seed

# Compilar assets
npm run build

# Ejecutar en desarrollo
php artisan serve
npm run dev

# Limpiar cache, configuraciones, views y rutas
php artisan optimize:clear
```

---

## Comandos disponibles

### Backups
```bash
# Crear backup manual
php artisan backup:manual

# Ejecutar backup automático (programado cada 10 días)
php artisan backup:automatico

# Importar backup
php artisan backup:import nombre_del_archivo.sql

# Listar backups
php artisan backup:list

# Eliminar backup
php artisan backup:delete nombre_del_archivo.sql
```

### Colas (Queue)
```bash
# Procesar cola en segundo plano
php artisan queue:work

# Verificar estado de la cola
php artisan queue:check

# Monitorear salud de la cola
php artisan queue:monitor

# Reintentar trabajos fallidos
php artisan queue:retry-failed

# Auto-recuperación de colas fallidas
php artisan queue:auto-recover
```

### Auditoría y seguridad
```bash
# Escanear rutas y middleware
php artisan audit:middleware-scan

# Listar todas las rutas con sus middleware
php artisan audit:routes

# Generar tests automáticos desde rutas
php artisan audit:generate-tests

# Ejecutar probe de seguridad
php artisan guard:probe

# Escanear policies y gates
php artisan audit:auth-scan

# Actualizar contraseña admin
php artisan app:update-admin-password
```

### Mantenimiento
```bash
# Limpiar datos expirados (tokens, sesiones, logs)
php artisan app:cleanup-expired

# Optimizar tablas de base de datos
php artisan app:optimize-database

# Pruebas de correo
php artisan mail:test-send
php artisan mail:test-complete
```

---

## Scripts de administración (PowerShell)

```powershell
# Iniciar worker de colas con reinicio automático
.\scripts\start-worker.ps1

# Verificar estado de colas
.\scripts\queue-status.ps1

# Iniciar scheduler
.\scripts\start-scheduler.ps1
```

---

## Tareas programadas

| Tarea | Frecuencia |
|-------|-----------|
| `backup:automatico` | Cada 10 días a las 2:00 AM |
| `guard:probe` | Lunes a las 8:00 AM |
| `app:cleanup-expired` | Diario a las 3:00 AM |
| `app:optimize-database` | Domingos a las 4:00 AM |
| `queue:auto-recover` | Cada 30 minutos |
| `queue:monitor` | Cada hora |

---

## Uso

1. Accede a `http://localhost:8000` después de ejecutar `php artisan serve`
2. Inicia sesión con las credenciales de prueba (`admin@gmail.com` / `adminSena2026`)

---

## Testing

```bash
# Ejecutar pruebas unitarias y funcionales
php artisan test

# Ejecutar con output detallado
vendor\bin\phpunit --testdox 2>&1
```

---

## Roles del sistema

| Rol | ID | Descripción |
|-----|----|-------------|
| Aprendiz | 1 | Visualiza proyectos, se postula, envía evidencias |
| Instructor | 2 | Gestiona proyectos asignados, crea etapas, califica evidencias |
| Empresa | 3 | Publica proyectos, gestiona postulaciones, ve reportes |
| Administrador | 4 | Gestiona usuarios, empresas, proyectos, soporte, backups |

---

## Estructura del proyecto

```bash
app/
├── Console/Commands/          # Comandos Artisan personalizados
│   ├── BackupAutomatico.php
│   ├── CleanupExpiredData.php
│   ├── OptimizeDatabase.php
│   ├── UpdateAdminPassword.php
│   ├── SendTestEmail.php / SendCompleteTestEmail.php
│   ├── CheckQueue.php / QueueMonitorCommand.php
│   ├── QueueRetryFailedCommand.php / QueueAutoRecover.php
│   ├── MiddlewareScannerCommand.php
│   ├── AuditRoutesCommand.php
│   ├── AuditTestGeneratorCommand.php
│   ├── AuditProbeCommand.php
│   └── AuditAuthScannerCommand.php
├── Events/                    # Eventos con broadcast en tiempo real
│   ├── NotificacionEnviada.php
│   ├── PostulacionEvent.php / ProyectoEvent.php
│   ├── EvidenciaEvent.php / EtapaEvent.php
│   ├── SoporteEvent.php / NuevoUsuarioEvent.php
│   └── AuditLogEvent.php
├── Exceptions/
│   └── Handler.php
├── Http/
│   ├── Controllers/
│   │   ├── Api/
│   │   │   └── ProyectoApiController.php
│   │   ├── AdminController.php
│   │   ├── AprendizController.php
│   │   ├── AuditLogController.php
│   │   ├── AuthController.php
│   │   ├── BackupController.php
│   │   ├── DashboardController.php
│   │   ├── EmpresaController.php
│   │   ├── ExportController.php
│   │   ├── FileController.php
│   │   ├── HomeController.php
│   │   ├── InfiniteScrollController.php
│   │   ├── InstructorController.php
│   │   ├── NotificacionController.php
│   │   ├── SoporteController.php
│   │   └── StatsController.php
│   ├── Middleware/
│   │   ├── AuthMiddleware.php          # auth.custom
│   │   ├── RolMiddleware.php           # rol
│   │   ├── OwnershipMiddleware.php     # ownership (protección IDOR)
│   │   ├── SecurityHeadersMiddleware.php
│   │   ├── SessionTimeout.php
│   │   └── ValidateFileUpload.php
│   └── Requests/               # 11 Form Requests de validación
├── Helpers/
│   └── helpers.php             # Funciones globales de sesión
├── Http/
├── Jobs/                       # Trabajos encolados
│   ├── SendNotificationJob.php
│   ├── SendEmailJob.php
│   ├── ProcessPostulacionJob.php
│   ├── ProcessBackupJob.php
│   ├── OptimizeDatabaseJob.php
│   ├── CleanupExpiredDataJob.php
│   └── GenerateReportJob.php
├── Mail/                       # 12 Mailable classes
├── Models/                     # 14 Modelos
├── Notifications/              # 4 Notificaciones
├── Providers/                  # 5 Proveedores
├── Services/                   # 7 Servicios
│   ├── ProyectoService.php
│   ├── EvidenciaService.php
│   ├── PostulacionService.php
│   ├── FileProcessingService.php
│   ├── AprendizService.php
│   ├── PerfilService.php
│   └── PasswordValidationService.php
└── Traits/
    ├── ValidacionMensajes.php
    └── PaginacionTrait.php
database/
├── migrations/                 # 27 migraciones
├── seeders/                    # 5 seeders
└── factories/
resources/
├── views/                      # 60+ vistas Blade
│   ├── layouts/
│   ├── auth/
│   ├── admin/
│   ├── aprendiz/
│   ├── empresa/
│   ├── instructor/
│   ├── emails/                 # 15 plantillas de email
│   ├── partials/
│   ├── shared/
│   └── errors/
├── css/                        # 14 archivos CSS
└── js/                         # 9 archivos JS
routes/
├── web.php                     # ~100 rutas web
├── api.php                     # Ruta API con Sanctum
├── channels.php                # 5 canales de broadcast
└── console.php
tests/
├── Unit/
├── Feature/                    # 10 archivos de test
└── TestCase.php
scripts/                        # Scripts PowerShell
config/                         # 18 archivos de configuración
public/
```

---

## Licencia

Este proyecto está bajo la licencia MIT.
