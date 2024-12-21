<?php

namespace Dearpos\Core\Tests\Unit\Models;

use Dearpos\Core\Models\Currency;
use Dearpos\Core\Tests\TestCase;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;

class CurrencyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_uses_uuid_as_primary_key()
    {
        $currency = Currency::factory()->create();

        $this->assertIsString($currency->id);
        $this->assertTrue(Str::isUuid($currency->id));
    }

    /** @test */
    public function it_has_required_attributes()
    {
        $currency = Currency::factory()->create([
            'code' => 'IDR',
            'name' => 'Indonesian Rupiah',
            'exchange_rate' => 1.0000,
        ]);

        $this->assertEquals('IDR', $currency->code);
        $this->assertEquals('Indonesian Rupiah', $currency->name);
        $this->assertEquals(1.0000, $currency->exchange_rate);
    }

    /** @test */
    public function it_enforces_unique_code()
    {
        Currency::factory()->create(['code' => 'IDR']);

        $this->expectException(QueryException::class);
        Currency::factory()->create(['code' => 'IDR']);
    }
}
