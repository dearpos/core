<?php

use Dearpos\Core\Models\Currency;

beforeEach(function () {
    $this->currency = Currency::factory()->create([
        'code' => 'IDR',
        'name' => 'Indonesian Rupiah',
        'exchange_rate' => 1.0,
    ]);
});

test('can list all currencies', function () {
    Currency::factory()->count(3)->create();

    $response = $this->getJson('/api/core/currencies');

    $response->assertStatus(200);
    $this->assertCount(4, $response->json()); // 3 + 1 from beforeEach
});

test('can create new currency', function () {
    $currencyData = [
        'code' => 'USD',
        'name' => 'US Dollar',
        'exchange_rate' => 15500.0,
    ];

    $response = $this->postJson('/api/core/currencies', $currencyData);

    $response->assertStatus(201);
    $response->assertJsonFragment($currencyData);

    $this->assertDatabaseHas('currencies', $currencyData);
});

test('can show currency details', function () {
    $response = $this->getJson("/api/core/currencies/{$this->currency->id}");

    $response->assertStatus(200);
    $response->assertJsonFragment([
        'code' => 'IDR',
        'name' => 'Indonesian Rupiah',
        'exchange_rate' => 1.0,
    ]);
});

test('can update currency', function () {
    $updatedData = [
        'code' => 'IDR',
        'name' => 'Indonesian Rupiah Updated',
        'exchange_rate' => 1.5,
    ];

    $response = $this->putJson("/api/core/currencies/{$this->currency->id}", $updatedData);

    $response->assertStatus(200);
    $response->assertJsonFragment($updatedData);

    $this->assertDatabaseHas('currencies', $updatedData);
});

test('can delete currency', function () {
    $response = $this->deleteJson("/api/core/currencies/{$this->currency->id}");

    $response->assertStatus(204);

    $this->assertDatabaseMissing('currencies', [
        'id' => $this->currency->id,
        'deleted_at' => null,
    ]);
});

test('cannot create currency with duplicate code', function () {
    $currencyData = [
        'code' => 'IDR', // Already exists from beforeEach
        'name' => 'Another IDR',
        'exchange_rate' => 1.0,
    ];

    $response = $this->postJson('/api/core/currencies', $currencyData);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['code']);
});
