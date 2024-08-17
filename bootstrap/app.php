<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        using: function(){

            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            Route::middleware('web')
                ->group(base_path('routes/admin.php'));

            Route::middleware('web')
                ->group(base_path('routes/seller.php'));

            Route::middleware('web')
                ->group(base_path('routes/client.php'));

            /*require __DIR__.'/../routes/admin.php';
            require __DIR__.'/../routes/seller.php';
            require __DIR__.'/../routes/client.php';  */
        },
        commands: __DIR__.'/../routes/console.php',
        health: '/up'
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
           'guest'=> \App\Http\Middleware\RedirectIfAuthenticated::class,
           'auth' => \App\Http\Middleware\Authenticate::class,
           'prevent-back-history' => \App\Http\Middleware\PreventBackHistory::class,
           'verified'  => \App\Http\Middleware\VerifiedSeller::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
