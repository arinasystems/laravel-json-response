<?php

namespace ArinaSystems\JsonResponse;

use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Response;

class JsonResponse
{
    /**
     * @var \ArinaSystems\JsonResponse\Status
     */
    protected $status;

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
     * @param \ArinaSystems\JsonResponse\Option|array|string $options
     */
    public function __construct(Option $options, Attribute $attributes, Status $status)
    {
        $this->options = $options;
        $this->status = $status;
        $this->attributes = $attributes;
    }

    /**
     * Return json response.
     *
     * @param  string|array                    $status
     * @param  array                           $attributes
     * @param  array                           $options
     * @return \Illuminate\Http\JsonResponse
     */
    public function json($status = null, array $attributes = [], array $options = [])
    {
        if (is_array($status)) {
            extract($status);
        }

        if (! empty($options)) {
            $this->options($options);
        }

        if (! is_null($status) && is_string($status)) {
            $this->status($status);
        }

        if (! empty($attributes)) {
            $this->attributes($attributes);
        }

        $is_error = $this->attributes('exception') ? true : false;

        return Response::json(
            $this->build($is_error),
            /* @scrutinizer ignore-type */
            $this->attributes('http_code', 200),
            /* @scrutinizer ignore-type */
            $this->attributes('headers', []),
            /* @scrutinizer ignore-type */
            $this->options('encoding_options')
        );
    }

    /**
     * Return json response with error.
     *
     * @param  \Throwable                      $exception
     * @param  string|array                    $status
     * @param  array                           $attributes
     * @param  array                           $options
     * @return \Illuminate\Http\JsonResponse
     */
    public function error($exception, $status = null, array $attributes = [], array $options = [])
    {
        $this->setAttributes('exception', $exception);

        return $this->json($status, $attributes, $options);
    }

    /**
     * Retrieve/Set json response status.
     *
     * @param  string                                   $status
     * @return \ArinaSystems\JsonResponse\Status|self
     */
    public function status(string $status = null)
    {
        if (is_string($status)) {
            throw_if(! $this->status->has($status), new Exception("The \"{$status}\" response state does not exist"));

            return $this->status->call($status, $this);
        }

        return $this->status;
    }

    /**
     * Retrieve/Set json response options.
     *
     * @param  string|array|null                         $key
     * @param  mixed|null                                $default
     * @return \ArinaSystems\JsonResponse\Option|mixed
     */
    public function options($key = null, $default = null)
    {
        if (is_array($key)) {
            return $this->setOptions($key);
        }

        if (! is_null($key)) {
            return $this->options->get($key, $default);
        }

        return $this->options ?? $default;
    }

    /**
     * Retrieve/Set json response attributes.
     *
     * @param  string|array|null                            $key
     * @param  mixed|null                                   $default
     * @return \ArinaSystems\JsonResponse\Attribute|mixed
     */
    public function attributes($key = null, $default = null)
    {
        if (is_array($key)) {
            return $this->setAttributes($key);
        }

        if (is_string($key)) {
            return $this->attributes->get($key, $default);
        }

        return $this->attributes ?? $default;
    }

    /**
     * Set json response options.
     *
     * @param  \ArinaSystems\JsonResponse\Option|array|string $options
     * @param  null|mixed                                     $value
     * @return self
     */
    public function setOptions($options, $value = null)
    {
        if (is_a($options, Option::class)) {
            $this->options = $options;
        }

        $this->options->set(/* @scrutinizer ignore-type */ $options, $value);

        return $this;
    }

    /**
     * Set json response option.
     *
     * @param  \ArinaSystems\JsonResponse\Option|array|string $options
     * @param  null|mixed                                     $value
     * @return self
     */
    public function setOption($options, $value = null)
    {
        return $this->setOptions($options, $value);
    }

    /**
     * Set json response attributes.
     *
     * @param  \ArinaSystems\JsonResponse\Attribute|array|string $attributes
     * @param  null|mixed                                        $value
     * @return self
     */
    public function setAttributes($attributes, $value = null)
    {
        if (is_a($attributes, Attribute::class)) {
            $this->attributes = $attributes;
        }

        $this->attributes->set(/* @scrutinizer ignore-type */ $attributes, $value);

        return $this;
    }

    /**
     * Set json response attribute.
     *
     * @param  \ArinaSystems\JsonResponse\Attribute|array|string $attributes
     * @param  null|mixed                                        $value
     * @return self
     */
    public function setAttribute($attributes, $value = null)
    {
        return $this->setAttributes($attributes, $value);
    }

    /**
     * Get the json response data array.
     *
     * @param  bool    $error
     * @return array
     */
    protected function build(bool $error = false): array
    {
        $structure = $this->structure($error);

        if (! $this->options('debug')) {
            unset($structure['debug']);
        }

        $response = array_intersect_key($this->attributes->all('value'), $structure);

        return $response;
    }

    /**
     * Get response data structure.
     *
     * @param  bool    $error
     * @return array
     */
    public function structure(bool $error = false): array
    {
        $structure = Arr::where($this->attributes->all('on-'.($error ? 'error' : 'response')), function ($onStructure) {
            return boolval($onStructure);
        });

        $structure = array_keys($structure);

        return array_flip($structure);
    }

    /**
     * Get the current instance of json response builder.
     *
     * @return \ArinaSystems\JsonResponse\JsonResponse
     */
    public function instance(): self
    {
        return $this;
    }
}
