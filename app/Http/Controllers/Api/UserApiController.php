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
use App\Models\Announcement;
use App\Models\Doctor;
use App\Models\VmMaster;
use App\Models\ServiceType;
use App\Models\SelfModule\RiskAssessmentQuestionnaire;
use App\Models\BookTeleconsultation;
//    use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

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
        // // dd($otpData);
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
        // // dd($user);
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthenticated'
            ], 401);
        }


         // ✅ Validation rules
            $request->validate([
                'email'           => 'nullable|email',
                'name'            => 'nullable|string|max:100',
                'last_name'       => 'nullable|string|max:100',
                'blood_group'     => 'nullable|string|max:10',
                'gender'          => 'nullable|string|max:10',
                'state'           => 'nullable|string|max:100',
                'district'        => 'nullable|string|max:100',
                'preferd_language'=> 'nullable|string|max:50',
                'user_type'       => 'nullable|string|max:50',
                'password'        => 'nullable|string|min:6',
            ]);

            // ✅ Prepare update data (jitna request me aaya ho)
            $updateData = $request->only([
                'name',
                'last_name',
                'email',
                'blood_group',
                'gender',
                'state',
                'district',
                'preferd_language',
                'user_type'
            ]);

            // ✅ Agar password aaya to hash bhi kare
            if ($request->filled('password')) {
                $updateData['txt_password'] = $request->password;
                $updateData['password']     = Hash::make($request->password);
            }

            // ✅ User ko update kare
            $user->update($updateData);

        return response()->json([
            'status'  => 'success',
            'message' => 'User details updated successfully',
            'user'    => $user
        ]);
       
    }

    
    public function book_appointments(Request $request)
    {
        // Hardcoded user (for now)
     
        // dd('dsfdsa');

        // //   $user = $request->user(); // or auth()->user()
            $user_id = 186;

        
        // Validation
        $validated = $request->validate([
            'service'          => 'required|integer',
            'state'            => 'required|integer',
            'district'         => 'required|integer',
            'testing_center'   => 'required|integer',
            'appointment_date' => 'required|date_format:d-m-Y',
        ]);
        
        $state_id = $validated['state'];
        // Save record
        $appointment = BookAppinmentMaster::create([
            'user_id'      => $user_id,
            'state_id'     => $validated['state'],
            'service_type_id' => $validated['service'],
            'district_id'  => $validated['district'],
            'center_ids'   => $validated['testing_center'],
            'appoint_date' => \Carbon\Carbon::createFromFormat('d-m-Y', $validated['appointment_date'])->format('Y-m-d'),
        ]);
          
        // Fetch VN details
        $vndata = VmMaster::where('state_code', $state_id)->first();

        // Generate unique id
        $uniqueId = $this->generateUniqueId($appointment->id);
        $appointment->survey_unique_ids = $uniqueId;
        $appointment->save();

        return response()->json([
            'status'     => true,
            'message'    => 'Appointment booked successfully.',
            'booking_id' => $appointment->id,
            'unique_id'  => $uniqueId,
            'vn_details' => $vndata, // 👈 extra data
        ]);
    }



        public function getCentersByState($stateId)
            {
                $centers = BookAppinmentMaster::where('state_id', $stateId)->get();

                return response()->json([
                    'status'  => true,
                    'message' => 'Centers fetched successfully.',
                    'data'    => $centers
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
      

    public function add_time_slot(Request $request)
    {

        //// dd('fghfghgf');

        $request->validate([
            'days' => 'required|array|min:1|max:7',
            'days.*.date' => 'required|date|after_or_equal:today',
            'days.*.time_slots' => 'required|array|min:1',
            'days.*.time_slots.*.start_time' => 'required|date_format:H:i',
            'days.*.time_slots.*.end_time'   => 'required|date_format:H:i',
        ]);

        $errors = [];
        foreach ($request->days as $dayIndex => $day) {
            foreach ($day['time_slots'] as $slotIndex => $slot) {
                if (strtotime($slot['end_time']) <= strtotime($slot['start_time'])) {
                    $errors["days.$dayIndex.time_slots.$slotIndex.end_time"] = [
                        "The end time must be after the start time."
                    ];
                }
            }
        }

        if (!empty($errors)) {
            return response()->json([
                'message' => 'Validation failed',
                'errors'  => $errors
            ], 422);
        }

        $userId = $request->user()->id;
     
       // // dd($userId);
        $created = [];

        // ✅ Merge slots
        $mergedDays = [];
        foreach ($request->days as $day) {
            $date = $day['date'];
            if (!isset($mergedDays[$date])) {
                $mergedDays[$date] = [];
            }
            $mergedDays[$date] = array_merge($mergedDays[$date], $day['time_slots']);
        }

        // ✅ Check overlaps
        foreach ($mergedDays as $date => $slots) {
            usort($slots, fn($a, $b) => strcmp($a['start_time'], $b['start_time']));
            for ($i = 0; $i < count($slots) - 1; $i++) {
                if ($slots[$i]['end_time'] > $slots[$i + 1]['start_time']) {
                    $errors[] = "Overlapping slots in request on {$date} between {$slots[$i]['start_time']}–{$slots[$i]['end_time']} and {$slots[$i+1]['start_time']}–{$slots[$i+1]['end_time']}.";
                }
            }
        }

        if (!empty($errors)) {
            return response()->json([
                'message' => 'Validation failed',
                'errors'  => $errors
            ], 422);
        }

        // ✅ Save
        foreach ($mergedDays as $date => $slots) {
            foreach ($slots as $slot) {
               $created[] = Availability::firstOrCreate(
                            [
                                'user_id'    => $userId,
                                'date'       => \Carbon\Carbon::parse($date)->format('Y-m-d'),
                                'start_time' => $slot['start_time'],
                                'end_time'   => $slot['end_time'],
                            ],
                            [] // additional default values if needed
                        );

            }
        }

        return response()->json([
            'message' => 'Availability slots saved successfully',
            'data'    => $created
        ]);
    }



        public function book_teleconsultation(Request $request)
        {
            $request->validate([
               // 'user_id'   => 'required|exists:users,id',
                'type'      => 'required|string|max:100',
                'service'   => 'required|string|max:100',
                'date'      => 'required|date|after_or_equal:today',
                'time'      => 'required|date_format:H:i',
                'language'  => 'required|string|max:50',
            ]);
            
            $userId = 1;
            // // dd($userId);

            // ✅ Step 1: Check availability
            $available = Availability::where('user_id', $userId)
                ->where('date', $request->date)
                ->where('start_time', '<=', $request->time)
                ->where('end_time', '>=', $request->time)
                ->exists();

            if (!$available) {
                return response()->json([
                    'message' => "No availability found for user {$userId} on {$request->date} at {$request->time}"
                ], 422);
            }

            // ✅ Step 2: Check if already booked
            $alreadyBooked = BookTeleconsultation::where('user_id', $userId)
                ->where('date', $request->date)
                ->where('time', $request->time)
                ->exists();

            if ($alreadyBooked) {
                return response()->json([
                    'message' => "Time slot already booked for {$request->date} at {$request->time}"
                ], 422);
            }

            // ✅ Step 3: Save booking
            $booking = BookTeleconsultation::create([
                'user_id'  => $userId,
                'type'     => $request->type,
                'service'  => $request->service,
                'date'     => $request->date,
                'time'     => $request->time,
                'language' => $request->language,
            ]);

            return response()->json([
                'message' => 'Teleconsultation booked successfully',
                'data'    => $booking
            ], 201);
        }


       public function get_book_teleconsultation(){
            $user_id = 1;

            $booking =  BookTeleconsultation::where('user_id', $user_id)->get();

                return response()->json([
                'message' => 'Teleconsultation booked successfully',
                'data'    => $booking
            ], 201);
       }

       	public function testing_center(Request $request)
		{
			$request->validate([
				'district_id' => 'required|integer',
				'state_code'  => 'required|integer',
			]);

			$centres = CentreMaster::where('district_id', $request->district_id)
						->where('state_code', $request->state_code)
						->get();

			if ($centres->isEmpty()) {
				return response()->json([
					'status'  => false,
					'message' => 'No testing centers found',
					'data'    => []
				], 404);
			}

			return response()->json([
				'status'  => true,
				'message' => 'Testing centers fetched successfully',
				'data'    => $centres
			]);
	    }

        public function get_questionaire()
        {
            $questions = RiskAssessmentQuestionnaire::with(['answers'])
                ->orderBy('priority', 'asc') // 👈 priority ascending order
                ->get();

            $formatted = $questions->map(function ($q) {
                return [
                    'question_id'       => $q->question_id,
                    'question'          => $q->question,
                    'question_mr'       => $q->question_mr,
                    'question_hi'       => $q->question_hi,
                    'question_te'       => $q->question_te,
                    'question_ta'       => $q->question_ta,
                    'question_slug'     => $q->question_slug,
                    'answer_input_type' => $q->answer_input_type,
                    'priority'          => $q->priority,
                    'options' => $q->answers->map(function ($a) {
                        return [
                            'answer_id'   => $a->answer_id,
                            'answer'      => $a->answer,
                            'answer_mr'   => $a->answer_mr,
                            'answer_hi'   => $a->answer_hi,
                            'answer_te'   => $a->answer_te,
                            'answer_ta'   => $a->answer_ta,
                            'answer_slug' => $a->answer_slug,
                            'weight'      => $a->weight,
                        ];
                    }),
                ];
            });

            return response()->json([
                'status'  => true,
                'message' => 'Questionnaire fetched successfully',
                'data'    => $formatted
            ]);
        }


         public function get_notifications()
         {

         }



         
         
    public function update_profile(Request $request)
    {
        $user = $request->user(); // ✅ Login user
        // // dd($user);
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthenticated'
            ], 401);
        }

        // ✅ Validation
        $request->validate([
            'user_picture' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);
        // ✅ Save file in storage/app/public/profile_pics
        $path = $request->file('user_picture')->store('user_picture', 'public');
        // // dd($path);
        
        // ✅ Old image delete (agar pehle se save ho)
        if ($user->user_picture) {
            Storage::disk('public')->delete($user->user_picture);
        }

        // ✅ Update in DB
        $user->user_picture = $path;
        $user->save();

        return response()->json([
            'status'  => true,
            'message' => 'Profile picture updated successfully',
            'user_picture_url' => asset('storage/' . $path)
        ]);
    }

   public function upload_report(Request $request)
    {
        // Assuming the user is logged in
        // $user = $request->user(); // ✅ Login user
        // For testing you had 
        // $user_id = $user->id;
        $user_id = 186;
        $booking_id = $request->booking_id;

        
        // if (!$user) {
        //     return response()->json([
        //         'status' => false,
        //         'message' => 'Unauthenticated'
        //     ], 401);
        // }

        // ✅ Validation
       // Validate manually for JSON response
        $validator = \Validator::make($request->all(), [
            'report_file' => 'required|mimes:pdf|max:2048', // Only PDF
        ]);

        if ($validator->fails()) {
            // Return proper JSON response on validation error
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // ✅ Save file in storage/app/public/report_file
        $path = $request->file('report_file')->store('report_file', 'public');
      

        // ✅ Save record in book_appointment table
        // $appointment = new \App\Models\BookAppinmentMaster(); 
        // $appointment->user_id = $user_id;
        // $appointment->report_file = $path;
        // $appointment->save();

        // Find the booking for this user
            $appointment = \App\Models\BookAppinmentMaster::where('id', $booking_id)
                            ->where('user_id', $user_id)
                            ->first();

            if (!$appointment) {
                return response()->json([
                    'status' => false,
                    'message' => 'Booking not found for this user.'
                ], 404);
            }

            // Update the report file
            $appointment->report_file = $path;
            $appointment->save();



        return response()->json([
            'status'  => true,
            'message' => 'Report uploaded successfully',
            'report_file_url' => asset('storage/' . $path)
        ]);
    }

    public function get_profile_pic(Request $request)
    {
        $user = $request->user(); // ✅ login user

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthenticated'
            ], 401);
        }

        return response()->json([
            'status'  => true,
            'profile_pic_url' => $user->user_picture 
                ? asset('storage/' . $user->user_picture) 
                : null
        ]);
    }


    public function get_time_slot(Request $request)
    {   

        // dd($request->user());
        try {
            $userId = $request->user()->id;
            // $userId = 183;

            // ✅ Fetch slots for user, grouped by date
            $availabilities = Availability::where('user_id', $userId)
                ->orderBy('date')
                ->orderBy('start_time')
                ->get()
                ->groupBy('date');

            // ✅ Format response
            $data = [];
            foreach ($availabilities as $date => $slots) {
                $data[] = [
                    'date' => $date,
                    'time_slots' => $slots->map(function ($slot) {
                        return [
                            'start_time' => $slot->start_time,
                            'end_time'   => $slot->end_time,
                        ];
                    })->values()
                ];
            }

            return response()->json([
                 'status' => 'success',
                'message' => 'Availability slots fetched successfully',
                'data'    => $data
            ], 200);

        } catch (\Throwable $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }


    public function get_vns_list(Request $request){

        $vn_data = VmMaster::get();
         return response()->json([
             'status' => 'success',
                'message' => 'All vns details',
                'data'    => $vn_data
            ], 200);

    }

    public function get_announcement(){
            $announcements = Announcement::orderBy('created_at', 'desc')->get();
          return response()->json([
                'status' => 'success',
                'message' => 'All announcement',
                'data'    => $announcements
            ], 200);
    }

    public function get_service_type(Request $request){

        $service_type = ServiceType::get();
         return response()->json([
             'status' => 'success',
                'message' => 'All vns details',
                'data'    => $service_type
            ], 200);

    }

    public function get_doctor(Request $request){

        $list = Doctor::get();
         return response()->json([
             'status' => 'success',
                'message' => 'All vns details',
                'data'    => $list
            ], 200);

    }

    
}
