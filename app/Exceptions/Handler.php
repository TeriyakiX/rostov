<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            if ($e instanceof \Symfony\Component\HttpKernel\Exception\HttpException) {
                if ($e->getStatusCode() >= 500 && $e->getStatusCode() < 600) {
                    \Log::error('Ошибка '.$e->getStatusCode().': '.$e->getMessage(), [
                        'url' => request()->url(),
                        'trace' => $e->getTraceAsString(),
                    ]);
                }
                if ($e->getStatusCode() >= 400 && $e->getStatusCode() < 500) {
                    \Log::warning('Ошибка '.$e->getStatusCode().': '.$e->getMessage(), [
                        'url' => request()->url(),
                        'trace' => $e->getTraceAsString(),
                    ]);
                }
            }
        });
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Throwable $exception)
    {
        // Конвертируем ModelNotFoundException в NotFoundHttpException
        if ($exception instanceof ModelNotFoundException) {
            $exception = new NotFoundHttpException('Ресурс не найден.', $exception);
        }

        if ($this->isHttpException($exception) && $exception->getStatusCode() == 404) {
            return response()->view('errors.400', [
                'status' => 404,
                'message' => 'Страница не найдена.',
            ], 404);
        }

        if ($this->isHttpException($exception) && $exception->getStatusCode() >= 400 && $exception->getStatusCode() < 500) {
            $message = '';
            switch ($exception->getStatusCode()) {
                case 403:
                    $message = 'Доступ запрещен.';
                    break;
                case 405:
                    $message = 'Метод не разрешен.';
                    break;
                default:
                    $message = 'Страница не найдена или ошибка в запросе.';
            }

            return response()->view('errors.400', [
                'status' => $exception->getStatusCode(),
                'message' => $message,
            ], $exception->getStatusCode());
        }

        if ($this->isHttpException($exception) && $exception->getStatusCode() >= 500) {
            return response()->view('errors.500', [
                'status' => $exception->getStatusCode(),
                'message' => 'Что-то пошло не так на сервере.',
            ], $exception->getStatusCode());
        }
        return parent::render($request, $exception);
    }
}
