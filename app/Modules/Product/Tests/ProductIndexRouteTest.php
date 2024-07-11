<?php

namespace App\Modules\Product\Tests;

use App\Modules\Base\Tests\AbstractWithFixturesTest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;

class ProductIndexRouteTest extends AbstractWithFixturesTest
{
    use RefreshDatabase;

    const URL = '/api/v1/product';

    public function setUp(): void
    {
        parent::setUp();
    }

    private function getJsonStructure()
    {
        return [
            'data' => [
                '*' => [
                    'type',
                    'id',
                    'attributes' => [
                        'name',
                        'price',
                        'created_at',
                        'updated_at',
                    ],
                    'meta' => [],
                ],
            ],
            'meta' => [
                'current_page',
                'from',
                'last_page',
                'links' => [
                    '*' => [
                        'url',
                        'label',
                        'active',
                    ]
                ],
                'path',
                'per_page',
                'to',
                'total',
            ],
            'links' => [
                'first',
                'last',
                'prev',
                'next',
            ],
        ];
    }

    /**
     * Success test case.
     *
     * @return void
     */
    public function testSuccess()
    {
        $response = $this
            ->get(self::URL);

        // Test response code.
        $response->assertStatus(200);

        // Test response structure.
        $response->assertJsonStructure($this->getJsonStructure());

        // Test response data.
        $response->assertJson(fn (AssertableJson $json) =>
        $json
            ->count('data', 2)

            ->where('data.0.type', 'product')
            ->where('data.0.id', '1')
            ->count('data.0.attributes', 4)
            ->where('data.0.attributes.name', 'Product 1')
            ->where('data.0.attributes.price', 10)

            ->where('data.1.type', 'product')
            ->where('data.1.id', '2')
            ->count('data.1.attributes', 4)
            ->where('data.1.attributes.name', 'Product 2')
            ->where('data.1.attributes.price', 20)

            ->etc()
        );

        // Test HSTS header value.
        $this->assertEquals(
            'max-age=63072000; includeSubDomains; preload',
            $response->headers->get('strict-transport-security')
        );

        // Test database data.
        $this->assertDatabaseHas('product', [
            'id' => '1',
            'name' => 'Product 1',
            'price' => '10',
        ]);
        $this->assertDatabaseHas('product', [
            'id' => '2',
            'name' => 'Product 2',
            'price' => '20',
        ]);
    }
}
