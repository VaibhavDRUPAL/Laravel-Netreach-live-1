<?php

namespace Database\Seeders;

use App\Models\EducationalAttainment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\{Config, Schema};
use Illuminate\Support\Str;

class EducationalAttainmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currentDateTime = currentDateTime();

        $data = [
            [
                EducationalAttainment::educational_attainment_id => 1,
                EducationalAttainment::educational_attainment => 'No education',
                EducationalAttainment::educational_attainment_slug => Str::slug('No education', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                EducationalAttainment::created_at => $currentDateTime
            ],
            [
                EducationalAttainment::educational_attainment_id => 2,
                EducationalAttainment::educational_attainment => 'Primary (Class 1-5)',
                EducationalAttainment::educational_attainment_slug => Str::slug('Primary (Class 1-5)', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                EducationalAttainment::created_at => $currentDateTime
            ],
            [
                EducationalAttainment::educational_attainment_id => 3,
                EducationalAttainment::educational_attainment => 'Secondary (Class 6-10)',
                EducationalAttainment::educational_attainment_slug => Str::slug('Secondary (Class 6-10)', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                EducationalAttainment::created_at => $currentDateTime
            ],
            [
                EducationalAttainment::educational_attainment_id => 4,
                EducationalAttainment::educational_attainment => 'Higher Secondary (Class 11-12)',
                EducationalAttainment::educational_attainment_slug => Str::slug('Higher Secondary (Class 11-12)', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                EducationalAttainment::created_at => $currentDateTime
            ],
            [
                EducationalAttainment::educational_attainment_id => 5,
                EducationalAttainment::educational_attainment => 'Graduate',
                EducationalAttainment::educational_attainment_slug => Str::slug('Graduate', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                EducationalAttainment::created_at => $currentDateTime
            ],
            [
                EducationalAttainment::educational_attainment_id => 6,
                EducationalAttainment::educational_attainment => 'Post Graduate & above',
                EducationalAttainment::educational_attainment_slug => Str::slug('Post Graduate & above', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                EducationalAttainment::created_at => $currentDateTime
            ],
            [
                EducationalAttainment::educational_attainment_id => 7,
                EducationalAttainment::educational_attainment => 'Not disclosed',
                EducationalAttainment::educational_attainment_slug => Str::slug('Not disclosed', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                EducationalAttainment::created_at => $currentDateTime
            ]
        ];

        Schema::disableForeignKeyConstraints();
        EducationalAttainment::insert($data);
    }
}
