<?php

namespace ArinaSystems\JsonResponse\Data\Transformers;

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
     * @param  object $item
     * @return void
     */
    public function __construct($item)
    {
        throw_if(!$this->validate($item), new Exception("Expected argument of type \"" . get_class($item) . "\" \"" . get_class($item) . "\" given."));
        $this->item = $item;
    }

    /**
     * Convert the object instance to an array.
     *
     * @return array
     */
    abstract public function toArray(): array;

    abstract public function transform(): string;

    protected function validate($item)
    {
        return is_a($item, $this->transform());
    }
}
