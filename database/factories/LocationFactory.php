<?php

namespace Dearpos\Core\Database\Factories;

use Dearpos\Core\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;

class LocationFactory extends Factory
{
    protected $model = Location::class;

    public function definition(): array
    {
        $cities = [
            'Jakarta', 'Surabaya', 'Bandung', 'Medan', 'Semarang',
            'Makassar', 'Palembang', 'Tangerang', 'Depok', 'Bekasi'
        ];

        $city = $this->faker->randomElement($cities);
        $code = 'LOC-' . strtoupper(substr($city, 0, 3)) . '-' . $this->faker->unique()->numberBetween(1, 999);

        return [
            'code' => $code,
            'name' => $city . ' Branch',
            'address' => $this->faker->streetAddress(),
            'city' => $city,
            'state' => $this->faker->state(),
            'country' => 'Indonesia',
            'postal_code' => $this->faker->postcode(),
            'phone' => $this->faker->phoneNumber(),
            'email' => $this->faker->unique()->safeEmail(),
            'is_active' => $this->faker->boolean(80), // 80% chance of being active
        ];
    }

    /**
     * State for main office location
     */
    public function mainOffice(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'code' => 'HO-JKT',
                'name' => 'Head Office Jakarta',
                'address' => 'Jl. Sudirman No. 1',
                'city' => 'Jakarta',
                'state' => 'DKI Jakarta',
                'country' => 'Indonesia',
                'postal_code' => '12190',
                'phone' => '021-5555555',
                'email' => 'ho.jakarta@dearpos.com',
                'is_active' => true,
            ];
        });
    }
}
