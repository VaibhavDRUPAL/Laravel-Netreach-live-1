<?php

namespace App\Imports\Sheets\Outreach;

use App\Models\{ClientType, DistrictMaster, StateMaster, TargetPopulation};
use App\Models\Outreach\{Counselling, Profile, ReferralService};
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\{WithHeadingRow, SkipsEmptyRows, WithMapping};
use PhpOffice\PhpSpreadsheet\Shared\Date;

class CounsellingImport implements WithHeadingRow, SkipsEmptyRows, WithMapping
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
            Counselling::referred_from  => !empty($data[Counselling::referred_from]) ? $data[Counselling::referred_from] : null,
            Counselling::referral_source  => !empty($data[Counselling::referral_source]) ? $data[Counselling::referral_source] : null,
            Counselling::date_of_counselling  => !empty($data[Counselling::date_of_counselling]) && is_numeric($data[Counselling::date_of_counselling]) ? Date::excelToDateTimeObject($data[Counselling::date_of_counselling])->format(DEFAULT_DATE_FORMAT)  : null,
            Counselling::phone_number  => !empty($data[Counselling::phone_number]) ? $data[Counselling::phone_number] : null,
            StateMaster::state  => !empty($data[StateMaster::state]) ? $data[StateMaster::state] : null,
            DistrictMaster::district  => !empty($data[DistrictMaster::district]) ? $data[DistrictMaster::district] : null,
            Counselling::location  => !empty($data[Counselling::location]) ? $data[Counselling::location] : null,
            TargetPopulation::target_population  => !empty($data[TargetPopulation::target_population]) ? $data[TargetPopulation::target_population] : null,
            Counselling::other_target_population  => !empty($data[Counselling::other_target_population]) ? $data[Counselling::other_target_population] : null,
            Counselling::type_of_counselling_offered  => !empty($data[Counselling::type_of_counselling_offered]) ? $data[Counselling::type_of_counselling_offered] : null,
            Counselling::type_of_counselling_offered_other  => !empty($data[Counselling::type_of_counselling_offered_other]) ? $data[Counselling::type_of_counselling_offered_other] : null,
            Counselling::counselling_medium  => !empty($data[Counselling::counselling_medium]) ? $data[Counselling::counselling_medium] : null,
            Counselling::other_counselling_medium  => !empty($data[Counselling::other_counselling_medium]) ? $data[Counselling::other_counselling_medium] : null,
            Counselling::duration_of_counselling  => !empty($data[Counselling::duration_of_counselling]) ? $data[Counselling::duration_of_counselling] : null,
            Counselling::key_concerns_discussed  => !empty($data[Counselling::key_concerns_discussed]) ? ucwords(Str::squish($data[Counselling::key_concerns_discussed])) : null,
            Counselling::follow_up_date  => !empty($data[Counselling::follow_up_date]) && is_numeric($data[Counselling::follow_up_date]) ? Date::excelToDateTimeObject($data[Counselling::follow_up_date])->format(DEFAULT_DATE_FORMAT)  : null,
            Counselling::remarks  => !empty($data[Counselling::remarks]) ? $data[Counselling::remarks] : null
        ];
    }
}