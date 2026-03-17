# 🌱 Bolsa de Proyectos SENA — Migración a Laravel

Migración completa del proyecto PHP nativo a **Laravel 11**.

---

## 📋 Requisitos

| Herramienta | Versión mínima |
|-------------|----------------|
| PHP         | 8.2+           |
| Composer    | 2.x            |
| MySQL       | 8.0+           |
| Laravel     | 11.x           |

---

## 🚀 Instalación

### 1. Clonar / copiar el proyecto
```bash
cp -r bolsa-proyectos/ /var/www/
cd /var/www/bolsa-proyectos
```

### 2. Instalar dependencias
```bash
composer install
```

### 3. Configurar entorno
```bash
cp .env.example .env
php artisan key:generate
```

Editar `.env` con tus datos de base de datos y correo:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bolsa_de_proyectos
DB_USERNAME=root
DB_PASSWORD=

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=bolsadeproyectossena@gmail.com
MAIL_PASSWORD=qanh_ojlq_cwxi_oodu
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=bolsadeproyectossena@gmail.com
MAIL_FROM_NAME="Bolsa de Proyecto SENA"
```

### 4. Crear la base de datos y ejecutar migraciones
```bash
# Crear base de datos en MySQL
mysql -u root -p -e "CREATE DATABASE bolsa_de_proyectos CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# Ejecutar migraciones + seeders
php artisan migrate --seed
```

> **Nota:** Si ya tienes la base de datos del proyecto anterior (`bolsa_de_proyectos.sql`), puedes importarla directamente:
> ```bash
> mysql -u root -p bolsa_de_proyectos < bolsa_de_proyectos.sql
> ```
> En ese caso, **omite el paso de migraciones** y solo ejecuta `php artisan key:generate`.

### 5. Enlace de almacenamiento (para imágenes de proyectos)
```bash
php artisan storage:link
```

### 6. Iniciar servidor de desarrollo
```bash
php artisan serve
```
Acceder en: `http://localhost:8000`

---

## 🗂️ Estructura del Proyecto Laravel

```
bolsa-proyectos/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php         ← Login, Logout, Registro
│   │   │   ├── AprendizController.php     ← Dashboard, proyectos, postulaciones
│   │   │   ├── EmpresaController.php      ← Gestión de proyectos empresa
│   │   │   ├── InstructorController.php   ← Panel instructor
│   │   │   └── AdminController.php        ← Panel administrador
│   │   └── Middleware/
│   │       ├── AuthMiddleware.php         ← Verifica sesión activa
│   │       └── RolMiddleware.php          ← Verifica rol del usuario
│   └── Mail/
│       └── RegistroExitoso.php            ← Correo de bienvenida
├── database/
│   ├── migrations/                        ← Tablas completas de BD
│   └── seeders/DatabaseSeeder.php         ← Datos iniciales (admin)
├── resources/views/
│   ├── layouts/
│   │   ├── app.blade.php                  ← Layout público
│   │   └── dashboard.blade.php            ← Layout con sidebar
│   ├── auth/                              ← Login y registros
│   ├── aprendiz/                          ← Vistas aprendiz
│   ├── empresa/                           ← Vistas empresa
│   ├── instructor/                        ← Vistas instructor
│   ├── admin/                             ← Panel administración
│   ├── emails/                            ← Plantilla correo
│   ├── index.blade.php                    ← Página principal
│   └── nosotros.blade.php                 ← Página nosotros
└── routes/web.php                         ← Todas las rutas
```

---

## 🔄 Equivalencia PHP nativo → Laravel

| PHP Nativo | Laravel |
|------------|---------|
| `Conexion.php` | `config/database.php` + `.env` |
| `Login.php` | `AuthController::login()` |
| `Registro.php` | `AuthController::registrarAprendiz/Instructor/Empresa()` |
| `mail.php` + PHPMailer | `App\Mail\RegistroExitoso` + `Mail::to()->send()` |
| `$_SESSION[...]` | `session([...])` / `session('clave')` |
| `$_POST[...]` | `$request->input('campo')` |
| `$conexion->prepare(...)` | `DB::table('tabla')->...` |
| `password_hash(...)` | `Hash::make(...)` |
| `password_verify(...)` | `Hash::check(...)` |
| `header("Location: ...")` | `redirect()->route('nombre')` |
| HTML/PHP mezclado | Blade templates (`@if`, `@foreach`, `{{ }}`) |
| Rutas manuales por archivos | `routes/web.php` con `Route::get/post/put/delete` |

---

## 🔐 Credenciales de prueba (después del seeder)

| Rol | Correo | Contraseña |
|-----|--------|------------|
| Administrador | admin@gmail.com | admin123 |

Los demás usuarios se crean a través del formulario de registro.

---

## 📧 Configuración de correo (Gmail)

1. Activar verificación en 2 pasos en tu cuenta Gmail.
2. Ir a **Seguridad → Contraseñas de aplicaciones**.
3. Generar una nueva contraseña de aplicación.
4. Pegar en `.env`:
```env
MAIL_USERNAME=tucorreo@gmail.com
MAIL_PASSWORD=xxxx_xxxx_xxxx_xxxx
```

---

## ✅ Funcionalidades implementadas

- [x] Autenticación con sesiones (login / logout)
- [x] Registro de Aprendiz, Instructor y Empresa
- [x] Middleware de autenticación y control de roles
- [x] Dashboard por rol (Aprendiz, Empresa, Instructor, Admin)
- [x] CRUD de proyectos (Empresa)
- [x] Postulación a proyectos (Aprendiz)
- [x] Gestión de postulaciones (Empresa)
- [x] Panel de administración (usuarios, empresas, proyectos)
- [x] Envío de correo de bienvenida (Mailable + Blade)
- [x] Migraciones completas de base de datos
- [x] Seeder con datos iniciales
- [x] Validaciones con mensajes en español
- [x] Upload de imágenes (proyectos)
- [x] Paginación de resultados
