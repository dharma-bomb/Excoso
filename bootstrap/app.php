<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\CheckSession;
use App\Http\Controllers\AdminController;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Append your middleware here
        // $middleware->append(CheckSession::class);
        $middleware->use([
            // \Illuminate\Http\Middleware\TrustHosts::class,
            \Illuminate\Http\Middleware\TrustProxies::class,
            \Illuminate\Http\Middleware\HandleCors::class,
            \Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance::class,
            \Illuminate\Http\Middleware\ValidatePostSize::class,
            \Illuminate\Foundation\Http\Middleware\TrimStrings::class,
            \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
            App\Http\Middleware\CheckSession::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Handle exceptions here
        // Example: Register custom exception handling
        $exceptions->report(function (Throwable $e) {
            // if ($e instanceof CustomException) {
            //     // Custom handling for specific exception
            //     Log::error('Custom exception occurred: '.$e->getMessage());
            // }
        });
    })
    ->create();
