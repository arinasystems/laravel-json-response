<?php

namespace ArinaSystems\JsonResponse\Builders;

use Exception;
use Illuminate\Support\Arr;

class DebugAttributeBuilder extends Builder
{
    /**
     * Build a value of the exception attribute.
     *
     * @param  \Exception  $exception
     * @return mixed
     */
    public function build($exception)
    {
        if (! is_a($exception, Exception::class)) {
            return $exception;
        }

        return [
            'file'  => $exception->getFile(),
            'line'  => $exception->getLine(),
            'trace' => collect($exception->getTrace())->map(function ($trace) {
                return Arr::except($trace, ['args']);
            })->all(),
        ];
    }
}
