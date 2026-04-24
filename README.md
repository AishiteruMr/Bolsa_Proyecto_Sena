# Bolsa de Proyectos SENA — Modern Edition

Plataforma integral premium para la conexión entre empresas, instructores y aprendices del SENA, mejorada con estándares modernos de seguridad, estabilidad y diseño sobre Laravel 11.x.

---

## Características

* Sistema de roles (Aprendiz, Empresa, Instructor, Administrador)
* Dashboard personalizado por perfil
* Gestión de proyectos y postulaciones
* Sistema de evidencias por etapas
* Notificaciones en tiempo real
* Seguridad avanzada con CSP y protección IDOR
* Diseño Premium Glassmorphism
* API REST para proyectos
* Estadísticas y métricas en tiempo real
* Scroll infinito para listados grandes
* Exportación de datos (Excel/CSV)
* Logging de auditoría completo
* Procesamiento de archivos seguros
* Validación de contraseñas robusta
* Middleware de seguridad personalizados
* Notificaciones por email
* Emails transaccionales
* Middleware de ownership
* Timeout de sesión
* Validación de firma
* Cifrado de cookies

---

## Tecnologías

* PHP 8.4+
* Laravel 11.x
* Vite
* Blade Templates
* MySQL / MariaDB
* PHPMailer
* Pusher

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

# Ejecutar en desarrollo
php artisan serve
npm run dev

# Crear backup manual
php artisan backup:manual

# Ejecutar backup automático
php artisan backup:automatico

# Importar backup
php artisan backup:import nombre_del_archivo.sql

# Listar backups
php artisan backup:list

# Eliminar backup
php artisan backup:delete nombre_del_archivo.sql

```

---

## Uso

1. Accede a `http://localhost:8000` después de ejecutar `php artisan serve`
2. Inicia sesión con las credenciales de prueba

---

## Estructura del proyecto

```bash
app/
├── Http/
│   ├── Controllers/
│   │   ├── Api/
│   │   ├── AprendizController.php
│   │   ├── EmpresaController.php
│   │   ├── InstructorController.php
│   │   ├── AdminController.php
│   │   ├── StatsController.php
│   │   ├── ExportController.php
│   │   └── AuditLogController.php
│   ├── Middleware/
│   │   ├── SecurityHeadersMiddleware.php
│   │   ├── OwnershipMiddleware.php
│   │   ├── SessionTimeout.php
│   │   └── ValidateFileUpload.php
│   └── Requests/
├── Models/
├── Services/
│   ├── ProyectoService.php
│   ├── EvidenciaService.php
│   ├── PostulacionService.php
│   ├── FileProcessingService.php
│   └── AprendizService.php
├── Notifications/
├── Mail/
├── Traits/
├── Providers/
└── Console/Commands/
database/
├── migrations/
└── seeders/
resources/
└── views/
routes/
public/
tests/
```

---

## Notas de Seguridad 

### Autenticación
- Implementar Laravel Fortify para autenticación robusta
- Usar Redis para rate limiting en producción
- Habilitar 2FA para administradores

### Base de Datos
- Usar PostgreSQL en producción para mejor rendimiento
- Configurar read replicas si hay alta carga
- Implementar backup automático

---

## Licencia

Este proyecto está bajo la licencia MIT.