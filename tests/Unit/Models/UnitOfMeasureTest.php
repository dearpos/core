<?php

namespace Dearpos\Core\Tests\Unit\Models;

use Dearpos\Core\Models\UnitOfMeasure;
use Dearpos\Core\Tests\TestCase;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;

class UnitOfMeasureTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_uses_uuid_as_primary_key()
    {
        $unit = UnitOfMeasure::factory()->create();

        $this->assertIsString($unit->id);
        $this->assertTrue(Str::isUuid($unit->id));
    }

    /** @test */
    public function it_has_required_attributes()
    {
        $unit = UnitOfMeasure::factory()->create([
            'code' => 'PCS',
            'name' => 'Pieces',
        ]);

        $this->assertEquals('PCS', $unit->code);
        $this->assertEquals('Pieces', $unit->name);
    }

    /** @test */
    public function it_enforces_unique_code()
    {
        UnitOfMeasure::factory()->create(['code' => 'PCS']);

        $this->expectException(QueryException::class);
        UnitOfMeasure::factory()->create(['code' => 'PCS']);
    }
}
