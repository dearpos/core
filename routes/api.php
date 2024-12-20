<?php

use Dearpos\Core\Http\Controllers\CurrencyController;
use Dearpos\Core\Http\Controllers\LocationController;
use Dearpos\Core\Http\Controllers\UnitOfMeasureController;
use Illuminate\Support\Facades\Route;

Route::prefix('api')->group(function () {
    Route::prefix('core')->group(function () {
        // Currency Routes
        Route::apiResource('currencies', CurrencyController::class);

        // Unit of Measure Routes
        Route::apiResource('units', UnitOfMeasureController::class);

        // Location Routes
        Route::apiResource('locations', LocationController::class);
    });
});
