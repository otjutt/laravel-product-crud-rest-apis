<?php

namespace App\Modules\Product\Tests;

use App\Modules\Base\Tests\AbstractWithFixturesTest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;

class ProductCreateRouteTest extends AbstractWithFixturesTest
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
     * Failure test case.
     *
     * @return void
     */
    public function testUnprocessableEntity()
    {
        $response = $this
            ->post(self::URL, [
                'data' => [
                    'attributes' => [
                        'abc' => 'def',
                    ],
                ],
            ]);

        // Test response code.
        $response->assertStatus(422);

        // Test response data.
        $response->assertJson([
            'errors' => [
                'data.attributes.name' => [
                    'The data.attributes.name field is required.',
                ],
                'data.attributes.price' => [
                    'The data.attributes.price field is required.',
                ],
            ],
        ]);
    }

    /**
     * Success test case.
     *
     * @return void
     */
    public function testSuccess()
    {
        $response = $this
            ->post(self::URL, [
                'data' => [
                    'attributes' => [
                        'name' => 'Product 3',
                        'price' => '30',
                    ],
                ],
            ]);

        // Test HTTP response code.
        $response->assertStatus(201);

        // Test response structure.
        $response->assertJsonStructure($this->getJsonStructure());

        // Test response data.
        $response->assertJson(fn (AssertableJson $json) =>
        $json
            ->where('data.type', 'product')
            ->where('data.id', '3')
            ->where('data.attributes.name', 'Product 3')
            ->where('data.attributes.price', 30)
            ->etc()
        );

        // Test HSTS header value.
        $this->assertEquals(
            'max-age=63072000; includeSubDomains; preload',
            $response->headers->get('strict-transport-security')
        );

        // Test database data.
        $this->assertDatabaseHas('product', [
            'id' => '3',
            'name' => 'Product 3',
            'price' => '30',
        ]);
    }
}
