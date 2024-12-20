<?php

use Dearpos\Core\Models\UnitOfMeasure;

beforeEach(function () {
    $this->uom = UnitOfMeasure::factory()->create([
        'code' => 'PCS',
        'name' => 'Pieces',
    ]);
});

test('can list all units of measure', function () {
    UnitOfMeasure::factory()->count(3)->create();

    $response = $this->getJson('/api/core/units');

    $response->assertStatus(200);
    $this->assertCount(4, $response->json()); // 3 + 1 from beforeEach
});

test('can create new unit of measure', function () {
    $uomData = [
        'code' => 'PACK',
        'name' => 'Pack',
    ];

    $response = $this->postJson('/api/core/units', $uomData);

    $response->assertStatus(201);
    $response->assertJsonFragment($uomData);

    $this->assertDatabaseHas('units_of_measures', $uomData);
});

test('can show unit of measure details', function () {
    $response = $this->getJson("/api/core/units/{$this->uom->id}");

    $response->assertStatus(200);
    $response->assertJsonFragment([
        'code' => 'PCS',
        'name' => 'Pieces',
    ]);
});

test('can update unit of measure', function () {
    $updatedData = [
        'code' => 'PCSU', // Changed to unique code
        'name' => 'Pieces Updated',
    ];

    $response = $this->putJson("/api/core/units/{$this->uom->id}", $updatedData);

    $response->assertStatus(200);
    $response->assertJsonFragment($updatedData);

    $this->assertDatabaseHas('units_of_measures', $updatedData);
});

test('can delete unit of measure', function () {
    $response = $this->deleteJson("/api/core/units/{$this->uom->id}");

    $response->assertStatus(204);

    $this->assertSoftDeleted('units_of_measures', [
        'id' => $this->uom->id,
    ]);
});

test('cannot create unit of measure with duplicate code', function () {
    $uomData = [
        'code' => 'PCS', // Already exists from beforeEach
        'name' => 'Another PCS',
    ];

    $response = $this->postJson('/api/core/units', $uomData);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['code']);
});
