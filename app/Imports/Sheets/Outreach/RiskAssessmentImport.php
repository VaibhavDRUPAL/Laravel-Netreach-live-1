<?php

namespace App\Imports\Sheets\Outreach;

use App\Models\{ClientType};
use App\Models\Outreach\{Profile, RiskAssessment};
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\{WithHeadingRow, SkipsEmptyRows, WithMapping};
use PhpOffice\PhpSpreadsheet\Shared\Date;

class RiskAssessmentImport implements WithHeadingRow, SkipsEmptyRows, WithMapping
{
    public function headingRow(): int
    {
        return 1;
    }

    public function map($data): array
    {
        foreach ($data as $key => $value)
            if (!empty($value) && !is_numeric($value))
                $data[$key] = removeNonPrintableCharacter($value);

        return [
            Profile::unique_serial_number  => !empty($data[Profile::unique_serial_number]) ? Str::lower(Str::squish($data[Profile::unique_serial_number])) : null,
            ClientType::client_type  => !empty($data[ClientType::client_type]) ? $data[ClientType::client_type] : null,
            RiskAssessment::date_of_risk_assessment  => !empty($data[RiskAssessment::date_of_risk_assessment]) && is_numeric($data[RiskAssessment::date_of_risk_assessment]) ? Date::excelToDateTimeObject($data[RiskAssessment::date_of_risk_assessment])->format(DEFAULT_DATE_FORMAT) : null,
            RiskAssessment::provided_client_with_information  => !empty($data[RiskAssessment::provided_client_with_information]) ? $data[RiskAssessment::provided_client_with_information] : null,
            RiskAssessment::types_of_information  => !empty($data[RiskAssessment::types_of_information]) ? Str::squish($data[RiskAssessment::types_of_information]) : null,
            RiskAssessment::had_sex_without_a_condom  => $data[RiskAssessment::had_sex_without_a_condom],
            RiskAssessment::shared_needle_for_injecting_drugs  => $data[RiskAssessment::shared_needle_for_injecting_drugs],
            RiskAssessment::sexually_transmitted_infection  => $data[RiskAssessment::sexually_transmitted_infection],
            RiskAssessment::sex_with_more_than_one_partners  => $data[RiskAssessment::sex_with_more_than_one_partners],
            RiskAssessment::had_chemical_stimulantion_or_alcohol_before_sex  => $data[RiskAssessment::had_chemical_stimulantion_or_alcohol_before_sex],
            RiskAssessment::had_sex_in_exchange_of_goods_or_money  => $data[RiskAssessment::had_sex_in_exchange_of_goods_or_money],
            RiskAssessment::other_reason_for_hiv_test  => $data[RiskAssessment::other_reason_for_hiv_test],
            RiskAssessment::risk_category  => !empty($data[RiskAssessment::risk_category]) ? (int) $data[RiskAssessment::risk_category] : null
        ];
    }
}
