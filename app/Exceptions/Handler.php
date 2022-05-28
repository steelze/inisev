<?php

namespace App\Exceptions;

use App\Helpers\RespondWith;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var string[]
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var string[]
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
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (Throwable $e) {
            if (request()->expectsJson()) {
                if ($e instanceof MethodNotAllowedHttpException) {
                    return RespondWith::error(
                        [],
                        config('app.debug') ? $e->getMessage() : 'Invalid request method. Please contact administrator.',
                        $e->getStatusCode()
                    );
                }

                if ($e instanceof AccessDeniedHttpException) {
                    return RespondWith::error(
                        [],
                        ($e->getMessage() != 'This action is unauthorized.') ? $e->getMessage() : 'You don\'t have sufficient permission',
                        $e->getStatusCode()
                    );
                }

                if ($e instanceof NotFoundHttpException) {

                    if ($e->getPrevious() instanceof ModelNotFoundException) {
                        return RespondWith::error([], $e->getMessage(), Response::HTTP_NOT_FOUND);
                    }
        
                    return RespondWith::error([], 'Route not found', Response::HTTP_NOT_FOUND);
                }
        
                if ($e instanceof ValidationException) {
                    $errors = array_map(fn($error) => $error[0], $e->errors());
                    return RespondWith::error($errors, 'Validation error', Response::HTTP_UNPROCESSABLE_ENTITY);
                }
                
                if ($e instanceof AuthenticationException) {
                    return RespondWith::error([], $e->getMessage(), Response::HTTP_UNAUTHORIZED);
                }
        
                if (app()->isLocal()) {
                    return RespondWith::error($e, $e->getMessage(), (method_exists($e, 'getStatusCode')) ? $e->getStatusCode() : Response::HTTP_INTERNAL_SERVER_ERROR);
                } else {
                    return RespondWith::error([], $e->getMessage(), (method_exists($e, 'getStatusCode')) ? $e->getStatusCode() : Response::HTTP_INTERNAL_SERVER_ERROR);
                }
            }

            if ($e instanceof HttpException) {
                if ($e->getStatusCode() == 419) {
                    return redirect()
                        ->back()
                        ->withInput(request()->except('_token'))
                        ->with('error', __('Sorry your session has expired. Please refresh and try again'));
                }
            }
        });
    }
}
