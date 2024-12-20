<?php

namespace Dearpos\Core\Database\Factories;

use Dearpos\Core\Models\UnitOfMeasure;
use Illuminate\Database\Eloquent\Factories\Factory;

class UnitOfMeasureFactory extends Factory
{
    protected $model = UnitOfMeasure::class;

    public function definition(): array
    {
        $units = [
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
        ];

        $code = $this->faker->randomElement(array_keys($units));

        return [
            'code' => $code,
            'name' => $units[$code],
        ];
    }
}
