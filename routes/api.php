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
| API Públicas - Empresa
|--------------------------------------------------------------------------
*/

Route::get('/empresas', [EmpresaApiController::class, 'index']);
Route::get('/empresa/{nit}/ubicacion', [EmpresaApiController::class, 'obtenerUbicacion']);

/*
|--------------------------------------------------------------------------
| API Protegidas - Empresa (requieren sesión)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth.custom'])->group(function () {
    Route::get('/empresa/ubicacion/sesion', [EmpresaApiController::class, 'obtenerUbicacionSesion']);
    Route::put('/empresa/{id}/ubicacion', [EmpresaApiController::class, 'actualizarUbicacion']);
});
