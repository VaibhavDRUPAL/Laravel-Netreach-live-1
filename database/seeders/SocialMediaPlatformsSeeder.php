<?php

namespace Database\Seeders;

use App\Models\Platform;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class SocialMediaPlatformsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currentDateTime = currentDateTime();

        $data = [
            [
                Platform::id => 1,
                Platform::name => 'Grindr',
                Platform::created_at => $currentDateTime
            ],
            [
                Platform::id => 2,
                Platform::name => 'Planet Romeo',
                Platform::created_at => $currentDateTime
            ],
            [
                Platform::id => 3,
                Platform::name => 'Blued',
                Platform::created_at => $currentDateTime
            ],
            [
                Platform::id => 4,
                Platform::name => 'Scruff',
                Platform::created_at => $currentDateTime
            ],
            [
                Platform::id => 5,
                Platform::name => 'Tinder',
                Platform::created_at => $currentDateTime
            ],
            [
                Platform::id => 6,
                Platform::name => 'OK CUPID',
                Platform::created_at => $currentDateTime
            ],
            [
                Platform::id => 7,
                Platform::name => 'Bumble',
                Platform::created_at => $currentDateTime
            ],
            [
                Platform::id => 8,
                Platform::name => 'WhatsApp',
                Platform::created_at => $currentDateTime
            ],
            [
                Platform::id => 9,
                Platform::name => 'Instagram',
                Platform::created_at => $currentDateTime
            ],
            [
                Platform::id => 10,
                Platform::name => 'Facebook',
                Platform::created_at => $currentDateTime
            ],
            [
                Platform::id => 11,
                Platform::name => 'Brokers',
                Platform::created_at => $currentDateTime
            ],
            [
                Platform::id => 12,
                Platform::name => 'Gay Friendly',
                Platform::created_at => $currentDateTime
            ],
            [
                Platform::id => 13,
                Platform::name => 'TAMI',
                Platform::created_at => $currentDateTime
            ],
            [
                Platform::id => 14,
                Platform::name => 'Telegram',
                Platform::created_at => $currentDateTime
            ],
            [
                Platform::id => 15,
                Platform::name => 'WALLA',
                Platform::created_at => $currentDateTime
            ],
            [
                Platform::id => 16,
                Platform::name => 'Telephone call',
                Platform::created_at => $currentDateTime
            ],
            [
                Platform::id => 17,
                Platform::name => 'Spicy',
                Platform::created_at => $currentDateTime
            ],
            [
                Platform::id => 99,
                Platform::name => 'Others',
                Platform::created_at => $currentDateTime
            ]
        ];

        Schema::disableForeignKeyConstraints();
        Platform::truncate();
        Platform::insert($data);
    }
}
