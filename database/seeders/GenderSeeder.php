<?php

namespace Database\Seeders;

use App\Models\Gender;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class GenderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currentDateTime = currentDateTime();

        $data = [
            [
                Gender::gender => 'Male',
                Gender::created_at => $currentDateTime
            ],
            [
                Gender::gender => 'Female',
                Gender::created_at => $currentDateTime
            ],
            [
                Gender::gender => 'TG',
                Gender::created_at => $currentDateTime
            ],
            [
                Gender::gender => 'Not Disclosed',
                Gender::created_at => $currentDateTime
            ],
            [
                Gender::gender => 'Others',
                Gender::created_at => $currentDateTime
            ]
        ];

        Schema::disableForeignKeyConstraints();
        Gender::insert($data);
    }
}
