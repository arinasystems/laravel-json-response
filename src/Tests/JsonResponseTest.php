<?php

namespace ArinaSystems\JsonResponse\Tests;

use ArinaSystems\JsonResponse\Code;
use ArinaSystems\JsonResponse\Facades\Option;
use ArinaSystems\JsonResponse\Facades\JsonResponse;
use Illuminate\Support\Facades\Config;

class JsonResponseTest extends TestCase
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
     * @test
     */
    public function it_builds_default_json()
    {
        $defaults = Option::defaults();

        $response = JsonResponse::json()->getData();

        $this->assertEquals($response->success, $defaults['success']);
        $this->assertEquals($response->http_code, $defaults['http_code']);
        $this->assertEquals($response->code, $defaults['code']);
    }

    /**
     * @test
     */
    public function it_returns_with_response_structure()
    {
        $responseStructure = (array) JsonResponse::json()->getData();
        $builderStructure = JsonResponse::structure();

        $this->assertEquals(array_keys($responseStructure), array_keys($builderStructure));
    }

    /**
     * @test
     */
    public function it_returns_with_error_structure()
    {
        // Enable debugging mode.
        Config::set('json-response.debug', true);

        $responseStructure = (array) JsonResponse::error()->getData();
        $builderStructure = JsonResponse::structure(true);

        $this->assertEquals(array_keys($responseStructure), array_keys($builderStructure));
    }

    /**
     * @test
     */
    public function it_returns_with_certain_headers()
    {
        JsonResponse::attributes(['headers' => ['App-Name' => 'Laravel']]);

        $response = JsonResponse::json();

        $this->assertEquals($response->headers->get('App-Name'), 'Laravel');
    }
}
