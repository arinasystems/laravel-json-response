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
     * @var int
     */
    protected $http_code;

    /**
     * @var int
     */
    protected $code;

    /**
     * @var \Illuminate\Contracts\Translation\Translator|string|array|null
     */
    protected $message;

    /**
     * @var array
     */
    protected $errors;

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

        $exceptionName = class_basename(get_class($exception));

        $this->message = $exception->getMessage();

        if ($exception instanceof AuthenticationException) {
            $this->http_code = 401;
            $this->code = 401;
            $this->message = __('Unauthenticated.');
        } elseif ($exception instanceof ValidationException) {
            $this->http_code = $exception->status;
            $this->code = $exception->status;
            $errors = $exception->errors();
        } elseif ($exception instanceof HttpExceptionInterface) {
            $this->http_code = $exception->getStatusCode();
            $this->code = $exception->getStatusCode();
        } else {
            $this->http_code = 500;
            $this->code = 500;
        }

        if (method_exists($this, $handle = 'handle' . $exceptionName)) {
            $this->{$handle}($exception);
        }

        JsonResponse::setAttributes([
            'success'   => false,
            'http_code' => $this->http_code,
            'code'      => $this->code,
            'message'   => $this->message,
            'errors'    => $errors ?? [],
            'debug'     => $exception->getTrace(),
        ]);

        return $exceptionName;
    }
}
