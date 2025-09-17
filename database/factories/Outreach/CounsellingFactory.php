<?php

namespace Database\Factories\Outreach;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Outreach>
 */
class CounsellingFactory extends Factory
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
            'unique_serial_number' => fake()->numerify('VN####'),
            'uid' => fake()->lexify(),
            'uid_number'=> fake()->lexify(),
            'client_type' => fake()->numberBetween(1,3),
            'referred_from' => fake()->numberBetween(1,4),
            'referral_source'=> fake()->lexify(),
            'name_the_client'=> fake()->name(),
            'date_counselling'=>fake()->dateTimeThisMonth(),
            'phone_number' => fake()->phoneNumber(),
            'location'=>fake()->lexify(),
            'age' => fake()->numberBetween(20,100),
            'gender' => fake()->numberBetween(1,5),
            'gender_other'=> fake()->lexify(),
            'type_target_population' => fake()->numberBetween(1,7),
            'other_target_pop'=> fake()->lexify(),
            'type_of_counselling_offered' => fake()->numberBetween(1,6),
            'type_of_counselling_offered_other'=> fake()->lexify(),
            'counselling_medium'=> fake()->lexify(),
            'duration_counselling'=> fake()->lexify(),
            'key_concerns_discussed'=> fake()->lexify(),
            'follow_up_date'=>fake()->dateTimeThisMonth(),
            'remarks'=> fake()->lexify(),
        ];
    }
}
