<?php

namespace Dearpos\Core\Tests\Feature;

use Dearpos\Core\Models\Location;

beforeEach(function () {
    Location::query()->forceDelete();

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

test('can create new location', function () {
    $data = [
        'code' => 'WH-BDG',
        'name' => 'Warehouse Bandung',
        'address' => 'Jl. Asia Afrika No. 1',
        'city' => 'Bandung',
        'state' => 'Jawa Barat',
        'country' => 'Indonesia',
        'postal_code' => '40111',
        'phone' => '022-5555555',
        'email' => 'wh.bandung@dearpos.com',
        'is_active' => true,
    ];

    $response = $this->postJson('/api/locations', $data);

    $response->assertStatus(201);
    $response->assertJsonFragment($data);

    $this->assertDatabaseHas('locations', [
        'code' => 'WH-BDG',
        'name' => 'Warehouse Bandung',
    ]);
});

test('cannot create location with duplicate code', function () {
    $data = [
        'code' => 'HO-JKT',
        'name' => 'Head Office Jakarta',
        'address' => 'Jl. Sudirman No. 1',
        'city' => 'Jakarta',
        'state' => 'DKI Jakarta',
        'country' => 'Indonesia',
        'postal_code' => '12190',
        'phone' => '021-5555555',
        'email' => 'ho.jakarta2@dearpos.com',
        'is_active' => true,
    ];

    $response = $this->postJson('/api/locations', $data);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['code']);
});

test('cannot create location with duplicate email', function () {
    $data = [
        'code' => 'HO-JKT2',
        'name' => 'Head Office Jakarta',
        'address' => 'Jl. Sudirman No. 1',
        'city' => 'Jakarta',
        'state' => 'DKI Jakarta',
        'country' => 'Indonesia',
        'postal_code' => '12190',
        'phone' => '021-5555555',
        'email' => 'ho.jakarta@dearpos.com',
        'is_active' => true,
    ];

    $response = $this->postJson('/api/locations', $data);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['email']);
});

test('can list all locations', function () {
    $response = $this->getJson('/api/locations');

    $response->assertStatus(200);
    $response->assertJsonFragment([
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

test('can show location details', function () {
    $response = $this->getJson("/api/locations/{$this->location->id}");

    $response->assertStatus(200);
    $response->assertJsonFragment([
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

test('can update location', function () {
    $updatedData = [
        'code' => 'HO-JKT',
        'name' => 'Head Office Jakarta Updated',
        'address' => 'Jl. Sudirman No. 1',
        'city' => 'Jakarta',
        'state' => 'DKI Jakarta',
        'country' => 'Indonesia',
        'postal_code' => '12190',
        'phone' => '021-5555555',
        'email' => 'ho.jakarta@dearpos.com',
        'is_active' => true,
    ];

    $response = $this->putJson("/api/locations/{$this->location->id}", $updatedData);

    $response->assertStatus(200);
    $response->assertJsonFragment($updatedData);

    $this->assertDatabaseHas('locations', [
        'id' => $this->location->id,
        'name' => 'Head Office Jakarta Updated',
    ]);
});

test('can delete location', function () {
    $response = $this->deleteJson("/api/locations/{$this->location->id}");

    $response->assertStatus(204);

    $this->assertSoftDeleted('locations', [
        'id' => $this->location->id,
    ]);
});
