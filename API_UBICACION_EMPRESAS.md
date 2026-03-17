# API REST - Ubicación de Empresas

## Descripción
API REST para gestionar y obtener información de ubicación de empresas en la plataforma Bolsa de Proyectos SENA.

## Base URL
```
http://127.0.0.1:8000/api
```

---

## Endpoints

### 1. Listar Empresas Activas
**Pública** - No requiere autenticación

```
GET /api/empresas
```

**Response (200 OK):**
```json
{
  "success": true,
  "message": "Empresas obtenidas correctamente",
  "data": [
    {
      "emp_id": 1,
      "emp_nit": 9004857213,
      "emp_nombre": "Empresa XYZ",
      "emp_representante": "Juan Pérez",
      "emp_ubicacion": "Bogotá, Cundinamarca",
      "emp_ciudad": "Bogotá",
      "emp_departamento": "Cundinamarca"
    }
  ],
  "total": 1
}
```

---

### 2. Obtener Ubicación por NIT
**Pública** - No requiere autenticación

```
GET /api/empresa/{nit}/ubicacion
```

**Parámetros:**
- `nit` (integer, requerido) - NIT de la empresa

**Ejemplo:**
```
GET /api/empresa/9004857213/ubicacion
```

**Response (200 OK):**
```json
{
  "success": true,
  "message": "Ubicación obtenida correctamente",
  "data": {
    "emp_id": 1,
    "emp_nit": 9004857213,
    "emp_nombre": "Empresa XYZ",
    "ubicacion": "Bogotá, Cundinamarca",
    "ubicacion_completa": "Calle 10 #20-30, Bogotá, Cundinamarca",
    "departamento": "Cundinamarca",
    "ciudad": "Bogotá",
    "direccion": "Calle 10 #20-30"
  }
}
```

**Response (404 Not Found):**
```json
{
  "success": false,
  "message": "Empresa no encontrada",
  "data": null
}
```

---

### 3. Obtener Ubicación por Sesión
**Protegida** - Requiere sesión activa

```
GET /api/empresa/ubicacion/sesion
```

**Headers requeridos:**
```
Accept: application/json
Content-Type: application/json
Cookie: PHPSESSID=...
```

**Response (200 OK):**
```json
{
  "success": true,
  "message": "Ubicación obtenida correctamente",
  "data": {
    "emp_id": 1,
    "emp_nit": 9004857213,
    "emp_nombre": "Empresa XYZ",
    "ubicacion": "Bogotá, Cundinamarca",
    "ubicacion_completa": "Calle 10 #20-30, Bogotá, Cundinamarca",
    "departamento": "Cundinamarca",
    "ciudad": "Bogotá",
    "direccion": "Calle 10 #20-30"
  }
}
```

**Response (401 Unauthorized):**
```json
{
  "success": false,
  "message": "No hay sesión de empresa activa",
  "data": null
}
```

---

### 4. Actualizar Ubicación
**Protegida** - Requiere sesión activa

```
PUT /api/empresa/{id}/ubicacion
```

**Parámetros:**
- `id` (integer, requerido) - ID de la empresa

**Body (JSON):**
```json
{
  "ubicacion": "Medellín, Antioquia",
  "departamento": "Antioquia",
  "ciudad": "Medellín",
  "direccion": "Carrera 50 #10-20"
}
```

**Campos válidos:**
- `ubicacion` (string, opcional) - max 255 caracteres
- `departamento` (string, opcional) - max 100 caracteres
- `ciudad` (string, opcional) - max 100 caracteres
- `direccion` (string, opcional) - max 255 caracteres

**Response (200 OK):**
```json
{
  "success": true,
  "message": "Ubicación actualizada correctamente",
  "data": {
    "ubicacion": "Medellín, Antioquia",
    "departamento": "Antioquia",
    "ciudad": "Medellín",
    "direccion": "Carrera 50 #10-20"
  }
}
```

**Response (404 Not Found):**
```json
{
  "success": false,
  "message": "Empresa no encontrada",
  "data": null
}
```

---

## Códigos de Estado HTTP

| Código | Descripción |
|--------|-------------|
| 200 | OK - Solicitud exitosa |
| 400 | Bad Request - Parámetros inválidos |
| 401 | Unauthorized - Sesión requerida |
| 404 | Not Found - Recurso no encontrado |
| 500 | Internal Server Error - Error del servidor |

---

## Ejemplos con cURL

### Listar empresas
```bash
curl -X GET "http://127.0.0.1:8000/api/empresas" \
  -H "Accept: application/json"
```

### Obtener ubicación por NIT
```bash
curl -X GET "http://127.0.0.1:8000/api/empresa/9004857213/ubicacion" \
  -H "Accept: application/json"
```

### Obtener ubicación de sesión
```bash
curl -X GET "http://127.0.0.1:8000/api/empresa/ubicacion/sesion" \
  -H "Accept: application/json" \
  -H "Cookie: PHPSESSID=abc123xyz"
```

### Actualizar ubicación
```bash
curl -X PUT "http://127.0.0.1:8000/api/empresa/1/ubicacion" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -H "Cookie: PHPSESSID=abc123xyz" \
  -d '{
    "ubicacion": "Medellín, Antioquia",
    "ciudad": "Medellín",
    "departamento": "Antioquia"
  }'
```

---

## Ejemplos con JavaScript/Fetch

### Obtener ubicación de sesión
```javascript
fetch('/api/empresa/ubicacion/sesion', {
  method: 'GET',
  headers: {
    'Accept': 'application/json',
    'Content-Type': 'application/json'
  }
})
.then(response => response.json())
.then(data => {
  if (data.success) {
    console.log('Ubicación:', data.data.ubicacion);
  }
})
.catch(error => console.error('Error:', error));
```

### Actualizar ubicación
```javascript
fetch('/api/empresa/1/ubicacion', {
  method: 'PUT',
  headers: {
    'Accept': 'application/json',
    'Content-Type': 'application/json'
  },
  body: JSON.stringify({
    ubicacion: 'Medellín, Antioquia',
    ciudad: 'Medellín',
    departamento: 'Antioquia'
  })
})
.then(response => response.json())
.then(data => {
  if (data.success) {
    console.log('Ubicación actualizada');
  }
})
.catch(error => console.error('Error:', error));
```

---

## Integración en Formulario de Proyectos

### Automatización
Cuando se carga el formulario de crear proyecto:
1. Se ejecuta automáticamente la solicitud GET `/api/empresa/ubicacion/sesion`
2. Se prellenar el campo de ubicación con la información de la empresa
3. El usuario puede editar o mantener la ubicación sugerida

### Botón de Recarga
Existe un botón con icono de sincronización que permite recargar la ubicación en cualquier momento.

### Notificaciones
- **Éxito**: Mensaje verde en la esquina superior derecha
- **Advertencia**: Mensaje naranja si no hay ubicación configurada
- **Error**: Mensaje rojo si hay problemas de conexión

---

## Estructura de Base de Datos

### Tabla: empresa
```sql
ALTER TABLE empresa ADD COLUMN (
  emp_ubicacion VARCHAR(255) NULL,
  emp_departamento VARCHAR(100) NULL,
  emp_ciudad VARCHAR(100) NULL,
  emp_direccion VARCHAR(255) NULL
);
```

---

## Manejo de Errores

### Errores Comunes

**Empresa no encontrada (404):**
```json
{
  "success": false,
  "message": "Empresa no encontrada"
}
```

**Sin sesión activa (401):**
```json
{
  "success": false,
  "message": "No hay sesión de empresa activa"
}
```

**Error de servidor (500):**
```json
{
  "success": false,
  "message": "Error al obtener la ubicación de la empresa",
  "error": "Descripción del error"
}
```

---

## Middleware de Seguridad

- **Públicas**: Endpoints disponibles sin autenticación
- **Protegidas**: Requieren middleware `auth.custom` (sesión activa)
- **Logs**: Todos los errores se registran en `storage/logs/laravel.log`

---

## Rutas Registradas

```php
// Públicas
GET    /api/empresas
GET    /api/empresa/{nit}/ubicacion

// Protegidas (requieren sesión)
GET    /api/empresa/ubicacion/sesion
PUT    /api/empresa/{id}/ubicacion
```

---

## Versionado

- **Versión**: 1.0.0
- **Fecha**: Marzo 17, 2026
- **Controlador**: `App\Http\Controllers\Api\EmpresaApiController`

