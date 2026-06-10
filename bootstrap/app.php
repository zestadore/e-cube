<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->validateCsrfTokens(except: [
            '/paytm/callback',
            '/paytm/candidate-view-callback',
            '/paytm/profile-download-callback',
        ]);

        // Gate employees with an incomplete profile out of every screen,
        // sending them to the profile-completion flow first.
        $middleware->appendToGroup('web', \App\Http\Middleware\EnsureEmployeeProfileComplete::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
