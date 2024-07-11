<?php

namespace App\Modules\Product\Tests;

use App\Modules\Base\Tests\AbstractWithFixturesTest;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductDeleteRouteTest extends AbstractWithFixturesTest
{
    use RefreshDatabase;

    const URL = '/api/v1/product';

    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Success test case.
     *
     * @return void
     */
    public function testSuccess()
    {
        $response = $this
            ->delete(self::URL . '/1');

        // Test response code.
        $response->assertStatus(204);

        // Test HSTS header value.
        $this->assertEquals(
            'max-age=63072000; includeSubDomains; preload',
            $response->headers->get('strict-transport-security')
        );

        /* Check that resource is deleted in the database. */
        $this->assertDatabaseMissing('product', [
            'id' => '1',
        ]);
    }
}
