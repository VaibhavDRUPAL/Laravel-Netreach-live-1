<?php

namespace Database\Factories\Outreach;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Outreach>
 */
class RiskAssessmentFactory extends Factory
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
            'uid' => fake()->lexify(),
            'client_type' => fake()->numberBetween(1,2),
            'date_risk_assessment' =>fake()->dateTimeThisMonth(),
            'high_risk' => fake()->numberBetween(1,4),
            'shared_needle_for_injecting_drugs' => fake()->numberBetween(1,4),
            'sexually_transmitted_infection' =>fake()->numberBetween(1,4),
            'sex_with_more_than_one_partners' => fake()->numberBetween(1,4),
            'had_chemical_stimulant_or_alcohol_before_sex' => fake()->numberBetween(1,4),
            'had_sex_in_exchange_of_goods_or_money' => fake()->numberBetween(1,4),
            'other_reason_for_hiv_test' => fake()->word(),
            'risk_category' => fake()->numberBetween(1,3),
            
        ];
    }
}
