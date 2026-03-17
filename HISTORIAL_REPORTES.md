# Historial de Proyectos y Reportes de Seguimiento

## Descripción General

Se han implementado nuevas funcionalidades para que instructores y aprendices puedan visualizar el historial de proyectos y realizar seguimiento detallado de las etapas, entregas y evidencias.

## Para Instructores 👨‍🏫

### 1. Historial de Proyectos

**Ruta:** `instructor/historial`

Permite al instructor ver todos los proyectos que ha supervisado con estadísticas:

- **Información del proyecto:**
  - Título, empresa y categoría
  - Fechas de publicación y finalización
  - Estado actual (Activo, Completado, etc.)

- **Estadísticas:**
  - Total de postulaciones
  - Aprendices aprobados
  - Visualización rápida en tarjetas

- **Acciones:**
  - Botón para acceder al reporte de seguimiento detallado

### 2. Reporte de Seguimiento por Proyecto

**Ruta:** `instructor/proyectos/{id}/reporte`

Reporte completo y detallado de un proyecto específico:

#### Secciones incluidas:

**Información del Proyecto:**
- Datos básicos (empresa, categoría, estado)
- Fechas de publicación y finalización
- Duración estimada

**Aprendices Asignados:**
- Tabla con lista de todos los aprendices aprobados
- Email de contacto
- Cantidad de entregas y evidencias por aprendiz

**Etapas del Proyecto:**
- Listado de todas las etapas con acordeón expandible
- Para cada etapa:
  - Descripción completa
  - Todas las entregas realizadas con:
    - Nombre del aprendiz
    - Estado (Pendiente, Entregada, Aprobada, Rechazada)
    - Fecha y hora de entrega
    - Archivo adjunto (si aplica)
    - Descripción de la entrega
  - Todas las evidencias con:
    - Nombre del aprendiz
    - Estado (Pendiente, Aprobada, Rechazada)
    - Fecha y hora
    - Comentarios del instructor
    - Archivo de evidencia

**Resumen General:**
- Tarjetas con estadísticas clave:
  - Total aprendices asignados
  - Total entregas realizadas
  - Total evidencias registradas
  - Total etapas del proyecto

## Para Aprendices 👨‍🎓

### 1. Historial de Proyectos

**Ruta:** `aprendiz/historial`

Vista del historial de postulaciones del aprendiz:

- **Información de cada postulación:**
  - Título del proyecto
  - Empresa responsable
  - Categoría
  - Instructor asignado
  - Fecha de postulación
  - Estado actual (Pendiente, Aprobada, Rechazada)

- **Estados visuales:**
  - Verde: Aprobada ✓
  - Rojo: Rechazada ✗
  - Amarillo: Pendiente ⏳

- **Acciones:**
  - Para postulaciones aprobadas: acceso a "Ver Mis Entregas"
  - Para postulaciones no aprobadas: botón deshabilitado

### 2. Mis Entregas

**Ruta:** `aprendiz/mis-entregas`

Seguimiento completo de entregas y evidencias en proyectos aprobados:

#### Secciones incluidas:

**Por cada proyecto aprobado:**

- **Tab: Entregas**
  - Lista de todas las entregas realizadas
  - Por cada entrega:
    - Nombre de la etapa
    - Estado (Pendiente, Entregada, Aprobada, Rechazada)
    - Número de etapa
    - Fecha y hora de entrega
    - Descripción de la entrega
    - Botón para descargar archivo

- **Tab: Evidencias**
  - Lista de todas las evidencias registradas
  - Por cada evidencia:
    - Nombre de la etapa
    - Estado (Pendiente, Aprobada, Rechazada)
    - Número de etapa
    - Fecha y hora
    - Comentarios del instructor
    - Botón para descargar archivo

**Resumen General:**
- Tarjetas con estadísticas:
  - Total entregas realizadas
  - Entregas aprobadas
  - Total evidencias registradas
  - Evidencias aprobadas

## Cambios Realizados

### Controllers

#### `InstructorController.php`

Nuevos métodos agregados:

```php
// Obtener historial de todos los proyectos supervisados
public function historial()

// Obtener reporte detallado de seguimiento de un proyecto
public function reporteSeguimiento($proId)
```

#### `AprendizController.php`

Nuevos métodos agregados:

```php
// Obtener historial de postulaciones del aprendiz
public function historial()

// Obtener entregas y evidencias de proyectos aprobados
public function misEntregas()
```

### Rutas (routes/web.php)

**Para Instructor:**
```
GET /instructor/historial                 → instructor.historial
GET /instructor/proyectos/{id}/reporte    → instructor.reporte
```

**Para Aprendiz:**
```
GET /aprendiz/historial                   → aprendiz.historial
GET /aprendiz/mis-entregas                → aprendiz.entregas
```

### Vistas

**Nuevas vistas creadas:**

1. `resources/views/instructor/historial.blade.php`
   - Listado de proyectos supervisados
   - Tarjetas con estadísticas
   - Enlace a reporte de seguimiento

2. `resources/views/instructor/reporte-seguimiento.blade.php`
   - Reporte completo por proyecto
   - Etapas con acordeón
   - Entregas y evidencias detalladas
   - Estadísticas generales

3. `resources/views/aprendiz/historial.blade.php`
   - Historial de postulaciones
   - Estados visuales
   - Acceso a entregas para proyectos aprobados

4. `resources/views/aprendiz/mis-entregas.blade.php`
   - Entregas y evidencias por proyecto
   - Tabs para entregas vs evidencias
   - Resumen de estadísticas

### Navegación

**Dashboard del Instructor:**
- ✨ Nuevo: Opción de menú "Historial" con icono de reloj

**Dashboard del Aprendiz:**
- ✨ Nuevo: Opción de menú "Historial" con icono de reloj
- ✨ Nuevo: Opción de menú "Mis Entregas" con icono de tareas

## Características Técnicas

### Consultas a Base de Datos

**Historial Instructor:**
- JOIN con empresa, postulacion y aprendiz
- COUNT y GROUP BY para estadísticas
- Filtro por documento del instructor

**Reporte de Seguimiento:**
- Múltiples JOINs con etapa, entrega_etapa, evidencia
- Datos jerarquizados por etapa
- Información completa de entregas y evidencias

**Historial Aprendiz:**
- JOIN con proyecto, empresa, instructor y postulacion
- Información de estado de postulación
- Cálculo de días restantes

**Mis Entregas:**
- JOINs con entrega_etapa, evidencia, etapa
- Filtrado por aprendiz y proyecto
- Grouping por proyecto y etapa

### Validaciones

- Verificación de pertenencia del proyecto al instructor
- Validación de estado de postulación (solo proyectos aprobados para entregas)
- Protección de rutas con middleware `auth.custom` y rol

### Diseño UI/UX

- Tarjetas con gradientes y colores distintivos
- Acordeones para organización jerárquica
- Tabs para separar entregas y evidencias
- Badges con colores según estado
- Iconos Font Awesome para mejor visualización
- Responsive design

## Uso

### Para Instructores

1. Acceder a dashboard
2. Hacer clic en "Historial" en el menú lateral
3. Ver listado de proyectos supervisados
4. Hacer clic en "Ver Reporte de Seguimiento" para detalles completos
5. Expandir acordeones para ver entregas y evidencias

### Para Aprendices

1. Acceder a dashboard
2. Hacer clic en "Historial" en el menú lateral para ver postulaciones
3. Una vez aprobado en un proyecto, hacer clic en "Mis Entregas"
4. Ver todas las entregas y evidencias por proyecto
5. Usar tabs para cambiar entre entregas y evidencias

## Base de Datos

**Tablas utilizadas:**
- `proyecto` - Información del proyecto
- `empresa` - Datos de la empresa
- `aprendiz` - Información del aprendiz
- `usuario` - Datos de usuario
- `instructor` - Información del instructor
- `postulacion` - Registro de postulaciones
- `etapa` - Etapas del proyecto
- `entrega_etapa` - Entregas por etapa
- `evidencia` - Evidencias de proyecto

**Relaciones principales:**
- Proyecto → Empresa (via emp_nit)
- Proyecto → Instructor (via ins_usr_documento)
- Postulacion → Proyecto + Aprendiz
- Entrega_Etapa → Etapa + Aprendiz + Proyecto
- Evidencia → Etapa + Aprendiz + Proyecto

## Próximas Mejoras Sugeridas

1. **Reportes PDF:** Generar reportes en PDF descargables
2. **Filtros avanzados:** Filtrar por estado, fecha, etapa
3. **Exportación:** Exportar datos a Excel
4. **Notificaciones:** Alertas cuando se aprueban/rechazan entregas
5. **Comentarios:** Sistema de comentarios en entregas
6. **Calificación:** Agregar sistema de calificación de entregas
7. **Estadísticas gráficas:** Gráficos de progreso y desempeño
