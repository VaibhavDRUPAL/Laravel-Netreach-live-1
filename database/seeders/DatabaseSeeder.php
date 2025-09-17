<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call([
        //     RolePermissionSeeder::class,
        //     SettingsSeeder::class,
        //     LanguageSeeder::class,
        //     LanguageCounterSeeder::class,
        //     GreetingsSeeder::class,
        //     MediaTypeSeeder::class, 
        //     QuestionnaireSeeder::class,
        //     TestingCenterSeeder::class         
        // ]);
        $this->call([
            ClientResponseSeeder::class,
            ClientTypeSeeder::class,
            EducationalAttainmentSeeder::class,
            GenderSeeder::class,
            OccupationSeeder::class,
            ReasonForNotAccessingServiceSeeder::class,
            ServiceTypeSeeder::class,
            STIServiceSeeder::class,
            TargetPopulationSeeder::class,
            TIServiceSeeder::class,
            SocialMediaPlatformsSeeder::class,
            OutreachSeeder::class
        ]);
    }
}