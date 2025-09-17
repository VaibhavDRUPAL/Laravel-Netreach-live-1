<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class DistrictMasterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'state_code' => fake()->numberBetween(1,100),
            'district_code' => fake()->numberBetween(1,100),
            'district_name' => fake()->lexify('district-?????'),
            'dst_cd' => fake()->lexify(),
            'st_cd' => fake()->lexify(),
        ];
    }
}
