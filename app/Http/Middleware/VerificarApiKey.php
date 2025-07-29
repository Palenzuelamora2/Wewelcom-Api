<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; 

class VerificarApiKey
{
    // Funcion para verificar que exista la api-key
    public function handle(Request $request, Closure $next)
    {
        $apiKeyHeader = $request->header('X-API-KEY');
        $apiKeyConfig = config('services.api_key');

        Log::info('API KEY config leída: ' . $apiKeyConfig);
        Log::info('API KEY header recibido: ' . $apiKeyHeader);

        if (!$apiKeyHeader || $apiKeyHeader !== $apiKeyConfig) {
            return response()->json(['mensaje' => 'API Key inválida'], 401);
        }
        return $next($request);
    }
}
