<?php

namespace ArinaSystems\JsonResponse\Status;

use ArinaSystems\JsonResponse\JsonResponse;

class OkStatus implements Status
{
    /**
     * Handle response status.
     *
     * @param  \ArinaSystems\JsonResponse\JsonResponse   $builder
     * @return \ArinaSystems\JsonResponse\JsonResponse
     */
    public function handle($builder): JsonResponse
    {
        return $builder->setAttribute('message', 'ok')
                       ->setAttribute('success', true)
                       ->setAttribute('code', 200);
    }
}
