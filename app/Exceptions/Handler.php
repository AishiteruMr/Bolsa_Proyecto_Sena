<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Routing\Exceptions\TooManyRequestsHttpException;
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
            //
        });

        // Manejar rate limiting (429 Too Many Requests)
        $this->render(function (Throwable $e, Request $request) {
            if ($e instanceof TooManyRequestsHttpException) {
                $retryAfter = $e->getHeaders()['Retry-After'] ?? 60;
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
        });
    }
}
