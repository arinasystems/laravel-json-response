<?php

namespace ArinaSystems\JsonResponse;

use Illuminate\Support\Arr;
use InvalidArgumentException;

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
     * @param  \ArinaSystems\JsonResponse\Option  $options
     */
    public function __construct(Option $options)
    {
        $this->parse($options);
    }

    /**
     * Get an attribute from an array using "dot" notation.
     *
     * @param  string  $key
     * @param  mixed  $default
     * @return mixed
     */
    public function get(string $key, $default = null)
    {
        return Arr::get($this->attributes, $key.'.value', $default);
    }

    /**
     * Set a attribute to a given value using "dot" notation.
     *
     * @param  string|array  $keys
     * @param  null|mixed  $value
     * @return self
     */
    public function set($keys, $value = null)
    {
        if (is_array($keys)) {
            foreach ($keys as $key => $value) {
                $this->set($key, $value);
            }

            return $this;
        }

        if (! is_string($keys)) {
            throw new InvalidArgumentException('$key must be a string or array.');
        }

        $value = $this->build($keys, $value);

        Arr::set($this->attributes, $keys.'.value', $value);

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

        foreach ($attributes as $attribute => $options) {
            $attributes[$attribute] = Arr::get($options, $value);
        }

        return $attributes;
    }

    /**
     * Build the value of attribute.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  mixed|null  $builder
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
     * Get the attribute's value builder.
     *
     * @param  string  $attribute
     * @return mixed
     */
    protected function builderOf(string $attribute)
    {
        return Arr::get($this->options->builders(), $attribute);
    }

    /**
     * Parsing the attributes from the given options.
     *
     * @param  \ArinaSystems\JsonResponse\Option  $options
     * @return void
     */
    protected function parse(Option $options): void
    {
        $this->options = $options;
        $this->attributes = (array) $options->get('attributes');
        $this->set($this->all());
    }

    /**
     * Dynamically set attribute on the response attributes object.
     *
     * @param  string  $key
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
     * Get an instance of attribute object.
     *
     * @return self
     */
    public function instance()
    {
        return $this;
    }
}
