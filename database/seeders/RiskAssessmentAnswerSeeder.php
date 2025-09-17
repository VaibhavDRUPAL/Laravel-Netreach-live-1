<?php

namespace Database\Seeders;

use App\Models\SelfModule\RiskAssessmentAnswer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\{Config, Schema};
use Illuminate\Support\Str;

class RiskAssessmentAnswerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                RiskAssessmentAnswer::question_id => 2,
                RiskAssessmentAnswer::answer => Str::title('15-19'),
                RiskAssessmentAnswer::answer_slug => Str::slug('15-19', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentAnswer::weight => 3,
                RiskAssessmentAnswer::is_active => false
            ],
            [
                RiskAssessmentAnswer::question_id => 2,
                RiskAssessmentAnswer::answer => Str::title('18-29'),
                RiskAssessmentAnswer::answer_slug => Str::slug('18-29', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentAnswer::weight => 8,
                RiskAssessmentAnswer::is_active => true
            ],
            [
                RiskAssessmentAnswer::question_id => 2,
                RiskAssessmentAnswer::answer => Str::title('30-39'),
                RiskAssessmentAnswer::answer_slug => Str::slug('30-39', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentAnswer::weight => 2,
                RiskAssessmentAnswer::is_active => true
            ],
            [
                RiskAssessmentAnswer::question_id => 2,
                RiskAssessmentAnswer::answer => Str::title('40-49'),
                RiskAssessmentAnswer::answer_slug => Str::slug('40-49', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentAnswer::weight => 1,
                RiskAssessmentAnswer::is_active => true
            ],
            [
                RiskAssessmentAnswer::question_id => 2,
                RiskAssessmentAnswer::answer => Str::title('50+'),
                RiskAssessmentAnswer::answer_slug => Str::slug('50+', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentAnswer::weight => 1,
                RiskAssessmentAnswer::is_active => true
            ],
            [
                RiskAssessmentAnswer::question_id => 3,
                RiskAssessmentAnswer::answer => Str::title('Male'),
                RiskAssessmentAnswer::answer_slug => Str::slug('Male', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentAnswer::weight => 3,
                RiskAssessmentAnswer::is_active => true
            ],
            [
                RiskAssessmentAnswer::question_id => 3,
                RiskAssessmentAnswer::answer => Str::title('Female'),
                RiskAssessmentAnswer::answer_slug => Str::slug('Female', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentAnswer::weight => 2,
                RiskAssessmentAnswer::is_active => true
            ],
            [
                RiskAssessmentAnswer::question_id => 3,
                RiskAssessmentAnswer::answer => Str::title('Transgender'),
                RiskAssessmentAnswer::answer_slug => Str::slug('Transgender', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentAnswer::weight => 4,
                RiskAssessmentAnswer::is_active => true
            ],
            [
                RiskAssessmentAnswer::question_id => 4,
                RiskAssessmentAnswer::answer => Str::title('Single'),
                RiskAssessmentAnswer::answer_slug => Str::slug('Single', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentAnswer::weight => 4,
                RiskAssessmentAnswer::is_active => false
            ],
            [
                RiskAssessmentAnswer::question_id => 4,
                RiskAssessmentAnswer::answer => Str::title('Married'),
                RiskAssessmentAnswer::answer_slug => Str::slug('Married', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentAnswer::weight => 2,
                RiskAssessmentAnswer::is_active => false
            ],
            [
                RiskAssessmentAnswer::question_id => 4,
                RiskAssessmentAnswer::answer => Str::title('Divorced'),
                RiskAssessmentAnswer::answer_slug => Str::slug('Divorced', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentAnswer::weight => 4,
                RiskAssessmentAnswer::is_active => false
            ],
            [
                RiskAssessmentAnswer::question_id => 4,
                RiskAssessmentAnswer::answer => Str::title('Widow/Widower'),
                RiskAssessmentAnswer::answer_slug => Str::slug('Widow/Widower', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentAnswer::weight => 4,
                RiskAssessmentAnswer::is_active => false
            ],
            [
                RiskAssessmentAnswer::question_id => 6,
                RiskAssessmentAnswer::answer => Str::title('Yes'),
                RiskAssessmentAnswer::answer_slug => Str::slug('Yes', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentAnswer::weight => 3,
                RiskAssessmentAnswer::is_active => true
            ],
            [
                RiskAssessmentAnswer::question_id => 6,
                RiskAssessmentAnswer::answer => Str::title('No'),
                RiskAssessmentAnswer::answer_slug => Str::slug('No', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentAnswer::weight => 0,
                RiskAssessmentAnswer::is_active => true
            ],
            [
                RiskAssessmentAnswer::question_id => 7,
                RiskAssessmentAnswer::answer => Str::title('Infromal'),
                RiskAssessmentAnswer::answer_slug => Str::slug('Infromal', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentAnswer::weight => 4,
                RiskAssessmentAnswer::is_active => false
            ],
            [
                RiskAssessmentAnswer::question_id => 7,
                RiskAssessmentAnswer::answer => Str::title('Formal'),
                RiskAssessmentAnswer::answer_slug => Str::slug('Formal', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentAnswer::weight => 2,
                RiskAssessmentAnswer::is_active => false
            ],
            [
                RiskAssessmentAnswer::question_id => 7,
                RiskAssessmentAnswer::answer => Str::title('Unemployed'),
                RiskAssessmentAnswer::answer_slug => Str::slug('Unemployed', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentAnswer::weight => 3,
                RiskAssessmentAnswer::is_active => false
            ],
            [
                RiskAssessmentAnswer::question_id => 8,
                RiskAssessmentAnswer::answer => Str::title('Once a week'),
                RiskAssessmentAnswer::answer_slug => Str::slug('Once a week', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentAnswer::weight => 1,
                RiskAssessmentAnswer::is_active => false
            ],
            [
                RiskAssessmentAnswer::question_id => 8,
                RiskAssessmentAnswer::answer => Str::title('Twice a week'),
                RiskAssessmentAnswer::answer_slug => Str::slug('Twice a week', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentAnswer::weight => 2,
                RiskAssessmentAnswer::is_active => false
            ],
            [
                RiskAssessmentAnswer::question_id => 8,
                RiskAssessmentAnswer::answer => Str::title('Thrice a week'),
                RiskAssessmentAnswer::answer_slug => Str::slug('Thrice a week', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentAnswer::weight => 3,
                RiskAssessmentAnswer::is_active => false
            ],
            [
                RiskAssessmentAnswer::question_id => 8,
                RiskAssessmentAnswer::answer => Str::title('Month or longer'),
                RiskAssessmentAnswer::answer_slug => Str::slug('Month or longer', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentAnswer::weight => 4,
                RiskAssessmentAnswer::is_active => false
            ],
            [
                RiskAssessmentAnswer::question_id => 8,
                RiskAssessmentAnswer::answer => Str::title('No travel'),
                RiskAssessmentAnswer::answer_slug => Str::slug('No travel', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentAnswer::weight => 0,
                RiskAssessmentAnswer::is_active => false
            ],
            [
                RiskAssessmentAnswer::question_id => 9,
                RiskAssessmentAnswer::answer => Str::title('Male'),
                RiskAssessmentAnswer::answer_slug => Str::slug('Male', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentAnswer::weight => 7,
                RiskAssessmentAnswer::is_active => true
            ],
            [
                RiskAssessmentAnswer::question_id => 9,
                RiskAssessmentAnswer::answer => Str::title('Female'),
                RiskAssessmentAnswer::answer_slug => Str::slug('Female', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentAnswer::weight => 7,
                RiskAssessmentAnswer::is_active => true
            ],
            [
                RiskAssessmentAnswer::question_id => 9,
                RiskAssessmentAnswer::answer => Str::title('Both including Transgender'),
                RiskAssessmentAnswer::answer_slug => Str::slug('Both including Transgender', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentAnswer::weight => 7,
                RiskAssessmentAnswer::is_active => true
            ],
            [
                RiskAssessmentAnswer::question_id => 10,
                RiskAssessmentAnswer::answer => Str::title('10 to 14 years'),
                RiskAssessmentAnswer::answer_slug => Str::slug('10 to 14 years', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentAnswer::weight => 5,
                RiskAssessmentAnswer::is_active => true
            ],
            [
                RiskAssessmentAnswer::question_id => 10,
                RiskAssessmentAnswer::answer => Str::title('15 to 24 years'),
                RiskAssessmentAnswer::answer_slug => Str::slug('15 to 24 years', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentAnswer::weight => 3,
                RiskAssessmentAnswer::is_active => true
            ],
            [
                RiskAssessmentAnswer::question_id => 10,
                RiskAssessmentAnswer::answer => Str::title('25 to 49 years'),
                RiskAssessmentAnswer::answer_slug => Str::slug('25 to 49 years', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentAnswer::weight => 2,
                RiskAssessmentAnswer::is_active => true
            ],
            [
                RiskAssessmentAnswer::question_id => 10,
                RiskAssessmentAnswer::answer => Str::title('Never'),
                RiskAssessmentAnswer::answer_slug => Str::slug('Never', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentAnswer::weight => 0,
                RiskAssessmentAnswer::is_active => true
            ],
            [
                RiskAssessmentAnswer::question_id => 11,
                RiskAssessmentAnswer::answer => Str::title('Receptive Anal Intercourse (Receiving Penetration in the Anus)'),
                RiskAssessmentAnswer::answer_slug => Str::slug('Receptive Anal Intercourse (Receiving Penetration in the Anus)', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentAnswer::weight => 2,
                RiskAssessmentAnswer::is_active => true
            ],
            [
                RiskAssessmentAnswer::question_id => 11,
                RiskAssessmentAnswer::answer => Str::title('Insertive Anal Intercourse (Performing Penetration in Partner’s Anus)'),
                RiskAssessmentAnswer::answer_slug => Str::slug('Insertive Anal Intercourse (Performing Penetration in Partner’s Anus)', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentAnswer::weight => 5,
                RiskAssessmentAnswer::is_active => true
            ],
            [
                RiskAssessmentAnswer::question_id => 11,
                RiskAssessmentAnswer::answer => Str::title('Receptive Vaginal Intercourse (Receiving Penetration in the Vagina)'),
                RiskAssessmentAnswer::answer_slug => Str::slug('Receptive Vaginal Intercourse (Receiving Penetration in the Vagina)', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentAnswer::weight => 10,
                RiskAssessmentAnswer::is_active => true
            ],
            [
                RiskAssessmentAnswer::question_id => 11,
                RiskAssessmentAnswer::answer => Str::title('Insertive Vaginal Intercourse (Performing Penetration in Partner’s Vagina)'),
                RiskAssessmentAnswer::answer_slug => Str::slug('Insertive Vaginal Intercourse (Performing Penetration in Partner’s Vagina)', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentAnswer::weight => 5,
                RiskAssessmentAnswer::is_active => true
            ],
            [
                RiskAssessmentAnswer::question_id => 11,
                RiskAssessmentAnswer::answer => Str::title('Receptive Oral Intercourse (Receiving Oral Stimulation of the Vagina/Penis)'),
                RiskAssessmentAnswer::answer_slug => Str::slug('Receptive Oral Intercourse (Receiving Oral Stimulation of the Vagina/Penis)', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentAnswer::weight => 5,
                RiskAssessmentAnswer::is_active => true
            ],
            [
                RiskAssessmentAnswer::question_id => 11,
                RiskAssessmentAnswer::answer => Str::title('Insertive Oral Intercourse (Performing Oral Stimulation on Partner’s Vagina/Penis)'),
                RiskAssessmentAnswer::answer_slug => Str::slug('Insertive Oral Intercourse (Performing Oral Stimulation on Partner’s Vagina/Penis)', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentAnswer::weight => 2,
                RiskAssessmentAnswer::is_active => true
            ],
            [
                RiskAssessmentAnswer::question_id => 12,
                RiskAssessmentAnswer::answer => Str::title('Yes - All the time'),
                RiskAssessmentAnswer::answer_slug => Str::slug('Yes - All the time', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentAnswer::weight => -2,
                RiskAssessmentAnswer::is_active => true
            ],
            [
                RiskAssessmentAnswer::question_id => 12,
                RiskAssessmentAnswer::answer => Str::title('No'),
                RiskAssessmentAnswer::answer_slug => Str::slug('No', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentAnswer::weight => 15,
                RiskAssessmentAnswer::is_active => true
            ],
            [
                RiskAssessmentAnswer::question_id => 12,
                RiskAssessmentAnswer::answer => Str::title('Sometimes'),
                RiskAssessmentAnswer::answer_slug => Str::slug('Sometimes', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentAnswer::weight => 2,
                RiskAssessmentAnswer::is_active => true
            ],
            [
                RiskAssessmentAnswer::question_id => 13,
                RiskAssessmentAnswer::answer => Str::title('Yes- Most of the time'),
                RiskAssessmentAnswer::answer_slug => Str::slug('Yes- Most of the time', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentAnswer::weight => 10,
                RiskAssessmentAnswer::is_active => true
            ],
            [
                RiskAssessmentAnswer::question_id => 13,
                RiskAssessmentAnswer::answer => Str::title('No'),
                RiskAssessmentAnswer::answer_slug => Str::slug('No', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentAnswer::weight => 0,
                RiskAssessmentAnswer::is_active => true
            ],
            [
                RiskAssessmentAnswer::question_id => 13,
                RiskAssessmentAnswer::answer => Str::title('Sometimes'),
                RiskAssessmentAnswer::answer_slug => Str::slug('Sometimes', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentAnswer::weight => 1,
                RiskAssessmentAnswer::is_active => true
            ],
            [
                RiskAssessmentAnswer::question_id => 14,
                RiskAssessmentAnswer::answer => Str::title('Yes'),
                RiskAssessmentAnswer::answer_slug => Str::slug('Yes', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentAnswer::weight => 2,
                RiskAssessmentAnswer::is_active => true
            ],
            [
                RiskAssessmentAnswer::question_id => 14,
                RiskAssessmentAnswer::answer => Str::title('Sometimes'),
                RiskAssessmentAnswer::answer_slug => Str::slug('Sometimes', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentAnswer::weight => 1,
                RiskAssessmentAnswer::is_active => true
            ],
            [
                RiskAssessmentAnswer::question_id => 14,
                RiskAssessmentAnswer::answer => Str::title('Not using the injectable equipment'),
                RiskAssessmentAnswer::answer_slug => Str::slug('Not using the injectable equipment', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentAnswer::weight => 0,
                RiskAssessmentAnswer::is_active => true
            ],
            [
                RiskAssessmentAnswer::question_id => 15,
                RiskAssessmentAnswer::answer => Str::title('Yes'),
                RiskAssessmentAnswer::answer_slug => Str::slug('Yes', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentAnswer::weight => 8,
                RiskAssessmentAnswer::is_active => true
            ],
            [
                RiskAssessmentAnswer::question_id => 15,
                RiskAssessmentAnswer::answer => Str::title('No'),
                RiskAssessmentAnswer::answer_slug => Str::slug('No', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentAnswer::weight => 0,
                RiskAssessmentAnswer::is_active => true
            ],
            [
                RiskAssessmentAnswer::question_id => 15,
                RiskAssessmentAnswer::answer => Str::title('Sometimes'),
                RiskAssessmentAnswer::answer_slug => Str::slug('Sometimes', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentAnswer::weight => 2,
                RiskAssessmentAnswer::is_active => true
            ],
            [
                RiskAssessmentAnswer::question_id => 16,
                RiskAssessmentAnswer::answer => Str::title('Yes'),
                RiskAssessmentAnswer::answer_slug => Str::slug('Yes', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentAnswer::weight => 10,
                RiskAssessmentAnswer::is_active => true
            ],
            [
                RiskAssessmentAnswer::question_id => 16,
                RiskAssessmentAnswer::answer => Str::title('No'),
                RiskAssessmentAnswer::answer_slug => Str::slug('No', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentAnswer::weight => 0,
                RiskAssessmentAnswer::is_active => true
            ],
            [
                RiskAssessmentAnswer::question_id => 17,
                RiskAssessmentAnswer::answer => Str::title('Regularly'),
                RiskAssessmentAnswer::answer_slug => Str::slug('Regularly', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentAnswer::weight => -3,
                RiskAssessmentAnswer::is_active => true
            ],
            [
                RiskAssessmentAnswer::question_id => 17,
                RiskAssessmentAnswer::answer => Str::title('No'),
                RiskAssessmentAnswer::answer_slug => Str::slug('No', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentAnswer::weight => 1,
                RiskAssessmentAnswer::is_active => true
            ],
            [
                RiskAssessmentAnswer::question_id => 18,
                RiskAssessmentAnswer::answer => Str::title('0-3 months'),
                RiskAssessmentAnswer::answer_slug => Str::slug('0-3 months', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentAnswer::weight => 0,
                RiskAssessmentAnswer::is_active => true
            ],
            [
                RiskAssessmentAnswer::question_id => 18,
                RiskAssessmentAnswer::answer => Str::title('3-12 months'),
                RiskAssessmentAnswer::answer_slug => Str::slug('3-12 months', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentAnswer::weight => 1,
                RiskAssessmentAnswer::is_active => true
            ],
            [
                RiskAssessmentAnswer::question_id => 18,
                RiskAssessmentAnswer::answer => Str::title('More than 12 months'),
                RiskAssessmentAnswer::answer_slug => Str::slug('More than 12 months', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentAnswer::weight => 2,
                RiskAssessmentAnswer::is_active => true
            ],
            [
                RiskAssessmentAnswer::question_id => 18,
                RiskAssessmentAnswer::answer => Str::title('Never tested'),
                RiskAssessmentAnswer::answer_slug => Str::slug('Never tested', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentAnswer::weight => 3,
                RiskAssessmentAnswer::is_active => true
            ],
            [
                RiskAssessmentAnswer::question_id => 19,
                RiskAssessmentAnswer::answer => Str::title('Weight loss of more than 5 kg over 3 months.'),
                RiskAssessmentAnswer::answer_slug => Str::slug('Weight loss of more than 5 kg over 3 months.', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentAnswer::weight => 8,
                RiskAssessmentAnswer::is_active => true
            ],
            [
                RiskAssessmentAnswer::question_id => 19,
                RiskAssessmentAnswer::answer => Str::title('Persistent cold and flu in the past 6 months.'),
                RiskAssessmentAnswer::answer_slug => Str::slug('Persistent cold and flu in the past 6 months.', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentAnswer::weight => 1,
                RiskAssessmentAnswer::is_active => false
            ],
            [
                RiskAssessmentAnswer::question_id => 19,
                RiskAssessmentAnswer::answer => Str::title('Persistent diarrhoea and fatigue in the past 30 days.'),
                RiskAssessmentAnswer::answer_slug => Str::slug('Persistent diarrhoea and fatigue in the past 30 days.', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentAnswer::weight => 1,
                RiskAssessmentAnswer::is_active => false
            ],
            [
                RiskAssessmentAnswer::question_id => 19,
                RiskAssessmentAnswer::answer => Str::title('Recurring night sweats in the past few months.'),
                RiskAssessmentAnswer::answer_slug => Str::slug('Recurring night sweats in the past few months.', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentAnswer::weight => 8,
                RiskAssessmentAnswer::is_active => true
            ],
            [
                RiskAssessmentAnswer::question_id => 19,
                RiskAssessmentAnswer::answer => Str::title('White patches in the mouth.'),
                RiskAssessmentAnswer::answer_slug => Str::slug('White patches in the mouth.', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentAnswer::weight => 1,
                RiskAssessmentAnswer::is_active => false
            ],
            [
                RiskAssessmentAnswer::question_id => 19,
                RiskAssessmentAnswer::answer => Str::title('Bad breath.'),
                RiskAssessmentAnswer::answer_slug => Str::slug('Bad breath.', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentAnswer::weight => 1,
                RiskAssessmentAnswer::is_active => false
            ],
            [
                RiskAssessmentAnswer::question_id => 19,
                RiskAssessmentAnswer::answer => Str::title('Sore throat.'),
                RiskAssessmentAnswer::answer_slug => Str::slug('Sore throat.', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentAnswer::weight => 1,
                RiskAssessmentAnswer::is_active => false
            ],
            [
                RiskAssessmentAnswer::question_id => 19,
                RiskAssessmentAnswer::answer => Str::title('Ulcers.'),
                RiskAssessmentAnswer::answer_slug => Str::slug('Ulcers.', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentAnswer::weight => 1,
                RiskAssessmentAnswer::is_active => false
            ],
            [
                RiskAssessmentAnswer::question_id => 19,
                RiskAssessmentAnswer::answer => Str::title('Difficulty in eating.'),
                RiskAssessmentAnswer::answer_slug => Str::slug('Difficulty in eating.', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentAnswer::weight => 1,
                RiskAssessmentAnswer::is_active => false
            ],
            [
                RiskAssessmentAnswer::question_id => 19,
                RiskAssessmentAnswer::answer => Str::title('Dry cough.'),
                RiskAssessmentAnswer::answer_slug => Str::slug('Dry cough.', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentAnswer::weight => 1,
                RiskAssessmentAnswer::is_active => false
            ],
            [
                RiskAssessmentAnswer::question_id => 19,
                RiskAssessmentAnswer::answer => Str::title('Wet cough for more than 3 weeks in the past 1 year.'),
                RiskAssessmentAnswer::answer_slug => Str::slug('Wet cough for more than 3 weeks in the past 1 year.', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentAnswer::weight => 5,
                RiskAssessmentAnswer::is_active => true
            ],
            [
                RiskAssessmentAnswer::question_id => 19,
                RiskAssessmentAnswer::answer => Str::title('Blood in cough in the past 1 year'),
                RiskAssessmentAnswer::answer_slug => Str::slug('Blood in cough in the past 1 year', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentAnswer::weight => 5,
                RiskAssessmentAnswer::is_active => true
            ],
            [
                RiskAssessmentAnswer::question_id => 19,
                RiskAssessmentAnswer::answer => Str::title('Persistent fever or chills for no known reasons in the past 1 year'),
                RiskAssessmentAnswer::answer_slug => Str::slug('Persistent fever or chills for no known reasons in the past 1 year', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentAnswer::weight => 5,
                RiskAssessmentAnswer::is_active => true
            ],
            [
                RiskAssessmentAnswer::question_id => 19,
                RiskAssessmentAnswer::answer => Str::title('Persistent shortness of breath or chest pain in the past 1 year'),
                RiskAssessmentAnswer::answer_slug => Str::slug('Persistent shortness of breath or chest pain in the past 1 year', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentAnswer::weight => 2,
                RiskAssessmentAnswer::is_active => false
            ],
            [
                RiskAssessmentAnswer::question_id => 19,
                RiskAssessmentAnswer::answer => Str::title('None of the above'),
                RiskAssessmentAnswer::answer_slug => Str::slug('None of the above 19', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentAnswer::weight => 0,
                RiskAssessmentAnswer::is_active => true
            ],
            [
                RiskAssessmentAnswer::question_id => 20,
                RiskAssessmentAnswer::answer => Str::title('Genital warts (small bumps on genitals)'),
                RiskAssessmentAnswer::answer_slug => Str::slug('Genital warts (small bumps on genitals)', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentAnswer::weight => 1,
                RiskAssessmentAnswer::is_active => true
            ],
            [
                RiskAssessmentAnswer::question_id => 20,
                RiskAssessmentAnswer::answer => Str::title('Genital herpes (genital pains or sore genitals and open sores on genitals)'),
                RiskAssessmentAnswer::answer_slug => Str::slug('Genital herpes (genital pains or sore genitals and open sores on genitals)', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentAnswer::weight => 1,
                RiskAssessmentAnswer::is_active => true
            ],
            [
                RiskAssessmentAnswer::question_id => 20,
                RiskAssessmentAnswer::answer => Str::title('Gonorrhea (bacterial infection: white or yellow liquid visible in genital region)'),
                RiskAssessmentAnswer::answer_slug => Str::slug('Gonorrhea (bacterial infection: white or yellow liquid visible in genital region)', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentAnswer::weight => 1,
                RiskAssessmentAnswer::is_active => true
            ],
            [
                RiskAssessmentAnswer::question_id => 20,
                RiskAssessmentAnswer::answer => Str::title('Syphilis (rash on the body or painless sore on genitals, rectum, or mouth)'),
                RiskAssessmentAnswer::answer_slug => Str::slug('Syphilis (rash on the body or painless sore on genitals, rectum, or mouth)', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentAnswer::weight => 1,
                RiskAssessmentAnswer::is_active => true
            ],
            [
                RiskAssessmentAnswer::question_id => 20,
                RiskAssessmentAnswer::answer => Str::title('Gonococcal (painful urination and abnormal discharge from penis or vagina)'),
                RiskAssessmentAnswer::answer_slug => Str::slug('Gonococcal (painful urination and abnormal discharge from penis or vagina)', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentAnswer::weight => 1,
                RiskAssessmentAnswer::is_active => true
            ],
            [
                RiskAssessmentAnswer::question_id => 20,
                RiskAssessmentAnswer::answer => Str::title('None'),
                RiskAssessmentAnswer::answer_slug => Str::slug('None 20', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentAnswer::weight => 1,
                RiskAssessmentAnswer::is_active => true
            ],
            [
                RiskAssessmentAnswer::question_id => 21,
                RiskAssessmentAnswer::answer => Str::title('Sexually abused'),
                RiskAssessmentAnswer::answer_slug => Str::slug('Sexually abused', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentAnswer::weight => 2,
                RiskAssessmentAnswer::is_active => false
            ],
            [
                RiskAssessmentAnswer::question_id => 21,
                RiskAssessmentAnswer::answer => Str::title('Bitten'),
                RiskAssessmentAnswer::answer_slug => Str::slug('Bitten', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentAnswer::weight => 1,
                RiskAssessmentAnswer::is_active => false
            ],
            [
                RiskAssessmentAnswer::question_id => 21,
                RiskAssessmentAnswer::answer => Str::title('None of the above'),
                RiskAssessmentAnswer::answer_slug => Str::slug('None of the above', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentAnswer::weight => 0,
                RiskAssessmentAnswer::is_active => false
            ],
            [
                RiskAssessmentAnswer::question_id => 9,
                RiskAssessmentAnswer::answer => Str::title('Asexual'),
                RiskAssessmentAnswer::answer_slug => Str::slug('Asexual', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentAnswer::weight => 0,
                RiskAssessmentAnswer::is_active => true
            ],
            [
                RiskAssessmentAnswer::question_id => 3,
                RiskAssessmentAnswer::answer => Str::title('Other'),
                RiskAssessmentAnswer::answer_slug => Str::slug('Other', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentAnswer::weight => 0,
                RiskAssessmentAnswer::is_active => true
            ],
            [
                RiskAssessmentAnswer::question_id => 17,
                RiskAssessmentAnswer::answer => Str::title('Intermittent'),
                RiskAssessmentAnswer::answer_slug => Str::slug('Intermittent', '-', Config::get('app.locale'), SLUG_DICTIONARY),
                RiskAssessmentAnswer::weight => 0,
                RiskAssessmentAnswer::is_active => true
            ]
        ];

        

        Schema::disableForeignKeyConstraints();
        RiskAssessmentAnswer::truncate();
        RiskAssessmentAnswer::insert($data);
    }
}