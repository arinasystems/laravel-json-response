<?php

namespace ArinaSystems\JsonResponse\Data\Transformers;

use Illuminate\Support\Arr;
use Illuminate\Pagination\LengthAwarePaginator;
use ArinaSystems\JsonResponse\Facades\JsonResponse;

class JsonResourceTransformer extends Transformer
{
    /**
     * Determine which class of object should be transform.
     *
     * @return string
     */
    public function objectClass(): string
    {
        return \Illuminate\Http\Resources\Json\JsonResource::class;
    }

    /**
     * Transform the data value to array.
     *
     * @return array
     */
    public function toArray(): array
    {
        if ($this->item->resource instanceof LengthAwarePaginator) {
            $this->paginationInformation();
        }

        return $this->item->resolve();
    }

    /**
     * Add the pagination information to the response.
     *
     * @return void
     */
    protected function paginationInformation()
    {
        $paginated = $this->item->resource->toArray();

        JsonResponse::setAttributes('links', $this->paginationLinks($paginated));
        JsonResponse::setAttributes('meta', $this->meta($paginated));
    }

    /**
     * Get the pagination links for the response.
     *
     * @param  array   $paginated
     * @return array
     */
    protected function paginationLinks($paginated)
    {
        return [
            'first' => $paginated['first_page_url'] ?? null,
            'last'  => $paginated['last_page_url'] ?? null,
            'prev'  => $paginated['prev_page_url'] ?? null,
            'next'  => $paginated['next_page_url'] ?? null,
        ];
    }

    /**
     * Gather the meta data for the response.
     *
     * @param  array   $paginated
     * @return array
     */
    protected function meta($paginated)
    {
        return Arr::except($paginated, [
            'data',
            'first_page_url',
            'last_page_url',
            'prev_page_url',
            'next_page_url',
        ]);
    }
}
