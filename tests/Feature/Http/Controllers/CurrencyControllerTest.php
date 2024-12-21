<?php

namespace Dearpos\Core\Tests\Feature\Http\Controllers;

use Dearpos\Core\Models\Currency;
use Dearpos\Core\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CurrencyControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_list_currencies()
    {
        Currency::factory()->count(3)->create();

        $response = $this->getJson('/api/currencies');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'code', 'name', 'exchange_rate', 'created_at', 'updated_at'],
                ],
                'links',
                'meta',
            ]);
    }

    /** @test */
    public function it_can_create_currency()
    {
        $data = [
            'code' => 'USD',
            'name' => 'US Dollar',
            'exchange_rate' => 15500.0000,
        ];

        $response = $this->postJson('/api/currencies', $data);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => ['id', 'code', 'name', 'exchange_rate', 'created_at', 'updated_at'],
            ]);

        $this->assertDatabaseHas('currencies', $data);
    }

    /** @test */
    public function it_validates_currency_code_format()
    {
        $data = [
            'code' => 'INVALID',
            'name' => 'Invalid Currency',
            'exchange_rate' => 1.0000,
        ];

        $response = $this->postJson('/api/currencies', $data);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['code']);
    }
}
