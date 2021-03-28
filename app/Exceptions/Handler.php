<?php

namespace App\Exceptions;

use App\Traits\ApiCustomExceptions;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Throwable;


class Handler extends ExceptionHandler
{
    use ApiCustomExceptions;

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
            //
        });
    }

    public function render($request, Throwable $e)
    {
        if ($e instanceof ValidationException) {
            return $this->convertValidationExceptionToResponse($e, $request);
        }

        if ($e instanceof ModelNotFoundException) {
            $modelName = strtolower(class_basename($e->getModel()));
            return $this->errorResponse("Does not exists any {$modelName} with the specified identification", 404);
        }

        if ($e instanceof QueryException) {
            $code = $e->errorInfo[1];
            // The code 19 is for sqlite | code 1451 is for mysql
            if ($code == 19 || $code == 1451) {
                return $this->errorResponse('Cannot remove this resource permanently. It is related with any other resource.', 409);
            }
        }

        return parent::render($request, $e);
    }
}
