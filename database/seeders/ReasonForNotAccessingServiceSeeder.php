<?php

namespace Database\Seeders;

use App\Models\ReasonForNotAccessingService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\{Config, Schema};
use Illuminate\Support\Str;

class ReasonForNotAccessingServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currentDateTime = currentDateTime();

        $data = [
            [
                ReasonForNotAccessingService::reason_id => 1,
                ReasonForNotAccessingService::reason => 'Covid issues',
                ReasonForNotAccessingService::reason_slug => Str::slug('Covid issues', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                ReasonForNotAccessingService::created_at => $currentDateTime
            ],
            [
                ReasonForNotAccessingService::reason_id => 2,
                ReasonForNotAccessingService::reason => 'Testing center closed',
                ReasonForNotAccessingService::reason_slug => Str::slug('Testing center closed', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                ReasonForNotAccessingService::created_at => $currentDateTime
            ],
            [
                ReasonForNotAccessingService::reason_id => 3,
                ReasonForNotAccessingService::reason => 'Unable to reach on time',
                ReasonForNotAccessingService::reason_slug => Str::slug('Unable to reach on time', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                ReasonForNotAccessingService::created_at => $currentDateTime
            ],
            [
                ReasonForNotAccessingService::reason_id => 4,
                ReasonForNotAccessingService::reason => 'Inconvenient timings',
                ReasonForNotAccessingService::reason_slug => Str::slug('Inconvenient timings', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                ReasonForNotAccessingService::created_at => $currentDateTime
            ],
            [
                ReasonForNotAccessingService::reason_id => 5,
                ReasonForNotAccessingService::reason => 'Out of station',
                ReasonForNotAccessingService::reason_slug => Str::slug('Out of station', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                ReasonForNotAccessingService::created_at => $currentDateTime
            ],
            [
                ReasonForNotAccessingService::reason_id => 6,
                ReasonForNotAccessingService::reason => 'Lack of time',
                ReasonForNotAccessingService::reason_slug => Str::slug('Lack of time', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                ReasonForNotAccessingService::created_at => $currentDateTime
            ],
            [
                ReasonForNotAccessingService::reason_id => 7,
                ReasonForNotAccessingService::reason => 'Fear of being positive',
                ReasonForNotAccessingService::reason_slug => Str::slug('Fear of being positive', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                ReasonForNotAccessingService::created_at => $currentDateTime
            ],
            [
                ReasonForNotAccessingService::reason_id => 8,
                ReasonForNotAccessingService::reason => 'Unwell',
                ReasonForNotAccessingService::reason_slug => Str::slug('Unwell', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                ReasonForNotAccessingService::created_at => $currentDateTime
            ],
            [
                ReasonForNotAccessingService::reason_id => 9,
                ReasonForNotAccessingService::reason => 'Center staff behaviour',
                ReasonForNotAccessingService::reason_slug => Str::slug('Center staff behaviour', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                ReasonForNotAccessingService::created_at => $currentDateTime
            ],
            [
                ReasonForNotAccessingService::reason_id => 10,
                ReasonForNotAccessingService::reason => 'Testing kit unavailable',
                ReasonForNotAccessingService::reason_slug => Str::slug('Testing kit unavailable', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                ReasonForNotAccessingService::created_at => $currentDateTime
            ],
            [
                ReasonForNotAccessingService::reason_id => 11,
                ReasonForNotAccessingService::reason => 'Centre is crowded',
                ReasonForNotAccessingService::reason_slug => Str::slug('Centre is crowded', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                ReasonForNotAccessingService::created_at => $currentDateTime
            ],
            [
                ReasonForNotAccessingService::reason_id => 12,
                ReasonForNotAccessingService::reason => 'Weather issue',
                ReasonForNotAccessingService::reason_slug => Str::slug('Weather issue', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                ReasonForNotAccessingService::created_at => $currentDateTime
            ],
            [
                ReasonForNotAccessingService::reason_id => 13,
                ReasonForNotAccessingService::reason => 'Lost contact with client',
                ReasonForNotAccessingService::reason_slug => Str::slug('Lost contact with client', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                ReasonForNotAccessingService::created_at => $currentDateTime
            ],
            [
                ReasonForNotAccessingService::reason_id => 14,
                ReasonForNotAccessingService::reason => 'Centre is far away',
                ReasonForNotAccessingService::reason_slug => Str::slug('Centre is far away', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                ReasonForNotAccessingService::created_at => $currentDateTime
            ],
            [
                ReasonForNotAccessingService::reason_id => 15,
                ReasonForNotAccessingService::reason => 'Afraid of being noticed',
                ReasonForNotAccessingService::reason_slug => Str::slug('Afraid of being noticed', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                ReasonForNotAccessingService::created_at => $currentDateTime
            ],
            [
                ReasonForNotAccessingService::reason_id => 16,
                ReasonForNotAccessingService::reason => 'Long waiting time',
                ReasonForNotAccessingService::reason_slug => Str::slug('Long waiting time', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                ReasonForNotAccessingService::created_at => $currentDateTime
            ],
            [
                ReasonForNotAccessingService::reason_id => 17,
                ReasonForNotAccessingService::reason => 'No update from client',
                ReasonForNotAccessingService::reason_slug => Str::slug('No update from client', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                ReasonForNotAccessingService::created_at => $currentDateTime
            ],
            [
                ReasonForNotAccessingService::reason_id => 18,
                ReasonForNotAccessingService::reason => 'Unable to locate centre',
                ReasonForNotAccessingService::reason_slug => Str::slug('Unable to locate centre', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                ReasonForNotAccessingService::created_at => $currentDateTime
            ],
            [
                ReasonForNotAccessingService::reason_id => 19,
                ReasonForNotAccessingService::reason => 'Expensive',
                ReasonForNotAccessingService::reason_slug => Str::slug('Expensive', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                ReasonForNotAccessingService::created_at => $currentDateTime
            ],
            [
                ReasonForNotAccessingService::reason_id => 99,
                ReasonForNotAccessingService::reason => 'Others',
                ReasonForNotAccessingService::reason_slug => Str::slug('Others', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                ReasonForNotAccessingService::created_at => $currentDateTime
            ]
        ];

        Schema::disableForeignKeyConstraints();
        ReasonForNotAccessingService::insert($data);
    }
}
