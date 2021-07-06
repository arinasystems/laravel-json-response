<?php

namespace ArinaSystems\JsonResponse\Tests;

use ArinaSystems\JsonResponse\Facades\Attribute;

class AttributeTest extends TestCase
{
    /**
     * @var \ArinaSystems\JsonResponse\Attribute
     */
    protected $attribute;

    /**
     * @var array
     */
    protected $attributes = [];

    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->attributes = [
            'success'   => true,
            'code'      => 2000,
            'http_code' => 200,
            'locale'    => 'en',
            'message'   => 'Hello, World!',
            'data'      => null,
            'headers'   => [],
            'exception' => null,
            'errors'    => [],
            'debug'     => null,
        ];

        $this->attribute = Attribute::set($this->attributes);
    }

    /**
     * @test
     */
    public function it_returns_value_of_given_key()
    {
        $this->assertEquals($this->attribute->get('code'), $this->attributes['code']);
    }

    /**
     * @test
     */
    public function it_returns_value_of_given_key_with_default_value()
    {
        $this->assertEquals($this->attribute->get('something', true), true);
    }

    /**
     * @test
     */
    public function it_can_set_a_value_of_given_key()
    {
        $value = $this->attribute->set('message', 'some_value')->get('message');
        $this->assertEquals($value, 'some_value');
    }

    /**
     * @test
     */
    public function it_can_set_an_array_of_keys_and_values()
    {
        $response = $this->attribute->set([
            'message' => 'some_value',
            'code'    => 5000,
        ]);

        $this->assertEquals($response->get('message'), 'some_value');
        $this->assertEquals($response->get('code'), 5000);
    }

    /**
     * @test
     */
    public function it_can_set_a_value_of_given_key_with_magic_methods()
    {
        $this->attribute->message = 'some_value';
        $value = $this->attribute->get('message');

        $this->assertEquals($value, 'some_value');
    }

    /**
     * @test
     */
    public function it_returns_value_of_given_key_with_magic_methods()
    {
        $this->assertEquals($this->attribute->code, $this->attributes['code']);
    }
}
