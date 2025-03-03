<?php

namespace App\Exceptions;

use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Client\RequestException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use RuntimeException;
use Throwable;

class ExceptionHandler
{
    /**
     * Register the exception handling.
     */
    public static function register(Exceptions $exceptions): void
    {
        $exceptions->render(function (ValidationException $exception, $request) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $exception->errors(),
            ], 422);
        });

        $exceptions->render(function (NotFoundHttpException $exception, $request) {
            return response()->json([
                'success' => false,
                'message' => 'Route not found',
            ], 404);
        });

        $exceptions->render(function (AccessDeniedHttpException $exception, $request) {
            return response()->json([
                'success' => false,
                'message' => 'Access denied',
            ], 403);
        });

        $exceptions->render(function (MethodNotAllowedHttpException $exception, $request) {
            return response()->json([
                'success' => false,
                'message' => 'HTTP method not allowed',
            ], 405);
        });

        $exceptions->render(function (RequestException $exception, $request) {
            return response()->json([
                'success' => false,
                'message' => 'API request failed',
                'error' => config('app.debug') ? $exception->getMessage() : null
            ], 500);
        });

        $exceptions->render(function (QueryException $exception, $request) {
            return response()->json([
                'success' => false,
                'message' => 'Database error',
                'error' => config('app.debug') ? $exception->getMessage() : null
            ], 500);
        });

        $exceptions->render(function (HttpException $exception, $request) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage(),
            ], $exception->getStatusCode());
        });

        $exceptions->render(function (RuntimeException $exception, $request) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage(),
            ], 500);
        });

        $exceptions->render(function (Throwable $exception, $request) {
            return response()->json([
                'success' => false,
                'message' => 'An unexpected error occurred',
                'error' => config('app.debug') ? $exception->getMessage() : null
            ], 500);
        });
    }
}