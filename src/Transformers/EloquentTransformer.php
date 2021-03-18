<?php

namespace ArinaSystems\JsonResponse\Transformers;

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
