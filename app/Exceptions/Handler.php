<?php

namespace App\Exceptions;

use App\Helpers\TimeHelper;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;

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
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        $result = [];
        $error = false;
        $result['success'] = false;
        $code = 500;
        if ($exception instanceof UnauthorizedHttpException)
        {
            $code = Response::HTTP_UNAUTHORIZED;
            $error = true;
            $result['message'] = $exception->getMessage();
            if ($exception->getMessage() == 'Token has expired')
            {
                $code = 498;
            }
            if ($exception->getMessage() == 'The token has been blacklisted')
            {
                $code = 498;
                $result['message'] = 'Token already invalidated.';
            }
        }
        else if ($exception instanceof MethodNotAllowedHttpException)
        {
            $code = Response::HTTP_METHOD_NOT_ALLOWED;
            $error = true;
            $result['message'] = 'HTTP method is not allowed';
        }
        else if ($exception instanceof NotFoundHttpException)
        {
            $code = Response::HTTP_NOT_FOUND;
            $error = true;
            $result['message'] = 'API Endpoint not found.';
        }
        else if ($exception instanceof \Exception)
        {
            $code = Response::HTTP_INTERNAL_SERVER_ERROR;
            $error = true;
            $result['message'] = $exception->getMessage();
            $result['data'] = [
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
                'code' => $exception->getCode(),
                'trace' => $exception->getTraceAsString()
            ];
        }
        if ($error)
        {
            $result['elapsed'] = TimeHelper::server_elapsed_time();
            return response()->json($result, $code);
        }
        return parent::render($request, $exception);
    }
}
