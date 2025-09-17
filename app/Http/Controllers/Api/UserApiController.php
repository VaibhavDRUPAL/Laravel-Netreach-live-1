<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\CentreMaster;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Common\{SMS, WhatsApp};
use App\Models\OTPMaster;
use App\Models\BookAppinmentMaster;
use App\Models\StateMaster;
use App\Models\DistrictMaster;
use App\Models\Availability;
//    use Illuminate\Support\Facades\Validator;

class UserApiController extends Controller
{

 

    protected function getRiskLevel($percentage)
    {
        if ($percentage >= 75) {
            return 'Very High Risk';
        } elseif ($percentage >= 50) {
            return 'High Risk';
        } elseif ($percentage >= 25) {
            return 'Medium Risk';
        } else {
            return 'Low Risk';
        }
    }
 


    public function getUserDetails(Request $request)
{
    $user = $request->user(); // or auth()->user()

    if (!$user) {
        return response()->json([
            'status' => false,
            'message' => 'Unauthenticated'
        ], 401);
    }

    return response()->json([
        'status' => true,
        'message' => 'User details fetched successfully',
        'user' => $user,
    ]);
}


    public function sendOTP(Request $request)
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


    public function verifyOTP(Request $request)
    {

        $request->validate([
            'mobile_number' => 'required|digits:10|regex:' . MOB_REGEX,
            'otp'           => 'required|digits:4',
        ]);

        $mobileNo = $request->mobile_number;
        $otpData = OTPMaster::where('phone_no', $mobileNo)
            ->where('otp', $request->otp)
            ->first();

        if (!$otpData) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid OTP'
            ], 401);
        }

        // OTP valid → user check
        $user = User::where('phone_number', $mobileNo)->first();

        if (!$user) {
            $user = User::create([
                'phone_number' => $mobileNo,
                'name' => 'New User'
            ]);
        }

        // Login token
        $token = $user->createToken('API Token')->plainTextToken;

        // OTP delete after use
        $otpData->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Login successful',
            'token'   => $token,
            'user'    => $user
        ]);
    }


     public function updateUser(Request $request)
    {
        $user = $request->user(); // or auth()->user()

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthenticated'
            ], 401);
        }


        // ✅ Validation for update
        $request->validate([
            'email'    => 'nullable|email',
            'name'     => 'nullable|string|max:100',
            'password' => 'nullable|string|min:6'
        ]);

        $updateData = [];

        if ($request->filled('name')) {
            $updateData['name'] = $request->name;
        }

        if ($request->filled('email')) {
            $updateData['email'] = $request->email;
        }

        if ($request->filled('password')) {
            $updateData['txt_password'] = $request->password;
            $updateData['password']     = Hash::make($request->password);
        }

        // ✅ Update details
        $user->update($updateData);

        return response()->json([
            'status'  => 'success',
            'message' => 'User details updated successfully',
            'user'    => $user
        ]);
       
    }

    public function book_appointment(Request $request){
        $user_id =183;
        $request->validate([
            'service' => 'required',
            'state' => 'required',
            'district' => 'required',
            'testing_center' => 'required',
            'appointment_date' => 'required|date',
        ]);

        // Create the booking record
        $appointment = BookAppinmentMaster::create([
            'user_id' => $user_id,
            'state_id' => $request->state,
            // Assuming 'service' corresponds to 'survey_id'
            'survey_id' => $request->service,
            'district_id' => $request->district,
            // Assuming 'testing_center' corresponds to 'center_ids'
            'center_ids' => $request->testing_center,
            'appoint_date' => $request->appointment_date,
            // You may need to fill other fields like 'serach_by' and 'pincode' if available in the request
        ]);

        // Generate the unique ID and update the booking record
        $uniqueId = $this->generateUniqueId($appointment->id);
        $appointment->survey_unique_ids = $uniqueId;
        $appointment->save();

        return response()->json([
            'status' => true,
            'message' => 'Appointment booked successfully.',
            'booking_id' => $appointment->id,
            'unique_id' => $uniqueId,
        ]);

          

    }

     private function generateUniqueId($bookingId)
            {
                // Format: NETREACH/HR/SELF/7464
                // The last part is a number (e.g., booking ID) that can be padded with zeros for a consistent length.
                $paddedId = str_pad($bookingId, 4, '0', STR_PAD_LEFT);
                return 'NETREACH/HR/SELF/' . $paddedId;
            }


    public function questionnaire(Request $request)
    {
        // 1. प्रश्नों और उनके भार (weights) को परिभाषित करें
        $weights = [
            'age' => [
                '18-29' => 8,
                '30-39' => 2,
                '40-49' => 1,
                '50+' => 1,
            ],
            'gender' => [
                'Male' => 3,
                'Female' => 2,
                'Transgender' => 4,
            ],
            // Annexure I के अनुसार State के भार (weights) यहाँ जोड़ें
            'state' => [
                // उदाहरण: 'Uttar Pradesh' => 9, 'Delhi' => 5
                // आपको अपने डेटाबेस या एनेक्सचर से यह डेटा डालना होगा।
            ],
            'migrant_worker' => [
                'Yes' => 3,
                'No' => 0,
            ],
            'sexual_attraction' => [
                'Male' => 7,
                'Female' => 7,
                'Both including Transgender' => 7,
                'Asexual' => 0,
            ],
            'first_sex_age' => [
                '10-14' => 5,
                '15-24' => 3,
                '25-49' => 2,
                'Never' => 0,
            ],
            'sexual_activities' => [
                'Anal receptive' => 2,
                'Anal insertive' => 5,
                'Vaginal receptive' => 10,
                'Vaginal insertive' => 5,
                'Oral receptive' => 5,
                'Oral insertive' => 2,
            ],
            'condom_use' => [
                'Yes- All the time' => -2,
                'No' => 15,
                'Sometime' => 2,
            ],
            'drugs_before_sex' => [
                'Yes- Most of the time' => 10,
                'No' => 0,
                'Sometime' => 1,
            ],
            'share_injecting_equipment' => [
                'Yes' => 2,
                'Sometime' => 1,
                'Not using the injectable equipment' => 0,
            ],
            'drink_before_sex' => [
                'Yes' => 8,
                'No' => 0,
                'Sometime' => 2,
            ],
            'multiple_partners' => [
                'Yes' => 10,
                'No' => 0,
            ],
            'prep' => [
                'Regularly' => -3,
                'Intermittent' => 0,
                'No' => 1,
            ],
            'hiv_test_time' => [
                '0-3 months' => 0,
                '3-12 months' => 1,
                'More than 12 months' => 2,
                'Never tested' => 3,
            ],
            'symptoms_1' => [ // प्रश्न 16
                'Weight loss' => 8,
                'Recurring night sweats' => 8,
                'Wet cough' => 5,
                'Blood in cough' => 5,
                'Persistent fever or chills' => 5,
                'None' => 0,
            ],
            'symptoms_2' => [ // प्रश्न 17
                'Genital warts' => 1,
                'Genital herpes' => 1,
                'Gonorrhoea' => 1,
                'Syphilis' => 1,
                'Gonococcal' => 1,
                'None' => 0,
            ],
        ];

        // 2. कुल संभावित भार (maximum possible score) की गणना करें
        $maxScore = 0;
        foreach ($weights as $question => $options) {
            // Check if the options array is not empty before finding the max value
            if (!empty($options)) { 
                $maxScore += max(array_values($options));
            }
        }

        // 3. Request data को वैलिडेट करें (एक बेसिक validation)
        $validated = $request->validate([
            'age' => 'required|string',
            'gender' => 'required|string',
            'state' => 'required|string',
            'migrant_worker' => 'required|string',
            'sexual_attraction' => 'required|string',
            'first_sex_age' => 'required|string',
            'sexual_activities' => 'required|array',
            'condom_use' => 'required|string',
            'drugs_before_sex' => 'required|string',
            'share_injecting_equipment' => 'required|string',
            'drink_before_sex' => 'required|string',
            'multiple_partners' => 'required|string',
            'prep' => 'required|string',
            'hiv_test_time' => 'required|string',
            'symptoms_1' => 'required|array',
            'symptoms_2' => 'required|array',
        ]);

        // 4. कुल स्कोर की गणना करें
        $totalScore = 0;
        
        // सामान्य प्रश्नों के लिए स्कोर जोड़ें
        foreach ($validated as $key => $value) {
            if (isset($weights[$key]) && !is_array($value)) {
                $totalScore += $weights[$key][$value] ?? 0;
            }
        }
        
        // मल्टी-सेलेक्ट प्रश्नों (प्रश्न 8, 16, 17) के लिए स्कोर जोड़ें
        foreach ($validated['sexual_activities'] as $activity) {
            $totalScore += $weights['sexual_activities'][$activity] ?? 0;
        }
        
        foreach ($validated['symptoms_1'] as $symptom) {
            $totalScore += $weights['symptoms_1'][$symptom] ?? 0;
        }

        foreach ($validated['symptoms_2'] as $symptom) {
            $totalScore += $weights['symptoms_2'][$symptom] ?? 0;
        }

        // 5. स्कोर प्रतिशत (percentage) की गणना करें
        $scorePercentage = ($totalScore / $maxScore) * 100;

        // 6. JSON response वापस करें
        return response()->json([
            'status' => true,
            'message' => 'Risk score calculated successfully.',
            'total_score' => $totalScore,
            'max_possible_score' => $maxScore,
            'score_percentage' => round($scorePercentage, 2) . '%',
            'risk_level' => $this->getRiskLevel($scorePercentage),
        ]);
    }

       public function get_state(){
        $states = StateMaster::get();
         return response()->json([
            'status' => true,
            'message' => 'data fetch successfully.',
            'states'   => $states           
        ]);
    }


    public function get_district(Request $request)
    {
        // Validate that state_id is provided in the request
        $request->validate([
            'state_id' => 'required|integer',
        ]);

        $stateId = $request->input('state_id');

        // Fetch districts by state_id
        $districts = DistrictMaster::where('state_id', $stateId)->get();

        // Return the districts as a JSON response
        return response()->json([
            'status' => 'success',
            'data' => $districts,
        ]);
    }
    // public function login(Request $request)
    // {
    //     // Validation
    //     $request->validate([
    //         'phone_number' => 'required|string|max:15',
    //         'password'     => 'nullable|string|min:6',
    //         'otp'          => 'nullable|string|min:4|max:6',
    //     ]);

    //     // User check
    //     $user = User::where('phone_number', $request->phone_number)->first();

    //     if (!$user) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Mobile number not found'
    //         ], 404);
    //     }

    //     // If password is given
    //     if ($request->filled('password')) {
    //         if (!Hash::check($request->password, $user->password)) {
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => 'Invalid password'
    //             ], 401);
    //         }
    //     }
    //     // Else if OTP is given
    //     elseif ($request->filled('otp')) {
    //         if ($user->otp !== $request->otp) {
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => 'Invalid OTP'
    //             ], 401);
    //         }
    //     } else {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Please provide password or OTP'
    //         ], 422);
    //     }

    //     // ✅ Login success: Save user in session
    //     Auth::login($user);

    //     // ✅ (Optional) If API is being used, generate token also
    //     $token = $user->createToken('API Token')->plainTextToken;

    //     return response()->json([
    //         'status'  => true,
    //         'message' => 'Login successful',
    //         'token'   => $token,   // API ke liye
    //         'user'    => $user     // Website ke liye session me already login ho gaya hai
    //     ]);
    // }

    //     public function login(Request $request)
    // {
    //     $request->validate([
    //         'phone_number' => 'required|string|max:15',
    //         'password'     => 'nullable|string|min:6',
    //         'otp'          => 'nullable|string|min:4|max:6',
    //     ]);

    //     $user = User::where('phone_number', $request->phone_number)->first();

    //     if (!$user) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Mobile number not found'
    //         ], 404);
    //     }

    //     // If password is given, check password
    //     if ($request->filled('password')) {
    //         if (!Hash::check($request->password, $user->password)) {
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => 'Invalid password'
    //             ], 401);
    //         }
    //     }
    //     // Else if OTP is given, check OTP
    //     elseif ($request->filled('otp')) {
    //         if ($user->otp !== $request->otp) {
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => 'Invalid OTP'
    //             ], 401);
    //         }
    //     } else {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Please provide password or OTP'
    //         ], 422);
    //     }

    //     // If reached here, login success
    //     $token = $user->createToken('API Token')->plainTextToken;

    //     return response()->json([
    //         'status' => true,
    //         'message' => 'Login successful',
    //         'token'   => $token,
    //         'user'    => $user
    //     ]);
    // }

    // public function createUser(Request $request)
    // {
    //     $request->validate([
    //         'phone_number' => 'required|string|max:15',
    //         'name' => 'nullable|string|max:255',
    //         'email' => 'nullable|email',
    //         'password' => 'nullable|string|min:6',
    //         'role' => 'nullable|string'
    //     ]);

    //     // Mobile number check
    //     $existingUser = User::where('phone_number', $request->phone_number)->first();

    //     if ($existingUser) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'Account already exists with this mobile number',
    //             'user' => $existingUser
    //         ], 200);
    //     }

    //     // User create
    //     $userData = $request->only(['name', 'email', 'phone_number', 'txt_password']);
    //     $user = User::create($userData);

    //     if ($request->role) {
    //         $user->assignRole($request->role);
    //     }

    //     return response()->json([
    //         'status' => 'success',
    //         'message' => 'Account created successfully',
    //         'user' => $user
    //     ], 201);
    // }

   


        public function create_time_slot(Request $request)
        {
            $validator = Validator::make($request->all(), [
                'days' => 'required|array|min:1|max:7',
                'days.*.date' => 'required|date|after_or_equal:today',
                'days.*.time_slots' => 'required|array|min:1',
                'days.*.time_slots.*.start_time' => 'required|date_format:H:i',
                'days.*.time_slots.*.end_time'   => 'required|date_format:H:i',
            ]);

            $validator->after(function ($validator) use ($request) {
                foreach ($request->days as $dayIndex => $day) {
                    foreach ($day['time_slots'] as $slotIndex => $slot) {
                        if (strtotime($slot['end_time']) <= strtotime($slot['start_time'])) {
                            $validator->errors()->add(
                                "days.$dayIndex.time_slots.$slotIndex.end_time",
                                "End time must be after start time for slot #".($slotIndex+1)." on day ".($day['date'])
                            );
                        }
                    }
                }
            });

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            // If validation passes
            $userId = 1; // example
            $created = [];

            foreach ($request->days as $day) {
                foreach ($day['time_slots'] as $slot) {
                    $created[] = Availability::create([
                        'user_id'    => $userId,
                        'date'       => \Carbon\Carbon::parse($day['date'])->format('Y-m-d'),
                        'start_time' => $slot['start_time'],
                        'end_time'   => $slot['end_time'],
                    ]);
                }
            }

            return response()->json([
                'message' => 'Availability slots saved successfully',
                'data'    => $created
            ]);
        }

    
}
