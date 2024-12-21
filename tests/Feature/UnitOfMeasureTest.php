<?php

namespace Dearpos\Core\Tests\Feature;

use Dearpos\Core\Models\UnitOfMeasure;

beforeEach(function () {
    UnitOfMeasure::query()->forceDelete();

    $this->uom = UnitOfMeasure::factory()->create([
        'code' => 'PCS',
        'name' => 'Pieces',
    ]);
});

test('can create new unit of measure', function () {
    $data = [
        'code' => 'M',
        'name' => 'Meter',
    ];

    $response = $this->postJson('/api/units', $data);

    $response->assertStatus(201);
    $response->assertJsonFragment($data);

    $this->assertDatabaseHas('units_of_measures', [
        'code' => 'M',
        'name' => 'Meter',
    ]);
});

test('cannot create unit of measure with duplicate code', function () {
    $data = [
        'code' => 'PCS',
        'name' => 'Pieces',
    ];

    $response = $this->postJson('/api/units', $data);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['code']);
});

test('can list all units of measure', function () {
    $response = $this->getJson('/api/units');

    $response->assertStatus(200);
    $response->assertJsonFragment([
        'code' => 'PCS',
        'name' => 'Pieces',
    ]);
});

test('can show unit of measure details', function () {
    $response = $this->getJson("/api/units/{$this->uom->id}");

    $response->assertStatus(200);
    $response->assertJsonFragment([
        'code' => 'PCS',
        'name' => 'Pieces',
    ]);
});

test('can update unit of measure', function () {
    $updatedData = [
        'code' => 'PCSU',
        'name' => 'Pieces Updated',
    ];

    $response = $this->putJson("/api/units/{$this->uom->id}", $updatedData);

    $response->assertStatus(200);
    $response->assertJsonFragment($updatedData);

    $this->assertDatabaseHas('units_of_measures', [
        'id' => $this->uom->id,
        'code' => 'PCSU',
        'name' => 'Pieces Updated',
    ]);
});

test('can delete unit of measure', function () {
    $response = $this->deleteJson("/api/units/{$this->uom->id}");

    $response->assertStatus(204);

    $this->assertSoftDeleted('units_of_measures', [
        'id' => $this->uom->id,
    ]);
});
