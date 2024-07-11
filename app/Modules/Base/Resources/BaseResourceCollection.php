<?php

namespace App\Modules\Base\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection;

class BaseResourceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->getCollection(),
            'meta' => $this->getMeta(),
        ];
    }

    public function getMeta(): array
    {
        return [];
    }

    public function getCollection(): Collection
    {
        return new Collection();
    }
}
