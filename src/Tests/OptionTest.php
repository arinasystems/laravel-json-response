<?php

namespace ArinaSystems\JsonResponse\Tests;

use ArinaSystems\JsonResponse\Option;
use Illuminate\Support\Facades\Config;

class OptionTest extends TestCase
{
    /**
     * @var \ArinaSystems\JsonResponse\Option
     */
    protected $options;

    /**
     * @var array
     */
    protected $config;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->config = Config::get('json-response');
        $this->options = new Option($this->config);
    }

    /**
     * @test
     */
    public function it_loads_the_given_config_array()
    {
        $this->assertEquals($this->options->all(), $this->config);
    }

    /**
     * @test
     */
    public function it_returns_a_value_of_given_key()
    {
        $this->assertEquals($this->options->get('attributes'), $this->config['attributes']);
    }

    /**
     * @test
     */
    public function it_returns_a_value_of_given_key_with_default_value()
    {
        $this->assertEquals($this->options->get('some_key', 'default'), 'default');
    }

    /**
     * @test
     */
    public function it_can_set_a_value_of_given_key()
    {
        $value = $this->options->set('some_key', 'some_value')->get('some_key');
        $this->assertEquals($value, 'some_value');
    }

    /**
     * @test
     */
    public function it_can_set_an_array_of_keys_and_values()
    {
        $value = $this->options->set([
            'some_key'         => 'some_value',
            'another_some_key' => 'another_some_value',
        ]);

        $this->assertEquals($value->get('some_key'), 'some_value');
        $this->assertEquals($value->get('another_some_key'), 'another_some_value');
    }

    /**
     * @test
     */
    public function it_can_set_a_value_of_given_key_with_magic_methods()
    {
        $this->options->some_key = 'some_value';
        $value = $this->options->get('some_key');

        $this->assertEquals($value, 'some_value');
    }

    /**
     * @test
     */
    public function it_can_get_value_of_given_key_with_magic_methods()
    {
        $this->assertEquals($this->options->attributes, $this->config['attributes']);
    }
}
