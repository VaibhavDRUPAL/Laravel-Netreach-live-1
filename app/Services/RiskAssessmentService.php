<?php

namespace App\Services;

use App\Models\SelfModule\RiskAssessmentQuestionnaire;

class RiskAssessmentService
{
    public function getAllQuestionnaire($request)
    {
        // Logic to get all questionnaires
        return RiskAssessmentQuestionnaire::all(); // Example, use actual logic
    }
}
