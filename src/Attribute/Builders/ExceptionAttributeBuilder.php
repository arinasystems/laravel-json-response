<?php

namespace ArinaSystems\JsonResponse\Attribute\Builders;

use Throwable;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use ArinaSystems\JsonResponse\Facades\JsonResponse;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ExceptionAttributeBuilder extends Builder
{
    /**
     * Build a value of the exception attribute.
     *
     * @param  \Throwable $exception
     * @return mixed
     */
    public function build($exception)
    {
        if (!is_a($exception, Throwable::class)) {
            return $exception;
        }

        if ($exception instanceof AuthenticationException) {
            $http_code = 401;
            $code = 401;
            $message = __('Unauthenticated.');
        } elseif ($exception instanceof ValidationException) {
            $http_code = $exception->status;
            $code = $exception->status;
            $message = $exception->getMessage();
            $errors = $exception->errors();
        } else {
            $http_code = $this->isHttpException($exception) ? $exception->getStatusCode() : 500;
            $code = $this->isHttpException($exception) ? $exception->getStatusCode() : 500;
            $message = $exception->getMessage();
        }

        JsonResponse::setAttributes([
            'success'   => false,
            'http_code' => $http_code,
            'code'      => $code,
            'message'   => $message,
            'errors'    => $errors ?? [],
            'debug'     => $exception->getTrace(),
        ]);

        return $exception ? class_basename(get_class($exception)) : null;
    }

    /**
     * Determine if the given exception is an HTTP exception.
     *
     * @param  \Throwable $exception
     * @return bool
     */
    protected function isHttpException(Throwable $exception)
    {
        return $exception instanceof HttpExceptionInterface;
    }
}
