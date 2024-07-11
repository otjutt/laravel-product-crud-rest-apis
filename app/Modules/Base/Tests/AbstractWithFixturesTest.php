<?php

namespace App\Modules\Base\Tests;

use App\Modules\Product\Models\Product;

class AbstractWithFixturesTest extends AbstractTest
{
    public function setUp(): void
    {
        parent::setUp();

        Product::create([
            'name' => 'Product 1',
            'price' => '10',
        ]);
        Product::create([
            'name' => 'Product 2',
            'price' => '20',
        ]);
    }
}
