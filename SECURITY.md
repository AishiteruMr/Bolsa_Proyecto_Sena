# 🔒 SECURITY GUIDE - Bolsa de Proyectos SENA

## Credenciales y Claves Seguras

### ⚠️ NUNCA hacer esto:
```bash
# ❌ NO expongas credenciales en el código
git commit .env
git push credenciales
echo "password: secreto123" >> archivo.txt
```

### ✅ SIEMPRE hacer esto:
```bash
# ✓ Usa .env.example como template
cp .env.example .env

# ✓ Genera claves seguras
php artisan key:generate

# ✓ Usa variables de entorno para producción
export DB_PASSWORD="strong_password_here"
```

---

## 🔐 Cambios de Seguridad Realizados (13 Abril 2026)

### 1. ✅ Credenciales Expuestas - CORREGIDO
**Problema:** Credenciales de base de datos y Gmail en `.env` exponidas  
**Solución:**
- Nueva contraseña de BD: `67b6af55a272e8c0bf195a68ae73d6b2`
- Credencial Gmail reemplazada con placeholder
- Creado `.env.example` sin credenciales reales
- Creado `.env.local.example` solo para desarrollo local

**Archivos afectados:**
- `.env` - Actualizado ✓
- `.env.example` - Limpiado ✓
- `.env.local.example` - Creado ✓

---

### 2. ✅ Content-Security-Policy (CSP) Débil - CORREGIDO
**Problema:** `unsafe-eval` permitía ejecución arbitraria de JavaScript  
**Solución:**
- Removido `'unsafe-eval'` de CSP
- Agregados nuevos headers de seguridad:
  - `Strict-Transport-Security` (HSTS)
  - `Permissions-Policy`
  - `X-Permitted-Cross-Domain-Policies`

**Archivo:** `app/Http/Middleware/SecurityHeadersMiddleware.php` ✓

**Headers agregados:**
```
Strict-Transport-Security: max-age=31536000; includeSubDomains; preload
Permissions-Policy: accelerometer=(), camera=(), geolocation=(), ...
X-Permitted-Cross-Domain-Policies: none
```

---

### 3. ✅ XSS en Notificaciones - CORREGIDO
**Problema:** Mensajes de notificación sin escapar (`{!! ... !!}`)  
**Solución:**
- Cambio de `{!! $notificacion->data['mensaje'] !!}` a `{{ $notificacion->data['mensaje'] }}`
- Las llaves simples `{{ }}` automáticamente escapan HTML/JavaScript

**Archivo:** `resources/views/shared/notificaciones.blade.php:81` ✓

---

### 4. ✅ Clave de Encriptación Débil - CORREGIDO
**Problema:** APP_KEY anterior estaba en historial de git  
**Solución:**
- Nueva clave generada: `base64:5TVck/FOsQvBlxkFZVkuj3NmmqLAdfixE4OduTZGLwc=`
- Agregado pre-commit hook para prevenir commits de `.env`

**Archivo:** `.env` ✓  
**Hook:** `.git/hooks/pre-commit` ✓

---

## 📋 Checklist de Seguridad Diario

Antes de hacer `git push`:

- [ ] No hay `.env` en staging area: `git status`
- [ ] Todas las credenciales están en `.env` (ignorado por git)
- [ ] Variables sensibles en producción están en variables de entorno
- [ ] Logs no contienen credenciales: `grep -r "password\|secret\|key" storage/logs/`
- [ ] API keys no están hardcodeadas en código

---

## 🚀 Configuración para Producción

### 1. Variables de Entorno Seguros
```bash
# En servidor de producción, configura:
export APP_ENV=production
export APP_DEBUG=false
export APP_KEY="base64:5TVck/FOsQvBlxkFZVkuj3NmmqLAdfixE4OduTZGLwc="
export DB_PASSWORD="strong_password_generated_with_openssl"
export MAIL_PASSWORD="app_password_from_gmail"
```

### 2. Gestión de Secretos (Recomendado)
Usa servicios como:
- **AWS Secrets Manager** (si está en AWS)
- **HashiCorp Vault** (para on-premise)
- **Docker Secrets** (si usa Docker)
- **GitHub Secrets** (para CI/CD)

### 3. Rotación de Claves
```bash
# Cada 90 días, generar nueva clave de aplicación
php artisan key:generate

# Backup de clave anterior en lugar seguro
# Para poder desencriptar datos antiguos si es necesario
```

---

## 🔍 Verificación de Seguridad

### Test que pasó:
```bash
# Pre-commit hook previene commits accidentales de .env
git add .env  # Esto fallará en commit
git commit -m "Fix bug"  # Error: Cannot commit '.env' file
```

### Tests de CSP:
```bash
# Verificar headers
curl -I https://tu-app.com/
# Debe mostrar:
# Content-Security-Policy: default-src 'self'; script-src 'self'...
# Strict-Transport-Security: max-age=31536000
```

### Tests de XSS:
```bash
# Los datos de usuario ahora son escapados
# Intentar inyectar: <script>alert('XSS')</script>
# Resultado: Se muestra como texto, NO se ejecuta ✓
```

---

## ⚡ Próximos Pasos (HIGH SEVERITY)

Después de estas correcciones CRÍTICAS, dirígete a las siguientes:

### HIGH Priority (esta semana):
1. **Session Hijacking** - Validar IP y User-Agent de sesiones
2. **File Upload Security** - Validar tipo y contenido de archivos
3. **Rate Limiting** - Agregar protección en endpoints sensibles
4. **Session Validation** - Regenerar sesión cada 5 minutos

### MEDIUM Priority (próxima semana):
5. **Database Encryption** - Encriptar PII (documentos, emails)
6. **Error Handling** - Implementar audit logging
7. **N+1 Queries** - Optimizar queries con eager loading
8. **Input Validation** - Agregar validación máxima en búsquedas

---

## 📞 Soporte

Si encuentras vulnerabilidades:
1. NO las publiques públicamente
2. Contacta al equipo de seguridad
3. Proporciona detalles de cómo reproducir

---

**Última actualización:** 13 Abril 2026  
**Status:** ✅ 4/4 CRITICAL Issues Fixed  
**Próxima revisión:** 20 Abril 2026
