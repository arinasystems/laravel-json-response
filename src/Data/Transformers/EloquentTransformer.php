<?php

namespace ArinaSystems\JsonResponse\Data\Transformers;

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

    /**
     * Determine which class of object should be transform.
     *
     * @return string
     */
    public function objectClass(): string
    {
        return \Illuminate\Database\Eloquent\Model::class;
    }
}
