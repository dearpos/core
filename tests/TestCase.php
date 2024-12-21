<?php

namespace Dearpos\Core\Tests;

use Dearpos\Core\CoreServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Dearpos\\Core\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            CoreServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        // Run the migrations
        $migrations = [
            include __DIR__.'/../database/migrations/create_currencies_table.php.stub',
            include __DIR__.'/../database/migrations/create_units_of_measures_table.php.stub',
            include __DIR__.'/../database/migrations/create_locations_table.php.stub',
        ];

        foreach ($migrations as $migration) {
            $migration->up();
        }
    }

    protected function tearDown(): void
    {
        // Clean up the database after each test
        $migrations = [
            include __DIR__.'/../database/migrations/create_currencies_table.php.stub',
            include __DIR__.'/../database/migrations/create_units_of_measures_table.php.stub',
            include __DIR__.'/../database/migrations/create_locations_table.php.stub',
        ];

        foreach ($migrations as $migration) {
            $migration->down();
        }

        parent::tearDown();
    }

    protected function defineRoutes($router)
    {
        require __DIR__.'/../routes/api.php';
    }
}
