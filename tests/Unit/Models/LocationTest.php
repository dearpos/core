<?php

namespace Dearpos\Core\Tests\Unit\Models;

use Dearpos\Core\Models\Location;
use Dearpos\Core\Tests\TestCase;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;

class LocationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_uses_uuid_as_primary_key()
    {
        $location = Location::factory()->create();

        $this->assertIsString($location->id);
        $this->assertTrue(Str::isUuid($location->id));
    }

    /** @test */
    public function it_has_required_attributes()
    {
        $location = Location::factory()->create([
            'code' => 'HO-JKT',
            'name' => 'Head Office Jakarta',
            'address' => 'Jl. Sudirman No. 1',
            'city' => 'Jakarta',
            'country' => 'Indonesia',
            'postal_code' => '12190',
            'is_active' => true,
        ]);

        $this->assertEquals('HO-JKT', $location->code);
        $this->assertEquals('Head Office Jakarta', $location->name);
        $this->assertEquals('Jl. Sudirman No. 1', $location->address);
        $this->assertEquals('Jakarta', $location->city);
        $this->assertEquals('Indonesia', $location->country);
        $this->assertEquals('12190', $location->postal_code);
        $this->assertTrue($location->is_active);
    }

    /** @test */
    public function it_enforces_unique_code()
    {
        Location::factory()->create(['code' => 'HO-JKT']);

        $this->expectException(QueryException::class);
        Location::factory()->create(['code' => 'HO-JKT']);
    }

    /** @test */
    public function it_enforces_unique_email_when_provided()
    {
        Location::factory()->create(['email' => 'test@example.com']);

        $this->expectException(QueryException::class);
        Location::factory()->create(['email' => 'test@example.com']);
    }
}
