<?php

namespace App\Modules\Product\Http\Resources;

use App\Modules\Base\Resources\BaseResourceCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ProductCollection extends BaseResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return parent::toArray($request);
    }

    public function getCollection(): Collection
    {
        return $this->collection;
    }
}
