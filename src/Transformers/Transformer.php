<?php

namespace ArinaSystems\JsonResponse\Transformers;

use Exception;

abstract class Transformer
{
    /**
     * @var object
     */
    protected $item;

    /**
     * Create a new instance.
     *
     * @param  object  $item
     */
    public function __construct($item)
    {
        throw_if(! $this->validate($item), new Exception('Expected argument of type "'.get_class($item).'" "'.get_class($item).'" given.'));
        $this->item = $item;
    }

    /**
     * Convert the object instance to an array.
     *
     * @return array
     */
    abstract public function toArray(): array;

    /**
     * Determine which class of object should be transform.
     *
     * @return string
     */
    abstract public function objectClass(): string;

    /**
     * Check if the given object item is an instance of the determined class.
     *
     * @param $item
     * @return bool
     */
    protected function validate($item)
    {
        return (bool) is_a($item, $this->objectClass());
    }
}
