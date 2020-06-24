<?php

namespace ArinaSystems\JsonResponse\Attribute\Builders;

use Illuminate\Container\Container;
use ArinaSystems\JsonResponse\Option;
use ArinaSystems\JsonResponse\Attribute;

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
     * @return void
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
