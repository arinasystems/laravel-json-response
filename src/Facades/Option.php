<?php

namespace ArinaSystems\JsonResponse\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Option.
 *
 * @method static \ArinaSystems\JsonResponse\Option instance() Get the current instance of json response options.
 * @method static \ArinaSystems\JsonResponse\Option set(string|array $key, mixed $value = null) Set a option to a given value using "dot" notation.
 * @method static mixed get(string $key, $default = null) Get a option from an array using "dot" notation.
 * @method static array all() Retrieve all json response options.
 * @method static array builders() Retrieve all attributes builders.
 */
class Option extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'json-response.option';
    }
}
