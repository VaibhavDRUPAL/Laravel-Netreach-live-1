<?php

namespace Database\Seeders;

use App\Models\SelfModule\RiskAssessmentQuestionnaire;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UpdateQuestionnaireSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            1 => [
                1,
                2,
                3,
                6
            ],
            2 => [],
            3 => [
                9,
                10,
                11,
                12,
                13,
                14
            ],
            4 => [
                15,
                16,
                17,
                18,
                19
            ],
            5 => [
                20
            ]
        ];

        RiskAssessmentQuestionnaire::where(RiskAssessmentQuestionnaire::group_no, '!=', 0)->update([RiskAssessmentQuestionnaire::group_no => 0]);

        foreach ($data as $key => $value) {
            if (!empty($value)) {
                RiskAssessmentQuestionnaire::whereIn(RiskAssessmentQuestionnaire::question_id, $value)
                    ->update([
                        RiskAssessmentQuestionnaire::group_no => $key
                    ]);
            }
        }
    }
}
