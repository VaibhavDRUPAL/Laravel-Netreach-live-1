<?php

namespace App\Imports\Sheets\Outreach;

use App\Models\{CentreMaster, ClientType, ReasonForNotAccessingService, ServiceType, STIService, TIService};
use App\Models\Outreach\{Profile, ReferralService};
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\{WithHeadingRow, SkipsEmptyRows, WithMapping};
use PhpOffice\PhpSpreadsheet\Shared\Date;


class ReferralServiceImport implements WithHeadingRow, SkipsEmptyRows, WithMapping
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
            ClientType::client_type  => !empty($data[ClientType::client_type]) ? $data[ClientType::client_type] : null,
            ServiceType::service_type  => !empty($data[ServiceType::service_type]) ? $data[ServiceType::service_type] : null,
            ServiceType::other_service  => !empty($data[ServiceType::other_service]) ? Str::squish($data[ServiceType::other_service]) : null,
            TIService::ti_service  => !empty($data[TIService::ti_service]) ? $data[TIService::ti_service] : null,
            TIService::other_ti_service  => !empty($data[TIService::other_ti_service]) ? $data[TIService::other_ti_service] : null,
            ReferralService::counselling_service  => !empty($data[ReferralService::counselling_service]) ? $data[ReferralService::counselling_service] : null,
            ReferralService::prevention_programme  => !empty($data[ReferralService::prevention_programme]) ? $data[ReferralService::prevention_programme] : null,
            ReferralService::type_of_facility_where_referred  => !empty($data[ReferralService::type_of_facility_where_referred]) ? $data[ReferralService::type_of_facility_where_referred] : null,
            ReferralService::referral_date  => !empty($data[ReferralService::referral_date]) && is_numeric($data[ReferralService::referral_date]) ? Date::excelToDateTimeObject($data[ReferralService::referral_date])->format(DEFAULT_DATE_FORMAT)  : null,
            CentreMaster::center_name  => !empty($data[CentreMaster::center_name]) ? Str::lower(Str::squish($data[CentreMaster::center_name]))  : null,
            ReferralService::referred_state  => !empty($data[ReferralService::referred_state]) ? $data[ReferralService::referred_state]  : null,
            ReferralService::referred_district  => !empty($data[ReferralService::referred_district]) ? $data[ReferralService::referred_district]  : null,
            ReferralService::type_of_facility_where_tested  => !empty($data[ReferralService::type_of_facility_where_tested]) ? Str::squish($data[ReferralService::type_of_facility_where_tested])  : null,
            ReferralService::name_of_different_center  => !empty($data[ReferralService::name_of_different_center]) ? Str::squish($data[ReferralService::name_of_different_center])  : null,
            ReferralService::test_centre_state  => !empty($data[ReferralService::test_centre_state]) ? Str::squish($data[ReferralService::test_centre_state])  : null,
            ReferralService::test_centre_district  => !empty($data[ReferralService::test_centre_district]) ? Str::squish($data[ReferralService::test_centre_district])  : null,
            ReferralService::date_of_accessing_service  => !empty($data[ReferralService::date_of_accessing_service]) && is_numeric($data[ReferralService::date_of_accessing_service]) ? Date::excelToDateTimeObject($data[ReferralService::date_of_accessing_service])->format(DEFAULT_DATE_FORMAT)  : null,
            ReferralService::applicable_for_hiv_test  => !empty($data[ReferralService::applicable_for_hiv_test]) ? $data[ReferralService::applicable_for_hiv_test] : null,
            STIService::sti_service  => !empty($data[STIService::sti_service]) ? $data[STIService::sti_service] : null,
            STIService::other_sti_service  => !empty($data[STIService::other_sti_service]) ? $data[STIService::other_sti_service] : null,
            ReferralService::pid_or_other_unique_id_of_the_service_center  => !empty($data[ReferralService::pid_or_other_unique_id_of_the_service_center]) ? $data[ReferralService::pid_or_other_unique_id_of_the_service_center] : null,
            ReferralService::outcome_of_the_service_sought  => !empty($data[ReferralService::outcome_of_the_service_sought]) ? $data[ReferralService::outcome_of_the_service_sought] : null,
            ReasonForNotAccessingService::reason_for_not_accessing_service  => !empty($data[ReasonForNotAccessingService::reason_for_not_accessing_service]) ? $data[ReasonForNotAccessingService::reason_for_not_accessing_service] : null,
            ReferralService::other_not_access  => !empty($data[ReferralService::other_not_access]) ? $data[ReferralService::other_not_access] : null,
            ReferralService::follow_up_date  => !empty($data[ReferralService::follow_up_date]) ? $data[ReferralService::follow_up_date] : null,
            ReferralService::remarks  => !empty($data[ReferralService::remarks]) ? $data[ReferralService::follow_up_date] : null
        ];
    }
}
