<?php

namespace ArinaSystems\JsonResponse\Tests;

use ArinaSystems\JsonResponse\Providers\JsonResponseServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

/**
 * Class TestCase.
 */
abstract class TestCase extends Orchestra
{
    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Get JsonResponse package providers.
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            JsonResponseServiceProvider::class,
        ];
    }

    /**
     * @param  $app
     * @return array
     */
    protected function getPackageAliases($app)
    {
        return [
            'JsonResponse' => 'ArinaSystems\JsonResponse\Facades\JsonResponse',
        ];
    }
}
