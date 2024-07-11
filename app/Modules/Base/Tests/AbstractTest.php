<?php

namespace App\Modules\Base\Tests;

use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class AbstractTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->withHeader('Accept', 'application/json');

        DB::statement("SET foreign_key_checks=0");

        DB::table('product')->truncate();

        DB::statement("SET foreign_key_checks=1");
    }

    public function tearDown(): void
    {
        DB::disconnect();
        parent::tearDown();
    }
}
