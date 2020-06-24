<?php

namespace ArinaSystems\JsonResponse\Attribute\Builders;

class ErrorsAttributeBuilder extends Builder
{
    /**
     * Build a value of the errors attribute.
     *
     * @param  array|string|object $errors
     * @return mixed
     */
    public function build($errors)
    {
        return $errors;
    }
}
