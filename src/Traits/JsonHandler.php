<?php

namespace ArinaSystems\JsonResponse\Traits;

use Throwable;
use ArinaSystems\JsonResponse\Facades\JsonResponse;

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
