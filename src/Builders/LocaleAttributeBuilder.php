<?php

namespace ArinaSystems\JsonResponse\Builders;

use Illuminate\Support\Facades\Config;

class LocaleAttributeBuilder extends Builder
{
    /**
     * Build a value of the attribute.
     *
     * @param  string|null $locale
     * @return string
     */
    public function build($locale = null)
    {
        return $locale ?? Config::get('app.locale');
    }
}
