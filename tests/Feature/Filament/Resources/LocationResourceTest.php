<?php

namespace Dearpos\Core\Tests\Feature\Filament\Resources;

use Dearpos\Core\Filament\Resources\LocationResource;
use Dearpos\Core\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

class LocationResourceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_render_location_index_page()
    {
        $this->get(LocationResource::getUrl('index'))
            ->assertSuccessful();
    }

    /** @test */
    public function it_can_render_location_create_form()
    {
        $this->get(LocationResource::getUrl('create'))
            ->assertSuccessful();
    }

    /** @test */
    public function it_can_create_location()
    {
        $response = Livewire::test(LocationResource\Pages\CreateLocation::class)
            ->fillForm([
                'code' => 'HO-JKT',
                'name' => 'Head Office Jakarta',
                'address' => 'Jl. Sudirman No. 1',
                'city' => 'Jakarta',
                'country' => 'Indonesia',
                'postal_code' => '12190',
                'is_active' => true,
            ])
            ->call('create');

        $response->assertHasNoErrors();
        $this->assertDatabaseHas('locations', [
            'code' => 'HO-JKT',
            'name' => 'Head Office Jakarta',
        ]);
    }
}
