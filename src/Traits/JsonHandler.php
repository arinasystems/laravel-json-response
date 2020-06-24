<?php

namespace ArinaSystems\JsonResponse\Traits;

use Exception;
use ArinaSystems\JsonResponse\Facades\JsonResponse;

trait JsonHandler
{
    /**
     * Prepare a JSON response for the given exception.
     *
     * @param  \Illuminate\Http\Request        $request
     * @param  \Exception                      $exception
     * @return \Illuminate\Http\JsonResponse
     */
    protected function renderForJson($request, Exception $exception)
    {
        return JsonResponse::setAttributes('exception', $exception)->error();
    }
}
