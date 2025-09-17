<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: [
            __DIR__.'/../routes/api.php',
            __DIR__.'/../src/IdentityAndAccess/User/Infrastructure/Routes/api.php',
            __DIR__.'/../src/CustomerManagement/Customer/Infrastructure/Routes/api.php',
            __DIR__.'/../src/OrderManagement/Order/Infrastructure/Routes/api.php',
            __DIR__.'/../src/ProductManagement/Product/Infrastructure/Routes/api.php',
        ],
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )

    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->group('api', [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ]);
    })

    ->withProviders([
        App\Providers\IamServiceProvider::class,
    ])


    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
    

