<?php

namespace Database\Seeders;

use App\Models\LanguageModule\Language;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currentDateTime = currentDateTime();
        $data = array(
            [
                Language::name => 'English',
                Language::label_as => 'English',
                Language::language_code => 'en-in',
                Language::locale => 'en',
                Language::created_at => $currentDateTime,
            ],
            [
                Language::name => 'हिंदी',
                Language::label_as => 'Hindi',
                Language::language_code => 'hn-in',
                Language::locale => 'hn',
                Language::created_at => $currentDateTime
            ],
            [
                Language::name => 'मराठी',
                Language::label_as => 'Marathi',
                Language::language_code => 'mr-in',
                Language::locale => 'mr',
                Language::created_at => $currentDateTime
            ],
            [
                Language::name => 'తెలుగు',
                Language::label_as => 'Telugu',
                Language::language_code => 'te-in',
                Language::locale => 'te',
                Language::created_at => $currentDateTime
            ],
            [
                Language::name => 'ગુજરાથી',
                Language::label_as => 'Gujrathi',
                Language::language_code => 'gu-in',
                Language::locale => 'gu',
                Language::created_at => $currentDateTime
            ],
            [
                Language::name => 'ಕನ್ನಡ',
                Language::label_as => 'Kannada',
                Language::language_code => 'kn-in',
                Language::locale => 'kn',
                Language::created_at => $currentDateTime
            ],
            [
                Language::name => 'தமிழ்',
                Language::label_as => 'Tamil',
                Language::language_code => 'ta-in',
                Language::locale => 'ta',
                Language::created_at => $currentDateTime
            ],
            [
                Language::name => 'മലയാളം',
                Language::label_as => 'Malyalum',
                Language::language_code => 'ml-in',
                Language::locale => 'ml',
                Language::created_at => $currentDateTime
            ],
        );
        Language::insert($data);
    }
}