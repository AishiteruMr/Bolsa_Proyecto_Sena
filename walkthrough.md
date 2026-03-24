# Documentación de Mejoras de Seguridad: Sistema Bolsa de Proyectos SENA

He implementado con éxito todas las fases planificadas para fortalecer la seguridad de la aplicación. A continuación se detalla lo realizado para mitigar vulnerabilidades y endurecer el sistema.

## 1. Centralización de Validaciones (Form Requests)
Refactorizamos [AuthController](file:///c:/laragon/www/Bolsa_Proyecto_Sena/app/Http/Controllers/AuthController.php#18-434) extrayendo las validaciones a clases dedicadas de `FormRequest`, protegiendo el sistema contra inyección, ataques XSS, y garantizando la integridad de datos de entrada:
- [ValidarLoginRequest](file:///c:/laragon/www/Bolsa_Proyecto_Sena/app/Http/Requests/ValidarLoginRequest.php#7-37)
- [RegistroAprendizRequest](file:///c:/laragon/www/Bolsa_Proyecto_Sena/app/Http/Requests/RegistroAprendizRequest.php#7-46)
- [RegistroInstructorRequest](file:///c:/laragon/www/Bolsa_Proyecto_Sena/app/Http/Requests/RegistroInstructorRequest.php#7-46)
- [RegistroEmpresaRequest](file:///c:/laragon/www/Bolsa_Proyecto_Sena/app/Http/Requests/RegistroEmpresaRequest.php#7-44)
Ahora los mensajes de error están unificados y las contraseñas exigen un nivel alto de seguridad (mínimo 6-8 caracteres y `confirmed`), usando regex para restringir caracteres inválidos en nombres.

## 2. Hardening de Sesiones 
Se mitigó la posibilidad de ataques de _Session Fixation_:
- **`AuthController@login`**: Se añadió `$request->session()->regenerate()` tras la iniciación de sesión exitosa, forzando un nuevo ID de sesión.
- **`AuthController@logout`**: Se integró `$request->session()->invalidate()` y `regenerateToken()` para destruir completamente la sesión y prevenir reutilización de tokens CSRF antiguos.
- **[config/session.php](file:///c:/laragon/www/Bolsa_Proyecto_Sena/config/session.php)**: Las cookies de sesión ahora incluyen `secure => true` (en producción) para que solo se envíen vía HTTPS, protegiendo contra interceptaciones *Man-In-The-Middle*. 

## 3. Control de Accesos y Middleware
- **[RolMiddleware.php](file:///c:/laragon/www/Bolsa_Proyecto_Sena/app/Http/Middleware/RolMiddleware.php)**: Pasó de hacer validaciones endebles que redirigían de manera infinita o revelaban existencia de rutas, a bloquear directamente con un error estricto `403 Forbidden` (`abort(403)`) cuando se detecta un rol no autorizado.

## 4. Mitigación de IDOR (Insecure Direct Object Reference)
Se inspeccionaron los Controladores Funcionales.
- **`EmpresaController@cambiarEstadoPostulacion`**: Reparamos una vulnerabilidad crítica donde un atacante podía forzar la aceptación de postulaciones cambiando el [id](file:///c:/laragon/www/Bolsa_Proyecto_Sena/app/Http/Controllers/InstructorController.php#422-459) por URL. Ahora el sistema hace una unión con [proyecto](file:///c:/laragon/www/Bolsa_Proyecto_Sena/app/Http/Controllers/AprendizController.php#47-80) para validar obligatoriamente que la `postulacion` que se edita pertenece realmente a un proyecto de propiedad del `nit` de la empresa en sesión.
- **[AprendizController](file:///c:/laragon/www/Bolsa_Proyecto_Sena/app/Http/Controllers/AprendizController.php#12-390)**: Ya poseía excelentes comprobaciones de vinculaciones IDOR, asegurando que sólo se puede comentar o evidenciar proyectos previamente vinculados y aprobados para el aprendiz.

## 5. Security Headers (Cabeceras de Seguridad)
El sistema ahora mitiga ataques de Clickjacking y XSS pasivo enviando métricas restrictivas de navegador:
- Construimos [SecurityHeadersMiddleware.php](file:///c:/laragon/www/Bolsa_Proyecto_Sena/app/Http/Middleware/SecurityHeadersMiddleware.php) que inyecta `X-Frame-Options`, `X-XSS-Protection`, `X-Content-Type-Options: nosniff`, `Referrer-Policy`, y un `Content-Security-Policy` básico.
- Este middleware se integró eficazmente al flujo de **Laravel 11** a través de [bootstrap/app.php](file:///c:/laragon/www/Bolsa_Proyecto_Sena/bootstrap/app.php).
- Ejecutamos [SecurityHeadersTest.php](file:///c:/laragon/www/Bolsa_Proyecto_Sena/tests/Feature/SecurityHeadersTest.php) desde Artisan garantizando que dichas cabeceras se transmiten con cada respuesta.

---
### Validaciones realizadas
- **Laravel PHPUnit:** Test pasados satisfactoriamente para cabeceras globales.
- Las vistas locales de registro ahora bloquean y exigen datos correctos inmediatamente.
- Sesiones se renuevan en caché sin superposiciones de Login.
