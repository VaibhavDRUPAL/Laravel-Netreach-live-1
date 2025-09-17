<?php

namespace Database\Seeders;

use App\Models\ChatbotModule\Content;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChatbotContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currentDateTime = currentDateTime();

        $data = [
            [
                Content::title => 'Chat again',
                Content::description => 'This appears while reseting the chat',
                Content::slug => createSlug('Chat again'),
                Content::content => json_encode([
                    'en' => 'You want to start the chat again?'
                ]),
                Content::created_at => $currentDateTime
            ],
            [
                Content::title => 'Chat again - Cancel',
                Content::description => 'This is button text, appears on confirm box while reseting the chat.',
                Content::slug => createSlug('Chat again - Cancel'),
                Content::content => json_encode([
                    'en' => 'Cancel'
                ]),
                Content::created_at => $currentDateTime
            ],
            [
                Content::title => 'Chat again - Confirm',
                Content::description => 'This is button text, appears on confirm box while reseting the chat.',
                Content::slug => createSlug('Chat again - Confirm'),
                Content::content => json_encode([
                    'en' => 'Confirm'
                ]),
                Content::created_at => $currentDateTime
            ],
            [
                Content::title => 'Ask another question',
                Content::description => 'This text appears after each answer.',
                Content::slug => createSlug('Ask another question'),
                Content::content => json_encode([
                    'en' => 'Would you like to ask another question?'
                ]),
                Content::created_at => $currentDateTime
            ],
            [
                Content::title => 'Ask another question - Yes',
                Content::description => 'This is button text, appears after each answer.',
                Content::slug => createSlug('Ask another question - Yes'),
                Content::content => json_encode([
                    'en' => "Yes, I'd like to ask another question"
                ]),
                Content::created_at => $currentDateTime
            ],
            [
                Content::title => 'Ask another question - No',
                Content::description => 'This is button text, appears after each answer.',
                Content::slug => createSlug('Ask another question - No'),
                Content::content => json_encode([
                    'en' => "No, that's all for now"
                ]),
                Content::created_at => $currentDateTime
            ],
            [
                Content::title => 'Load more',
                Content::description => 'This is button text, appears after each group of 5 questions.',
                Content::slug => createSlug('Load More'),
                Content::content => json_encode([
                    'en' => "Load More"
                ]),
                Content::created_at => $currentDateTime
            ],
            [
                Content::title => 'Book an Appointment',
                Content::description => 'This is button text, appears after each group of 5 questions.',
                Content::slug => createSlug('Book an Appointment'),
                Content::content => json_encode([
                    'en' => "Book an Appointment"
                ]),
                Content::created_at => $currentDateTime
            ]
        ];
        Content::insert($data);
    }
}
