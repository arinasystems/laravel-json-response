<?php

namespace ArinaSystems\JsonResponse\Facades;

use Illuminate\Support\Facades\Facade;

class Status extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'json-response.status';
    }
}
