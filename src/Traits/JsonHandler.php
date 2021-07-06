<?php

namespace ArinaSystems\JsonResponse\Traits;

use ArinaSystems\JsonResponse\Facades\JsonResponse;
use Throwable;

trait JsonHandler
{
    /**
     * Prepare a JSON response for the given exception.
     *
     * @param  \Throwable                      $exception
     * @return \Illuminate\Http\JsonResponse
     */
    protected function renderForJson(Throwable $exception)
    {
        return JsonResponse::error($exception);
    }
}
