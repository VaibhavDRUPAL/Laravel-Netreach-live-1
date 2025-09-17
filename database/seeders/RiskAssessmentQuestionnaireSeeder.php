<?php

namespace Database\Seeders;

use App\Models\SelfModule\RiskAssessmentQuestionnaire;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\{Config, Schema};
use Illuminate\Support\Str;

class RiskAssessmentQuestionnaireSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                RiskAssessmentQuestionnaire::question => Str::squish('Mobile number'),
                RiskAssessmentQuestionnaire::question_slug => Str::slug('Mobile number', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentQuestionnaire::answer_input_type => Str::lower(Str::squish('text')),
                RiskAssessmentQuestionnaire::priority => 1,
                RiskAssessmentQuestionnaire::is_active => true,
            ],
            [
                RiskAssessmentQuestionnaire::question => Str::squish('Age'),
                RiskAssessmentQuestionnaire::question_slug => Str::slug('Age', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentQuestionnaire::answer_input_type => Str::lower(Str::squish('radio')),
                RiskAssessmentQuestionnaire::priority => 2,
                RiskAssessmentQuestionnaire::is_active => true,
            ],
            [
                RiskAssessmentQuestionnaire::question => Str::squish('Gender'),
                RiskAssessmentQuestionnaire::question_slug => Str::slug('Gender', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentQuestionnaire::answer_input_type => Str::lower(Str::squish('radio')),
                RiskAssessmentQuestionnaire::priority => 3,
                RiskAssessmentQuestionnaire::is_active => true,
            ],
            [
                RiskAssessmentQuestionnaire::question => Str::squish('Marital status'),
                RiskAssessmentQuestionnaire::question_slug => Str::slug('Marital status', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentQuestionnaire::answer_input_type => Str::lower(Str::squish('radio')),
                RiskAssessmentQuestionnaire::priority => 4,
                RiskAssessmentQuestionnaire::is_active => false,
            ],
            [
                RiskAssessmentQuestionnaire::question => Str::squish('State'),
                RiskAssessmentQuestionnaire::question_slug => Str::slug('State', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentQuestionnaire::answer_input_type => Str::lower(Str::squish('select')),
                RiskAssessmentQuestionnaire::priority => 5,
                RiskAssessmentQuestionnaire::is_active => true,
            ],
            [
                RiskAssessmentQuestionnaire::question => Str::squish('Are you a Migrant worker? (At least 30 days away from his/*her* district for the job)'),
                RiskAssessmentQuestionnaire::question_slug => Str::slug('Are you a Migrant worker? (At least 30 days away from his/*her* district for the job)', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentQuestionnaire::answer_input_type => Str::lower(Str::squish('radio')),
                RiskAssessmentQuestionnaire::priority => 6,
                RiskAssessmentQuestionnaire::is_active => true,
            ],
            [
                RiskAssessmentQuestionnaire::question => Str::squish('What is your occupation type?'),
                RiskAssessmentQuestionnaire::question_slug => Str::slug('What is your occupation type?', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentQuestionnaire::answer_input_type => Str::lower(Str::squish('radio')),
                RiskAssessmentQuestionnaire::priority => 7,
                RiskAssessmentQuestionnaire::is_active => false,
            ],
            [
                RiskAssessmentQuestionnaire::question => Str::squish('Did you travel in the last 30 days?'),
                RiskAssessmentQuestionnaire::question_slug => Str::slug('Did you travel in the last 30 days?', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentQuestionnaire::answer_input_type => Str::lower(Str::squish('radio')),
                RiskAssessmentQuestionnaire::priority => 8,
                RiskAssessmentQuestionnaire::is_active => false,
            ],
            [
                RiskAssessmentQuestionnaire::question => Str::squish('Sexual attraction'),
                RiskAssessmentQuestionnaire::question_slug => Str::slug('Sexual attraction', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentQuestionnaire::answer_input_type => Str::lower(Str::squish('radio')),
                RiskAssessmentQuestionnaire::priority => 9,
                RiskAssessmentQuestionnaire::is_active => true,
            ],
            [
                RiskAssessmentQuestionnaire::question => Str::squish('What was your age when you had sex for the first time?'),
                RiskAssessmentQuestionnaire::question_slug => Str::slug('What was your age when you had sex for the first time?', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentQuestionnaire::answer_input_type => Str::lower(Str::squish('radio')),
                RiskAssessmentQuestionnaire::priority => 10,
                RiskAssessmentQuestionnaire::is_active => true,
            ],
            [
                RiskAssessmentQuestionnaire::question => Str::squish('Which sexual activities have you performed in the past 30 days?'),
                RiskAssessmentQuestionnaire::question_slug => Str::slug('Which sexual activities have you performed in the past 30 days?', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentQuestionnaire::answer_input_type => Str::lower(Str::squish('checkbox')),
                RiskAssessmentQuestionnaire::priority => 11,
                RiskAssessmentQuestionnaire::is_active => true,
            ],
            [
                RiskAssessmentQuestionnaire::question => Str::squish('Did you use a condom during sex in the last 30 days?'),
                RiskAssessmentQuestionnaire::question_slug => Str::slug('Did you use a condom during sex in the last 30 days?', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentQuestionnaire::answer_input_type => Str::lower(Str::squish('radio')),
                RiskAssessmentQuestionnaire::priority => 12,
                RiskAssessmentQuestionnaire::is_active => true,
            ],
            [
                RiskAssessmentQuestionnaire::question => Str::squish('Do you use drugs before or during sex?'),
                RiskAssessmentQuestionnaire::question_slug => Str::slug('Do you use drugs before or during sex?', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentQuestionnaire::answer_input_type => Str::lower(Str::squish('radio')),
                RiskAssessmentQuestionnaire::priority => 13,
                RiskAssessmentQuestionnaire::is_active => true,
            ],
            [
                RiskAssessmentQuestionnaire::question => Str::squish('Do you share injecting equipment when you use drugs?'),
                RiskAssessmentQuestionnaire::question_slug => Str::slug('Do you share injecting equipment when you use drugs?', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentQuestionnaire::answer_input_type => Str::lower(Str::squish('radio')),
                RiskAssessmentQuestionnaire::priority => 14,
                RiskAssessmentQuestionnaire::is_active => true,
            ],
            [
                RiskAssessmentQuestionnaire::question => Str::squish('Do you drink before or during sex?'),
                RiskAssessmentQuestionnaire::question_slug => Str::slug('Do you drink before or during sex?', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentQuestionnaire::answer_input_type => Str::lower(Str::squish('radio')),
                RiskAssessmentQuestionnaire::priority => 15,
                RiskAssessmentQuestionnaire::is_active => true,
            ],
            [
                RiskAssessmentQuestionnaire::question => Str::squish('Have you had sex with more than one partner in the past 30 days?'),
                RiskAssessmentQuestionnaire::question_slug => Str::slug('Have you had sex with more than one partner in the past 30 days?', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentQuestionnaire::answer_input_type => Str::lower(Str::squish('radio')),
                RiskAssessmentQuestionnaire::priority => 16,
                RiskAssessmentQuestionnaire::is_active => true,
            ],
            [
                RiskAssessmentQuestionnaire::question => Str::squish('Have you received pre-exposure prophylaxis (PrEP) for HIV prevention in the last 30 days?'),
                RiskAssessmentQuestionnaire::question_slug => Str::slug('Have you received pre-exposure prophylaxis (PrEP) for HIV prevention in the last 30 days?', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentQuestionnaire::answer_input_type => Str::lower(Str::squish('radio')),
                RiskAssessmentQuestionnaire::priority => 17,
                RiskAssessmentQuestionnaire::is_active => true,
            ],
            [
                RiskAssessmentQuestionnaire::question => Str::squish('When was the last time you tested for HIV?'),
                RiskAssessmentQuestionnaire::question_slug => Str::slug('When was the last time you tested for HIV?', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentQuestionnaire::answer_input_type => Str::lower(Str::squish('radio')),
                RiskAssessmentQuestionnaire::priority => 18,
                RiskAssessmentQuestionnaire::is_active => true,
            ],
            [
                RiskAssessmentQuestionnaire::question => Str::squish('Have you experienced/noticed any or many of the following?'),
                RiskAssessmentQuestionnaire::question_slug => Str::slug('Have you experienced/noticed any or many of the following?', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentQuestionnaire::answer_input_type => Str::lower(Str::squish('checkbox')),
                RiskAssessmentQuestionnaire::priority => 19,
                RiskAssessmentQuestionnaire::is_active => true,
            ],
            [
                RiskAssessmentQuestionnaire::question => Str::squish('Have you noticed/experienced any or many of the following?'),
                RiskAssessmentQuestionnaire::question_slug => Str::slug('Have you noticed/experienced any or many of the following?', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentQuestionnaire::answer_input_type => Str::lower(Str::squish('checkbox')),
                RiskAssessmentQuestionnaire::priority => 20,
                RiskAssessmentQuestionnaire::is_active => true,
            ],
            [
                RiskAssessmentQuestionnaire::question => Str::squish('Have you gone through the following in the past 30 days or months?'),
                RiskAssessmentQuestionnaire::question_slug => Str::slug('Have you gone through the following in the past 30 days or months?', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentQuestionnaire::answer_input_type => Str::lower(Str::squish('radio')),
                RiskAssessmentQuestionnaire::priority => 21,
                RiskAssessmentQuestionnaire::is_active => false,
            ],
        ];

        

        Schema::disableForeignKeyConstraints();
        RiskAssessmentQuestionnaire::truncate();
        RiskAssessmentQuestionnaire::insert($data);
    }
}