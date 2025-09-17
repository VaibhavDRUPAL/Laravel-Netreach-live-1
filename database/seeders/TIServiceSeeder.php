<?php

namespace Database\Seeders;

use App\Models\TIService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\{Config, Schema};
use Illuminate\Support\Str;

class TIServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currentDateTime = currentDateTime();

        $data = [
            [
                TIService::ti_service_id => 1,
                TIService::ti_service => 'Drop-in Center (DIC)',
                TIService::ti_service_slug => Str::slug('Drop-in Center (DIC)', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                TIService::created_at => $currentDateTime
            ],
            [
                TIService::ti_service_id => 2,
                TIService::ti_service => 'Condom',
                TIService::ti_service_slug => Str::slug('Condom', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                TIService::created_at => $currentDateTime
            ],
            [
                TIService::ti_service_id => 3,
                TIService::ti_service => 'Lubricant',
                TIService::ti_service_slug => Str::slug('Lubricant', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                TIService::created_at => $currentDateTime
            ],
            [
                TIService::ti_service_id => 4,
                TIService::ti_service => 'Doctor consultation',
                TIService::ti_service_slug => Str::slug('Doctor consultation', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                TIService::created_at => $currentDateTime
            ],
            [
                TIService::ti_service_id => 5,
                TIService::ti_service => 'Counseling',
                TIService::ti_service_slug => Str::slug('Counseling', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                TIService::created_at => $currentDateTime
            ],
            [
                TIService::ti_service_id => 6,
                TIService::ti_service => 'OST',
                TIService::ti_service_slug => Str::slug('OST', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                TIService::created_at => $currentDateTime
            ],
            [
                TIService::ti_service_id => 7,
                TIService::ti_service => 'Social Entitlements',
                TIService::ti_service_slug => Str::slug('Social Entitlements', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                TIService::created_at => $currentDateTime
            ],
            [
                TIService::ti_service_id => 8,
                TIService::ti_service => 'Gender Based Violence',
                TIService::ti_service_slug => Str::slug('Gender Based Violence', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                TIService::created_at => $currentDateTime
            ],
            [
                TIService::ti_service_id => 9,
                TIService::ti_service => 'Crisis cases',
                TIService::ti_service_slug => Str::slug('Crisis cases', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                TIService::created_at => $currentDateTime
            ],
            [
                TIService::ti_service_id => 10,
                TIService::ti_service => 'Social Welfare schemes/Protection scheme',
                TIService::ti_service_slug => Str::slug('Social Welfare schemes/Protection scheme', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                TIService::created_at => $currentDateTime
            ],
            [
                TIService::ti_service_id => 11,
                TIService::ti_service => 'Other Sexual & Reproductive Health',
                TIService::ti_service_slug => Str::slug('Other Sexual & Reproductive Health', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                TIService::created_at => $currentDateTime
            ],
            [
                TIService::ti_service_id => 99,
                TIService::ti_service => 'Others',
                TIService::ti_service_slug => Str::slug('Others', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                TIService::created_at => $currentDateTime
            ]
        ];

        Schema::disableForeignKeyConstraints();
        TIService::insert($data);
    }
}
