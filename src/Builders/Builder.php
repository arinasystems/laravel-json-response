<?php

namespace ArinaSystems\JsonResponse\Builders;

use ArinaSystems\JsonResponse\Attribute;
use ArinaSystems\JsonResponse\Option;
use Illuminate\Container\Container;

abstract class Builder
{
    /**
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * @var \ArinaSystems\JsonResponse\Option
     */
    protected $options;

    /**
     * @var \ArinaSystems\JsonResponse\Attribute
     */
    protected $attributes;

    /**
     * Create a new instance.
     *
     * @param \ArinaSystems\JsonResponse\Option    $options
     * @param \ArinaSystems\JsonResponse\Attribute $attributes
     */
    public function __construct(Option $options, Attribute $attributes)
    {
        $this->options = $options;
        $this->attributes = $attributes;
        $this->request = Container::getInstance()->make('request');
    }

    /**
     * Build a value of the attribute.
     *
     * @return mixed
     */
    abstract public function build($value);
}
