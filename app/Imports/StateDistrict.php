<?php

namespace App\Imports;

use App\Imports\Sheets\Districts;
use App\Imports\Sheets\States;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class StateDistrict implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            'state' => new States,
            'district' => new Districts
        ];
    }
}
