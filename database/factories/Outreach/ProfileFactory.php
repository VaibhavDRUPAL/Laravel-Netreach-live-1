<?php

namespace Database\Factories\Outreach;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Outreach>
 */
class ProfileFactory extends Factory
{   
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'district_id' => fake()->numberBetween(1,10),
            'state_id' => fake()->numberBetween(1,10),
            'region_id' => fake()->numberBetween(1,10),
            'unique_serial_number' => fake()->numerify('VN####'),
            'uid' => fake()->lexify(),
            'client_type' => fake()->numberBetween(1,2),
            'reg_date' =>fake()->dateTimeThisMonth(),
            'location' => fake()->lexify(),
            'app_platform' => fake()->numberBetween(1,15),
            'profile_name' =>fake()->name(),
            'age_profile' => fake()->numberBetween(20,100),
            'gender' => fake()->numberBetween(1,5),
            'type_target_population' => fake()->numberBetween(1,8),
            'res_client_intro_infor' => fake()->numberBetween(1,7),
            'virtual_platform' => fake()->numberBetween(1,2),
            'please_mention' => fake()->numberBetween(1,15),
            'reached_out' => fake()->numberBetween(1,2),
            'phone_number' => fake()->phoneNumber(),
            
        ];
    }
}
