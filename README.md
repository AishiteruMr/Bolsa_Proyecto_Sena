# 🚀 Bolsa de Proyectos SENA — Modern Edition

Plataforma integral premium para la conexión entre empresas, instructores y aprendices del SENA, mejorada con estándares modernos de seguridad, estabilidad y diseño sobre Laravel 11.x.

---


## ✨ Características

* ✅ Sistema de roles (Aprendiz, Empresa, Instructor, Administrador)
* ✅ Dashboard personalizado por perfil
* ✅ Gestión de proyectos y postulaciones
* ✅ Sistema de evidencias por etapas
* ✅ Notificaciones en tiempo real
* ✅ Seguridad avanzada con CSP y protección IDOR
* ✅ Diseño Premium Glassmorphism

---

## 🛠️ Tecnologías

* PHP 8.4+
* Laravel 11.x
* Vite
* Blade Templates
* MySQL / MariaDB
* PHPMailer
* Pusher

---

## 📦 Instalación

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
```

---

## ▶️ Uso

1. Accede a `http://localhost:8000` después de ejecutar `php artisan serve`
2. Inicia sesión con las credenciales de prueba

---

## 📂 Estructura del proyecto

```bash
app/
 ├── Http/
 ├── Models/
 ├── Providers/
 └── ...
database/
 ├── migrations/
 └── seeders/
resources/
 └── views/
routes/
public/
```

---

## ⚠️ Notas de Seguridad 

### Autenticación
- Implementar Laravel Fortify para autenticación robusta
- Usar Redis para rate limiting en producción
- Habilitar 2FA para administradores

### Base de Datos
- Usar PostgreSQL en producción para mejor rendimiento
- Configurar read replicas si hay alta carga
- Implementar backup automático

---

## 📄 Licencia

Este proyecto está bajo la licencia MIT.

