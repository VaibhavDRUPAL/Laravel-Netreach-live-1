<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DummyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Outreach\Profile::factory()->count(5)->create();
        \App\Models\Outreach\RiskAssessment::factory()->count(5)->create();
        \App\Models\Outreach\ReferralService::factory()->count(5)->create();
        \App\Models\Outreach\Counselling::factory()->count(5)->create();
        \App\Models\Outreach\PLHIV::factory()->count(5)->create();
    }
}
