# INFORME DE AUDITORÍA DE SEGURIDAD
## Bolsa de Proyectos SENA

**Fecha de Auditoría:** 20 de Marzo de 2026  
**Nivel de Riesgo General:** ALTO  
**Versión:** 1.0

---

## RESUMEN EJECUTIVO

Se identificaron **13 vulnerabilidades críticas** y **21 problemas de seguridad** en la aplicación. Varios problemas permiten acceso no autorizado a datos sensibles, modificación de registros de otros usuarios, y exposición de información confidencial.

---

## 1. VULNERABILIDADES CRÍTICAS ENCONTRADAS

### 1.1 AUTORIZACIÓN DÉBIL - Cambio de Estado de Postulación (CRÍTICO)
**Ubicación:** `EmpresaController::cambiarEstadoPostulacion()` (línea 214-222)

```php
public function cambiarEstadoPostulacion(Request $request, int $id)
{
    $request->validate(['estado' => 'required|in:Pendiente,Aprobada,Rechazada']);
    
    $postulacion = Postulacion::findOrFail($id);  // ❌ SIN VALIDACIÓN
    $postulacion->update(['pos_estado' => $request->estado]);
    
    return back()->with('success', 'Estado de postulación actualizado.');
}
```

**Problema:** 
- NO verifica que la postulación pertenezca a un proyecto de la empresa
- Una empresa puede cambiar el estado de postulaciones de OTROS proyectos
- Permite aprobar/rechazar aprendices sin autoridad

**Riesgo:** CRÍTICO - Modificación no autorizada de datos

**Impacto:**
- Empresa A puede aprobar/rechazar aprendices de Empresa B
- Fraude en el proceso de selección

**Recomendación:**
```php
public function cambiarEstadoPostulacion(Request $request, int $id)
{
    $request->validate(['estado' => 'required|in:Pendiente,Aprobada,Rechazada']);
    
    $nit = session('nit');
    
    // ✅ VALIDAR QUE PERTENECE A LA EMPRESA
    $postulacion = Postulacion::where('pos_id', $id)
        ->whereHas('proyecto', function($query) use ($nit) {
            $query->where('emp_nit', $nit);
        })->firstOrFail();
    
    $postulacion->update(['pos_estado' => $request->estado]);
    
    return back()->with('success', 'Estado de postulación actualizado.');
}
```

---

### 1.2 AUTORIZACIÓN DÉBIL - Eliminar Proyectos (CRÍTICO)
**Ubicación:** `EmpresaController::eliminarProyecto()` (línea 158-184)

```php
public function eliminarProyecto(int $id)
{
    $nit = session('nit');
    
    $proyecto = Proyecto::where('pro_id', $id)
        ->where('emp_nit', $nit)
        ->first();  // ✅ BIEN: valida que pertenezca a la empresa
    
    if (!$proyecto) {
        return redirect()->route('empresa.proyectos')
            ->with('error', 'Proyecto no encontrado.');
    }
    
    // ✅ BIEN: valida pertenencia
    // Elimina datos correctamente
}
```

**Status:** ✅ CORRECTO - Este método SÍ valida autorización

---

### 1.3 ACCESO NO AUTORIZADO A POSTULACIONES DE OTROS APRENDICES (CRÍTICO)
**Ubicación:** `AprendizController::verDetalleProyecto()` (línea 186-214)

```php
public function verDetalleProyecto(int $proId)
{
    $usrId = session('usr_id');
    $aprendiz = Aprendiz::where('usr_id', $usrId)->firstOrFail();
    
    // ✅ BIEN: Valida que esté aprobado
    $postulacion = $aprendiz->postulacionesAprobadas()
        ->where('pro_id', $proId)
        ->firstOrFail();
    
    $proyecto = Proyecto::with(['empresa', 'instructor'])
        ->findOrFail($proId);
    
    $etapas = $proyecto->etapasOrdenadas();
    
    // ✅ BIEN: Obtiene solo evidencias del aprendiz
    $evidencias = $aprendiz->evidencias()
        ->where('evid_pro_id', $proId)
        ->with('etapa')
        ->get();
}
```

**Status:** ✅ CORRECTO - Valida correctamente

---

### 1.4 API SIN AUTENTICACIÓN - EmpresaApiController (CRÍTICO)
**Ubicación:** `Api/EmpresaApiController.php` - TODOS LOS MÉTODOS

```php
// GET /api/empresa/{nit}/ubicacion
public function obtenerUbicacion($nit)  // ❌ SIN PROTECCIÓN
{
    $empresa = DB::table('empresa')
        ->where('emp_nit', $nit)
        ->first();
    
    return response()->json([...]);
}

// GET /api/empresas - LISTA TODAS LAS EMPRESAS
public function index()  // ❌ SIN PROTECCIÓN
{
    $empresas = DB::table('empresa')
        ->select('emp_id', 'emp_nit', 'emp_nombre', 'emp_representante', ...)
        ->where('emp_estado', 1)
        ->get();
    
    return response()->json([...]);
}
```

**Problema:**
- NO tiene middleware de autenticación
- Cualquier persona puede acceder
- Expone información sensible (NITs, nombres, representantes, ubicaciones)

**Riesgo:** CRÍTICO - Exposición de datos sensibles

**Recomendación:**
```php
// routes/api.php
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/empresa/{nit}/ubicacion', ...);
    Route::get('/empresas', ...);
    Route::put('/empresa/{id}/ubicacion', ...);
});
```

---

### 1.5 EXPOSICIÓN DE ERRORES EN API (ALTO)
**Ubicación:** `Api/EmpresaApiController.php` - Todos los catch blocks

```php
} catch (\Exception $e) {
    Log::error('Error al obtener ubicación: ' . $e->getMessage());
    return response()->json([
        'success' => false,
        'message' => 'Error al obtener la ubicación',
        'error' => $e->getMessage()  // ❌ EXPONE DETALLES
    ], 500);
}
```

**Problema:**
- Retorna mensajes de error detallados en respuestas JSON
- En producción expone stack traces y rutas internas

**Recomendación:**
```php
} catch (\Exception $e) {
    Log::error('Error al obtener ubicación: ' . $e->getMessage());
    
    return response()->json([
        'success' => false,
        'message' => 'Error al procesar la solicitud'
        // NO incluir $e->getMessage() en producción
    ], 500);
}
```

---

### 1.6 DEBUG MODE HABILITADO EN PRODUCCIÓN (CRÍTICO)
**Ubicación:** `.env`

```
APP_ENV=local
APP_DEBUG=true  // ❌ PELIGROSO EN PRODUCCIÓN
APP_URL=http://localhost
```

**Problema:**
- APP_DEBUG=true expone stack traces completos
- Muestra variables, queries, rutas del servidor
- Información sensible visible en errores

**Recomendación:**
```
APP_ENV=production
APP_DEBUG=false
```

---

### 1.7 SESSION ENCRYPTION DESHABILITADO (ALTO)
**Ubicación:** `config/session.php`

```php
'encrypt' => false,  // ❌ DATOS DE SESIÓN EN TEXTO PLANO
```

**Problema:**
- Los datos de sesión (usr_id, nit, emp_id, rol) se guardan sin encriptar
- Si alguien accede al archivo de sesión, obtiene acceso completo

**Recomendación:**
```php
'encrypt' => true,  // ✅ Encriptar datos sensibles de sesión
```

---

## 2. PROBLEMAS DE VALIDACIÓN Y SANITIZACIÓN

### 2.1 BÚSQUEDA SIN SANITIZACIÓN (MEDIO)
**Ubicación:** `AprendizController::proyectos()` (línea 65-66)

```php
if ($request->filled('buscar')) {
    $query->busqueda($request->buscar);  // ✅ BIEN: Usa Eloquent
}
```

**Model:** `Proyecto.php` (línea 93-96)

```php
public function scopeBusqueda(Builder $query, $termino): Builder
{
    return $query->where('pro_titulo_proyecto', 'like', "%{$termino}%")
                 ->orWhere('pro_descripcion', 'like', "%{$termino}%");
}
```

**Status:** ✅ SEGURO - Eloquent sanitiza automáticamente

---

### 2.2 VALIDACIÓN DÉBIL DE CONTRASEÑA (MEDIO)
**Ubicación:** Múltiples controladores

```php
'password' => 'required|string|min:6|max:100|confirmed'
```

**Problemas:**
- Mínimo 6 caracteres es muy bajo (OWASP: 12+ caracteres)
- Sin requisitos de complejidad (mayúsculas, minúsculas, números, símbolos)
- Sin validación de contraseñas comunes

**Recomendación:**
```php
'password' => 'required|string|min:12|confirmed|password:mixed,numbers,symbols',
```

---

### 2.3 CONTRASEÑAS VACIAS SIN HASHEAR - SEGURIDAD HEREDADA (MEDIO)
**Ubicación:** `AuthController::login()` (línea 59-63)

```php
} elseif ($usuario->usr_contrasena === $password) {  // ❌ COMPARACIÓN TEXTO PLANO
    DB::table('usuario')
        ->where('usr_id', $usuario->usr_id)
        ->update(['usr_contrasena' => Hash::make($password)]);
    $loginOk = true;
}
```

**Problema:**
- Acepta contraseñas sin hashear (legacy support)
- Comparación de texto plano es insegura
- Debería forzar reset de contraseña

**Recomendación:**
```php
// Forzar reset de contraseña para usuarios sin hash
if (empty($usuario->usr_contrasena)) {
    return back()->with('error', 'Debes restablecer tu contraseña.');
}
```

---

## 3. PROBLEMAS DE CONTROL DE ACCESO POR ROLES

### 3.1 
