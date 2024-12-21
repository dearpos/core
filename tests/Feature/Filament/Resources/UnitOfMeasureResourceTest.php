<?php

namespace Dearpos\Core\Tests\Feature\Filament\Resources;

use Dearpos\Core\Filament\Resources\UnitOfMeasureResource;
use Dearpos\Core\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

class UnitOfMeasureResourceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_render_unit_index_page()
    {
        $this->get(UnitOfMeasureResource::getUrl('index'))
            ->assertSuccessful();
    }

    /** @test */
    public function it_can_render_unit_create_form()
    {
        $this->get(UnitOfMeasureResource::getUrl('create'))
            ->assertSuccessful();
    }

    /** @test */
    public function it_can_create_unit()
    {
        $response = Livewire::test(UnitOfMeasureResource\Pages\CreateUnitOfMeasure::class)
            ->fillForm([
                'code' => 'KG',
                'name' => 'Kilogram',
            ])
            ->call('create');

        $response->assertHasNoErrors();
        $this->assertDatabaseHas('units_of_measures', [
            'code' => 'KG',
            'name' => 'Kilogram',
        ]);
    }
}
