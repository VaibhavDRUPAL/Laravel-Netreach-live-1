<?php

namespace App\Imports\Sheets\Outreach;

use App\Models\{CentreMaster, ClientType, DistrictMaster, StateMaster};
use App\Models\Outreach\{PLHIV, Profile, ReferralService, STIService};
use App\Models\STIService as ParentSTIService;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\{WithHeadingRow, SkipsEmptyRows, WithMapping};
use PhpOffice\PhpSpreadsheet\Shared\Date;

class STILineListImport

implements WithHeadingRow, SkipsEmptyRows, WithMapping
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
            STIService::date_of_sti  => !empty($data[STIService::date_of_sti]) && is_numeric($data[STIService::date_of_sti]) ? Date::excelToDateTimeObject($data[STIService::date_of_sti])->format(DEFAULT_DATE_FORMAT)  : null,
            ClientType::client_type  => !empty($data[ClientType::client_type]) ? $data[ClientType::client_type] : null,
            STIService::pid_or_other_unique_id_of_the_service_center  => !empty($data[STIService::pid_or_other_unique_id_of_the_service_center]) ? $data[STIService::pid_or_other_unique_id_of_the_service_center]  : null,
            ParentSTIService::sti_service  => !empty($data[ParentSTIService::sti_service]) ? $data[ParentSTIService::sti_service] : null,
            STIService::applicable_for_syphillis  => !empty($data[STIService::applicable_for_syphillis]) ? $data[STIService::applicable_for_syphillis]  : null,
            STIService::treated  => !empty($data[STIService::treated]) && $data[STIService::treated] == 1 ? true  : false,
            STIService::type_facility_where_treated  => !empty($data[STIService::type_facility_where_treated]) ? $data[STIService::type_facility_where_treated]  : null,
            CentreMaster::center_name  => !empty($data[CentreMaster::center_name]) ? Str::lower(Str::squish($data[CentreMaster::center_name]))  : null,
            StateMaster::state  => !empty($data[StateMaster::state]) ? $data[StateMaster::state]  : null,
            DistrictMaster::district  => !empty($data[DistrictMaster::district]) ? $data[DistrictMaster::district]  : null,
            STIService::remarks  => !empty($data[STIService::remarks]) ? $data[STIService::remarks]  : null
        ];
    }
}
