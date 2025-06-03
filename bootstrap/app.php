<?php

use Illuminate\Foundation\Application;
use App\Http\Middleware\AdminMiddleWare;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias(['admin'=> AdminMiddleWare::class]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->reportable(function (NotFoundHttpException $e) {
            return abort(404);
        });
    })->create();
