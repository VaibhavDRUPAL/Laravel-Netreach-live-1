<?php

namespace App\Imports\Sheets\Outreach;

use App\Models\{ClientResponse, ClientType, DistrictMaster, EducationalAttainment, Occupation, Platform, StateMaster, TargetPopulation};
use App\Models\Outreach\Profile;
use Maatwebsite\Excel\Concerns\{WithHeadingRow, SkipsEmptyRows, WithMapping};
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Illuminate\Support\Str;

class ProfileImport implements WithHeadingRow, SkipsEmptyRows, WithMapping
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
            Profile::uid  => !empty($data[Profile::unique_serial_number]) ? Str::replace('/', UNDERSCORE, Str::squish($data[Profile::unique_serial_number])) : null,
            ClientType::client_type  => !empty($data[ClientType::client_type]) ? $data[ClientType::client_type] : null,
            Profile::registration_date  => !empty($data[Profile::registration_date]) && is_numeric($data[Profile::registration_date]) ? Date::excelToDateTimeObject($data[Profile::registration_date])->format(DEFAULT_DATE_FORMAT) : null,
            StateMaster::state => !empty($data[StateMaster::state]) ? $data[StateMaster::state] : null,
            DistrictMaster::district => !empty($data[DistrictMaster::district]) ? $data[DistrictMaster::district] : null,
            Profile::location => !empty($data[Profile::location]) ? ucwords(Str::squish($data[Profile::location])) : null,
            Profile::region_id => !empty($data[Profile::region_id]) ? ucwords(Str::squish($data[Profile::region_id])) : null,
            Platform::platform_name  => !empty($data[Platform::platform_name]) ? $data[Platform::platform_name] : null,
            Platform::others_platform  => !empty($data[Platform::others_platform]) ? $data[Platform::others_platform] : null,
            Profile::profile_name => ucwords(Str::squish($data[Profile::profile_name])),
            Profile::age => !empty($data[Profile::age]) ? $data[Profile::age] : null,
            Profile::gender => !empty($data[Profile::gender]) ? $data[Profile::gender] : null,
            Profile::other_gender => !empty($data[Profile::other_gender]) ? $data[Profile::other_gender] : null,
            TargetPopulation::target_population => !empty($data[TargetPopulation::target_population]) ? $data[TargetPopulation::target_population] : null,
            ClientResponse::client_response => !empty($data[ClientResponse::client_response]) ? $data[ClientResponse::client_response] : null,
            EducationalAttainment::educational_attainment => !empty($data[EducationalAttainment::educational_attainment]) ? $data[EducationalAttainment::educational_attainment] : null,
            Occupation::primary_occupation => !empty($data[Occupation::primary_occupation]) ? $data[Occupation::primary_occupation] : null,
            Occupation::other_occupation => !empty($data[Occupation::other_occupation]) ? $data[Occupation::other_occupation] : null,
            Platform::other_virtual_platform => !empty($data[Platform::other_virtual_platform]) ? $data[Platform::other_virtual_platform] : null,
            Profile::reached_out => !empty($data[Profile::reached_out]) ? $data[Profile::reached_out] : null,
            Profile::phone_number => !empty($data[Profile::phone_number]) ? Str::squish($data[Profile::phone_number]) : null,
            Profile::shared_website_link => !empty($data[Profile::shared_website_link]) ? $data[Profile::shared_website_link] : null,
            Profile::follow_up_date => !empty($data[Profile::follow_up_date]) && is_numeric($data[Profile::follow_up_date]) ? Date::excelToDateTimeObject($data[Profile::follow_up_date])->format(DEFAULT_DATE_FORMAT) : null,
            Profile::remarks => !empty($data[Profile::remarks]) ? Str::squish($data[Profile::remarks]) : null
        ];
    }
}
