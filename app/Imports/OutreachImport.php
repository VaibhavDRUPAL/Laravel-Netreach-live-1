<?php

namespace App\Imports;

use App\Imports\Sheets\Outreach\{CounsellingImport, PLHIVImport, ProfileImport, ReferralServiceImport, RiskAssessmentImport, STILineListImport};
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class OutreachImport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            'outreach' => new ProfileImport,
            'risk_assessment' => new RiskAssessmentImport,
            'referral' => new ReferralServiceImport,
            'plhiv' => new PLHIVImport,
            'sti_line_list' => new STILineListImport,
            'counselling' => new CounsellingImport
        ];
    }
}
