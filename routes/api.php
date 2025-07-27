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

// *** RUTA PARA SERVIR EL SWAGGER JSON ***
// Esta ruta leerá el archivo api-docs.json desde storage y lo devolverá.
Route::get('/api-docs-json', function () {
    $filePath = storage_path('api-docs/api-docs.json'); // Ruta donde L5-Swagger genera el archivo
    if (file_exists($filePath)) {
        $content = file_get_contents($filePath);
        if ($content === false) {
            return response()->json(['error' => 'No se pudo leer el contenido del archivo ' . $filePath], 500);
        } elseif (empty($content)) {
            return response()->json(['warning' => 'El archivo ' . $filePath . ' existe pero está vacío.'], 200);
        } else {
            return response($content, 200, ['Content-Type' => 'application/json']);
        }
    }
    return response()->json(['error' => 'El archivo api-docs.json no existe en ' . $filePath], 404);
});
