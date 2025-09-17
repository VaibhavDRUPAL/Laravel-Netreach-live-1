<?php

namespace Database\Seeders;

use App\Models\Occupation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\{Config, Schema};
use Illuminate\Support\Str;

class OccupationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currentDateTime = currentDateTime();

        $data = [
            [
                Occupation::occupation_id => 1,
                Occupation::occupation => 'Govt. job',
                Occupation::occupation_slug => Str::slug('Govt. job', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                Occupation::created_at => $currentDateTime
            ],
            [
                Occupation::occupation_id => 2,
                Occupation::occupation => 'Private job',
                Occupation::occupation_slug => Str::slug('Private job', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                Occupation::created_at => $currentDateTime
            ],
            [
                Occupation::occupation_id => 3,
                Occupation::occupation => 'Self-employed',
                Occupation::occupation_slug => Str::slug('Self-employed', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                Occupation::created_at => $currentDateTime
            ],
            [
                Occupation::occupation_id => 4,
                Occupation::occupation => 'Daily Wage Labourer',
                Occupation::occupation_slug => Str::slug('Daily Wage Labourer', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                Occupation::created_at => $currentDateTime
            ],
            [
                Occupation::occupation_id => 5,
                Occupation::occupation => 'Agricultural',
                Occupation::occupation_slug => Str::slug('Agricultural', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                Occupation::created_at => $currentDateTime
            ],
            [
                Occupation::occupation_id => 6,
                Occupation::occupation => 'Household work',
                Occupation::occupation_slug => Str::slug('Household work', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                Occupation::created_at => $currentDateTime
            ],
            [
                Occupation::occupation_id => 7,
                Occupation::occupation => 'Student',
                Occupation::occupation_slug => Str::slug('Student', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                Occupation::created_at => $currentDateTime
            ],
            [
                Occupation::occupation_id => 8,
                Occupation::occupation => 'Pensioner',
                Occupation::occupation_slug => Str::slug('Pensioner', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                Occupation::created_at => $currentDateTime
            ],
            [
                Occupation::occupation_id => 9,
                Occupation::occupation => 'Sex work',
                Occupation::occupation_slug => Str::slug('Sex work', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                Occupation::created_at => $currentDateTime
            ],
            [
                Occupation::occupation_id => 10,
                Occupation::occupation => 'Begging',
                Occupation::occupation_slug => Str::slug('Begging', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                Occupation::created_at => $currentDateTime
            ],
            [
                Occupation::occupation_id => 11,
                Occupation::occupation => 'Badhai',
                Occupation::occupation_slug => Str::slug('Badhai', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                Occupation::created_at => $currentDateTime
            ],
            [
                Occupation::occupation_id => 12,
                Occupation::occupation => 'Unemployed',
                Occupation::occupation_slug => Str::slug('Unemployed', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                Occupation::created_at => $currentDateTime
            ],
            [
                Occupation::occupation_id => 98,
                Occupation::occupation => 'Not Disclosed',
                Occupation::occupation_slug => Str::slug('Not Disclosed', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                Occupation::created_at => $currentDateTime
            ],
            [
                Occupation::occupation_id => 99,
                Occupation::occupation => 'Others (Specify)',
                Occupation::occupation_slug => Str::slug('Others (Specify)', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                Occupation::created_at => $currentDateTime
            ]
        ];

        Schema::disableForeignKeyConstraints();
        Occupation::insert($data);
    }
}
