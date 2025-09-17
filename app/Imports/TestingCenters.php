<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\{SkipsEmptyRows, WithMapping, WithChunkReading, WithHeadingRow};
use Illuminate\Support\Str;

class TestingCenters implements WithMapping, WithHeadingRow, WithChunkReading, SkipsEmptyRows
{
    public function map($center): array
    {
        return [
            'center_name' => Str::lower(Str::squish($center['center_name'])),
            'address' => !empty($center['address']) ? Str::title(Str::squish($center['address'])) : null,
            'state' => !empty($center['state']) ? Str::lower(Str::squish($center['state'])) : null,
            'district' => !empty($center['district']) ? Str::lower(Str::squish($center['district'])) : null,
            'type_of_facility' => !empty($center['type_of_facility']) ? Str::squish($center['type_of_facility']) : null,
            'type_of_services' => !empty($center['type_of_services']) ? Str::squish($center['type_of_services']) : null,
            'name_counsellor' => !empty($center['name_of_counselor']) ? ucwords(Str::squish($center['name_of_counselor'])) : null,
            'contact_no' => !empty($center['phone_number']) ? Str::squish($center['phone_number']) : null
        ];
    }

    public function headingRow(): int
    {
        return 1;
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}