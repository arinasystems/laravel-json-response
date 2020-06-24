<?php

namespace ArinaSystems\JsonResponse\Attribute\Builders;

class SuccessAttributeBuilder extends Builder
{
    /**
     * Build a value of the attribute.
     *
     * @param  bool   $success
     * @return bool
     */
    public function build($success)
    {
        return boolval($success);
    }
}
