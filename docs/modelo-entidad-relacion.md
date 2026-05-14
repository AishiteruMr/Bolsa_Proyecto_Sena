# Modelo Entidad-Relación — Bolsa de Proyectos SENA

## Diagrama ER (Mermaid)

```mermaid
erDiagram

    roles {
        BIGINT id PK
        VARCHAR_50 nombre UK
        VARCHAR_100 nombre_visible
        TIMESTAMP created_at
        TIMESTAMP updated_at
    }

    usuarios {
        BIGINT id PK
        BIGINT numero_documento UK
        VARCHAR_100 correo UK
        VARCHAR_255 contrasena
        TIMESTAMP email_verified_at
        BIGINT rol_id FK
        VARCHAR_100 remember_token
        TIMESTAMP created_at
        TIMESTAMP updated_at
    }

    aprendices {
        BIGINT id PK
        BIGINT usuario_id FK_UK
        VARCHAR_100 nombres
        VARCHAR_100 apellidos
        VARCHAR_150 programa_formacion
        BOOLEAN activo
        TIMESTAMP created_at
        TIMESTAMP updated_at
        TIMESTAMP deleted_at
    }

    instructores {
        BIGINT id PK
        BIGINT usuario_id FK_UK
        VARCHAR_100 nombres
        VARCHAR_100 apellidos
        VARCHAR_150 especialidad
        BOOLEAN activo
        ENUM disponibilidad
        TIMESTAMP created_at
        TIMESTAMP updated_at
    }

    administradores {
        BIGINT id PK
        BIGINT usuario_id FK_UK
        VARCHAR_100 nombres
        VARCHAR_100 apellidos
        BOOLEAN activo
        TIMESTAMP created_at
        TIMESTAMP updated_at
    }

    empresas {
        BIGINT id PK
        BIGINT usuario_id FK_UK
        BIGINT nit UK
        VARCHAR_150 nombre
        VARCHAR_100 representante
        VARCHAR_100 correo_contacto UK
        VARCHAR_255 ubicacion
        DECIMAL latitud
        DECIMAL longitud
        BOOLEAN activo
        TIMESTAMP created_at
        TIMESTAMP updated_at
        TIMESTAMP deleted_at
    }

    proyectos {
        BIGINT id PK
        BIGINT empresa_nit FK
        BIGINT instructor_usuario_id FK
        VARCHAR_200 titulo
        VARCHAR_100 categoria
        TEXT descripcion
        VARCHAR_300 requisitos_especificos
        VARCHAR_300 habilidades_requeridas
        DATE fecha_publicacion
        SMALLINT duracion_estimada_dias
        ENUM estado
        BOOLEAN calidad_aprobada
        VARCHAR_255 imagen_url
        VARCHAR_255 url_estructura
        INT numero_postulantes
        VARCHAR_255 ubicacion
        DECIMAL latitud
        DECIMAL longitud
        TIMESTAMP created_at
        TIMESTAMP updated_at
        TIMESTAMP deleted_at
    }

    postulaciones {
        BIGINT id PK
        BIGINT aprendiz_id FK
        BIGINT proyecto_id FK
        TIMESTAMP fecha_postulacion
        ENUM estado
        TIMESTAMP created_at
        TIMESTAMP updated_at
    }

    etapas {
        BIGINT id PK
        BIGINT proyecto_id FK
        TINYINT orden
        VARCHAR_200 nombre
        TEXT descripcion
        JSON documentos_requeridos
        VARCHAR_255 url_documento
        TIMESTAMP created_at
        TIMESTAMP updated_at
    }

    evidencias {
        BIGINT id PK
        BIGINT aprendiz_id FK
        BIGINT etapa_id FK
        BIGINT proyecto_id FK
        VARCHAR_255 ruta_archivo
        ENUM estado
        TEXT comentario_instructor
        TIMESTAMP fecha_envio
        TIMESTAMP created_at
        TIMESTAMP updated_at
    }

    entregas_etapa {
        BIGINT id PK
        BIGINT aprendiz_id FK
        BIGINT etapa_id FK
        BIGINT proyecto_id FK
        VARCHAR_255 url_archivo
        TEXT descripcion
        ENUM estado
        TIMESTAMP created_at
        TIMESTAMP updated_at
    }

    audit_logs {
        BIGINT id PK
        BIGINT user_id FK
        VARCHAR_50 accion
        VARCHAR_100 modulo
        VARCHAR_100 tabla_afectada
        BIGINT registro_id
        JSON datos_anteriores
        JSON datos_nuevos
        VARCHAR_45 ip_address
        VARCHAR_255 user_agent
        TEXT descripcion
        TIMESTAMP created_at
        TIMESTAMP updated_at
    }

    audit_reports {
        BIGINT id PK
        INT total_scanned
        INT vulnerabilities_found
        TIMESTAMP created_at
    }

    audit_entries {
        BIGINT id PK
        BIGINT report_id FK
        VARCHAR_255 uri
        INT expected
        INT status
        VARCHAR_255 result
        TEXT remediation
    }

    mensajes_soporte {
        BIGINT id PK
        VARCHAR_255 nombre
        VARCHAR_255 email
        VARCHAR_255 motivo
        TEXT mensaje
        TIMESTAMP created_at
        TIMESTAMP updated_at
    }

    email_verification_otps {
        BIGINT id PK
        VARCHAR_255 email
        VARCHAR_255 otp
        TIMESTAMP expires_at
        TIMESTAMP created_at
        TIMESTAMP updated_at
    }

    password_reset_tokens {
        VARCHAR_255 email PK
        VARCHAR_255 token
        TIMESTAMP created_at
        TIMESTAMP expires_at
    }

    notifications {
        UUID id PK
        VARCHAR_255 type
        VARCHAR_255 notifiable_type
        BIGINT notifiable_id
        TEXT data
        TIMESTAMP read_at
        TIMESTAMP created_at
        TIMESTAMP updated_at
    }

    sessions {
        VARCHAR_255 id PK
        BIGINT user_id FK
        VARCHAR_45 ip_address
        TEXT user_agent
        TEXT payload
        INT last_activity
    }

    personal_access_tokens {
        BIGINT id PK
        VARCHAR_255 tokenable_type
        BIGINT tokenable_id
        VARCHAR_255 name
        VARCHAR_64 token UK
        TEXT abilities
        TIMESTAMP last_used_at
        TIMESTAMP expires_at
        TIMESTAMP created_at
        TIMESTAMP updated_at
    }

    %% ═══════════════ RELACIONES ═══════════════

    roles ||--o{ usuarios : "1:N — un rol tiene muchos usuarios"
    usuarios ||--o| aprendices : "1:1 — perfil aprendiz"
    usuarios ||--o| instructores : "1:1 — perfil instructor"
    usuarios ||--o| administradores : "1:1 — perfil administrador"
    usuarios ||--o| empresas : "1:1 — perfil empresa"

    empresas ||--o{ proyectos : "1:N — empresa publica proyectos (via nit)"
    usuarios ||--o{ proyectos : "1:N — instructor asignado (nullable)"

    aprendices ||--o{ postulaciones : "1:N — aprendiz se postula"
    proyectos ||--o{ postulaciones : "1:N — proyecto recibe postulaciones"

    proyectos ||--o{ etapas : "1:N — proyecto tiene etapas"

    aprendices ||--o{ evidencias : "1:N — aprendiz sube evidencias"
    etapas ||--o{ evidencias : "1:N — etapa recibe evidencias"
    proyectos ||--o{ evidencias : "1:N — evidencia pertenece a proyecto"

    aprendices ||--o{ entregas_etapa : "1:N — aprendiz hace entregas"
    etapas ||--o{ entregas_etapa : "1:N — etapa recibe entregas"
    proyectos ||--o{ entregas_etapa : "1:N — entrega pertenece a proyecto"

    usuarios ||--o{ audit_logs : "1:N — usuario genera logs"
    audit_reports ||--o{ audit_entries : "1:N — reporte tiene entradas"

    usuarios ||--o{ sessions : "1:N — sesiones activas"
    usuarios ||--o{ notifications : "1:N — notificaciones (polimórfica)"
```

---

## Descripción de Entidades

### 1. `roles`
Catálogo de roles del sistema.

| Campo | Tipo | Restricciones | Descripción |
|-------|------|---------------|-------------|
| id | BIGINT | PK, Auto | Identificador |
| nombre | VARCHAR(50) | UNIQUE | Nombre interno (aprendiz, instructor, empresa, admin) |
| nombre_visible | VARCHAR(100) | NULLABLE | Nombre mostrado en la interfaz |

---

### 2. `usuarios`
Credenciales de autenticación de todos los usuarios.

| Campo | Tipo | Restricciones | Descripción |
|-------|------|---------------|-------------|
| id | BIGINT | PK, Auto | Identificador |
| numero_documento | BIGINT | UNIQUE | Cédula o NIT |
| correo | VARCHAR(100) | UNIQUE | Correo electrónico |
| contrasena | VARCHAR(255) | NOT NULL | Contraseña (hash) |
| email_verified_at | TIMESTAMP | NULLABLE | Fecha de verificación de email |
| rol_id | BIGINT | FK → roles.id | Rol del usuario |

**Relaciones:**
- **N:1** con `roles` (un usuario tiene un rol)
- **1:1** con `aprendices`, `instructores`, `administradores`, `empresas` (perfil según rol)

---

### 3. `aprendices`
Perfil de los aprendices SENA.

| Campo | Tipo | Restricciones | Descripción |
|-------|------|---------------|-------------|
| id | BIGINT | PK, Auto | Identificador |
| usuario_id | BIGINT | FK → usuarios.id, UNIQUE | Vínculo al usuario |
| nombres | VARCHAR(100) | NOT NULL | Nombres |
| apellidos | VARCHAR(100) | NOT NULL | Apellidos |
| programa_formacion | VARCHAR(150) | NOT NULL | Programa SENA |
| activo | BOOLEAN | DEFAULT true | Estado activo |

**Relaciones:**
- **1:1** con `usuarios`
- **1:N** con `postulaciones`
- **1:N** con `evidencias`
- **1:N** con `entregas_etapa`

---

### 4. `instructores`
Perfil de los instructores SENA.

| Campo | Tipo | Restricciones | Descripción |
|-------|------|---------------|-------------|
| id | BIGINT | PK, Auto | Identificador |
| usuario_id | BIGINT | FK → usuarios.id, UNIQUE | Vínculo al usuario |
| nombres | VARCHAR(100) | NOT NULL | Nombres |
| apellidos | VARCHAR(100) | NOT NULL | Apellidos |
| especialidad | VARCHAR(150) | NULLABLE | Área de especialidad |
| activo | BOOLEAN | DEFAULT true | Estado activo |
| disponibilidad | ENUM | DEFAULT 'disponible' | disponible, ocupado, no_disponible |

**Relaciones:**
- **1:1** con `usuarios`
- Referenciado indirectamente por `proyectos.instructor_usuario_id` → `usuarios.id`

---

### 5. `administradores`
Perfil de los administradores del sistema.

| Campo | Tipo | Restricciones | Descripción |
|-------|------|---------------|-------------|
| id | BIGINT | PK, Auto | Identificador |
| usuario_id | BIGINT | FK → usuarios.id, UNIQUE | Vínculo al usuario |
| nombres | VARCHAR(100) | NOT NULL | Nombres |
| apellidos | VARCHAR(100) | NOT NULL | Apellidos |
| activo | BOOLEAN | DEFAULT true | Estado activo |

**Relaciones:**
- **1:1** con `usuarios`

---

### 6. `empresas`
Perfil de empresas que publican proyectos.

| Campo | Tipo | Restricciones | Descripción |
|-------|------|---------------|-------------|
| id | BIGINT | PK, Auto | Identificador |
| usuario_id | BIGINT | FK → usuarios.id, UNIQUE | Vínculo al usuario |
| nit | BIGINT | UNIQUE | NIT de la empresa |
| nombre | VARCHAR(150) | NOT NULL | Razón social |
| representante | VARCHAR(100) | NOT NULL | Representante legal |
| correo_contacto | VARCHAR(100) | UNIQUE | Correo de contacto |
| ubicacion | VARCHAR(255) | NULLABLE | Dirección o ciudad |
| latitud | DECIMAL(10,8) | NULLABLE | Coordenada geográfica |
| longitud | DECIMAL(11,8) | NULLABLE | Coordenada geográfica |
| activo | BOOLEAN | DEFAULT true | Estado activo |

**Relaciones:**
- **1:1** con `usuarios`
- **1:N** con `proyectos` (vía `nit`)

---

### 7. `proyectos`
Proyectos publicados por empresas.

| Campo | Tipo | Restricciones | Descripción |
|-------|------|---------------|-------------|
| id | BIGINT | PK, Auto | Identificador |
| empresa_nit | BIGINT | FK → empresas.nit | Empresa que publica |
| instructor_usuario_id | BIGINT | FK → usuarios.id, NULLABLE | Instructor asignado |
| titulo | VARCHAR(200) | NOT NULL | Título del proyecto |
| categoria | VARCHAR(100) | NOT NULL | Categoría |
| descripcion | TEXT | NOT NULL | Descripción detallada |
| requisitos_especificos | VARCHAR(300) | NULLABLE | Requisitos |
| habilidades_requeridas | VARCHAR(300) | NULLABLE | Habilidades |
| fecha_publicacion | DATE | NOT NULL | Fecha de publicación |
| duracion_estimada_dias | SMALLINT | NOT NULL | Duración en días |
| estado | ENUM | DEFAULT 'pendiente' | pendiente, aprobado, rechazado, en_progreso, completado, cerrado |
| calidad_aprobada | BOOLEAN | DEFAULT false | Aprobación de calidad |
| imagen_url | VARCHAR(255) | NULLABLE | URL de imagen |
| url_estructura | VARCHAR(255) | NULLABLE | URL de estructura |
| numero_postulantes | INT | DEFAULT 0 | Contador de postulantes |
| ubicacion | VARCHAR(255) | NULLABLE | Ubicación geográfica |
| latitud | DECIMAL(10,8) | NULLABLE | Coordenada |
| longitud | DECIMAL(11,8) | NULLABLE | Coordenada |

**Relaciones:**
- **N:1** con `empresas` (vía `empresa_nit` → `empresas.nit`)
- **N:1** con `usuarios` (instructor asignado, nullable)
- **1:N** con `postulaciones`
- **1:N** con `etapas`
- **1:N** con `evidencias`
- **1:N** con `entregas_etapa`

---

### 8. `postulaciones`
Postulaciones de aprendices a proyectos.

| Campo | Tipo | Restricciones | Descripción |
|-------|------|---------------|-------------|
| id | BIGINT | PK, Auto | Identificador |
| aprendiz_id | BIGINT | FK → aprendices.id | Aprendiz que se postula |
| proyecto_id | BIGINT | FK → proyectos.id | Proyecto al que se postula |
| fecha_postulacion | TIMESTAMP | DEFAULT CURRENT | Fecha de postulación |
| estado | ENUM | DEFAULT 'pendiente' | pendiente, en_revision, aceptada, rechazada |

**Restricciones:** UNIQUE(aprendiz_id, proyecto_id) — Un aprendiz no puede postularse dos veces al mismo proyecto.

**Relaciones:**
- **N:1** con `aprendices`
- **N:1** con `proyectos`

---

### 9. `etapas`
Etapas o fases de un proyecto.

| Campo | Tipo | Restricciones | Descripción |
|-------|------|---------------|-------------|
| id | BIGINT | PK, Auto | Identificador |
| proyecto_id | BIGINT | FK → proyectos.id | Proyecto al que pertenece |
| orden | TINYINT | NOT NULL | Orden de la etapa |
| nombre | VARCHAR(200) | NOT NULL | Nombre de la etapa |
| descripcion | TEXT | NOT NULL | Descripción |
| documentos_requeridos | JSON | NULLABLE | Lista de documentos requeridos |
| url_documento | VARCHAR(255) | NULLABLE | URL del documento de la etapa |

**Relaciones:**
- **N:1** con `proyectos`
- **1:N** con `evidencias`
- **1:N** con `entregas_etapa`

---

### 10. `evidencias`
Evidencias cargadas por aprendices para revisión.

| Campo | Tipo | Restricciones | Descripción |
|-------|------|---------------|-------------|
| id | BIGINT | PK, Auto | Identificador |
| aprendiz_id | BIGINT | FK → aprendices.id | Aprendiz que sube |
| etapa_id | BIGINT | FK → etapas.id | Etapa asociada |
| proyecto_id | BIGINT | FK → proyectos.id | Proyecto asociado |
| ruta_archivo | VARCHAR(255) | NOT NULL | Ruta del archivo |
| estado | ENUM | DEFAULT 'pendiente' | pendiente, aceptada, rechazada |
| comentario_instructor | TEXT | NULLABLE | Feedback del instructor |
| fecha_envio | TIMESTAMP | DEFAULT CURRENT | Fecha de envío |

**Relaciones:**
- **N:1** con `aprendices`
- **N:1** con `etapas`
- **N:1** con `proyectos`

---

### 11. `entregas_etapa`
Entregas formales del aprendiz por etapa.

| Campo | Tipo | Restricciones | Descripción |
|-------|------|---------------|-------------|
| id | BIGINT | PK, Auto | Identificador |
| aprendiz_id | BIGINT | FK → aprendices.id | Aprendiz que entrega |
| etapa_id | BIGINT | FK → etapas.id | Etapa asociada |
| proyecto_id | BIGINT | FK → proyectos.id | Proyecto asociado |
| url_archivo | VARCHAR(255) | NULLABLE | URL del archivo |
| descripcion | TEXT | NULLABLE | Descripción de la entrega |
| estado | ENUM | DEFAULT 'pendiente' | pendiente, aceptada, rechazada |

**Relaciones:**
- **N:1** con `aprendices`
- **N:1** con `etapas`
- **N:1** con `proyectos`

---

### 12. `audit_logs`
Registro de auditoría del sistema.

| Campo | Tipo | Restricciones | Descripción |
|-------|------|---------------|-------------|
| id | BIGINT | PK, Auto | Identificador |
| user_id | BIGINT | FK → usuarios.id | Usuario que realizó la acción |
| accion | VARCHAR(50) | NOT NULL | Tipo de acción |
| modulo | VARCHAR(100) | NOT NULL | Módulo del sistema |
| tabla_afectada | VARCHAR(100) | NULLABLE | Tabla afectada |
| registro_id | BIGINT | NULLABLE | ID del registro afectado |
| datos_anteriores | JSON | NULLABLE | Datos antes del cambio |
| datos_nuevos | JSON | NULLABLE | Datos después del cambio |
| ip_address | VARCHAR(45) | NULLABLE | Dirección IP |
| user_agent | VARCHAR(255) | NULLABLE | User Agent |
| descripcion | TEXT | NULLABLE | Descripción legible |

**Relaciones:**
- **N:1** con `usuarios`

---

### 13. `audit_reports`
Reportes de auditoría de seguridad.

| Campo | Tipo | Restricciones | Descripción |
|-------|------|---------------|-------------|
| id | BIGINT | PK, Auto | Identificador |
| total_scanned | INT | NOT NULL | Total de endpoints escaneados |
| vulnerabilities_found | INT | NOT NULL | Vulnerabilidades encontradas |
| created_at | TIMESTAMP | DEFAULT CURRENT | Fecha de creación |

**Relaciones:**
- **1:N** con `audit_entries`

---

### 14. `audit_entries`
Entradas individuales de un reporte de auditoría.

| Campo | Tipo | Restricciones | Descripción |
|-------|------|---------------|-------------|
| id | BIGINT | PK, Auto | Identificador |
| report_id | BIGINT | FK → audit_reports.id | Reporte al que pertenece |
| uri | VARCHAR(255) | NOT NULL | URI escaneada |
| expected | INT | NOT NULL | Código HTTP esperado |
| status | INT | NOT NULL | Código HTTP obtenido |
| result | VARCHAR(255) | NOT NULL | Resultado (pass/fail) |
| remediation | TEXT | NULLABLE | Recomendación de corrección |

**Relaciones:**
- **N:1** con `audit_reports`

---

### 15. `mensajes_soporte`
Mensajes de contacto/soporte (sin relación FK).

| Campo | Tipo | Restricciones | Descripción |
|-------|------|---------------|-------------|
| id | BIGINT | PK, Auto | Identificador |
| nombre | VARCHAR(255) | NOT NULL | Nombre del remitente |
| email | VARCHAR(255) | NOT NULL | Correo del remitente |
| motivo | VARCHAR(255) | NOT NULL | Motivo del mensaje |
| mensaje | TEXT | NOT NULL | Contenido del mensaje |

---

### 16. `email_verification_otps`
Códigos OTP para verificación de email.

| Campo | Tipo | Restricciones | Descripción |
|-------|------|---------------|-------------|
| id | BIGINT | PK, Auto | Identificador |
| email | VARCHAR(255) | INDEX | Correo electrónico |
| otp | VARCHAR(255) | NOT NULL | Código OTP |
| expires_at | TIMESTAMP | NOT NULL | Fecha de expiración |

---

### 17. `password_reset_tokens`
Tokens para restablecimiento de contraseña.

| Campo | Tipo | Restricciones | Descripción |
|-------|------|---------------|-------------|
| email | VARCHAR(255) | PK | Correo electrónico |
| token | VARCHAR(255) | NOT NULL | Token de reset |
| created_at | TIMESTAMP | NULLABLE | Fecha de creación |
| expires_at | TIMESTAMP | NULLABLE | Fecha de expiración |

---

### 18. `notifications` (Laravel)
Notificaciones del sistema (polimórfica).

| Campo | Tipo | Restricciones | Descripción |
|-------|------|---------------|-------------|
| id | UUID | PK | Identificador UUID |
| type | VARCHAR(255) | NOT NULL | Clase de la notificación |
| notifiable_type | VARCHAR(255) | NOT NULL | Tipo del modelo notificable |
| notifiable_id | BIGINT | NOT NULL | ID del modelo notificable |
| data | TEXT | NOT NULL | Datos JSON de la notificación |
| read_at | TIMESTAMP | NULLABLE | Fecha de lectura |

---

### 19. `sessions` (Laravel)
Sesiones activas de usuarios.

---

### 20. `personal_access_tokens` (Sanctum)
Tokens de acceso API (Laravel Sanctum).

---

## Resumen de Relaciones

| Relación | Tipo | FK | Referencia |
|----------|------|----|------------|
| usuarios → roles | N:1 | `usuarios.rol_id` | `roles.id` |
| aprendices → usuarios | 1:1 | `aprendices.usuario_id` | `usuarios.id` |
| instructores → usuarios | 1:1 | `instructores.usuario_id` | `usuarios.id` |
| administradores → usuarios | 1:1 | `administradores.usuario_id` | `usuarios.id` |
| empresas → usuarios | 1:1 | `empresas.usuario_id` | `usuarios.id` |
| proyectos → empresas | N:1 | `proyectos.empresa_nit` | `empresas.nit` |
| proyectos → usuarios (instructor) | N:1 | `proyectos.instructor_usuario_id` | `usuarios.id` |
| postulaciones → aprendices | N:1 | `postulaciones.aprendiz_id` | `aprendices.id` |
| postulaciones → proyectos | N:1 | `postulaciones.proyecto_id` | `proyectos.id` |
| etapas → proyectos | N:1 | `etapas.proyecto_id` | `proyectos.id` |
| evidencias → aprendices | N:1 | `evidencias.aprendiz_id` | `aprendices.id` |
| evidencias → etapas | N:1 | `evidencias.etapa_id` | `etapas.id` |
| evidencias → proyectos | N:1 | `evidencias.proyecto_id` | `proyectos.id` |
| entregas_etapa → aprendices | N:1 | `entregas_etapa.aprendiz_id` | `aprendices.id` |
| entregas_etapa → etapas | N:1 | `entregas_etapa.etapa_id` | `etapas.id` |
| entregas_etapa → proyectos | N:1 | `entregas_etapa.proyecto_id` | `proyectos.id` |
| audit_logs → usuarios | N:1 | `audit_logs.user_id` | `usuarios.id` |
| audit_entries → audit_reports | N:1 | `audit_entries.report_id` | `audit_reports.id` |
| sessions → usuarios | N:1 | `sessions.user_id` | `usuarios.id` |

---

## Cardinalidad Resumida

```
roles           1 ── N   usuarios
usuarios        1 ── 1   aprendices
usuarios        1 ── 1   instructores
usuarios        1 ── 1   administradores
usuarios        1 ── 1   empresas
empresas        1 ── N   proyectos        (via nit)
usuarios        1 ── N   proyectos        (instructor, nullable)
aprendices      1 ── N   postulaciones
proyectos       1 ── N   postulaciones
proyectos       1 ── N   etapas
aprendices      1 ── N   evidencias
etapas          1 ── N   evidencias
proyectos       1 ── N   evidencias
aprendices      1 ── N   entregas_etapa
etapas          1 ── N   entregas_etapa
proyectos       1 ── N   entregas_etapa
usuarios        1 ── N   audit_logs
audit_reports   1 ── N   audit_entries
```
