<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AprendizController;
use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\NotificacionController;
use App\Http\Controllers\StatsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rutas públicas
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/nosotros', function () {
    return view('nosotros');
})->name('nosotros');

/*
|--------------------------------------------------------------------------
| Rutas de autenticación
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post')->middleware('throttle:5,1');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verifyEmail'])->name('verification.verify')->middleware('signed');
Route::get('/email/resend-verification', [AuthController::class, 'resendVerification'])->name('verification.resend');

// Recuperación de contraseña
Route::get('/olvide-contraseña', [AuthController::class, 'showOlvideContraseña'])->name('auth.olvide-contraseña');
Route::post('/enviar-recuperacion', [AuthController::class, 'enviarEnlaceRecuperacion'])->name('auth.enviar-recuperacion')->middleware('throttle:3,1');
// ✅ SEGURIDAD: Nueva ruta sin email en query parameters
Route::get('/recuperar-contraseña/{token}', [AuthController::class, 'mostrarFormularioRestablecerContraseña'])->name('auth.mostrar-restablecer-seguro');
Route::post('/restablecer-contraseña', [AuthController::class, 'restablecerContraseña'])->name('auth.restablecer-contraseña')->middleware('throttle:5,1');

// Registros
Route::get('/registro/aprendiz', [AuthController::class, 'showRegistroAprendiz'])->name('registro.aprendiz');
Route::get('/registro/empresa', [AuthController::class, 'showRegistroEmpresa'])->name('registro.empresa');
Route::get('/registro/instructor', [AuthController::class, 'showRegistroInstructor'])->name('registro.instructor');
Route::post('/registro/aprendiz', [AuthController::class, 'registrarAprendiz'])->name('registro.aprendiz.post')->middleware('throttle:5,1');
Route::post('/registro/empresa', [AuthController::class, 'registrarEmpresa'])->name('registro.empresa.post')->middleware('throttle:5,1');
Route::post('/registro/instructor', [AuthController::class, 'registrarInstructor'])->name('registro.instructor.post')->middleware('throttle:5,1');

Route::middleware(['auth.custom'])->group(function () {
    Route::get('/notificaciones', [NotificacionController::class, 'index'])->name('notificaciones.index');
    Route::post('/notificaciones/leer-todas', [NotificacionController::class, 'leerTodas'])->name('notificaciones.leer_todas');
    Route::post('/notificaciones/{id}/leer', [NotificacionController::class, 'leer'])->name('notificaciones.leer');
});

/*
|--------------------------------------------------------------------------
| Rutas protegidas — Aprendiz (rol 1)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth.custom', 'rol:1'])->prefix('aprendiz')->name('aprendiz.')->group(function () {
    Route::get('/dashboard', [AprendizController::class, 'dashboard'])->name('dashboard');
    Route::get('/proyectos', [AprendizController::class, 'proyectos'])->name('proyectos');
    // ✅ SEGURIDAD: Rate limiting en postulación (máx 10/minuto)
    Route::post('/proyectos/{id}/postular', [AprendizController::class, 'postular'])->name('postular')->middleware('throttle:10,1');
    Route::get('/mis-postulaciones', [AprendizController::class, 'misPostulaciones'])->name('postulaciones');
    Route::get('/proyectos/{id}/detalle', [AprendizController::class, 'verDetalleProyecto'])->name('proyecto.detalle');
    // ✅ SEGURIDAD: Rate limiting en envío de evidencia (máx 20/minuto)
    Route::post('/proyectos/{proId}/etapas/{etaId}/evidencia', [AprendizController::class, 'enviarEvidencia'])->name('evidencia.enviar')->middleware('throttle:20,1');
    Route::get('/historial', [AprendizController::class, 'historial'])->name('historial');
    Route::get('/mis-entregas', [AprendizController::class, 'misEntregas'])->name('entregas');
    Route::get('/perfil', [AprendizController::class, 'perfil'])->name('perfil');
    Route::put('/perfil', [AprendizController::class, 'actualizarPerfil'])->name('perfil.update');
});

/*
|--------------------------------------------------------------------------
| Rutas protegidas — Empresa (rol 3)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth.custom', 'rol:3'])->prefix('empresa')->name('empresa.')->group(function () {
    Route::get('/dashboard', [EmpresaController::class, 'dashboard'])->name('dashboard');
    Route::get('/proyectos', [EmpresaController::class, 'proyectos'])->name('proyectos');
    Route::get('/proyectos/crear', [EmpresaController::class, 'crearProyecto'])->name('proyectos.crear');
    Route::post('/proyectos', [EmpresaController::class, 'guardarProyecto'])->name('proyectos.store');
    Route::get('/proyectos/{id}/editar', [EmpresaController::class, 'editarProyecto'])->name('proyectos.edit');
    Route::put('/proyectos/{id}', [EmpresaController::class, 'actualizarProyecto'])->name('proyectos.update');
    Route::delete('/proyectos/{id}', [EmpresaController::class, 'eliminarProyecto'])->name('proyectos.destroy');
    Route::get('/proyectos/{id}/postulantes', [EmpresaController::class, 'verPostulantes'])->name('proyectos.postulantes');
    Route::get('/proyectos/{id}/participantes', [EmpresaController::class, 'verParticipantes'])->name('proyectos.participantes');
    Route::get('/proyectos/{id}/reporte', [EmpresaController::class, 'verReporte'])->name('proyectos.reporte');
    // ✅ SEGURIDAD: Rate limiting en cambio de estado (máx 30/minuto)
    Route::post('/postulaciones/{id}/estado', [EmpresaController::class, 'cambiarEstadoPostulacion'])->name('postulaciones.estado')->middleware('throttle:30,1');
    Route::get('/perfil', [EmpresaController::class, 'perfil'])->name('perfil');
    Route::put('/perfil', [EmpresaController::class, 'actualizarPerfil'])->name('perfil.update');
});

/*
|--------------------------------------------------------------------------
| Rutas protegidas — Instructor (rol 2)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth.custom', 'rol:2'])->prefix('instructor')->name('instructor.')->group(function () {
    Route::get('/dashboard', [InstructorController::class, 'dashboard'])->name('dashboard');
    Route::get('/proyectos', [InstructorController::class, 'proyectos'])->name('proyectos');
    Route::get('/proyectos/{id}', [InstructorController::class, 'detalleProyecto'])->name('proyecto.detalle');
    Route::get('/historial', [InstructorController::class, 'historial'])->name('historial');
    Route::get('/proyectos/{id}/reporte', [InstructorController::class, 'reporteSeguimiento'])->name('reporte');
    // ✅ SEGURIDAD: Rate limiting en cambio de estado (máx 30/minuto)
    Route::post('/postulaciones/{id}/estado', [InstructorController::class, 'cambiarEstadoPostulacion'])->name('postulaciones.estado')->middleware('throttle:30,1');

    // RUTAS PARA ETAPAS
    Route::post('/proyectos/{id}/etapas', [InstructorController::class, 'crearEtapa'])->name('etapas.crear');
    Route::put('/etapas/{id}', [InstructorController::class, 'editarEtapa'])->name('etapas.editar');
    Route::delete('/etapas/{id}', [InstructorController::class, 'eliminarEtapa'])->name('etapas.eliminar');

    // RUTAS PARA IMAGEN DE PROYECTO
    Route::post('/proyectos/{id}/imagen', [InstructorController::class, 'subirImagenProyecto'])->name('proyectos.imagen');

    // RUTAS PARA EVIDENCIAS
    Route::get('/proyectos/{id}/evidencias', [InstructorController::class, 'verEvidencias'])->name('evidencias.ver');
    // ✅ SEGURIDAD: Rate limiting en calificación (máx 20/minuto)
    Route::put('/evidencias/{id}', [InstructorController::class, 'calificarEvidencia'])->name('evidencias.calificar')->middleware('throttle:20,1');

    Route::get('/aprendices', [InstructorController::class, 'aprendices'])->name('aprendices');
    Route::get('/perfil', [InstructorController::class, 'perfil'])->name('perfil');
    Route::put('/perfil', [InstructorController::class, 'actualizarPerfil'])->name('perfil.update');
});

/*
|--------------------------------------------------------------------------
| Rutas protegidas — Administrador (rol 4)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth.custom', 'rol:4'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/usuarios', [AdminController::class, 'usuarios'])->name('usuarios');
    // ✅ SEGURIDAD: Rate limiting en cambio de estado (máx 30/minuto)
    Route::post('/usuarios/{id}/estado', [AdminController::class, 'cambiarEstadoUsuario'])->name('usuarios.estado')->middleware('throttle:30,1');
    Route::get('/empresas', [AdminController::class, 'empresas'])->name('empresas');
    // ✅ SEGURIDAD: Rate limiting en cambio de estado (máx 30/minuto)
    Route::post('/empresas/{id}/estado', [AdminController::class, 'cambiarEstadoEmpresa'])->name('empresas.estado')->middleware('throttle:30,1');
    Route::get('/proyectos', [AdminController::class, 'proyectos'])->name('proyectos');
    Route::get('/proyectos/{id}/revisar', [AdminController::class, 'revisarProyecto'])->name('proyectos.revisar');
    // ✅ SEGURIDAD: Rate limiting en cambio de estado (máx 20/minuto)
    Route::post('/proyectos/{id}/estado', [AdminController::class, 'cambiarEstadoProyecto'])->name('proyectos.estado')->middleware('throttle:20,1');
    // ✅ SEGURIDAD: Rate limiting en asignación (máx 20/minuto)
    Route::post('/proyectos/{id}/asignar', [AdminController::class, 'asignarInstructor'])->name('proyectos.asignar')->middleware('throttle:20,1');

    // ✅ SEGURIDAD: Rate limiting en exportaciones (máx 10/minuto por seguridad)
    Route::get('/exportar/proyectos', [ExportController::class, 'proyectos'])->name('exportar.proyectos')->middleware('throttle:10,1');
    Route::get('/exportar/usuarios', [ExportController::class, 'usuarios'])->name('exportar.usuarios')->middleware('throttle:10,1');
    Route::get('/exportar/empresas', [ExportController::class, 'empresas'])->name('exportar.empresas')->middleware('throttle:10,1');
    Route::get('/exportar/aprendices', [ExportController::class, 'aprendices'])->name('exportar.aprendices')->middleware('throttle:10,1');
    Route::get('/exportar/instructores', [ExportController::class, 'instructores'])->name('exportar.instructores')->middleware('throttle:10,1');

    Route::get('/audit', [AuditLogController::class, 'index'])->name('audit');
});

Route::middleware(['auth.custom', 'rol:4'])->get('/api/admin/stats', [StatsController::class, 'dashboard'])->name('api.admin.stats');

Route::middleware(['auth.custom'])->group(function () {
    Route::get('/api/infinite/proyectos', [InfiniteScrollController::class, 'proyectos'])->name('api.infinite.proyectos');
    Route::get('/api/infinite/aprendices', [InfiniteScrollController::class, 'aprendices'])->name('api.infinite.aprendices');
    Route::middleware(['auth.custom', 'rol:3'])->get('/api/infinite/proyectos-empresa', [InfiniteScrollController::class, 'proyectosEmpresa'])->name('api.infinite.proyectos-empresa');
});
