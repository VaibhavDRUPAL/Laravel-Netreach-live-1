<?php

namespace Database\Seeders;

use App\Models\ChatbotModule\LanguageCounter;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LanguageCounterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = array(
            [
                LanguageCounter::language_id => 1,
            ],
            [
                LanguageCounter::language_id => 2,
            ],
            [
                LanguageCounter::language_id => 3
            ]
        );
        LanguageCounter::insert($data);
    }
}
