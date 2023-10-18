<?php

namespace App\Exceptions;

use CodePix\System\Application\Exception\BadRequestException;
use Costa\Entity\Exceptions\NotificationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
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

    public function render($request, Throwable $e)
    {
        if ($e instanceof BadRequestException) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 400);
        }

        if ($e instanceof NotificationException) {
            return response()->json([
                'message' => $e->getMessage(),
                'errors' => [
                    $e->getMessage(),
                ],
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return parent::render($request, $e);
    }
}
