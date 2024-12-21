<?php

namespace Dearpos\Core\Tests\Feature\Http\Controllers;

use Dearpos\Core\Models\UnitOfMeasure;
use Dearpos\Core\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UnitOfMeasureControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_list_units()
    {
        UnitOfMeasure::factory()->count(3)->create();

        $response = $this->getJson('/api/units');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'code', 'name', 'created_at', 'updated_at'],
                ],
                'links',
                'meta',
            ]);
    }

    /** @test */
    public function it_can_create_unit()
    {
        $data = [
            'code' => 'KG',
            'name' => 'Kilogram',
        ];

        $response = $this->postJson('/api/units', $data);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => ['id', 'code', 'name', 'created_at', 'updated_at'],
            ]);

        $this->assertDatabaseHas('units_of_measures', $data);
    }

    /** @test */
    public function it_validates_unit_code_length()
    {
        $data = [
            'code' => 'TOOLONGCODE',
            'name' => 'Invalid Unit',
        ];

        $response = $this->postJson('/api/units', $data);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['code']);
    }
}
