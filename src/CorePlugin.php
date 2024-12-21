<?php

namespace Dearpos\Core;

use Dearpos\Core\Filament\Resources\CurrencyResource;
use Dearpos\Core\Filament\Resources\LocationResource;
use Dearpos\Core\Filament\Resources\UnitOfMeasureResource;
use Filament\Contracts\Plugin;
use Filament\Panel;

class CorePlugin implements Plugin
{
    public function getId(): string
    {
        return 'dearpos-core';
    }

    public function register(Panel $panel): void
    {
        $panel
            ->resources([
                CurrencyResource::class,
                UnitOfMeasureResource::class,
                LocationResource::class,
            ])
            ->brandName('DearPOS')
            ->brandLogo(asset('vendor/core/images/logo.svg'))
            ->brandLogoHeight('2rem')
            ->favicon(asset('vendor/core/images/favicon.ico'));
    }

    public function boot(Panel $panel): void
    {
        //
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): static
    {
        /** @var static $plugin */
        $plugin = filament(app(static::class)->getId());

        return $plugin;
    }
}
