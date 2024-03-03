<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;


//class LogRequests
//{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
//    public function handle(Request $request, Closure $next): Response
//    {
//        return $next($request);
//    }
//}

Class LogRequests
{
    public function handle(Request $request, Closure $next)
    {

        $startTime = microtime(true); // Captura o tempo de início da solicitação

        $response = $next($request);

        $endTime = microtime(true); // Captura o tempo de término da solicitação
        $responseTime = ($endTime - $startTime) * 1000; // Calcula o tempo de resposta em milissegundos

        // Obtém informações da resposta
        $responseCode = $response->getStatusCode();


        // Insere os detalhes da resposta no banco de dados de logs
        DB::table('logs')->insert([
            'action' => 'access',
            'user_id' => $request->user()->id ?? null, // Se estiver autenticado
            'user_name' => $request->user()->name ?? 'anonymous', // Se estiver autenticado
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'method' => $request->method(),
            'route' => $request->getPathInfo(),
            'status' => $responseCode,
            'response_time' => $responseTime,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return $response;
    }
}
