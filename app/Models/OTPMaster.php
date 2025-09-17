<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OTPMaster extends Model
{
	//
	protected $table = 'otp_master';
	protected $fillable = ['phone_no', 'otp'];
}
