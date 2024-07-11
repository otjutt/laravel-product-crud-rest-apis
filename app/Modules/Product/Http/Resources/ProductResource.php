<?php

namespace App\Modules\Product\Http\Resources;

use App\Modules\Base\Resources\BaseResource;

class ProductResource extends BaseResource
{
    public function __construct(
        $resource,
        public $key = null,
        public array $attributes = [],
        public array $meta = [],
    ) {
        parent::__construct($resource);
    }

    public function getType(): string
    {
        return 'product';
    }

    public function getAttributes(): array
    {
        return [
            'name' => $this->name,
            'price' => $this->price,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
