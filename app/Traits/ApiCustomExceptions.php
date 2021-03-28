<?php


namespace App\Traits;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

trait ApiCustomExceptions
{
    use ApiResponder;

    public function handleException($request, Throwable $e)
    {
        if ($e instanceof NotFoundHttpException) {
            return $this->errorResponse('The specified URL cannot be found.', 404);
        }

        if ($e instanceof MethodNotAllowedHttpException) {
            return $this->errorResponse('The specified method for the request is invalid.', 405);
        }

        if ($e instanceof ModelNotFoundException) {
            $modelName = strtolower(class_basename($e->getModel()));
            return $this->errorResponse("Does not exists any {$modelName} with the specified identification", 404);
        }

        if ($e instanceof ValidationException) {
            return $this->convertValidationExceptionToResponse($e, $request);
        }

        if ($e instanceof QueryException) {
            $code = $e->errorInfo[1];
            // The code 19 is for sqlite | code 1451 is for mysql
            if ($code == 19 || $code == 1451) {
                return $this->errorResponse('Cannot remove this resource permanently. It is related with any other resource.', 409);
            }
        }

        if ($e instanceof AuthenticationException) {
            return $this->unauthenticated($request, $e);
        }

        if ($e instanceof HttpException) {
            return $this->errorResponse($e->getMessage(), $e->getStatusCode());
        }

        if (config('app.debug')) {
            return parent::render($request, $e);
        }

        return $this->errorResponse('Unexpected Exception. Try later', 500);
    }

    protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    {
        $errors = $e->validator->errors()->getMessages();
        return $this->errorResponse($errors, 422);
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return $this->errorResponse('Unauthenticated.', 401);
    }

}
