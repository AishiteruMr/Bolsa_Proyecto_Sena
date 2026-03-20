# CÓDIGO DE REMEDIACIÓN - FIXES Y PATCHES

## 1. ARREGLAR EmpresaController::cambiarEstadoPostulacion()

### ANTES (VULNERABLE):
```php
public function cambiarEstadoPostulacion(Request $request, int $id)
{
    $request->validate(['estado' => 'required|in:Pendiente,Aprobada,Rechazada']);

    $postulacion = Postulacion::findOrFail($id);
    $postulacion->update(['pos_estado' => $request->estado]);

    return back()->with('success', 'Estado de postulación actualizado.');
}
```

### DESPUÉS (SEGURO):
```php
public function cambiarEstadoPostulacion(Request $request, int $id)
{
    $request->validate(['estado' => 'required|in:Pendiente,Aprobada,Rechazada']);

    $nit = session('nit');

    // ✅ VALIDAR QUE LA POSTULACIÓN PERTENECE A UN PROYECTO DE ESTA EMPRESA
    $postulacion = Postulacion::where('pos_id', $id)
        ->whereHas('proyecto', function($query) use ($nit) {
            $query->where('emp_nit', $nit);
        })->firstOrFail();

    $postulacion->update(['pos_estado' => $request->estado]);

    return back()->with('success', 'Estado de postulación actualizado.');
}
```

---

## 2. PROTEGER API - EmpresaApiController

### routes/api.php

ANTES:
```php
Route::get('/empresa/{nit}/ubicacion', [EmpresaApiController::class, 'obtenerUbicacion']);
Route::get('/empresa/ubicacion/sesion', [EmpresaApiController::class, 'obtenerUbicacionSesion']);
Route::put('/empresa/{id}/ubicacion', [EmpresaApiController::class, 'actualizarUbicacion']);
Route::get('/empresas', [EmpresaApiController::class, 'index']);
```

DESPUÉS:
```php
// ✅ PROTEGIDO: Requiere autenticación
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/empresa/{nit}/ubicacion', [EmpresaApiController::class, 'obtenerUbicacion']);
    Route::get('/empresa/ubicacion/sesion', [EmpresaApiController::class, 'obtenerUbicacionSesion']);
    Route::put('/empresa/{id}/ubicacion', [EmpresaApiController::class, 'actualizarUbicacion']);
    Route::get('/empresas', [EmpresaApiController::class, 'index']);
});
```

### EmpresaApiController.php - Manejar Errores Seguro

ANTES:
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

DESPUÉS:
```php
} catch (\Exception $e) {
    Log::error('Error al obtener ubicación: ' . $e->getMessage());
    
    $message = app()->environment('production') 
        ? 'Error al procesar la solicitud'
        : $e->getMessage();
    
    return response()->json([
        'success' => false,
        'message' => $message
    ], 500);
}
```

---

## 3. ARREGLAR .env

### ANTES:
```
APP_ENV=local
APP_DEBUG=true
```

### DESPUÉS:
```
APP_ENV=production
APP_DEBUG=false
```

---

## 4. ARREGLAR config/session.php

### ANTES:
```php
'encrypt' => false,  // ❌ TEXTO PLANO
```

### DESPUÉS:
```php
'encrypt' => true,  // ✅ ENCRIPTADO
```

---

## 5. MEJORAR Middleware/RolMiddleware.php

### ANTES:
```php
public function handle(Request $request, Closure $next, int $rol): Response
{
    $rolSesion = session('rol');

    if ($rolSesion != $rol) {  // ❌ COMPARADOR DÉBIL
        return match ((int) $rolSesion) {
            1 => redirect()->route('aprendiz.dashboard'),
            2 => redirect()->route('instructor.dashboard'),
            3 => redirect()->route('empresa.dashboard'),
            4 => redirect()->route('admin.dashboard'),
            default => redirect()->route('login')->with('error', 'Acceso no autorizado.')
        };
    }

    return $next($request);
}
```

### DESPUÉS:
```php
public function handle(Request $request, Closure $next, int $rol): Response
{
    // ✅ Validar que existe sesión activa
    if (!session()->has('rol')) {
        session()->flush();
        return redirect()->route('login')->with('error', 'Sesión expirada.');
    }

    $rolSesion = (int) session('rol');

    // ✅ Comparador estricto
    if ($rolSesion !== $rol) {
        return match ($rolSesion) {
            1 => redirect()->route('aprendiz.dashboard'),
            2 => redirect()->route('instructor.dashboard'),
            3 => redirect()->route('empresa.dashboard'),
            4 => redirect()->route('admin.dashboard'),
            default => redirect()->route('login')->with('error', 'Acceso no autorizado.')
        };
    }

    return $next($request);
}
```

---

## 6. MEJORAR Middleware/AuthMiddleware.php

### ANTES:
```php
public function handle(Request $request, Closure $next): Response
{
    if (!session()->has('usr_id') && !session()->has('emp_id')) {
        return redirect()->route('login')->with('error', 'Debes iniciar sesión para continuar.');
    }

    return $next($request);
}
```

### DESPUÉS:
```php
public function handle(Request $request, Closure $next): Response
{
    // ✅ Validar que existe una sesión activa
    if (!session()->has('rol')) {
        session()->flush();
        return redirect()->route('login')->with('error', 'Debes iniciar sesión para continuar.');
    }

    $rol = (int) session('rol');

    // ✅ Validar que los datos de sesión son consistentes con el rol
    switch ($rol) {
        case 1:  // Aprendiz
            if (!session()->has('usr_id')) {
                session()->flush();
                return redirect()->route('login');
            }
            break;

        case 2:  // Instructor
            if (!session()->has('usr_id')) {
                session()->flush();
                return redirect()->route('login');
            }
            break;

        case 3:  // Empresa
            if (!session()->has('emp_id')) {
                session()->flush();
                return redirect()->route('login');
            }
            break;

        case 4:  // Admin
            if (!session()->has('usr_id')) {
                session()->flush();
                return redirect()->route('login');
            }
            break;

        default:
            session()->flush();
            return redirect()->route('login');
    }

    return $next($request);
}
```

---

## 7. MEJORAR VALIDACIÓN DE CONTRASEÑA

### Crear Validation Rule Personalizado

`app/Rules/StrongPassword.php`:
```php
<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class StrongPassword implements Rule
{
    public function passes($attribute, $value)
    {
        // Mínimo 12 caracteres
        if (strlen($value) < 12) {
            return false;
        }

        // Debe contener mayúsculas
        if (!preg_match('/[A-Z]/', $value)) {
            return false;
        }

        // Debe contener minúsculas
        if (!preg_match('/[a-z]/', $value)) {
            return false;
        }

        // Debe contener números
        if (!preg_match('/[0-9]/', $value)) {
            return false;
        }

        // Debe contener símbolos especiales
        if (!preg_match('/[!@#$%^&*()_+\-=\[\]{};:\'",.<>?\/\|`~]/', $value)) {
            return false;
        }

        return true;
    }

    public function message()
    {
        return 'La contraseña debe tener al menos 12 caracteres, incluir mayúsculas, minúsculas, números y símbolos especiales.';
    }
}
```

### Usar en Validación

```php
use App\Rules\StrongPassword;

$request->validate([
    'password' => ['required', 'string', 'confirmed', new StrongPassword()],
]);
```

---

## 8. ARREGLAR DATOS SENSIBLES EN SESIÓN

### AuthController::login() - ANTES:
```php
session([
    'usr_id'   => $usuario->usr_id,
    'documento'=> $usuario->usr_documento,  // ❌ PII
    'correo'   => $correo,                 // ❌ PII
    'rol'      => $usuario->rol_id,
    'nombre'   => $perfil->nombre ?? '',
    'apellido' => $perfil->apellido ?? '',
]);
```

### DESPUÉS:
```php
session([
    'usr_id'   => $usuario->usr_id,
    'rol'      => $usuario->rol_id,
    'nombre'   => $perfil->nombre ?? '',
]);

// ✅ Los datos sensibles se obtienen del DB cuando sea necesario
// Por ejemplo: $usuario->usr_correo cuando se necesite el correo
```

---

## 9. ELIMINAR EMAILS DE RESPUESTA
