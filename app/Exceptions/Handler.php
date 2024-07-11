<?php

namespace App\Exceptions;

use App\Modules\Base\Traits\ApiErrorResponse;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\RecordsNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Throwable;

class Handler extends ExceptionHandler
{
    use ApiErrorResponse;

    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

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
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  Request  $request
     * @param  Exception  $exception
     * @return JsonResponse
     */
    public function render($request, Throwable $exception)
    {
        return $this->handleException($request, $exception);
    }

    public function handleException($request, Throwable $exception): JsonResponse
    {
        Log::error('API error log.', [
            'message' => $exception->getMessage(),
            'traceAsString' => $exception->getTraceAsString(),
        ]);

        if ($exception instanceof AppException) {
            return response()->json(
                $this->errorResponse($exception->getMessage(), $exception->getCode()),
                $exception->getCode()
            );
        }

        if ($exception instanceof BadRequestException) {
            return response()->json(
                $this->errorResponse('Invalid request.', 400),
                400
            );
        }

        if ($exception instanceof AuthenticationException) {
            return response()->json(
                $this->errorResponse('Invalid authentication.', 401),
                401
            );
        }

        if ($exception instanceof AuthorizationException) {
            return response()->json(
                $this->errorResponse('Insufficient permissions.', 403),
                403
            );
        }

        if ($exception instanceof RecordsNotFoundException) {
            return response()->json(
                $this->errorResponse('Resource not found.', 404),
                404
            );
        }

        if ($exception instanceof ValidationException) {
            return response()->json(
                $this->errorResponse('Invalid data.', 422, $exception->errors()),
                422
            );
        }

        /* Debug: Give exception details when in debug mode. */
        if (config('app.debug') === true) {
            return response()->json(
                $this->errorResponse($exception->getMessage(), 500, $exception->getMessage()),
                500
            );
        }

        /* Default */
        return response()->json(
            $this->errorResponse('Something went wrong.', 500),
            500
        );
    }
}
