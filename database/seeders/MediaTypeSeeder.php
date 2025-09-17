<?php

namespace Database\Seeders;

use App\Models\MediaModule\MediaType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MediaTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currentDateTime = currentDateTime();

        $data = [
            [
                MediaType::type_name => 'Image',
                MediaType::slug => createSlug('Image'),
                MediaType::scope => json_encode([
                    'chatbot'
                ]),
                MediaType::is_deleted => false,
                MediaType::created_at => $currentDateTime
            ],
            [
                MediaType::type_name => 'Video',
                MediaType::slug => createSlug('Video'),
                MediaType::scope => json_encode([
                    'chatbot'
                ]),
                MediaType::is_deleted => false,
                MediaType::created_at => $currentDateTime
            ],
            [
                MediaType::type_name => 'Plain Text',
                MediaType::slug => createSlug('Plain Text'),
                MediaType::scope => json_encode([
                    'chatbot'
                ]),
                MediaType::is_deleted => false,
                MediaType::created_at => $currentDateTime
            ],
            [
                MediaType::type_name => 'Html',
                MediaType::slug => createSlug('Html'),
                MediaType::scope => json_encode([
                    'chatbot'
                ]),
                MediaType::is_deleted => false,
                MediaType::created_at => $currentDateTime
            ],
            [
                MediaType::type_name => 'Audio',
                MediaType::slug => createSlug('Audio'),
                MediaType::scope => json_encode([
                    'chatbot'
                ]),
                MediaType::is_deleted => true,
                MediaType::created_at => $currentDateTime
            ],
            [
                MediaType::type_name => 'Link',
                MediaType::slug => createSlug('Link'),
                MediaType::scope => json_encode([
                    'chatbot'
                ]),
                MediaType::is_deleted => false,
                MediaType::created_at => $currentDateTime
            ]
        ];
        MediaType::insert($data);
    }
}