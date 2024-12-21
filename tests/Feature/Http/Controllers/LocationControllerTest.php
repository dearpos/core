<?php

namespace Dearpos\Core\Tests\Feature\Http\Controllers;

use Dearpos\Core\Models\Location;
use Dearpos\Core\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LocationControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_list_locations()
    {
        Location::factory()->count(3)->create();

        $response = $this->getJson('/api/locations');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id', 'code', 'name', 'address', 'city', 'state', 'country',
                        'postal_code', 'phone', 'email', 'is_active', 'created_at', 'updated_at'
                    ]
                ],
                'links',
                'meta'
            ]);
    }

    /** @test */
    public function it_can_create_location()
    {
        $data = [
            'code' => 'HO-JKT',
            'name' => 'Head Office Jakarta',
            'address' => 'Jl. Sudirman No. 1',
            'city' => 'Jakarta',
            'country' => 'Indonesia',
            'postal_code' => '12190',
            'is_active' => true,
        ];

        $response = $this->postJson('/api/locations', $data);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id', 'code', 'name', 'address', 'city', 'country',
                    'postal_code', 'is_active', 'created_at', 'updated_at'
                ]
            ]);
        
        $this->assertDatabaseHas('locations', $data);
    }

    /** @test */
    public function it_validates_email_format()
    {
        $data = [
            'code' => 'HO-JKT',
            'name' => 'Head Office Jakarta',
            'address' => 'Jl. Sudirman No. 1',
            'city' => 'Jakarta',
            'country' => 'Indonesia',
            'postal_code' => '12190',
            'email' => 'invalid-email',
            'is_active' => true,
        ];

        $response = $this->postJson('/api/locations', $data);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }
}
