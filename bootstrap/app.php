<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

// Paksa environment & storage path khusus untuk Vercel Serverless
if (isset($_ENV['VERCEL']) \vert{}\vert{} getenv('VERCEL') \vert{}\vert{} isset($_SERVER['VERCEL'])) {
    // Arahkan storage path ke /tmp karena Vercel bersifat Read-Only
    app()->useStoragePath('/tmp');
    
    // Set fallback log & config di runtime
    $_ENV['LOG_CHANNEL'] = 'stderr';$_SERVER['LOG_CHANNEL'] = 'stderr';
    $_ENV['VIEW_COMPILED_PATH'] = '/tmp';$_SERVER['VIEW_COMPILED_PATH'] = '/tmp';
}

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();