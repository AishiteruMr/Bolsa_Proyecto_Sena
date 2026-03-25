<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotificacionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AprendizController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProyectoController;

/*
|--------------------------------------------------------------------------
| Rutas públicas
|--------------------------------------------------------------------------
*/


Route::get('/', [HomeController::class, 'index'])->name('home');
=======

Route::get('/', function () {
    return view('index');
})->name('home');


Route::get('/nosotros', function () {
    return view('nosotros');
})->name('nosotros');

/*
|--------------------------------------------------------------------------
| Rutas de autenticación
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Recuperación de contraseña
Route::get('/olvide-contraseña', [AuthController::class, 'showOlvideContraseña'])->name('auth.olvide-contraseña');
Route::post('/enviar-recuperacion', [AuthController::class, 'enviarEnlaceRecuperacion'])->name('auth.enviar-recuperacion');
Route::get('/recuperar-contraseña/{token}', [AuthController::class, 'mostrarFormularioRestablecerContraseña'])->name('auth.mostrar-restablecer');
Route::post('/restablecer-contraseña', [AuthController::class, 'restablecerContraseña'])->name('auth.restablecer-contraseña');

// Registros
Route::get('/registro/aprendiz', [AuthController::class, 'showRegistroAprendiz'])->name('registro.aprendiz');
Route::get('/registro/empresa', [AuthController::class, 'showRegistroEmpresa'])->name('registro.empresa');
Route::get('/registro/instructor', [AuthController::class, 'showRegistroInstructor'])->name('registro.instructor');
Route::post('/registro/aprendiz', [AuthController::class, 'registrarAprendiz'])->name('registro.aprendiz.post');
Route::post('/registro/empresa', [AuthController::class, 'registrarEmpresa'])->name('registro.empresa.post');
Route::post('/registro/instructor', [AuthController::class, 'registrarInstructor'])->name('registro.instructor.post');

/*
|--------------------------------------------------------------------------
| Rutas protegidas — Aprendiz (rol 1)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth.custom', 'rol:1'])->prefix('aprendiz')->name('aprendiz.')->group(function () {
    Route::get('/dashboard', [AprendizController::class, 'dashboard'])->name('dashboard');
    Route::get('/proyectos', [AprendizController::class, 'proyectos'])->name('proyectos');
    Route::post('/proyectos/{id}/postular', [AprendizController::class, 'postular'])->name('postular');
    Route::get('/mis-postulaciones', [AprendizController::class, 'misPostulaciones'])->name('postulaciones');
    Route::get('/proyectos/{id}/detalle', [AprendizController::class, 'verDetalleProyecto'])->name('proyecto.detalle');
    Route::post('/proyectos/{proId}/etapas/{etaId}/evidencia', [AprendizController::class, 'enviarEvidencia'])->name('evidencia.enviar');
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
    Route::post('/postulaciones/{id}/estado', [EmpresaController::class, 'cambiarEstadoPostulacion'])->name('postulaciones.estado');
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
    // 🔥 ESTA ES LA QUE FALTABA
    Route::get('/proyectos/{id}', [InstructorController::class, 'detalleProyecto'])->name('proyecto.detalle');
    Route::get('/historial', [InstructorController::class, 'historial'])->name('historial');
    Route::get('/proyectos/{id}/reporte', [InstructorController::class, 'reporteSeguimiento'])->name('reporte');
    Route::post('/postulaciones/{id}/estado', [InstructorController::class, 'cambiarEstadoPostulacion'])->name('postulaciones.estado');
    
    // RUTAS PARA ETAPAS
    Route::post('/proyectos/{id}/etapas', [InstructorController::class, 'crearEtapa'])->name('etapas.crear');
    Route::put('/etapas/{id}', [InstructorController::class, 'editarEtapa'])->name('etapas.editar');
    Route::delete('/etapas/{id}', [InstructorController::class, 'eliminarEtapa'])->name('etapas.eliminar');
    
    // RUTAS PARA IMAGEN DE PROYECTO
    Route::post('/proyectos/{id}/imagen', [InstructorController::class, 'subirImagenProyecto'])->name('proyectos.imagen');
    
    // RUTAS PARA EVIDENCIAS
    Route::get('/proyectos/{id}/evidencias', [InstructorController::class, 'verEvidencias'])->name('evidencias.ver');
    Route::put('/evidencias/{id}', [InstructorController::class, 'calificarEvidencia'])->name('evidencias.calificar');
    
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
    Route::post('/usuarios/{id}/estado', [AdminController::class, 'cambiarEstadoUsuario'])->name('usuarios.estado');
    Route::get('/empresas', [AdminController::class, 'empresas'])->name('empresas');
    Route::post('/empresas/{id}/estado', [AdminController::class, 'cambiarEstadoEmpresa'])->name('empresas.estado');
    Route::get('/proyectos', [AdminController::class, 'proyectos'])->name('proyectos');
    Route::post('/proyectos/{id}/estado', [AdminController::class, 'cambiarEstadoProyecto'])->name('proyectos.estado');
    Route::post('/proyectos/{id}/asignar', [AdminController::class, 'asignarInstructor'])
    ->name('proyectos.asignar');
    Route::get('/exportar/proyectos', [AdminController::class, 'exportarProyectos'])->name('proyectos.exportar');
    
});

// Rutas compartidas para todos los usuarios autenticados
Route::middleware(['auth.custom'])->group(function () {
    Route::get('/notificaciones', [NotificacionController::class, 'index'])->name('notificaciones.index');
    Route::post('/notificaciones/{id}/leer', [NotificacionController::class, 'leer'])->name('notificaciones.leer');
    Route::post('/notificaciones/leer-todas', [NotificacionController::class, 'leerTodas'])->name('notificaciones.leer_todas');
});
