<?php

namespace App\Basic\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\LengthAwarePaginator;

abstract class PaginateResource extends JsonResource
{

    abstract function data(Request $request, array $items): array;


    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'current_page' => $this->resource->currentPage(),
            'data' => $this->data($request, $this->resource->items()),
            // 'data' => $this->items->toArray(),
            // 'first_page_url' => $this->url(1),
            // 'from' => $resource->firstItem(),
            'last_page' => $this->resource->lastPage(),
            // 'last_page_url' => $this->url($this->lastPage()),
            // 'links' => $resource->linkCollection()->toArray(),
            // 'next_page_url' => $this->nextPageUrl(),
            // 'path' => $resource->path(),
            'per_page' => $this->resource->perPage(),
            // 'prev_page_url' => $this->previousPageUrl(),
            // 'to' => $resource->lastItem(),
            'total' => $this->resource->total(),
        ];

    }
}
