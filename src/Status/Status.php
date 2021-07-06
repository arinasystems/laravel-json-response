<?php

namespace ArinaSystems\JsonResponse\Status;

use ArinaSystems\JsonResponse\JsonResponse;

interface Status
{
    /**
     * Handle response status.
     *
     * @param  \ArinaSystems\JsonResponse\JsonResponse $builder
     * @return \ArinaSystems\JsonResponse\JsonResponse
     */
    public function handle($builder): JsonResponse;
}
