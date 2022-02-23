<?php

namespace ArinaSystems\JsonResponse\Builders;

use Exception;

class DataAttributeBuilder extends Builder
{
    /**
     * Build a value of the attribute.
     *
     * @param  mixed  $object
     * @return mixed
     */
    public function build($object)
    {
        if (! is_object($object)) {
            return $object;
        }

        foreach ($this->options->transformers as $type => $transformer) {
            if (is_a($object, $type)) {
                return (new $transformer($object))->toArray();
            }
        }

        throw new Exception('Transformer not found for type '.get_class($object).'.');
    }
}
