<?php

namespace Dearpos\Core\Tests\Feature;

use Dearpos\Core\Models\Currency;

beforeEach(function () {
    Currency::query()->forceDelete();

    $this->currency = Currency::factory()->create([
        'code' => 'IDR',
        'name' => 'Indonesian Rupiah',
        'exchange_rate' => 1.0,
    ]);
});

test('can create new currency', function () {
    $data = [
        'code' => 'USD',
        'name' => 'United States Dollar',
        'exchange_rate' => 15000,
    ];

    $response = $this->postJson('/api/currencies', $data);

    $response->assertStatus(201);
    $response->assertJsonFragment([
        'code' => 'USD',
        'name' => 'United States Dollar',
        'exchange_rate' => '15000.0000',
    ]);

    $this->assertDatabaseHas('currencies', [
        'code' => 'USD',
        'name' => 'United States Dollar',
        'exchange_rate' => 15000,
    ]);
});

test('cannot create currency with duplicate code', function () {
    $data = [
        'code' => 'IDR',
        'name' => 'Indonesian Rupiah',
        'exchange_rate' => 1,
    ];

    $response = $this->postJson('/api/currencies', $data);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['code']);
});

test('can list all currencies', function () {
    $response = $this->getJson('/api/currencies');

    $response->assertStatus(200);
    $response->assertJsonFragment([
        'code' => 'IDR',
        'name' => 'Indonesian Rupiah',
        'exchange_rate' => '1.0000',
    ]);
});

test('can show currency details', function () {
    $response = $this->getJson("/api/currencies/{$this->currency->id}");

    $response->assertStatus(200);
    $response->assertJsonFragment([
        'code' => 'IDR',
        'name' => 'Indonesian Rupiah',
        'exchange_rate' => '1.0000',
    ]);
});

test('can update currency', function () {
    $updatedData = [
        'code' => 'IDR',
        'name' => 'Indonesian Rupiah Updated',
        'exchange_rate' => 1,
    ];

    $response = $this->putJson("/api/currencies/{$this->currency->id}", $updatedData);

    $response->assertStatus(200);
    $response->assertJsonFragment([
        'code' => 'IDR',
        'name' => 'Indonesian Rupiah Updated',
        'exchange_rate' => '1.0000',
    ]);

    $this->assertDatabaseHas('currencies', [
        'id' => $this->currency->id,
        'name' => 'Indonesian Rupiah Updated',
    ]);
});

test('can delete currency', function () {
    $response = $this->deleteJson("/api/currencies/{$this->currency->id}");

    $response->assertStatus(204);

    $this->assertSoftDeleted('currencies', [
        'id' => $this->currency->id,
    ]);
});
