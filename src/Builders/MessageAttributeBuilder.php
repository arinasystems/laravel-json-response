<?php

namespace ArinaSystems\JsonResponse\Builders;

use Illuminate\Support\Facades\Lang;

class MessageAttributeBuilder extends Builder
{
    /**
     * Build a value of the attribute.
     *
     * @param  string  $message
     * @return string
     */
    public function build($message)
    {
        if ($this->options->get('message_translations') === true) {
            return (string) Lang::get($message);
        }

        return (string) $message;
    }
}
