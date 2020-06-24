<?php

return [
    'attributes'           => [
        'success'   => [
            'builder'     => \ArinaSystems\JsonResponse\Attribute\Builders\SuccessAttributeBuilder::class,
            'value'       => true,
            'on-response' => true,
            'on-error'    => true,
        ],
        'code'      => [
            'builder'     => \ArinaSystems\JsonResponse\Attribute\Builders\CodeAttributeBuilder::class,
            'value'       => \ArinaSystems\JsonResponse\Code::OK,
            'on-response' => true,
            'on-error'    => true,
        ],
        'http_code' => [
            'builder'     => null,
            'value'       => 200,
            'on-response' => true,
            'on-error'    => true,
        ],
        'locale'    => [
            'builder'     => \ArinaSystems\JsonResponse\Attribute\Builders\LocaleAttributeBuilder::class,
            'value'       => null,
            'on-response' => true,
            'on-error'    => true,
        ],
        'message'   => [
            'builder'     => \ArinaSystems\JsonResponse\Attribute\Builders\MessageAttributeBuilder::class,
            'value'       => null,
            'on-response' => true,
            'on-error'    => true,
        ],
        'data'      => [
            'builder'     => \ArinaSystems\JsonResponse\Attribute\Builders\DataAttributeBuilder::class,
            'value'       => null,
            'on-response' => true,
            'on-error'    => false,
        ],
        'headers'   => [
            'value'       => [],
            'on-response' => false,
            'on-error'    => false,
        ],
        'exception' => [
            'builder'     => \ArinaSystems\JsonResponse\Attribute\Builders\ExceptionAttributeBuilder::class,
            'value'       => null,
            'on-response' => false,
            'on-error'    => true,
        ],
        'errors'    => [
            'builder'     => \ArinaSystems\JsonResponse\Attribute\Builders\ErrorsAttributeBuilder::class,
            'value'       => [],
            'on-response' => false,
            'on-error'    => true,
        ],
        'debug'     => [
            'builder'     => \ArinaSystems\JsonResponse\Attribute\Builders\DebugAttributeBuilder::class,
            'value'       => null,
            'on-response' => false,
            'on-error'    => true,
        ],
    ],

    'status'               => [
        'ok' => \ArinaSystems\JsonResponse\Status\OkStatus::class,
    ],

    'transformers'         => [
        \Illuminate\Database\Eloquent\Model::class          => \ArinaSystems\JsonResponse\DataTransformers\EloquentTransformer::class,
        \Illuminate\Database\Eloquent\Collection::class     => null,
        \Illuminate\Http\Resources\Json\JsonResource::class => null,
    ],

    'codes'                => [
        'min' => \ArinaSystems\JsonResponse\Code::MIN,
        'max' => \ArinaSystems\JsonResponse\Code::MAX,
        'ok'  => \ArinaSystems\JsonResponse\Code::OK,
        // 'created' => \ArinaSystems\JsonResponse\Code::CREATED,
    ],

    'encoding_options'     => JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE,
    'debug'                => env('APP_DEBUG', false),
    'message_translations' => true,
];
