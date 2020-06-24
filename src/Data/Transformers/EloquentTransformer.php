<?php

namespace ArinaSystems\JsonResponse\DataTransformers;

use ArinaSystems\JsonResponse\Data\Transformers\Transformer;

class EloquentTransformer extends Transformer
{
    /**
     * Transform the data value to array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->item->toArray();
    }

    public function transform(): string
    {
        return \Illuminate\Database\Eloquent\Model::class;
    }
}
