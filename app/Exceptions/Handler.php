<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
            // Log all exceptions for audit
            Log::error('Application Exception', [
                'exception' => class_basename($e),
                'message' => $e->getMessage(),
                'user_id' => auth()->id() ?? session('usr_id'),
                'path' => request()->path(),
                'method' => request()->method(),
                'ip' => request()->ip(),
            ]);
        });

        // Handle rate limiting (429 Too Many Requests)
        $this->render(function (Throwable $e, Request $request) {
            $className = class_basename($e);

            // Handle rate limiting - different possible exception classes
            if ($className === 'ThrottleRequestsException' || str_contains($className, 'TooManyRequests')) {
                $retryAfter = 60;
                if (method_exists($e, 'getHeaders')) {
                    $retryAfter = $e->getHeaders()['Retry-After'] ?? 60;
                }
                $seconds = is_numeric($retryAfter) ? $retryAfter : 60;
                $minutes = ceil($seconds / 60);

                $message = 'Has superado el límite de intentos. ';
                $message .= "Por favor, espera {$minutes} minuto".($minutes > 1 ? 's' : '').' antes de intentar de nuevo.';

                if ($request->expectsJson()) {
                    return response()->json([
                        'error' => $message,
                        'retry_after' => $seconds,
                    ], 429);
                }

                return redirect()->back()->with('error', $message);
            }

            // Handle ModelNotFoundException - return friendly 404
            if ($e instanceof ModelNotFoundException) {
                if ($request->expectsJson()) {
                    return response()->json([
                        'error' => 'Recurso no encontrado',
                    ], 404);
                }

                return response()->view('errors.404', [], 404);
            }

            // Handle AuthenticationException
            if ($e instanceof AuthenticationException) {
                if ($request->expectsJson()) {
                    return response()->json([
                        'error' => 'No autenticado',
                    ], 401);
                }

                return redirect()->route('login');
            }
        });
    }
}
