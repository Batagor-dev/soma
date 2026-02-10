<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends ExceptionHandler
{
    /**
     * Daftar tipe exception yang tidak dilaporkan.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * Daftar input yang tidak pernah diflash untuk validasi.
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
            // Kirim notifikasi error ke Slack/Email dll
            if (app()->environment('production')) {
                $this->sendErrorNotification($e);
            }
        });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        // Untuk error HTTP
        if ($exception instanceof HttpException) {
            $statusCode = $exception->getStatusCode();
            
            // View name berdasarkan status code
            $viewName = "errors.{$statusCode}";
            
            // Cek jika view untuk status code tersebut ada
            if (view()->exists($viewName)) {
                return response()->view($viewName, [
                    'exception' => $exception
                ], $statusCode);
            }
        }
        
        // Untuk error umum
        if ($this->shouldReturnJson($request)) {
            return $this->prepareJsonResponse($request, $exception);
        }
        
        // Fallback ke view error default
        return response()->view('errors.default', [
            'exception' => $exception
        ], 500);
    }

    /**
     * Kirim notifikasi error (contoh implementasi)
     */
    private function sendErrorNotification(Throwable $e): void
    {
        // Implementasi notifikasi error
        // Bisa ke Slack, Email, Telegram, dll.
        
        if (app()->bound('sentry')) {
            app('sentry')->captureException($e);
        }
    }
}