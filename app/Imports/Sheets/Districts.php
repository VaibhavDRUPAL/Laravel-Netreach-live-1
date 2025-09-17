<?php

namespace App\Imports\Sheets;

use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMapping;

class Districts implements WithMapping, WithHeadingRow
{
    public function map($data): array
    {
        return [
            'district_code' => intval($data['district_code']),
            'state_name' => ucwords(Str::lower(Str::squish($data['state_name_code']))),
            'district_name' => ucwords(Str::lower(Str::squish($data['district'])))
        ];
    }
    public function headingRow(): int
    {
        return 1;
    }
}
