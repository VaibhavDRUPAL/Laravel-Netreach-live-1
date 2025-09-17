<?php

namespace Database\Seeders;

use App\Models\ClientResponse;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\{Config, Schema};
use Illuminate\Support\Str;

class ClientResponseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currentDateTime = currentDateTime();

        $data = [
            [
                ClientResponse::response_id => 1,
                ClientResponse::response => 'Responded',
                ClientResponse::response_slug => Str::slug('Responded', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                ClientResponse::created_at => $currentDateTime
            ],
            [
                ClientResponse::response_id => 2,
                ClientResponse::response => 'Client approached',
                ClientResponse::response_slug => Str::slug('Client approached', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                ClientResponse::created_at => $currentDateTime
            ],
            [
                ClientResponse::response_id => 3,
                ClientResponse::response => 'Wants to get back later for service',
                ClientResponse::response_slug => Str::slug('Wants to get back later for service', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                ClientResponse::created_at => $currentDateTime
            ],
            [
                ClientResponse::response_id => 4,
                ClientResponse::response => 'Not interested',
                ClientResponse::response_slug => Str::slug('Not interested', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                ClientResponse::created_at => $currentDateTime
            ],
            [
                ClientResponse::response_id => 5,
                ClientResponse::response => 'Did not respond',
                ClientResponse::response_slug => Str::slug('Did not respond', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                ClientResponse::created_at => $currentDateTime
            ],
            [
                ClientResponse::response_id => 6,
                ClientResponse::response => 'Blocked',
                ClientResponse::response_slug => Str::slug('Blocked', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                ClientResponse::created_at => $currentDateTime
            ],
            [
                ClientResponse::response_id => 7,
                ClientResponse::response => 'Responded & blocked later',
                ClientResponse::response_slug => Str::slug('Responded & blocked later', UNDERSCORE, Config::get('app.locale'), SLUG_DICTIONARY),
                ClientResponse::created_at => $currentDateTime
            ]
        ];

        Schema::disableForeignKeyConstraints();
        ClientResponse::insert($data);
    }
}
