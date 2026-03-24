<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\EmpresaApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/*
|--------------------------------------------------------------------------
| API Públicas - Empresa (SIN DATOS SENSIBLES)
|--------------------------------------------------------------------------
*/

// Nota: Estas rutas son públicas pero devuelven solo datos NO sensibles
// Las rutas que exponen emails, representantes, etc. REQUIEREN autenticación
// Route::get('/empresas', [EmpresaApiController::class, 'index']);
// Route::get('/empresa/{nit}/ubicacion', [EmpresaApiController::class, 'obtenerUbicacion']);

/*
|--------------------------------------------------------------------------
| API Protegidas - Empresa (requieren autenticación)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth.custom'])->group(function () {
    // Listar empresas (solo autenticados)
    Route::get('/empresas', [EmpresaApiController::class, 'index']);
    
    // Obtener ubicación de empresa (solo autenticados)
    Route::get('/empresa/{nit}/ubicacion', [EmpresaApiController::class, 'obtenerUbicacion']);
    
    // Obtener ubicación por sesión (autenticados)
    Route::get('/empresa/ubicacion/sesion', [EmpresaApiController::class, 'obtenerUbicacionSesion']);
    
    // Actualizar ubicación (autenticados)
    Route::put('/empresa/{id}/ubicacion', [EmpresaApiController::class, 'actualizarUbicacion']);
});
