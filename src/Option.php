<?php

namespace ArinaSystems\JsonResponse;

use Illuminate\Support\Arr;

class Option
{
    /**
     * @var array
     */
    protected $options = [];

    /**
     * Create a new instance.
     *
     * @param  array  $options
     * @return void
     */
    public function __construct(array $options)
    {
        $this->loadOptions($options);
    }

    /**
     * Get a option from an array using "dot" notation.
     *
     * @param  string     $key
     * @param  mixed|null $default
     * @return mixed
     */
    public function get(string $key, $default = null)
    {
        return Arr::get($this->options, $key, $default);
    }

    /**
     * Set a option to a given value using "dot" notation.
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

        if (is_string($key)) {
            Arr::set($this->options, $key, $value);
        }

        return $this;
    }

    /**
     * Retrieve all response options.
     *
     * @return array
     */
    public function all(): array
    {
        return (array) $this->options;
    }

    /**
     * Load the given options array to response options object.
     *
     * @param  array  $options
     * @return void
     */
    protected function loadOptions(array $options): void
    {
        $this->options = $options;
    }

    /**
     * Dynamically set option on the response options object.
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
     * Dynamically retrieve option on the response options object.
     *
     * @param  string  $key
     * @return mixed
     */
    public function __get($key)
    {
        return $this->get($key);
    }

    /**
     * Get the current instance of json response options.
     *
     * @return mixed
     */
    public function instance(): self
    {
        return $this;
    }

    /**
     * Retrieve all attributes builders.
     *
     * @return array
     */
    public function builders(): array
    {
        return array_map(function ($attribute) {
            return Arr::get($attribute, 'builder');
        }, $this->get('attributes'));
    }

    /**
     * Retrieve all attributes defaults.
     *
     * @return array
     */
    public function defaults(string $attribute = null): array
    {
        if ($attribute) {
            return config("json-response.attributes.{$attribute}.value");
        }

        return array_map(function ($attribute) {
            return Arr::get($attribute, 'value');
        }, config('json-response.attributes'));
    }
}
