<?php

namespace Database\Seeders;

use App\Models\ChatbotModule\Greetings;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GreetingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currentDateTime = currentDateTime();

        $data = [
            [
                Greetings::greeting_title => 'Welcome to NETREACH',
                Greetings::greetings => json_encode(
                    [
                        [
                            'locale' => 'en',
                            'media_type' => createSlug('Plain Text'),
                            'body' => 'Welcome to NETREACH, your one-stop website for taking care of your sexual health.'
                        ]
                    ]
                ),
                Greetings::created_at => $currentDateTime
            ]
        ];
        Greetings::insert($data);
    }
}