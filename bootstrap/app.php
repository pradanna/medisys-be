<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        # 1. Spatie Middleware
        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        # 1. Render JSON Exception
        $exceptions->shouldRenderJsonWhen(function (Request $request, Throwable $e) {
            if ($request->is('api/*')) {
                return true;
            }

            return $request->expectsJson();
        });

        # 2. Spatie Role Exception
        $exceptions->render(function (UnauthorizedException $e, Request $request) {
            if ($request->is('api/*')) {
                return \App\Utils\Http\APIResponse::error(
                    message: $e->getMessage(),
                    code: 403
                );
            }
        });

        # 3. Service Error Exception
        $exceptions->render(function (\App\Exceptions\DomainException $e, Request $request) {
            if ($request->is('api/*')) {
                return \App\Utils\Http\APIResponse::error(
                    message: $e->getMessage(),
                    code: $e->getCode() ?: 500
                );
            }
        });

        # 4. Route Not Found Exception
        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            if ($request->is('api/*')) {
                return \App\Utils\Http\APIResponse::error(
                    message: $e->getMessage() ?: 'route not found',
                    code: 404
                );
            }
        });

        # 5. Validation request exception
        $exceptions->render(function (\Illuminate\Validation\ValidationException $e, Request $request) {
            if ($request->is('api/*')) {
                return \App\Utils\Http\APIResponse::error(
                    message: "Validation Error",
                    code: 422,
                    errors: $e->errors()
                );
            }
        });

        # 6. Unexpected error exception
        $exceptions->render(function (Throwable $e, Request $request) {
            if ($request->is('api/*')) {
                $status = 500;
                if ($e instanceof HttpExceptionInterface) {
                    $status = $e->getStatusCode();
                }
                return \App\Utils\Http\APIResponse::error(
                    message: $e->getMessage() ?: 'An unexpected error occurred.',
                    code: $status,
                );
            }
        });
    })->create();
