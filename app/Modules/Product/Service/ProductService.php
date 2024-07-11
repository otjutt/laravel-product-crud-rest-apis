<?php

namespace App\Modules\Product\Service;

use App\Modules\Product\Models\Product;

class ProductService
{
    public function handleAttributes(Product $product, $data)
    {
        if (isset($data['name'])) {
            $product->name = $data['name'];
        }
        if (isset($data['price'])) {
            $product->price = $data['price'];
        }
    }
}
