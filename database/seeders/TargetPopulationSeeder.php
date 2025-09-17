<?php

namespace Database\Seeders;

use App\Models\TargetPopulation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\{Config, Schema};
use Illuminate\Support\Str;

class TargetPopulationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currentDateTime = currentDateTime();

        $data = [
            [
                TargetPopulation::target_id => 1,
                TargetPopulation::target_type => 'MSM',
                TargetPopulation::target_slug => Str::slug('MSM', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                TargetPopulation::created_at => $currentDateTime
            ],
            [
                TargetPopulation::target_id => 2,
                TargetPopulation::target_type => 'FSW',
                TargetPopulation::target_slug => Str::slug('FSW', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                TargetPopulation::created_at => $currentDateTime
            ],
            [
                TargetPopulation::target_id => 3,
                TargetPopulation::target_type => 'MSW',
                TargetPopulation::target_slug => Str::slug('MSW', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                TargetPopulation::created_at => $currentDateTime
            ],
            [
                TargetPopulation::target_id => 4,
                TargetPopulation::target_type => 'TG',
                TargetPopulation::target_slug => Str::slug('TG', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                TargetPopulation::created_at => $currentDateTime
            ],
            [
                TargetPopulation::target_id => 5,
                TargetPopulation::target_type => 'PWID',
                TargetPopulation::target_slug => Str::slug('PWID', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                TargetPopulation::created_at => $currentDateTime
            ],
            [
                TargetPopulation::target_id => 6,
                TargetPopulation::target_type => 'Adolescents and Youths (18-24)',
                TargetPopulation::target_slug => Str::slug('Adolescents and Youths (18-24)', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                TargetPopulation::created_at => $currentDateTime
            ],
            [
                TargetPopulation::target_id => 7,
                TargetPopulation::target_type => 'Men and Women with High risk behaviours accessing virtual platforms (above 24 yrs)',
                TargetPopulation::target_slug => Str::slug('Men and Women with High risk behaviours accessing virtual platforms (above 24 yrs)', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                TargetPopulation::created_at => $currentDateTime
            ],
            [
                TargetPopulation::target_id => 8,
                TargetPopulation::target_type => 'Not Disclosed',
                TargetPopulation::target_slug => Str::slug('Not Disclosed', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                TargetPopulation::created_at => $currentDateTime
            ],
            [
                TargetPopulation::target_id => 99,
                TargetPopulation::target_type => 'Others',
                TargetPopulation::target_slug => Str::slug('Others', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                TargetPopulation::created_at => $currentDateTime
            ]
        ];

        Schema::disableForeignKeyConstraints();
        TargetPopulation::insert($data);
    }
}
