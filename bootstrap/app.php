<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\BadMethodCallException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\MissingAppKeyException;
use App\Http\Controllers\Controller;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            if ($request->is('api/*')) {
                return Controller::sendError($e->getMessage(), 404);
            }
        });

        $exceptions->render(function (BadMethodCallException $e, Request $request) {
            if ($request->is('api/*')) {
                return Controller::sendError($e->getMessage(), 500);
            }
        });

        $exceptions->render(function (AccessDeniedHttpException $e, Request $request) {
            if ($request->is('api/*')) {
                return Controller::sendError($e->getMessage(), 403);
            }
        });

        $exceptions->render(function (MethodNotAllowedHttpException $e, Request $request) {
            if ($request->is('api/*')) {
                return Controller::sendError($e->getMessage(), 400);
            }
        });

        $exceptions->render(function (MissingAppKeyException $e, Request $request) {
            if ($request->is('api/*')) {
                return Controller::sendError($e->getMessage(), 400);
            }
        });
    })->create();
