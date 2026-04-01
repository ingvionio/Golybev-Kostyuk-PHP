<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Illuminate\Support\Facades\Response;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Перехватываем только HTTP-ошибки (404, 403, 500 и т.д.)
        $exceptions->render(function (HttpExceptionInterface $e, Request $request) {
            $statusCode = $e->getStatusCode();
            
            // Если это API-запрос, отдаем JSON
            if ($request->wantsJson()) {
                return response()->json(['error' => $e->getMessage()], $statusCode);
            }

            $headers = [
                'X-Error-Time' => now()->toDateTimeString(),
                'X-Error-Code' => $statusCode
            ];

            // Отдаем кастомный шаблон
            return Response::view('errors.custom', [
                'exception' => $e,
                'statusCode' => $statusCode
            ], $statusCode, $headers);
        });
    })->create();