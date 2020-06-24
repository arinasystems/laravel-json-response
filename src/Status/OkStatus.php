<?php

namespace ArinaSystems\JsonResponse\Status;

use ArinaSystems\JsonResponse\Code;

class OkStatus
{
    /**
     * @param  $builder
     * @return mixed
     */
    public function handle($builder)
    {
        return $builder->setAttributes('success', true)
                       ->setAttributes('code', Code::of('OK'));
    }
}
