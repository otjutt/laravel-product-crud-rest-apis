<?php

namespace App\Modules\Product\Tests;

use App\Modules\Base\Tests\AbstractWithFixturesTest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;

class ProductUpdateRouteTest extends AbstractWithFixturesTest
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
            ->post(self::URL . '/1', [
                'data' => [
                    'attributes' => [
                        'price' => 'abc',
                    ],
                ],
            ]);

        // Test response code.
        $response->assertStatus(422);

        // Test response data.
        $response->assertJson([
            'errors' => [
                'data.attributes.price' => [
                    'The data.attributes.price field must be a number.',
                    'The data.attributes.price field must be greater than or equal to 0.',
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
            ->post(self::URL . '/1', [
                'data' => [
                    'attributes' => [
                        'name' => 'Product 1 Updated',
                        'price' => '11',
                    ],
                ],
            ]);

        // Test response code.
        $response->assertStatus(202);

        // Test response structure.
        $response->assertJsonStructure($this->getJsonStructure());

        // Test response data.
        $response->assertJson(fn (AssertableJson $json) =>
        $json
            ->where('data.type', 'product')
            ->where('data.id', '1')
            ->where('data.attributes.name', 'Product 1 Updated')
            ->where('data.attributes.price', 11)
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
            'name' => 'Product 1 Updated',
            'price' => '11',
        ]);
        $this->assertDatabaseHas('product', [
            'id' => '2',
            'name' => 'Product 2',
            'price' => '20',
        ]);
    }
}
