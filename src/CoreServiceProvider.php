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
            ->hasMigration('create_currencies_table')
            ->hasMigration('create_locations_table')
            ->hasMigration('create_units_of_measures_table')
            ->hasCommand(CoreCommand::class);
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/core.php' => config_path('core.php'),
        ]);

        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');

        $this->publishesMigrations([
            __DIR__.'/../database/migrations' => database_path('migrations'),
        ]);
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/core.php', 'core');
    }
}
