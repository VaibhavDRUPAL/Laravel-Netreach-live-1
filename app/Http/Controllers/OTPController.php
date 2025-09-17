<?php

namespace App\Http\Controllers;

use App\Common\{SMS, WhatsApp};
use App\Models\OTPMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class OTPController extends Controller
{
    public static function sendOTP(Request $request)
    {
        $request->validate([
            'mobile_number' => 'required|digits:10|regex:' . MOB_REGEX,
        ]);

        $mobileNo = $request->input('mobile_number');

        OTPMaster::where('phone_no', $mobileNo)->delete();
        $otp = rand(1000, 9999);

        (new SMS)->sendOTP($otp, $mobileNo);

        (new WhatsApp)->sendOTP($otp, $mobileNo);

        OTPMaster::create([
            'otp' => $otp,
            'phone_no' => $mobileNo
        ]);

        $otp = App::isProduction() ? true : $otp;

        return response()->json(['status' => 'success', 'otp' => $otp]);
    }
}
