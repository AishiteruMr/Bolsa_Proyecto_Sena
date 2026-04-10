<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            // Log todas las excepciones con contexto relevante
            Log::error('Exception occurred', [
                'exception' => class_basename($e),
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'url' => request()->url(),
                'method' => request()->method(),
                'ip' => request()->ip(),
            ]);
        });

        // Manejar excepciones de modelo no encontrado
        $this->renderable(function (ModelNotFoundException $e, Request $request) {
            Log::warning('Model not found', [
                'model' => get_class($e->getModel()),
                'url' => $request->url(),
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'Recurso no encontrado',
                    'code' => 404,
                ], 404);
            }

            return response()->view('errors.404', [], 404);
        });

        // Manejar excepciones de validación
        $this->renderable(function (ValidationException $e, Request $request) {
            Log::debug('Validation error', [
                'errors' => $e->errors(),
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'Validation failed',
                    'errors' => $e->errors(),
                    'code' => 422,
                ], 422);
            }

            return back()->withErrors($e->errors())->withInput();
        });

        // Manejar excepciones HTTP
        $this->renderable(function (HttpException $e, Request $request) {
            $status = $e->getStatusCode();

            Log::warning("HTTP Exception: {$status}", [
                'url' => $request->url(),
                'message' => $e->getMessage(),
            ]);

            if ($status === 403) {
                Log::warning('Forbidden access attempt', [
                    'user_id' => session('usr_id'),
                    'url' => $request->url(),
                    'ip' => $request->ip(),
                ]);

                if ($request->expectsJson()) {
                    return response()->json([
                        'error' => 'Acceso denegado',
                        'code' => 403,
                    ], 403);
                }

                return response()->view('errors.403', [], 403);
            }

            if ($status === 404) {
                if ($request->expectsJson()) {
                    return response()->json([
                        'error' => 'No encontrado',
                        'code' => 404,
                    ], 404);
                }

                return response()->view('errors.404', [], 404);
            }

            if ($status === 429) {
                Log::warning('Rate limit exceeded', [
                    'user_id' => session('usr_id'),
                    'url' => $request->url(),
                    'ip' => $request->ip(),
                ]);

                return response()->view('errors.429', ['retryAfter' => $e->getHeaders()['Retry-After'] ?? 60], 429);
            }
        });

        // Manejar todas las excepciones no capturadas
        $this->renderable(function (Throwable $e, Request $request) {
            $status = 500;

            // Log detallado de error
            Log::critical('Unhandled exception', [
                'exception' => get_class($e),
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'url' => $request->url(),
                'user_id' => session('usr_id'),
                'ip' => $request->ip(),
            ]);

            // En desarrollo, mostrar el error completo
            if (config('app.debug')) {
                return response()->view('errors.500', [
                    'exception' => $e,
                ], $status);
            }

            // En producción, mostrar mensaje genérico
            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'Error interno del servidor',
                    'code' => 500,
                ], 500);
            }

            return response()->view('errors.500', [
                'message' => 'Ocurrió un error interno. Contacta con soporte si el problema persiste.',
            ], 500);
        });
    }
}
