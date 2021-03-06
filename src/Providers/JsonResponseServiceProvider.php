<?php

namespace ArinaSystems\JsonResponse\Providers;

use ArinaSystems\JsonResponse\Attribute;
use ArinaSystems\JsonResponse\JsonResponse;
use ArinaSystems\JsonResponse\Option;
use ArinaSystems\JsonResponse\Status;
use Illuminate\Support\ServiceProvider;

class JsonResponseServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerConfig();
        $this->registerFacade();
    }

    /**
     * Register facade.
     *
     * @return void
     */
    protected function registerFacade()
    {
        $this->app->singleton('json-response.option', function ($app) {
            return new Option($app['config']->get('json-response'));
        });
        $this->app->singleton('json-response.attribute', function ($app) {
            return new Attribute($app['json-response.option']->instance());
        });
        $this->app->singleton('json-response.status', function ($app) {
            return new Status($app['config']->get('json-response.status'));
        });
        $this->app->singleton('json-response.builder', function ($app) {
            return new JsonResponse($app['json-response.option']->instance(), $app['json-response.attribute']->instance(), $app['json-response.status']->instance());
        });
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__.'/../../config/config.php' => config_path('json-response.php'),
        ], 'json-response:config');
        $this->mergeConfigFrom(
            __DIR__.'/../../config/config.php',
            'json-response'
        );
    }
}
