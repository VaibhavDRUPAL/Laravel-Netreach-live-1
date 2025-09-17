<?php

namespace Database\Factories\Outreach;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Outreach>
 */
class PLHIVFactory extends Factory
{   
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'unique_serial_number' => fake()->numerify('VN####'),
            'reg_date'=>fake()->dateTimeThisMonth(),
            'netreach_uid_number' => fake()->numerify('NETREACH####'),
            'client_type' => fake()->numberBetween(1,2),
            'pid_unique_id_client_provided_service_centre' => fake()->lexify(),
            'name_of_the_client'=> fake()->name(),
            'date_confirmatory_test'=>fake()->dateTimeThisMonth(),
            'date_of_art_reg'=>fake()->dateTimeThisMonth(),
            'pre_art_reg_number' => fake()->lexify(),
            'date_of_on_art'=>fake()->dateTimeThisMonth(),
            'on_art_reg_number' => fake()->lexify(),
            'type_of_facility_where_treatment_sought' => fake()->lexify(),
            'art_centre_name' => fake()->lexify(),
            'art_centre_district'=> fake()->lexify(),
            'art_centre_state'=> fake()->lexify(),
            'remarks' => fake()->lexify(),
            'uid' => fake()->lexify(),
        ];
    }
}
