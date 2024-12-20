<?php

// config for Dearpos/Core
return [
    /*
    |--------------------------------------------------------------------------
    | Currency Settings
    |--------------------------------------------------------------------------
    |
    | Here you can configure the default currency settings for your application.
    | This includes the default currency code and exchange rate settings.
    |
    */
    'currency' => [
        'default' => env('DEFAULT_CURRENCY', 'IDR'),
        'supported' => [
            'IDR' => [
                'name' => 'Indonesian Rupiah',
                'exchange_rate' => 1.0,
            ],
            'USD' => [
                'name' => 'US Dollar',
                'exchange_rate' => 15500.0,
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Units of Measure Settings
    |--------------------------------------------------------------------------
    |
    | Here you can configure the default units of measure for your application.
    | You can add or modify the available units as needed.
    |
    */
    'uom' => [
        'default' => env('DEFAULT_UOM', 'PCS'),
        'supported' => [
            'PCS' => 'Pieces',
            'KG' => 'Kilogram',
            'GR' => 'Gram',
            'LTR' => 'Liter',
            'ML' => 'Milliliter',
            'M' => 'Meter',
            'CM' => 'Centimeter',
            'BOX' => 'Box',
            'PACK' => 'Pack',
            'UNIT' => 'Unit',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Location Settings
    |--------------------------------------------------------------------------
    |
    | Here you can configure the default location settings for your application.
    | This includes settings for the main location and other branches.
    |
    */
    'location' => [
        'default' => env('DEFAULT_LOCATION', 'HO-JKT'),
        'require_email' => env('LOCATION_REQUIRE_EMAIL', true),
        'require_phone' => env('LOCATION_REQUIRE_PHONE', true),
    ],
];
