<?php

namespace App\Imports\Sheets;

use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMapping;

class States implements WithHeadingRow, WithMapping
{
    public function map($data): array
    {
        return [
            'state_code' => intval($data['state_code']),
            'state_name' => ucwords(Str::lower(Str::squish($data['state_name']))),
            'st_cd' => Str::upper(Str::squish($data['state_initials'])),
        ];
    }
    public function headingRow(): int
    {
        return 1;
    }
}
