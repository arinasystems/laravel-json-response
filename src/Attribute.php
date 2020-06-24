<?php

namespace ArinaSystems\JsonResponse;

use Illuminate\Support\Arr;
use InvalidArgumentException;
use ArinaSystems\JsonResponse\Option;

class Attribute
{
    /**
     * @var \ArinaSystems\JsonResponse\Option
     */
    protected $options;

    /**
     * @var array
     */
    protected $attributes = [];

    /**
     * Create a new instance.
     *
     * @param  array|Option $attributes
     * @return void
     */
    public function __construct(Option $options)
    {
        $this->parse($options);
    }

    /**
     * Get an attribute from an array using "dot" notation.
     *
     * @param  string  $key
     * @param  mixed   $default
     * @return mixed
     */
    public function get(string $key, $default = null)
    {
        return Arr::get($this->attributes, $key . '.value', $default);
    }

    /**
     * Set a attribute to a given value using "dot" notation.
     *
     * @param  string|array $key
     * @param  null|mixed   $value
     * @return self
     */
    public function set($key, $value = null)
    {
        if (is_array($key)) {
            foreach ($key as $key => $value) {
                $this->set($key, $value);
            }
        }

        if (!is_string($key)) {
            throw new InvalidArgumentException();
        }

        $value = $this->build($key, $value);

        Arr::set($this->attributes, $key . '.value', $value);

        return $this;
    }

    /**
     * Retrieve all response attributes.
     *
     * @return array
     */
    public function all(string $value = 'value')
    {
        $attributes = $this->attributes;

        if (!is_null($value)) {
            foreach ($attributes as $attribute => $options) {
                $attributes[$attribute] = Arr::get($options, $value);
            }
        }

        return $attributes;
    }

    /**
     * Build the value of attribute.
     *
     * @param  string     $attribute
     * @param  mixed      $value
     * @param  mixed|null $builder
     * @return mixed
     */
    public function build(string $attribute, $value, $builder = null)
    {
        if (is_null($builder)) {
            $builder = $this->builderOf($attribute);
        }

        if (is_string($builder) && class_exists($builder)) {
            $builder = new $builder($this->options, $this);
            return $builder->build($value);
        }

        return $value;
    }

    /**
     * Get the builder attribute' value.
     *
     * @param  string  $attribute
     * @return mixed
     */
    protected function builderOf(string $attribute)
    {
        return Arr::get($this->options->builders(), $attribute);
    }

    /**
     * @param array $options
     */
    protected function parse($options): void
    {
        $this->options = $options;
        $this->attributes = $options->get('attributes');
        $this->set($this->all());
    }

    /**
     * Dynamically set attribute on the response attributes object.
     *
     * @param  string $key
     * @param  mixed  $value
     * @return void
     */
    public function __set(string $key, $value)
    {
        $this->set($key, $value);
    }

    /**
     * Dynamically retrieve attribute on the response attributes object.
     *
     * @param  string  $key
     * @return mixed
     */
    public function __get($key)
    {
        return $this->get($key);
    }

    /**
     * @return mixed
     */
    public function instance()
    {
        return $this;
    }
}
