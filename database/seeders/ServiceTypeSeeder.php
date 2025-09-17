<?php

namespace Database\Seeders;

use App\Models\ServiceType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\{Config, Schema};
use Illuminate\Support\Str;

class ServiceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currentDateTime = currentDateTime();

        $data = [
            [
                ServiceType::service_type_id => 1,
                ServiceType::service_type => 'HIV Testing',
                ServiceType::service_type_slug => Str::slug('HIV Testing', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                ServiceType::created_at => $currentDateTime
            ],
            [
                ServiceType::service_type_id => 2,
                ServiceType::service_type => 'STI Services',
                ServiceType::service_type_slug => Str::slug('STI Services', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                ServiceType::created_at => $currentDateTime
            ],
            [
                ServiceType::service_type_id => 3,
                ServiceType::service_type => 'PrEP',
                ServiceType::service_type_slug => Str::slug('PrEP', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                ServiceType::created_at => $currentDateTime
            ],
            [
                ServiceType::service_type_id => 4,
                ServiceType::service_type => 'PEP',
                ServiceType::service_type_slug => Str::slug('PEP', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                ServiceType::created_at => $currentDateTime
            ],
            [
                ServiceType::service_type_id => 5,
                ServiceType::service_type => 'HIV and STI counselling',
                ServiceType::service_type_slug => Str::slug('HIV and STI counselling', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                ServiceType::created_at => $currentDateTime
            ],
            [
                ServiceType::service_type_id => 6,
                ServiceType::service_type => 'Referral for mental health counselling',
                ServiceType::service_type_slug => Str::slug('Referral for mental health counselling', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                ServiceType::created_at => $currentDateTime
            ],
            [
                ServiceType::service_type_id => 7,
                ServiceType::service_type => 'ART linkages',
                ServiceType::service_type_slug => Str::slug('ART linkages', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                ServiceType::created_at => $currentDateTime
            ],
            [
                ServiceType::service_type_id => 8,
                ServiceType::service_type => 'Referral to TI for other services',
                ServiceType::service_type_slug => Str::slug('Referral to TI for other services', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                ServiceType::created_at => $currentDateTime
            ],
            [
                ServiceType::service_type_id => 9,
                ServiceType::service_type => 'OST',
                ServiceType::service_type_slug => Str::slug('OST', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                ServiceType::created_at => $currentDateTime
            ],
            [
                ServiceType::service_type_id => 10,
                ServiceType::service_type => 'SRS',
                ServiceType::service_type_slug => Str::slug('SRS', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                ServiceType::created_at => $currentDateTime
            ],
            [
                ServiceType::service_type_id => 11,
                ServiceType::service_type => 'Social Entitlements',
                ServiceType::service_type_slug => Str::slug('Social Entitlements', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                ServiceType::created_at => $currentDateTime
            ],
            [
                ServiceType::service_type_id => 13,
                ServiceType::service_type => 'Gender Based Violence',
                ServiceType::service_type_slug => Str::slug('Gender Based Violence', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                ServiceType::created_at => $currentDateTime
            ],
            [
                ServiceType::service_type_id => 14,
                ServiceType::service_type => 'Crisis cases',
                ServiceType::service_type_slug => Str::slug('Crisis cases', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                ServiceType::created_at => $currentDateTime
            ],
            [
                ServiceType::service_type_id => 15,
                ServiceType::service_type => 'Referral to Care & Support centre',
                ServiceType::service_type_slug => Str::slug('Referral to Care & Support centre', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                ServiceType::created_at => $currentDateTime
            ],
            [
                ServiceType::service_type_id => 16,
                ServiceType::service_type => 'Referral to de-addiction centre',
                ServiceType::service_type_slug => Str::slug('Referral to de-addiction centre', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                ServiceType::created_at => $currentDateTime
            ],
            [
                ServiceType::service_type_id => 17,
                ServiceType::service_type => 'Referral for enrolling in Social Welfare schemes',
                ServiceType::service_type_slug => Str::slug('Referral for enrolling in Social Welfare schemes', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                ServiceType::created_at => $currentDateTime
            ],
            [
                ServiceType::service_type_id => 18,
                ServiceType::service_type => 'Sexual & Reproductive Health',
                ServiceType::service_type_slug => Str::slug('Sexual & Reproductive Health', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                ServiceType::created_at => $currentDateTime
            ],
            [
                ServiceType::service_type_id => 19,
                ServiceType::service_type => 'Social Protection Scheme',
                ServiceType::service_type_slug => Str::slug('Social Protection Scheme', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                ServiceType::created_at => $currentDateTime
            ],
            [
                ServiceType::service_type_id => 20,
                ServiceType::service_type => 'NACO Helpline (1097)',
                ServiceType::service_type_slug => Str::slug('NACO Helpline (1097)', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                ServiceType::created_at => $currentDateTime
            ],
            [
                ServiceType::service_type_id => 99,
                ServiceType::service_type => 'Others',
                ServiceType::service_type_slug => Str::slug('Others', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                ServiceType::created_at => $currentDateTime
            ],
        ];

        Schema::disableForeignKeyConstraints();
        ServiceType::insert($data);
    }
}
