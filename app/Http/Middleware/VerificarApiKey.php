<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerificarApiKey
{
    //Funcion para verificar que exista la api-key
    public function handle(Request $request, Closure $next)
    {
        $apiKeyHeader = $request->header('X-API-KEY');
        $apiKeyConfig = config('services.api_key');

        if (!$apiKeyHeader || $apiKeyHeader !== $apiKeyConfig) {
            return response()->json(['mensaje' => 'API Key inválida'], 401);
        }

        return $next($request);
    }
}
