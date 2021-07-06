<?php

namespace ArinaSystems\JsonResponse;

use ArinaSystems\JsonResponse\Status\Status as StatusInterface;
use Illuminate\Support\Arr;

class Status
{
    /**
     * @var array
     */
    protected $status = [];

    /**
     * Create a new instance.
     *
     * @param array $status
     */
    public function __construct(array $status)
    {
        $this->loadStatus($status);
    }

    /**
     * Get a status from an array using "dot" notation.
     *
     * @param  string     $key
     * @param  mixed|null $default
     * @return mixed
     */
    public function get(string $key, $default = null)
    {
        return Arr::get($this->status, $key, $default);
    }

    /**
     * Forget a status from by given name.
     *
     * @param  string  $key
     * @return mixed
     */
    public function forget(string $key)
    {
        return Arr::forget($this->status, $key);
    }

    /**
     * Set a status to a given value using "dot" notation.
     *
     * @param  string|array $keys
     * @param  null|mixed   $value
     * @return self
     */
    public function set($keys, $value = null)
    {
        if (is_array($keys)) {
            foreach ($keys as $key => $value) {
                $this->set($key, $value);
            }
        }

        if (is_string($keys)) {
            Arr::set($this->status, $keys, $value);
        }

        return $this;
    }

    /**
     * Check if an status is exist in the array.
     *
     * @param  array  $key
     * @return bool
     */
    public function has($key)
    {
        return Arr::has($this->all(), $key);
    }

    /**
     * Retrieve all response status.
     *
     * @return array
     */
    public function all()
    {
        return $this->status;
    }

    /**
     * Call the response status.
     *
     * @return array
     */
    public function call(string $status, $builder)
    {
        $status = $this->get($status);

        if (! (new $status()) instanceof StatusInterface) {
            throw new \Exception("The class '{$status}' must implement 'ArinaSystems\JsonResponse\Status\Status' interface.", 1);
        }

        return (new $status())->handle($builder);
    }

    /**
     * Load the given status array to response status object.
     *
     * @param  array  $status
     * @return void
     */
    protected function loadStatus(array $status): void
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function instance()
    {
        return $this;
    }
}
