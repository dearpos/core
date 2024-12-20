<?php

use Dearpos\Core\Models\Location;

beforeEach(function () {
    $this->location = Location::factory()->create([
        'code' => 'HO-JKT',
        'name' => 'Head Office Jakarta',
        'address' => 'Jl. Sudirman No. 1',
        'city' => 'Jakarta',
        'state' => 'DKI Jakarta',
        'country' => 'Indonesia',
        'postal_code' => '12190',
        'phone' => '021-5555555',
        'email' => 'ho.jakarta@dearpos.com',
        'is_active' => true,
    ]);
});

test('can list all locations', function () {
    Location::factory()->count(3)->create();

    $response = $this->getJson('/api/core/locations');

    $response->assertStatus(200);
    $this->assertCount(4, $response->json()); // 3 + 1 from beforeEach
});

test('can create new location', function () {
    $locationData = [
        'code' => 'WH-BDG',
        'name' => 'Warehouse Bandung',
        'address' => 'Jl. Pasteur No. 1',
        'city' => 'Bandung',
        'state' => 'Jawa Barat',
        'country' => 'Indonesia',
        'postal_code' => '40161',
        'phone' => '022-5555555',
        'email' => 'wh.bandung@dearpos.com',
        'is_active' => true,
    ];

    $response = $this->postJson('/api/core/locations', $locationData);

    $response->assertStatus(201);
    $response->assertJsonFragment($locationData);

    $this->assertDatabaseHas('locations', $locationData);
});

test('can show location details', function () {
    $response = $this->getJson("/api/core/locations/{$this->location->id}");

    $response->assertStatus(200);
    $response->assertJsonFragment([
        'code' => 'HO-JKT',
        'name' => 'Head Office Jakarta',
    ]);
});

test('can update location', function () {
    $updatedData = [
        'code' => 'HO-JKTU', // Changed to unique code
        'name' => 'Head Office Jakarta Updated',
        'address' => 'Jl. Sudirman No. 1',
        'city' => 'Jakarta',
        'state' => 'DKI Jakarta',
        'country' => 'Indonesia',
        'postal_code' => '12190',
        'phone' => '021-5555555',
        'email' => 'ho.jakarta.updated@dearpos.com', // Changed to unique email
        'is_active' => true,
    ];

    $response = $this->putJson("/api/core/locations/{$this->location->id}", $updatedData);

    $response->assertStatus(200);
    $response->assertJsonFragment($updatedData);

    $this->assertDatabaseHas('locations', $updatedData);
});

test('can delete location', function () {
    $response = $this->deleteJson("/api/core/locations/{$this->location->id}");

    $response->assertStatus(204);

    $this->assertSoftDeleted('locations', [
        'id' => $this->location->id
    ]);
});

test('cannot create location with duplicate code', function () {
    $locationData = [
        'code' => 'HO-JKT', // Already exists from beforeEach
        'name' => 'Another Head Office',
        'address' => 'Jl. Thamrin No. 1',
        'city' => 'Jakarta',
        'state' => 'DKI Jakarta',
        'country' => 'Indonesia',
        'postal_code' => '12190',
        'phone' => '021-5555556',
        'email' => 'another.ho@dearpos.com',
        'is_active' => true,
    ];

    $response = $this->postJson('/api/core/locations', $locationData);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['code']);
});

test('cannot create location with duplicate email', function () {
    $locationData = [
        'code' => 'WH-JKT',
        'name' => 'Warehouse Jakarta',
        'address' => 'Jl. Thamrin No. 1',
        'city' => 'Jakarta',
        'state' => 'DKI Jakarta',
        'country' => 'Indonesia',
        'postal_code' => '12190',
        'phone' => '021-5555556',
        'email' => 'ho.jakarta@dearpos.com', // Already exists from beforeEach
        'is_active' => true,
    ];

    $response = $this->postJson('/api/core/locations', $locationData);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['email']);
});
