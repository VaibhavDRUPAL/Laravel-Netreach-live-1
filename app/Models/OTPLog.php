<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OTPLog extends Model
{
    use HasFactory;

    const otp_log_master = 'otp_log_master';
    const log_id = 'log_id';
    const mobile_no = 'mobile_no';
    const counter = 'counter';
    const created_at = 'created_at';

    // Table Details
    protected $table = self::otp_log_master;
    protected $primaryKey = self::log_id;
    public $timestamps = false;

    // Fillable
    protected $fillable = [
        self::mobile_no,
        self::counter,
        self::created_at
    ];

    // Add Log
    public static function addLog($mobile)
    {
        $data = self::where(self::mobile_no, $mobile);
        
        $exists = $data->exists();

        $data = $exists ? $data->increment(self::counter) : self::create([self::mobile_no => $mobile, self::created_at => currentDateTime()]);

        return $data ? $data : null;
    }
}
