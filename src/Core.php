<?php

namespace Dearpos\Core;

use Dearpos\Core\Models\Currency;
use Dearpos\Core\Models\Location;
use Dearpos\Core\Models\UnitOfMeasure;
use Illuminate\Support\Collection;

class Core
{
    /**
     * Get all active currencies
     */
    public static function currencies(): Collection
    {
        return Currency::withoutTrashed()
            ->orderBy('code')
            ->get();
    }

    /**
     * Get currency by code
     */
    public static function currency(string $code): ?Currency
    {
        return Currency::withoutTrashed()
            ->where('code', $code)
            ->first();
    }

    /**
     * Get all active locations
     */
    public static function locations(): Collection
    {
        return Location::withoutTrashed()
            ->orderBy('code')
            ->get();
    }

    /**
     * Get location by code
     */
    public static function location(string $code): ?Location
    {
        return Location::withoutTrashed()
            ->where('code', $code)
            ->first();
    }

    /**
     * Get all active units of measure
     */
    public static function units(): Collection
    {
        return UnitOfMeasure::withoutTrashed()
            ->orderBy('code')
            ->get();
    }

    /**
     * Get unit of measure by code
     */
    public static function unit(string $code): ?UnitOfMeasure
    {
        return UnitOfMeasure::withoutTrashed()
            ->where('code', $code)
            ->first();
    }

    /**
     * Get main office location
     */
    public static function mainOffice(): ?Location
    {
        return Location::withoutTrashed()
            ->where('code', 'HO-JKT')
            ->first();
    }

    /**
     * Get default currency (IDR)
     */
    public static function defaultCurrency(): ?Currency
    {
        return Currency::withoutTrashed()
            ->where('code', 'IDR')
            ->first();
    }

    /**
     * Get default unit of measure (PCS)
     */
    public static function defaultUnit(): ?UnitOfMeasure
    {
        return UnitOfMeasure::withoutTrashed()
            ->where('code', 'PCS')
            ->first();
    }
}
