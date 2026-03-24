# 🌱 Bolsa de Proyectos SENA — Modern Edition

Plataforma integral premium para la conexión entre empresas, instructores y aprendices del SENA, mejorada con estándares modernos de seguridad, estabilidad y diseño sobre **Laravel 11.x**.

---

## 🚀 Descripción General
Este proyecto es una evolución técnica de alto impacto. No solo se trata de una migración funcional, sino de una modernización completa enfocada en la robustez, la seguridad proactiva y una experiencia de usuario de nivel empresarial.

## 🛡️ Hardening de Seguridad
La plataforma ha sido blindada contra amenazas comunes mediante:
- **Content Security Policy (CSP):** Control estricto de recursos para prevenir XSS y Clickjacking via `SecurityHeadersMiddleware`.
- **Session Hardening:** Configuración de cookies con atributos `Secure`, `HttpOnly` y `SameSite=Lax`.
- **Protección IDOR:** Validación de propiedad en todos los flujos críticos de proyectos y postulaciones.
- **Middleware de Roles:** Control de acceso granular que garantiza que cada usuario solo acceda a lo que le corresponde.

---

## 🎭 Módulos por Rol

### 👨‍🎓 Aprendiz
- **Dashboard Personalizado:** Vista rápida de postulaciones y estado de proyectos.
- **Buscador de Proyectos:** Filtrado y exploración de oportunidades publicadas por empresas.
- **Gestión de Postulaciones:** Seguimiento en tiempo real del estado de sus aplicaciones.
- **Entrega de Evidencias:** Sistema de carga de archivos por etapas del proyecto.
- **Perfil Profesional:** Gestión de datos personales y trayectoria.

### 🏢 Empresa
- **Gestión de Proyectos:** CRUD completo de ofertas de proyectos para la comunidad SENA.
- **Panel de Postulantes:** Revisión detallada de perfiles interesados.
- **Control de Estados:** Aceptación o rechazo de candidatos con actualización instantánea.
- **Perfil Corporativo:** Información de contacto y descripción de la empresa.

### 👨‍🏫 Instructor
- **Seguimiento Técnico:** Supervisión detallada de los proyectos asignados.
- **Gestión de Etapas:** Creación y edición de las fases de desarrollo de cada proyecto.
- **Calificación de Evidencias:** Sistema de feedback y evaluación para los aprendices.
- **Reportes de Seguimiento:** Generación de informes de progreso.
- **Gestión de Imágenes:** Control visual del branding de los proyectos.

### ⚡ Administrador
- **Control de Usuarios:** Gestión centralizada de estados (Activo/Inactivo) para todos los perfiles.
- **Auditoría de Empresas:** Validación y aprobación de corporaciones registradas.
- **Supervisión de Proyectos:** Monitoreo global de la actividad en la plataforma.
- **Asignación de Instructores:** Vinculación de expertos técnicos a proyectos específicos.

---

## ✨ Características Técnicas (Modernización)

### 🎨 UI/UX Premium
- **Glassmorphism Design:** Interfaz translúcida, moderna y elegante.
- **Bento Grid Dashboard:** Distribución inteligente de información mediante tarjetas dinámicas.
- **Iconografía Activa:** Integración nativa de **FontAwesome 6** para una navegación intuitiva.
- **Responsividad Total:** Adaptación fluida a dispositivos móviles y escritorio.

### 🛠️ Stack Tecnológico
- **Core:** Laravel 11.x & PHP 8.2+
- **Frontend:** Vite, Blade, Vanilla CSS (Premium Tokens)
- **Base de Datos:** MySQL / MariaDB (Optimización con índices estratégicos)
- **Correo:** PHPMailer 6.9+ para notificaciones robustas.

---

## 📋 Requisitos e Instalación

1. **Requisitos:** PHP 8.2+, Composer 2.x, MySQL 8.0+, Node.js 18+.
2. **Clonar e Instalar:**
   ```bash
   git clone https://github.com/AishiteruMr/Bolsa_Proyecto_Sena.git
   cd Bolsa_Proyecto_Sena
   composer install
   npm install
   ```
3. **Configuración:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   > [!IMPORTANT]
   > Configura los accesos a la base de datos y credenciales de correo en el archivo `.env`.

4. **Base de Datos:**
   ```bash
   php artisan migrate --seed
   ```

5. **Ejecutar:**
   ```bash
   php artisan serve
   npm run dev
   ```

---

## 🔐 Credenciales de Prueba (Seeds)

| Perfil | Correo | Contraseña |
| :--- | :--- | :--- |
| **Administrador** | `admin@gmail.com` | `admin123` |
| **Instructor** | `instructor@gmail.com` | `admin123` |
| **Aprendiz** | `aprendiz@gmail.com` | `admin123` |
| **Empresa** | `empresa@gmail.com` | `admin123` |

---

**Desarrollado para la comunidad SENA - 2026 Modern Edition**
