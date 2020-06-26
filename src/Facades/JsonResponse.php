<?php

namespace ArinaSystems\JsonResponse\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * JsonResponse
 *
 * @method static \Illuminate\Http\JsonResponse json(string|array $status = null, array $attributes = [], array $options = []) Return json response.
 * @method static \Illuminate\Http\JsonResponse error(\Throwable $exception, string|array $status = null, array $attributes = [], array $options = []) Return json response with error.
 * @method static \ArinaSystems\JsonResponse\Status|\ArinaSystems\JsonResponse\JsonResponse status(string $status = null) Retrieve/Set json response status.
 * @method static \ArinaSystems\JsonResponse\Option|mixed options(string|array $key = null, mixed $default = null) Retrieve/Set json response options.
 * @method static \ArinaSystems\JsonResponse\Attribute|mixed attributes(string|array $key = null, mixed $default = null) Retrieve/Set json response attributes.
 * @method static \ArinaSystems\JsonResponse\JsonResponse setOptions(\ArinaSystems\JsonResponse\Option|array|string $options, mixed $value = null) Set json response options.
 * @method static \ArinaSystems\JsonResponse\JsonResponse setAttributes(\ArinaSystems\JsonResponse\Attribute|array|string $attributes, mixed $value = null) Set json response attributes.
 * @method static array structure(bool $error = false)
 * @method static \ArinaSystems\JsonResponse\JsonResponse instance() Get the current instance of json response builder.
 */
class JsonResponse extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'json-response.builder';
    }
}
