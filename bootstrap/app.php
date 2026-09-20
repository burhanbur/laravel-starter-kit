<?php

use App\Exceptions\ExceptionHandler;
use App\Http\Middleware\Cors;
use App\Http\Middleware\JwtAuthenticate;
use App\Http\Middleware\TransformResponseKeys;
use App\Http\Middleware\UserPermission;
use App\Http\Middleware\ValidateApiKey;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'cors' => Cors::class,
            'custom.jwt.auth' => JwtAuthenticate::class,
            'permission' => UserPermission::class,
            'transform.response.keys' => TransformResponseKeys::class,
            'api.key' => ValidateApiKey::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->renderable(function (Throwable $e, Request $request) {
            return (new ExceptionHandler())->render($e, $request);
        });
    })->create();
