<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DistrictMaster extends Model
{
    use HasFactory;

    const district = 'district';

    protected $table = 'district_master';

    public $timestamps = false;

    protected $fillable = [
        'state_id',
        'state_code',
        'district_code',
        'district_name',
        'district_name_mr',
        'district_name_hi',
        'district_name_ta',
        'district_name_te',
        'dst_cd',
        'st_cd'
    ];

    public function centres()
    {
        return $this->hasMany(CentreMaster::class, 'district_id', 'id');
    }
    public static function getOneDistrictName($id)
    {
        return DistrictMaster::where('id', $id)->pluck("district_name")->first();
    }
}
