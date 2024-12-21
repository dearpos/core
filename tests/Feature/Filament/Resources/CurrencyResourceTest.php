<?php

namespace Dearpos\Core\Tests\Feature\Filament\Resources;

use Dearpos\Core\Filament\Resources\CurrencyResource;
use Dearpos\Core\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

class CurrencyResourceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_render_currency_index_page()
    {
        $this->get(CurrencyResource::getUrl('index'))
            ->assertSuccessful();
    }

    /** @test */
    public function it_can_render_currency_create_form()
    {
        $this->get(CurrencyResource::getUrl('create'))
            ->assertSuccessful();
    }

    /** @test */
    public function it_can_create_currency()
    {
        $response = Livewire::test(CurrencyResource\Pages\CreateCurrency::class)
            ->fillForm([
                'code' => 'USD',
                'name' => 'US Dollar',
                'exchange_rate' => 15500.0000,
            ])
            ->call('create');

        $response->assertHasNoErrors();
        $this->assertDatabaseHas('currencies', [
            'code' => 'USD',
            'name' => 'US Dollar',
        ]);
    }
}
