<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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

    /**
     * Rendering Error
     * @param $request
     * @param Throwable $e
     * @return \Illuminate\Http\JsonResponse
     */
    public function render($request, Throwable $e)
    {
        //return parent::render($request,$e);

        //http 404 exception
        if ($e instanceof NotFoundHttpException) {
            $statusCode = 404;
            $responseData = [
                'code' => $statusCode,
                'message' => "Not Found",
            ];
        } elseif ($e instanceof ValidationException) {
            $statusCode = 400;
            $responseData = [
                'code' => $statusCode,
                'message' => 'Invalid parameter',
            ];
        } else {
            //other exception
            $statusCode = 500;
            $responseData = [
                'code' => $statusCode,
                'message' => "Internal Server Error",
            ];
        }

        //trace id
        $responseData['trace_id'] = $request->header('X-Trace-Id');

        //debug info
        if (config('app.debug')) {
            //real errcode
            $responseData['errcode'] = $e->getCode();
            //real errmessage
            $responseData['errmsg'] = $e->getMessage();
            $responseData['file'] = $e->getFile();
            $responseData['line'] = $e->getLine();
            $responseData['trace'] = $e->getTrace();
        }

        return response()->json($responseData, $statusCode);
    }
}
