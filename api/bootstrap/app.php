<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Http\Response as Res;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->use([
            \Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance::class,
            \Illuminate\Http\Middleware\TrustProxies::class,

            \Illuminate\Http\Middleware\ValidatePostSize::class,

            \Illuminate\Foundation\Http\Middleware\TrimStrings::class,
            \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,

            \Illuminate\Foundation\Http\Middleware\InvokeDeferredCallbacks::class,

            \App\Http\Middleware\XSSProtection::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (ThrottleRequestsException $e): JsonResponse {
            return response()->json([
                'message' => 'Rate limit reached. Please wait a moment before trying again.'
            ], $e->getCode() ?: Res::HTTP_TOO_MANY_REQUESTS);
        });

        $exceptions->render(function (ModelNotFoundException $e): JsonResponse {
            return response()->json([
                    'message' => config('app.debug') ? $e->getMessage() : 'Data not found',
                ],
                $e->getCode() ?: Res::HTTP_NOT_FOUND
            );
        });

        $exceptions->render(function (ValidationException $e): JsonResponse {
            return response()->json([
                    'message' => config('app.debug') ? $e->getMessage() : 'Validation Error',
                    'errors' => $e->errors() ?? [],
                ],
                $e->getCode() ?: Res::HTTP_UNPROCESSABLE_ENTITY
            );
        });

        $exceptions->render(function (RouteNotFoundException $e): JsonResponse {
            return response()->json([
                    'message' => config('app.debug') ? $e->getMessage() : 'Endpoint not found',
                ],
                $e->getCode() ?: Res::HTTP_NOT_FOUND
            );
        });

        $exceptions->render(function (Throwable $e): JsonResponse {
            return response()->json(
                [
                    'message' => config('app.debug') ? $e->getMessage() : 'Internal Server Error',
                ],
                $e->getCode() ?: Res::HTTP_INTERNAL_SERVER_ERROR
            );
        });
    })->create();
