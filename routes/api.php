<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\RestauranteController;

Route::prefix('v1')->group(function () {
    // Rutas públicas
    Route::post('/registro', [AuthController::class, 'registro']);
    Route::post('/login', [AuthController::class, 'login']);

    // Rutas protegidas, requieren estar autenticado con Sanctum
    Route::middleware('auth:sanctum', 'api.key')->group(function () {
        Route::get('/restaurantes', [RestauranteController::class, 'obtenerTodosRestaurantes']);
        Route::post('/crearRestaurante', [RestauranteController::class, 'crearRestaurante']);
        Route::put('/editarRestaurante/{id}', [RestauranteController::class, 'editarRestaurante']);
        Route::delete('/eliminarRestaurante/{id}', [RestauranteController::class, 'eliminarRestaurante']);
        Route::get('/buscarrestaurantes/{nombre}', [RestauranteController::class, 'buscarRestaurante']);
        Route::post('/logout', [AuthController::class, 'logout']);
    });
});
