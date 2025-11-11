<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
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
    }

    public function render($request, Throwable $exception)
{
        if ($exception instanceof \Illuminate\Session\TokenMismatchException) {
            \Log::error('CSRF Token Mismatch', [
                'session_id' => session()->getId(),
                'has_token' => session()->has('_token'),
                'request_token' => $request->input('_token'),
                'session_token' => session()->token(),
            ]);
        }
        
        return parent::render($request, $exception);
    }
}
