<?php

namespace ArinaSystems\JsonResponse\Attribute\Builders;

use ArinaSystems\JsonResponse\Code;

class CodeAttributeBuilder extends Builder
{
    /**
     * Build a value of the attribute.
     *
     * @param  string|int $code
     * @return int
     */
    public function build($code)
    {
        throw_if(
            is_integer($code) && !Code::inRange($code),
            new \Exception('The Api Code is out of range (' . Code::of('MIN') . ':' . Code::of('MAX') . ').')
        );

        return (int) is_integer($code) ? $code : Code::of($code);
    }
}
