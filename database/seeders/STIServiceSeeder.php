<?php

namespace Database\Seeders;

use App\Models\STIService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\{Config, Schema};
use Illuminate\Support\Str;

class STIServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currentDateTime = currentDateTime();

        $data = [
            [
                STIService::sti_service_id => 1,
                STIService::sti_service => 'Syphillis(rpr/vdrl)',
                STIService::sti_service_slug => Str::slug('Syphillis(rpr/vdrl)', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                STIService::created_at => $currentDateTime
            ],
            [
                STIService::sti_service_id => 2,
                STIService::sti_service => 'Vaginal/ Cervical Discharge(VCD)',
                STIService::sti_service_slug => Str::slug('Vaginal/ Cervical Discharge(VCD)', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                STIService::created_at => $currentDateTime
            ],
            [
                STIService::sti_service_id => 3,
                STIService::sti_service => 'Genital Ulcer (GUD)-non herpetic',
                STIService::sti_service_slug => Str::slug('Genital Ulcer (GUD)-non herpetic', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                STIService::created_at => $currentDateTime
            ],
            [
                STIService::sti_service_id => 4,
                STIService::sti_service => 'Lower abdominal pain(LAY)',
                STIService::sti_service_slug => Str::slug('Lower abdominal pain(LAY)', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                STIService::created_at => $currentDateTime
            ],
            [
                STIService::sti_service_id => 5,
                STIService::sti_service => 'Urethral DRscharge(UD)',
                STIService::sti_service_slug => Str::slug('Urethral DRscharge(UD)', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                STIService::created_at => $currentDateTime
            ],
            [
                STIService::sti_service_id => 6,
                STIService::sti_service => 'Ano-rectal DRscharge (ARD)',
                STIService::sti_service_slug => Str::slug('Ano-rectal DRscharge (ARD)', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                STIService::created_at => $currentDateTime
            ],
            [
                STIService::sti_service_id => 7,
                STIService::sti_service => 'Inguinal Bubo(IB)',
                STIService::sti_service_slug => Str::slug('Inguinal Bubo(IB)', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                STIService::created_at => $currentDateTime
            ],
            [
                STIService::sti_service_id => 8,
                STIService::sti_service => 'Painful scrotal swelling (SS)',
                STIService::sti_service_slug => Str::slug('Painful scrotal swelling (SS)', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                STIService::created_at => $currentDateTime
            ],
            [
                STIService::sti_service_id => 9,
                STIService::sti_service => 'Genital warts',
                STIService::sti_service_slug => Str::slug('Genital warts', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                STIService::created_at => $currentDateTime
            ],
            [
                STIService::sti_service_id => 10,
                STIService::sti_service => 'Hepatitis B',
                STIService::sti_service_slug => Str::slug('Hepatitis B', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                STIService::created_at => $currentDateTime
            ],
            [
                STIService::sti_service_id => 11,
                STIService::sti_service => 'Hepatitis C',
                STIService::sti_service_slug => Str::slug('Hepatitis C', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                STIService::created_at => $currentDateTime
            ],
            [
                STIService::sti_service_id => 12,
                STIService::sti_service => 'Gonorrhea',
                STIService::sti_service_slug => Str::slug('Gonorrhea', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                STIService::created_at => $currentDateTime
            ],
            [
                STIService::sti_service_id => 13,
                STIService::sti_service => 'Chlamydia',
                STIService::sti_service_slug => Str::slug('Chlamydia', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                STIService::created_at => $currentDateTime
            ],
            [
                STIService::sti_service_id => 99,
                STIService::sti_service => 'Others',
                STIService::sti_service_slug => Str::slug('Others', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                STIService::created_at => $currentDateTime
            ]
        ];

        Schema::disableForeignKeyConstraints();
        STIService::insert($data);
    }
}
