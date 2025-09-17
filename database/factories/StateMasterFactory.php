<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StateMaster>
 */
class StateMasterFactory extends Factory
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
            'state_name' => fake()->lexify('state-?????'),
            'st_cd' => fake()->lexify(),
            'region' => fake()->numberBetween(1,4),
        ];
    }
}
