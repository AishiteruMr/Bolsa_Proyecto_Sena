# 📋 CRONOGRAMA DE REFACTORIZACIÓN - PRUEBAS MANUALES

## ✅ Completado: Etapas 1, 2, 3

Toda la lógica ha sido refactorizada a patrones MVC de Laravel. Ahora necesitas **pruebas manuales** para validar que todo funciona correctamente.

---

## 🧪 ETAPA 4: PRUEBAS Y CORRECCIÓN DE ERRORES

### **TABLA DE PRUEBAS - FUNCIONALIDAD APRENDIZ**

#### 1️⃣ **PRUEBA: Dashboard del Aprendiz**

**Ruta**: `/aprendiz/dashboard`  
**Métodos involucrados**: `AprendizController@dashboard`, `AprendizService@obtenerEstadisticas`

**Validaciones a revisar**:
- [ ] ¿Carga correctamente la página?
- [ ] ¿Muestra el nombre del aprendiz?
- [ ] ¿Muestra las estadísticas correctas (total postulaciones, aprobadas, disponibles)?
- [ ] ¿Muestra 6 proyectos recientes?
- [ ] ¿Los proyectos recientes tienen empresa asignada?
- [ ] ¿Los botones funcionan (ver detalle, postularse)?

**Errores esperados a buscar**:
- [ ] Undefined property o relationship
- [ ] SQL errors
- [ ] Missing columns
- [ ] Null reference errors

---

#### 2️⃣ **PRUEBA: Explorar Proyectos**

**Ruta**: `/aprendiz/proyectos`  
**Métodos involucrados**: `AprendizController@proyectos`, `ProyectoService`

**Validaciones a revisar**:
- [ ] ¿Carga la lista de proyectos activos?
- [ ] ¿Funciona la búsqueda por título?
- [ ] ¿Funciona el filtro por categoría?
- [ ] ¿Muestra correctamente los proyectos ya postulados?
- [ ] ¿La paginación funciona (9 por página)?
- [ ] ¿Las categorías se cargan correctamente?

**Casos de prueba**:
```
1. Buscar "Laravel" → Debe mostrar solo proyectos con "Laravel" en el título
2. Filtrar por "Programación" → Debe mostrar solo proyectos de esa categoría
3. Combinar búsqueda + filtro → Debe funcionar correctamente
4. Ir a página 2 → Debe mostrar siguientes 9 proyectos
```

---

#### 3️⃣ **PRUEBA: Postular a Proyecto** ⭐ CRÍTICA

**Ruta**: `/aprendiz/proyectos/{id}/postular` (POST)  
**Métodos involucrados**: `AprendizController@postular`, `Postulacion@validarPostulacion`

**Validaciones a revisar**:
- [ ] ¿Se puede postular a un proyecto activo?
- [ ] ¿Se impide postular 2 veces al mismo proyecto?
- [ ] ¿Se impide postular si el proyecto no está activo?
- [ ] ¿Se impide postular si fue rechazado previamente?
- [ ] ¿Aparece mensaje de éxito?
- [ ] ¿Se guarda correctamente en BD?

**Casos de prueba**:
```
Caso 1: Postularse a proyecto nuevo
  1. Ir a /aprendiz/proyectos
  2. Click "Postularme" en un proyecto
  3. Ver mensaje: "✅ Postulación enviada correctamente"
  4. Verificar que el botón cambió a "✅ Ya postulado"

Caso 2: Intentar postularse 2 veces
  1. Postularse a un proyecto
  2. Recargar página
  3. Click "Postularme" nuevamente
  4. Debe aparecer: "Ya te postulaste a este proyecto"
  5. NO debe crear postulación duplicada

Caso 3: Postular a proyecto vencido
  1. Encontrar un proyecto con fecha vencida
  2. Click "Postularme"
  3. Debe aparecer: "El proyecto no está disponible para postulaciones"
```

---

#### 4️⃣ **PRUEBA: Mis Postulaciones**

**Ruta**: `/aprendiz/mis-postulaciones`  
**Métodos involucrados**: `AprendizController@misPostulaciones`, `PostulacionService`

**Validaciones a revisar**:
- [ ] ¿Muestra todas las postulaciones del aprendiz?
- [ ] ¿Muestra el estado de cada postulación (Pendiente, Aprobada, Rechazada)?
- [ ] ¿Muestra información de la empresa?
- [ ] ¿Muestra información del proyecto?
- [ ] ¿El botón "Ver Detalle" solo aparece si está aprobada?
- [ ] ¿La paginación funciona (10 por página)?
- [ ] ¿Se ordenan por fecha más reciente?

**Casos de prueba**:
```
1. Tener 0 postulaciones → Debe mostrar mensaje "No tienes postulaciones"
2. Tener 15 postulaciones → Debe mostrar 10 en página 1, 5 en página 2
3. Click en "Ver Detalle" (si está aprobada) → Ir a detalle del proyecto
```

---

#### 5️⃣ **PRUEBA: Historial de Proyectos**

**Ruta**: `/aprendiz/historial`  
**Métodos involucrados**: `AprendizController@historial`

**Validaciones a revisar**:
- [ ] ¿Muestra todos los proyectos a los que se postulo?
- [ ] ¿Muestra el estado de cada postulación?
- [ ] ¿Muestra el instructor asignado (o "No asignado" si no hay)?
- [ ] ¿Muestra días restantes correctamente?
- [ ] ¿Diferencia entre proyectos "Activos" y "Finalizados"?
- [ ] ¿Muestra empresa correctamente?

---

#### 6️⃣ **PRUEBA: Ver Detalle de Proyecto Aprobado** ⭐ CRÍTICA

**Ruta**: `/aprendiz/proyectos/{id}/detalle`  
**Métodos involucrados**: `AprendizController@verDetalleProyecto`, `AprendizService`

**Validaciones a revisar**:
- [ ] ¿Se carga el detalle correctamente?
- [ ] ¿Muestra todas las etapas del proyecto?
- [ ] ¿Las etapas están ordenadas correctamente?
- [ ] ¿Se impide acceso si la postulación no está aprobada?
- [ ] ¿Se impide acceso si intentas manipular la URL?
- [ ] ¿Muestra evidencias previas del aprendiz?
- [ ] ¿Se puede enviar nueva evidencia?

**Casos de prueba**:
```
Caso 1: Acceder a proyecto aprobado
  1. Ir a /aprendiz/mis-postulaciones
  2. Click "Ver Detalle" en postulación aprobada
  3. Debe cargar correctamente

Caso 2: Intentar acceder a proyecto no aprobado
  1. Ir a URL: /aprendiz/proyectos/{id-no-aprobado}/detalle
  2. Debe aparecer error 403: "No tienes acceso..."

Caso 3: Proyecto que no existe
  1. Ir a URL: /aprendiz/proyectos/99999/detalle
  2. Debe aparecer error 404
```

---

#### 7️⃣ **PRUEBA: Enviar Evidencia** ⭐ CRÍTICA

**Ruta**: `/aprendiz/proyectos/{proId}/etapas/{etaId}/evidencia` (POST)  
**Métodos involucrados**: `AprendizController@enviarEvidencia`, `EvidenciaService`

**Validaciones a revisar**:
- [ ] ¿Se valida que la descripción sea requerida?
- [ ] ¿Se valida que el archivo sea máximo 5MB?
- [ ] ¿Se acepta archivo nulo (descripción sin archivo)?
- [ ] ¿Se guarda correctamente en BD?
- [ ] ¿El archivo se guarda en storage/evidencias?
- [ ] ¿Se valida que la etapa pertenece al proyecto?
- [ ] ¿Aparecer evidencia anterior en el listado?

**Casos de prueba**:
```
Caso 1: Enviar evidencia con descripción y archivo
  1. Ir a detalle de proyecto aprobado
  2. Buscar una etapa
  3. Llenar: descripción + subir archivo
  4. Click "Enviar Evidencia"
  5. Mensaje: "✅ Evidencia enviada correctamente"
  6. Debe aparecer en el listado de evidencias

Caso 2: Enviar evidencia sin descripción
  1. Intentar enviar sin descripción
  2. Debe mostrar error: "La descripción es obligatoria"

Caso 3: Enviar archivo > 5MB
  1. Seleccionar archivo > 5MB
  2. Debe mostrar error: "El archivo no puede ser mayor a 5MB"

Caso 4: Enviar solo descripción (sin archivo)
  1. Llenar solo descripción
  2. NO seleccionar archivo
  3. Click enviar
  4. Debe funcionar correctamente
```

---

#### 8️⃣ **PRUEBA: Mis Entregas**

**Ruta**: `/aprendiz/mis-entregas`  
**Métodos involucrados**: `AprendizController@misEntregas`, `EvidenciaService`

**Validaciones a revisar**:
- [ ] ¿Muestra solo proyectos aprobados?
- [ ] ¿Muestra todas las evidencias enviadas?
- [ ] ¿Agrupa evidencias por proyecto?
- [ ] ¿Muestra el estado de cada evidencia?
- [ ] ¿Permite descargar archivos?
- [ ] ¿Muestra comentarios del instructor (si existen)?

---

#### 9️⃣ **PRUEBA: Perfil del Aprendiz**

**Ruta**: `/aprendiz/perfil`  
**Métodos involucrados**: `AprendizController@perfil`, `AprendizController@actualizarPerfil`

**Validaciones a revisar**:
- [ ] ¿Carga los datos actuales del aprendiz?
- [ ] ¿Valida que nombre sea requerido?
- [ ] ¿Valida que apellido sea requerido?
- [ ] ¿Valida que programa sea requerido?
- [ ] ¿Valida máximo 50 caracteres en nombre/apellido?
- [ ] ¿Valida máximo 100 caracteres en programa?
- [ ] ¿Permite cambiar contraseña (opcional)?
- [ ] ¿Valida mínimo 6 caracteres en contraseña?
- [ ] ¿Valida confirmación de contraseña?
- [ ] ¿Actualiza la sesión después de cambios?

**Casos de prueba**:
```
Caso 1: Actualizar datos básicos
  1. Cambiar nombre y apellido
  2. Click "Guardar Cambios"
  3. Debe mostrar: "✅ Perfil actualizado correctamente"
  4. Verificar que el nombre cambió en la sesión

Caso 2: Cambiar contraseña
  1. Llenar: Nueva Contraseña + Confirmar
  2. Click "Guardar Cambios"
  3. Mensaje de éxito
  4. Verificar que puedes loguearte con la nueva contraseña

Caso 3: Contraseñas no coinciden
  1. Llenar contraseña diferente en confirmación
  2. Debe mostrar error: "Las contraseñas no coinciden"
```

---

### **RESUMEN DE ESTADO**

| Etapa | Descripción | Estado |
|-------|-------------|--------|
| 1 | Adaptar lógica de postulación | ✅ COMPLETADO |
| 2 | Adaptar consultas a Laravel | ✅ COMPLETADO |
| 3 | Patrón MVC | ✅ COMPLETADO |
| 4 | Pruebas manuales | 🔄 EN PROCESO |

---

### **PRÓXIMOS PASOS**

1. **Realizar todas las pruebas manuales** en tu navegador
2. **Anotar cualquier error** encontrado
3. **Reportar aquí** para corregir bugs
4. **Validar en diferentes navegadores** (Chrome, Firefox, Safari)
5. **Validar en móvil** (responsivo)
6. **Hacer commit final** cuando todo funcione

---

### **ERRORES COMUNES A BUSCAR**

❌ **Errors 500 (Server Error)**
- Generalmente significa: falta `use` en un modelo, typo en relación, o método inexistente

❌ **Errors 403 (Forbidden)**
- Significa: validación de acceso fallando. Verifica postulación aprobada

❌ **Errors 404 (Not Found)**
- Significa: modelo no encontrado. Verifica que el ID existe en BD

❌ **Atributos undefined**
- Significa: falta cargar relación con `->with()` o cambió el nombre del atributo

❌ **SQL errors**
- Significa: el nombre de columna o tabla es incorrecto

---

## 📱 VALIDAR RESPONSIVO

Todas las páginas deben verse bien en:
- [ ] Desktop (1920px)
- [ ] Tablet (768px)
- [ ] Móvil (375px)

---

## 🎯 DEFINICIÓN DE "LISTO"

El cronograma estará 100% completado cuando:

✅ Todas las 9 pruebas pasen correctamente  
✅ No haya errores 500, 403, 404  
✅ Los datos se guardan correctamente en BD  
✅ Las relaciones Eloquent funcionan  
✅ Los servicios se usan correctamente  
✅ El código es limpio y sigue patrones MVC  
✅ Responsivo en móvil, tablet, desktop  
✅ Commit final hecho  

---

## 🚀 ¡LISTO PARA EMPEZAR LAS PRUEBAS!

Prueba cada funcionalidad y reporta los errores que encuentres.
