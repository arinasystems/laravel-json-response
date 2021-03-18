<?php

namespace ArinaSystems\JsonResponse\Status;

class OkStatus
{
    /**
     * @param  $builder
     * @return mixed
     */
    public function handle($builder)
    {
        return $builder->setAttributes('success', true)
                       ->setAttributes('code', 200);
    }
}
