<?php

namespace Dearpos\Core\Tests;

use Dearpos\Core\CoreServiceProvider;
use Filament\Actions\ActionsServiceProvider;
use Filament\FilamentServiceProvider;
use Filament\Forms\FormsServiceProvider;
use Filament\Infolists\InfolistsServiceProvider;
use Filament\Notifications\NotificationsServiceProvider;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\SupportServiceProvider;
use Filament\Tables\TablesServiceProvider;
use Filament\Widgets\WidgetsServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Dearpos\\Core\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );

        config()->set('app.key', 'base64:'.base64_encode(random_bytes(32)));
    }

    protected function getPackageProviders($app)
    {
        return [
            CoreServiceProvider::class,
            FilamentServiceProvider::class,
            LivewireServiceProvider::class,
            SupportServiceProvider::class,
            FormsServiceProvider::class,
            TablesServiceProvider::class,
            WidgetsServiceProvider::class,
            ActionsServiceProvider::class,
            NotificationsServiceProvider::class,
            InfolistsServiceProvider::class,
            TestPanelProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');
        config()->set('database.connections.testing', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
    }

    protected function defineDatabaseMigrations()
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    protected function defineRoutes($router)
    {
        require __DIR__.'/../routes/api.php';
    }
}

class TestPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('test')
            ->path('test')
            ->login()
            ->brandName('DearPOS')
            ->plugin(new \Dearpos\Core\CorePlugin)
            ->resources([
                \Dearpos\Core\Filament\Resources\CurrencyResource::class,
                \Dearpos\Core\Filament\Resources\LocationResource::class,
                \Dearpos\Core\Filament\Resources\UnitOfMeasureResource::class,
            ]);
    }
}
