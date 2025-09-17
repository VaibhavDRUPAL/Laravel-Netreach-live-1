<?php

namespace Database\Seeders;

use App\Models\ClientType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\{Config, Schema};
use Illuminate\Support\Str;

class ClientTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currentDateTime = currentDateTime();

        $data = [
            [
                ClientType::client_type_id => 1,
                ClientType::client_type => 'New client',
                ClientType::client_type_slug => Str::slug('New client', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                ClientType::created_at => $currentDateTime
            ],
            [
                ClientType::client_type_id => 2,
                ClientType::client_type => 'Follow up client',
                ClientType::client_type_slug => Str::slug('Follow up client', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                ClientType::created_at => $currentDateTime
            ],
            [
                ClientType::client_type_id => 3,
                ClientType::client_type => 'Repeat risk assessment',
                ClientType::client_type_slug => Str::slug('Repeat risk assessment', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                ClientType::created_at => $currentDateTime
            ],
            [
                ClientType::client_type_id => 4,
                ClientType::client_type => 'Repeat client',
                ClientType::client_type_slug => Str::slug('Repeat client', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                ClientType::created_at => $currentDateTime
            ],
            [
                ClientType::client_type_id => 5,
                ClientType::client_type => 'Repeat service/Retest',
                ClientType::client_type_slug => Str::slug('Repeat service/Retest', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                ClientType::created_at => $currentDateTime
            ],
            [
                ClientType::client_type_id => 6,
                ClientType::client_type => 'Confirmatory test',
                ClientType::client_type_slug => Str::slug('Confirmatory test', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                ClientType::created_at => $currentDateTime
            ],
        ];

        Schema::disableForeignKeyConstraints();
        ClientType::insert($data);
    }
}
