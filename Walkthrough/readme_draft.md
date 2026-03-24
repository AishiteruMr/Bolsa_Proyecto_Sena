# 🌱 Bolsa de Proyectos SENA — Laravel Edition

Plataforma integral para la conexión entre empresas, instructores y aprendices del SENA, facilitando la gestión de proyectos y el seguimiento de competencias.

---

## 🚀 Descripción
Este proyecto representa la migración completa de una solución robusta desarrollada originalmente en PHP nativo hacia el framework **Laravel 11**. Ofrece un entorno seguro, escalable y eficiente para que las empresas publiquen retos, los aprendices se postulen para aplicar sus conocimientos, y los instructores supervisen el progreso académico.

## 📋 Requisitos del Sistema

| Componente | Versión Mínima |
| :--- | :--- |
| **PHP** | 8.2+ |
| **Composer** | 2.x |
| **MySQL / MariaDB** | 8.0+ |
| **Laravel** | 11.x |

---

## 🛠️ Instalación y Configuración

### 1. Preparar el Entorno
Clona el repositorio y accede a la carpeta del proyecto:
```bash
git clone [url-del-repositorio]
cd Bolsa_Proyecto_Sena
```

### 2. Gestión de Dependencias
Instala las dependencias de PHP y Node.js:
```bash
composer install
npm install
```

### 3. Variables de Entorno
Copia el archivo de ejemplo y genera la clave de la aplicación:
```bash
cp .env.example .env
php artisan key:generate
```
> [!IMPORTANT]
> Configura las credenciales de tu base de datos y servidor de correo en el archivo [.env](file:///c:/laragon/www/Bolsa_Proyecto_Sena/.env).

### 4. Base de Datos
Crea la base de datos y ejecuta las migraciones con los datos iniciales (Seeders):
```bash
php artisan migrate --seed
```

### 5. Almacenamiento y Assets
Enlaza el almacenamiento y compila los archivos frontend:
```bash
php artisan storage:link
npm run build # O npm run dev para desarrollo
```

---

## 👥 Roles y Funcionalidades

### 🏢 Empresas
- Publicación y gestión (CRUD) de proyectos.
- Revisión de postulaciones y selección de aprendices.
- Seguimiento directo de los proyectos activos.

### 🎓 Aprendices
- Búsqueda y postulación a proyectos de interés.
- Carga de evidencias y seguimiento de su proceso formativo.
- Gestión de perfil profesional.

### 👨‍🏫 Instructores
- Supervisión de proyectos asignados.
- Calificación y retroalimentación de evidencias cargadas.
- Generación de reportes de seguimiento.

### 🔐 Administrador
- Control total de usuarios (Aprendices, Empresas, Instructores).
- Validación y activación de cuentas.
- Asignación de instructores a proyectos específicos.

---

## 🗂️ Estructura del Código (Highlights)

- **Controladores**: `app/Http/Controllers/` (Gestión centralizada de lógica).
- **Modelos**: `app/Models/` (Mapeo de base de datos con Eloquent).
- **Vistas**: `resources/views/` (Vistas modulares usando Blade).
- **Seguridad**: `app/Http/Middleware/` (Control de acceso basado en roles).

---

## 🔐 Credenciales de Acceso (Test)

| Perfil | Correo | Contraseña |
| :--- | :--- | :--- |
| **Administrador** | `admin@gmail.com` | `admin123` |

---

## ✅ Características Principales
- [x] Arquitectura MVC modular.
- [x] Sistema de autenticación con roles.
- [x] Carga segura de archivos (evidencias/imágenes).
- [x] Notificaciones por correo electrónico (PHPMailer/Laravel Mail).
- [x] Interfaz responsiva y amigable.
- [x] Paginación y filtrado de datos.
