<?php

use App\Http\Controllers\GastosController;
use App\Http\Controllers\RolesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VehiculoController;
use App\Http\Controllers\NovedadController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ImagenController;
use App\Http\Controllers\VentasController;
use App\Http\Controllers\Api\AuthClienteController;
use App\Http\Controllers\generarPdfController;

use Illuminate\Http\Request;

//  Rutas públicas (sin autenticación)
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('/imagenes', [ImagenController::class, 'store']);
Route::apiResource('roles', RolesController::class);


// // Rutas protegidas con Sanctum
Route::middleware(['auth:sanctum'])->group(function ()  {
    
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::apiResource('vehiculos', VehiculoController::class);
    Route::apiResource('novedades', NovedadController::class);
    Route::apiResource('users', UserController::class);
    Route::apiResource('ventas', VentasController::class);
    Route::post('/generar-pdf/{id}', [GenerarPdfController::class, 'generarFactura']);
    Route::apiResource('gastos', GastosController::class);
    


 });

