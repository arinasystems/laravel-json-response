<?php

namespace ArinaSystems\JsonResponse;

use Illuminate\Support\Facades\Config;

class Code
{
    const MIN = 1000;
    const MAX = 9999;

    const OK = 2000;

    /**
     * Determine if the given code is in the allowed range.
     *
     * @param  int    $code
     * @return bool
     */
    public static function inRange(int $code): bool
    {
        return $code >= static::of('MIN') && $code <= static::of('MAX');
    }

    /**
     * Retrieve the code by the given name.
     *
     * @param  string $code_name
     * @return int
     */
    public static function of(string $code_name)
    {
        return Config::get(
            'json-response.codes.' . strtolower($code_name),
            constant(static::class . '::' . strtoupper($code_name))
        );
    }
}
