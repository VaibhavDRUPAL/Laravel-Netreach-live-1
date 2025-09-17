<?php

namespace Database\Factories\Outreach;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Outreach>
 */
class ReferralServiceFactory extends Factory
{   
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uid' => fake()->lexify(),
            'unique_serial_number' => fake()->numerify('VN####'),
            'netreach_uid_number' => fake()->numerify('VN##/##/####'),
            'client_type' => fake()->numberBetween(1,5),
            'name_client' =>fake()->name(),
            'educational_attainment' => fake()->numberBetween(1,7),
            'primary_occupation_client'  => fake()->numberBetween(1,12),
            'other'  => fake()->lexify(),
            'provided_client_with_Information_BCC' => fake()->numberBetween(1,2),
            'bcc_provided' => fake()->lexify(),
            'type_service'  => fake()->numberBetween(1,20),
            'others_services' => fake()->lexify(),
            'referred_for_ti_service' => fake()->numberBetween(1,11),
            'others_referred_service' =>fake()->lexify(),
            'counselling_service' => fake()->numberBetween(1,2),
            'prevention_programme' => fake()->numberBetween(1,4),
            'type_facility_referred' => fake()->numberBetween(1,4),
            'date_referral' =>fake()->dateTimeThisMonth(),
            'referral_centre' => fake()->lexify(),
            'referred_centre_state' => fake()->lexify(),
            'referred_centre_district' => fake()->lexify(),
            'type_of_facility_where_tested' => fake()->numberBetween(1,4),
            'service_accessed' => fake()->lexify(),
            'test_centre_state' => fake()->lexify(),
            'test_centre_district' => fake()->lexify(),
            'date_of_accessing_service' =>fake()->dateTimeThisMonth(),
            'applicable_for_hiv_test' => fake()->numberBetween(1,2),
            'applicable_for_sti_service' => fake()->numberBetween(1,2),
            'pid_or_other_unique_id_of_the_client_provided_at_the_service_cen' =>fake()->lexify(),
            'outcome_of_the_service_sought' => fake()->numberBetween(1,3),
            'not_access_the_service_referred' => fake()->numberBetween(1,19),
            'other_not_access' => fake()->lexify(),
            'follow_up_date' =>fake()->dateTimeThisMonth(),
            'remarks' => fake()->lexify(),
            
        ];
    }
}
