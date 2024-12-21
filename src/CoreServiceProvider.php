<?php

namespace Dearpos\Core;

use Dearpos\Core\Commands\CoreCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class CoreServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('core')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigrations([
                'create_currencies_table',
                'create_locations_table',
                'create_units_of_measures_table',
            ])
            ->hasCommand(CoreCommand::class);
    }

    public function boot()
    {

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        $this->publishesMigrations([
            __DIR__.'/../database/migrations' => database_path('migrations'),
        ]);

        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');
    }

    public function register()
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }
}
