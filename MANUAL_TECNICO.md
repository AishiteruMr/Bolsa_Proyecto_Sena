# Manual Técnico - Bolsa de Proyectos SENA

## 1. Introducción
Este documento es la referencia técnica para el mantenimiento, desarrollo y despliegue de la plataforma **Bolsa de Proyectos SENA**. El sistema está construido sobre **Laravel 11.x**, aprovechando sus características modernas de seguridad, rendimiento y estructuración de código.

---

## 2. Tecnologías y Stack
*   **Lenguaje:** PHP 8.4+
*   **Framework:** Laravel 11.x
*   **Base de Datos:** MySQL / MariaDB
*   **Frontend:** Vite (compilación de assets), Blade Templates
*   **Servicios:** Pusher (WebSockets/Notificaciones), PHPMailer (transaccional)
*   **Entorno:** Laragon / Docker (recomendado en producción)

---

## 3. Arquitectura del Proyecto

El proyecto implementa un patrón **MVC (Modelo-Vista-Controlador)** robustecido con una **Capa de Servicios (`app/Services/`)** para encapsular la lógica de negocio, manteniendo los controladores delegados únicamente a la gestión de peticiones HTTP.

### 3.1. Estructura de Directorios
```text
app/
├── Http/
│   ├── Controllers/   # Lógica de enrutamiento y respuesta
│   ├── Middleware/    # Filtros de seguridad y autenticación
│   └── Requests/      # Validación de formularios (FormRequests)
├── Models/            # Modelos Eloquent (ORM)
├── Services/          # Capa de lógica de negocio pura
├── Traits/            # Funcionalidades reutilizables
└── ...
database/
├── migrations/        # Esquema de base de datos
└── seeders/           # Datos iniciales y de prueba
resources/
├── css/
├── js/
└── views/             # Blade Templates (Layouts + Componentes)
```

---

## 4. Configuración y Entorno
*   **Variables:** Definidas en el archivo `.env`. Consulte `.env.example` para la lista completa.
*   **Seguridad:** 
    *   `APP_KEY`: Clave única para cifrado.
    *   `DB_*`: Credenciales de base de datos.
    *   `PUSHER_*`: Configuración para notificaciones en tiempo real.

---

## 5. Implementaciones Técnicas Clave

### 5.1. Seguridad
*   **Middleware de Ownership (`OwnershipMiddleware`):** Implementa protección contra ataques IDOR (Insecure Direct Object Reference) verificando que el usuario autenticado posee el recurso que intenta acceder/modificar.
*   **Encabezados de Seguridad (`SecurityHeadersMiddleware`):** Aplica políticas robustas de CSP (Content Security Policy), HSTS, y protección contra XSS/Clickjacking.
*   **Validación de Carga de Archivos (`ValidateFileUpload`):** Middleware especializado en validar mime-types, extensiones y tamaño máximo antes de que el archivo toque el servidor.

### 5.2. Capa de Servicios
La lógica de negocio compleja (ej. creación de un proyecto con sus dependencias, validación de reglas de negocio) se encuentra en `app/Services/`. 
*   **Uso:** Inyecte la clase de servicio en el constructor del controlador.
*   **Ejemplo:** `ProyectoService::crearProyecto($data, $usuario);`

---

## 6. Comandos de Mantenimiento y Artisan
*   **Migraciones:** `php artisan migrate` (ejecutar antes de cambios en esquema).
*   **Caché:** 
    *   `php artisan config:cache` (producción)
    *   `php artisan route:cache` (producción)
    *   `php artisan view:cache` (producción)
*   **Storage:** `php artisan storage:link` (obligatorio tras el despliegue).
*   **Backups:** 
    *   `php artisan backup:manual`: Genera dump SQL cifrado.
    *   `php artisan backup:list`: Lista respaldos disponibles.

---

## 7. Flujos de Desarrollo
### 7.1. Adición de una nueva funcionalidad
1.  **Validación:** Crear `FormRequest` en `app/Http/Requests/`.
2.  **Lógica:** Crear/Actualizar servicio en `app/Services/`.
3.  **Controlador:** Invocar el servicio y manejar la respuesta HTTP.
4.  **Seguridad:** Aplicar middleware de `Ownership` si es un recurso privado.
5.  **UI:** Implementar en Blade usando componentes existentes para mantener la estética Glassmorphism.

### 7.2. Pruebas
Ejecute el suite de pruebas con:
```bash
php artisan test
```

---

## 8. Troubleshooting para Desarrolladores

*   **Error 500:** Revise `storage/logs/laravel.log`.
*   **Assets no cargan:** Ejecute `npm install && npm run dev` o `npm run build` para producción.
*   **Problemas de base de datos:** Verifique los permisos del usuario de base de datos y que las migraciones estén al día (`php artisan migrate:status`).
*   **Notificaciones no llegan:** Verifique la configuración de Pusher en `.env` y el estado del worker de colas (`php artisan queue:work`).
