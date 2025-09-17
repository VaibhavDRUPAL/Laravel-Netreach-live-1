<?php

namespace App\Models\SelfModule;

use App\Models\MeetCounsellorFollowUp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\StateMaster;

class MeetCounsellor extends Model
{
    use HasFactory;

    const meet_id = 'meet_id';
    const name = 'name';
    const mobile_no = 'mobile_no';
    const state_id = 'state_id';
    const state_name = 'state_name';
    const region = 'region';
    const message = 'message';
    const is_active = 'is_active';
    const is_deleted = 'is_deleted';
    const created_at = 'created_at';
    const meet_counsellor = 'meet_counsellor';

    // Table Details
    protected $table = self::meet_counsellor;
    protected $primaryKey = self::meet_id;


    // Fillable
    protected $fillable = [
        self::name,
        self::mobile_no,
        self::state_id,
        self::message,
        self::region,
        self::is_active,
        self::is_deleted,
        self::created_at
    ];


    public static function getAllData()
    {
        $data = DB::table(self::meet_counsellor);
        $count = $data->count();
        return ["data" => $data, "count" => $count];
    }
    public static function getRegionName($region)
    {
        $regions = [
            1 => 'North',
            2 => 'South',
            3 => 'East',
            4 => 'West'
        ];
        return $regions[$region] ?? 'Unknown';
    }
    public function followUps()
    {
        return $this->hasMany(MeetCounsellorFollowUp::class, 'meet_id', 'meet_id');
    }
}
