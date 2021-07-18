<p align="center" style="text-align:center"><img alt="Laravel JSON Response Cover" src="./docs/laravel-json-response.gif" /></p>
<p align="center">
<br/>
<a href="https://packagist.org/packages/arinasystems/laravel-json-response"><img src="https://img.shields.io/packagist/v/arinasystems/laravel-json-response.svg?style=flat-square" alt="Latest Version on Packagist"></a>
<a href="https://travis-ci.org/arinasystems/laravel-json-response"><img src="https://img.shields.io/travis/arinasystems/laravel-json-response/master.svg?style=flat-square" alt="Build Status"></a>
<a href="https://scrutinizer-ci.com/g/arinasystems/laravel-json-response"><img src="https://img.shields.io/scrutinizer/g/arinasystems/laravel-json-response.svg?style=flat-square" alt="Quality Score"></a>
<a href="https://packagist.org/packages/arinasystems/laravel-json-response"><img src="https://img.shields.io/packagist/dt/arinasystems/laravel-json-response.svg?style=flat-square" alt="Total Downloads"></a>
<a href="LICENSE.md"><img src="https://img.shields.io/badge/license-MIT-blue.svg?style=flat-square" alt="MIT Software License"></a>
</p>

# Laravel JSON Response

Extensible and powerful API response package for Laravel.

-   Localized Response
-   Presets Response Status
-   Attribute Builders
-   Data Transformers
-   JSON Exception Handler

---

-   [Installation](#installation)
-   [Basic Usage](#basic-usage)
-   [Configuration](#configuration)
    -   [Response Structure](#configuration)
    -   [Preset Status](#preset-status)
    -   [Data Transformers](#data-transformers)
    -   [JSON Encoding Options](#json-encoding-options)
    -   [Debugging Mode](#debugging-mode)
    -   [Message Translations](#message-translations)

---

## Installation

You can install the package via composer:

```bash
composer require arinasystems/laravel-json-response
```

The package will automatically register its service provider.

You can optionally publish the config file with:

```
php artisan vendor:publish --tag="json-response:config"
```

---

## Basic Usage

```php
use ArinaSystems\JsonResponse\Facades\JsonResponse;

/**
 * Display a listing of products.
 *
 * @return \Illuminate\Http\Response
 */
public function index()
{
    $products = Product::paginate(2);

    return JsonResponse::json('ok', ['data' => ProductResource::collection($products)]);
}
```

With just one line of code, your API client will get this response:

```json
{
    "success": true,
    "code": 200,
    "http_code": 200,
    "locale": "en",
    "message": "ok",
    "data": [
        {
            "id": "7OLgzrB1QVBQWMNZ3Rx08a24wAGEjqYVbeV",
            "name": "Aquafina Plastic Water Gallon – 18.9 L",
            "in_stock": true,
            "in_cart": false
            ...
        },
        {
            "id": "g3RbPoyMmPg9zr7qGZjW50Lp61aDlwnVOkE",
            "name": "Aquafina Plastic Water Bottle – 1.5 L",
            "in_stock": true,
            "in_cart": true
            ...
        }
    ],
    "additional": null,
    "links": {
        "first": "http://example.com/api/customer/products?page=1",
        "last": "http://example.com/api/customer/products?page=2",
        "prev": null,
        "next": "http://example.com/api/customer/products?page=2"
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 2,
        "path": "http://example.com/api/customer/products",
        "per_page": "2",
        "to": 2,
        "total": 3
    }
}
```

---

## Configuration

You can customize the response configuration from `config/json-response.php` file.

```php
<?php

return [
    'attributes'           => [
        'success'    => [
            'builder'     => \ArinaSystems\JsonResponse\Builders\SuccessAttributeBuilder::class,
            'value'       => true,
            'on-response' => true,
            'on-error'    => true,
        ],
        'code'       => [
            'builder'     => null,
            'value'       => 200,
            'on-response' => true,
            'on-error'    => true,
        ],
        'http_code'  => [
            'builder'     => null,
            'value'       => 200,
            'on-response' => true,
            'on-error'    => true,
        ],
        'locale'     => [
            'builder'     => \ArinaSystems\JsonResponse\Builders\LocaleAttributeBuilder::class,
            'value'       => null,
            'on-response' => true,
            'on-error'    => true,
        ],
        'message'    => [
            'builder'     => \ArinaSystems\JsonResponse\Builders\MessageAttributeBuilder::class,
            'value'       => null,
            'on-response' => true,
            'on-error'    => true,
        ],
        'data'       => [
            'builder'     => \ArinaSystems\JsonResponse\Builders\DataAttributeBuilder::class,
            'value'       => null,
            'on-response' => true,
            'on-error'    => false,
        ],
        'headers'    => [
            'value'       => [],
            'on-response' => false,
            'on-error'    => false,
        ],
        'exception'  => [
            'builder'     => \ArinaSystems\JsonResponse\Builders\ExceptionAttributeBuilder::class,
            'value'       => null,
            'on-response' => false,
            'on-error'    => true,
        ],
        'errors'     => [
            'builder'     => \ArinaSystems\JsonResponse\Builders\ErrorsAttributeBuilder::class,
            'value'       => [],
            'on-response' => false,
            'on-error'    => true,
        ],
        'debug'      => [
            'builder'     => \ArinaSystems\JsonResponse\Builders\DebugAttributeBuilder::class,
            'value'       => null,
            'on-response' => false,
            'on-error'    => true,
        ],
        'additional' => [
            'builder'     => null,
            'value'       => null,
            'on-response' => true,
            'on-error'    => true,
        ],
        'links'      => [
            'builder'     => null,
            'value'       => null,
            'on-response' => true,
            'on-error'    => true,
        ],
        'meta'       => [
            'builder'     => null,
            'value'       => null,
            'on-response' => true,
            'on-error'    => true,
        ],
    ],

    'status'               => [
        'ok' => \ArinaSystems\JsonResponse\Status\OkStatus::class,
    ],

    'transformers'         => [
        \Illuminate\Database\Eloquent\Model::class          => \ArinaSystems\JsonResponse\Transformers\EloquentTransformer::class,
        \Illuminate\Http\Resources\Json\JsonResource::class => \ArinaSystems\JsonResponse\Transformers\JsonResourceTransformer::class,
    ],

    'encoding_options'     => JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE,
    'debug'                => env('APP_DEBUG', false),
    'message_translations' => true,
];
```

### Response Structure

The first section in the configuration file allows you to set up the normal response and error response attributes. Each attribute array contains four options:

-   builder: Used to build the attribute value. (builder class or null to disable)
-   value: It's a default value if not passed in. (mixed)
-   on-response: Determines whether this attribute will appear in normal response. (boolean)
-   on-error: Determines whether this attribute will appear in error response. (boolean)

### Preset Status

In transformers array define the preset statuses in the "Status" array. The key defines the status name, and the value is the name of the case class.

### Data Transformers

Specify the data transformer for the given object type as a key and the transformer class as the value.

### JSON Encoding Options

Set the json encoding options in 'encoding_options'.

### Debugging Mode

Enable/Disable the debugging mode in 'debug' option.

### Message Translations

Enable/Disable the locale response message in 'message_translations' option.

---

### Testing

```bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email info@arinasystems.com instead of using the issue tracker.

## Credits

-   [Arina Systems](https://github.com/arinasystems)
-   [Mohamed Zedan](https://github.com/ZedanLab)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
