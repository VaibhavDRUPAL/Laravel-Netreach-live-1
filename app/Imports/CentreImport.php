<?php

namespace App\Imports;

use App\Models\CentreMaster;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class CentreImport implements ToModel, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    private $sid,$did;

    public function __construct($a,$b){
        $this->sid=$a;
        $this->did=$b;
    }

    public function startRow(): int
    {
        return 2;
    }

    public function model(array $row)
    {
        return new CentreMaster([                
            'name'  => $row[0],
            
            'address'  => $row[1],
            
            'pin_code'  => $row[2],
            
            'state_code'  => $this->sid,
            
            'district_id'  => $this->did,
            
            'services_avail'  => $row[3],
            
            'services_available'  => $row[4],
            
            'name_counsellor'  => isset($row[5])?$row[5]:'',
            
            'centre_contact_no'  => isset($row[6])?$row[6]:'',
            
            'incharge'  => $row[7],
            
            'contact_no'   => $row[8],
            'created_at'   => date('Y-m-d H:i:s')

        ]);
    }
}
