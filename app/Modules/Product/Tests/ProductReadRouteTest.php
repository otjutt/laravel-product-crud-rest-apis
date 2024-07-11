<?php

namespace App\Modules\Product\Tests;

use App\Modules\Base\Tests\AbstractWithFixturesTest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;

class ProductReadRouteTest extends AbstractWithFixturesTest
{
    use RefreshDatabase;

    const URL = '/api/v1/product';

    public function setUp(): void
    {
        parent::setUp();
    }

    public function getJsonStructure()
    {
        return [
            'data' => [
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
            ->get(self::URL . '/1');

        // Test response code.
        $response->assertStatus(200);

        // Test response structure.
        $response->assertJsonStructure($this->getJsonStructure());

        // Test response data.
        $response->assertJson(fn (AssertableJson $json) =>
        $json
            ->where('data.type', 'product')
            ->where('data.id', '1')
            ->where('data.attributes.name', 'Product 1')
            ->where('data.attributes.price', 10)
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
    }
}
