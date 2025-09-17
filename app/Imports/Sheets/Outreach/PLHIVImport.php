<?php

namespace App\Imports\Sheets\Outreach;

use App\Models\ClientType;
use App\Models\Outreach\{PLHIV, Profile, ReferralService};
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\{WithHeadingRow, SkipsEmptyRows, WithMapping};
use PhpOffice\PhpSpreadsheet\Shared\Date;


class PLHIVImport implements WithHeadingRow, SkipsEmptyRows, WithMapping
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
            ReferralService::netreach_uid_number  => !empty($data[ReferralService::netreach_uid_number]) ? Str::squish($data[ReferralService::netreach_uid_number]) : null,
            PLHIV::registration_date  => !empty($data[PLHIV::registration_date]) && is_numeric($data[PLHIV::registration_date]) ? Date::excelToDateTimeObject($data[PLHIV::registration_date])->format(DEFAULT_DATE_FORMAT)  : null,
            ClientType::client_type  => !empty($data[ClientType::client_type]) ? $data[ClientType::client_type] : null,
            PLHIV::pid_or_other_unique_id_of_the_service_center  => !empty($data[PLHIV::pid_or_other_unique_id_of_the_service_center]) ? $data[PLHIV::pid_or_other_unique_id_of_the_service_center]  : null,
            PLHIV::date_of_confirmatory  => !empty($data[PLHIV::date_of_confirmatory]) && is_numeric($data[PLHIV::date_of_confirmatory]) ? Date::excelToDateTimeObject($data[PLHIV::date_of_confirmatory])->format(DEFAULT_DATE_FORMAT)  : null,
            PLHIV::date_of_art_reg  => !empty($data[PLHIV::date_of_art_reg]) && is_numeric($data[PLHIV::date_of_art_reg]) ? Date::excelToDateTimeObject($data[PLHIV::date_of_art_reg])->format(DEFAULT_DATE_FORMAT)  : null,
            PLHIV::pre_art_reg_number  => !empty($data[PLHIV::pre_art_reg_number]) ? $data[PLHIV::pre_art_reg_number]  : null,
            PLHIV::date_of_on_art  => !empty($data[PLHIV::date_of_on_art]) && is_numeric($data[PLHIV::date_of_on_art]) ? Date::excelToDateTimeObject($data[PLHIV::date_of_on_art])->format(DEFAULT_DATE_FORMAT)  : null,
            PLHIV::on_art_reg_number  => !empty($data[PLHIV::on_art_reg_number]) ? $data[PLHIV::on_art_reg_number]  : null,
            PLHIV::type_of_facility_where_treatment_sought  => !empty($data[PLHIV::type_of_facility_where_treatment_sought]) ? $data[PLHIV::type_of_facility_where_treatment_sought]  : null,
            PLHIV::art_state  => !empty($data[PLHIV::art_state]) ? $data[PLHIV::art_state]  : null,
            PLHIV::art_district  => !empty($data[PLHIV::art_district]) ? $data[PLHIV::art_district]  : null,
            PLHIV::art_center  => !empty($data[PLHIV::art_center]) ? $data[PLHIV::art_center]  : null,
            PLHIV::remarks  => !empty($data[PLHIV::remarks]) ? $data[PLHIV::remarks]  : null
        ];
    }
}
