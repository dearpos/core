<?php

namespace Dearpos\Core\Database\Factories;

use Dearpos\Core\Models\Currency;
use Illuminate\Database\Eloquent\Factories\Factory;

class CurrencyFactory extends Factory
{
    protected $model = Currency::class;

    public function definition(): array
    {
        $currencies = [
            'IDR' => ['Indonesian Rupiah', 1.0],
            'USD' => ['US Dollar', 15500.0],
            'EUR' => ['Euro', 17000.0],
            'SGD' => ['Singapore Dollar', 11500.0],
            'MYR' => ['Malaysian Ringgit', 3300.0],
        ];

        $code = $this->faker->randomElement(array_keys($currencies));
        $currency = $currencies[$code];

        return [
            'code' => $code,
            'name' => $currency[0],
            'exchange_rate' => $currency[1],
        ];
    }
}
