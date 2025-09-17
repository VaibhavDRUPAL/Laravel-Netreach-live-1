<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Surveys;
use App\Models\VmMaster;
use App\Models\CentreMaster;
use App\Models\BookAppinmentMaster;
use App\Models\StateMaster;
use App\Models\VmCountStartMaster;
use App\Models\Customer;
use App\Models\Genrate;
use App\Models\OTPMaster;
use App\Models\CountVnByLink;
use App\Models\Post;
use App\Models\Blog;
use App\Models\ChatbotModule\{Greetings, Questionnaire};
use App\Models\DistrictMaster;
use App\Models\MeetCounsellorFollowUp;
use PDF;
use Illuminate\Support\Facades\{Config, Auth, Validator, Session, Cookie, DB, Log};
use App\Common\AisensyService;
use App\Common\IPStack;
use App\Models\SelfModule\{RiskAssessment, RiskAssessmentAnswer, RiskAssessmentItems, RiskAssessmentQuestionnaire};
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\App;
use App\Models\SelfModule\MeetCounsellor;
use App\Exports\MeetCounsellorExport;
use App\Common\{SMS, WhatsApp};


class SurveyController extends Controller
{
	public $booking_by_vn = '';
	public $platform_id = '';
	public $link_by_user_id = '';
	public $book_by_link = '';
	protected $aisensyService;

	public function __construct(AisensyService $aisensyService, Request $request)
	{
		$this->aisensyService = $aisensyService;
	}

	public function index()
	{
		// if(session('locale'))
		// $locale=session('locale');
		// else
		// $locale=app()->getlocale();
		$vnname = Session::get('name');

		return view('home.survey.verify_otp', compact('vnname'));
	}

	public function home(Request $request)
	{

		if ($request->has('vncode')) {
			$vn_id = $request->query('vncode');
			$GetVnCode = Genrate::select('users.id', 'users.email', 'genrates.unique_code_link', 'genrates.platform_id')->join('users', 'users.id', '=', 'genrates.user_id')->where(["genrates.user_identified" => $vn_id])->get();
			if ($GetVnCode->count() > 0) {
				$this->booking_by_vn = strtoupper($GetVnCode[0]->email);
				$this->platform_id = $GetVnCode[0]->platform_id;
				$this->link_by_user_id = $GetVnCode[0]->id;
			} else {
				$userLink = User::where(["manual_link" => $vn_id])->get();
				if ($userLink->count() > 0) {
					$this->booking_by_vn = strtoupper($userLink[0]->email);
					$this->platform_id = '';
					$this->link_by_user_id = $userLink[0]->id;
					$this->book_by_link = 1;
				} else {
					$this->book_by_link = 0;
					$this->booking_by_vn = '';
					$this->platform_id = '';
					$this->link_by_user_id = '';
				}
			}
		} else {
			$this->booking_by_vn = '';
			$this->platform_id = '';
			$this->link_by_user_id = '';
			$this->book_by_link = 0;
		}
		$request->session()->put('booking_by_vn', $this->booking_by_vn);
		$request->session()->put('platform_id', $this->platform_id);
		$request->session()->put('link_by_user_id', $this->link_by_user_id);
		$request->session()->put('book_by_link', $this->book_by_link);
		Session::forget('disclaimer');
		Session::forget('age_limt');
		Session::forget('identify');
		Session::forget('sexually');
		Session::forget('hivinfection');
		Session::forget('fname');
		Session::forget('sexually');
		Session::forget('hivinfection');
		Session::forget('risk_leavel');
		$token = "page_second";
		$keys = Crypt::encryptString($token);

		if (Cookie::has(Questionnaire::selected_questions))
			Cookie::queue(Cookie::forget(Questionnaire::selected_questions));

		if (Cookie::has(Greetings::locale))
			Cookie::queue(Cookie::forget(Greetings::locale));

		return view('home.home', ["keys" => $keys]);
	}

	public function center_register(Request $request)
	{
		//return view('auth.center_register');
		$center = CentreMaster::pluck('name', 'id');
		return view('auth.center_register', compact('center'));
	}

	protected function center_register_store(Request $request)
	{
		$user = User::create([
			'name' => $request['name'],
			'center' => $request['center'],
			'email' => $request['email'],
			'password' => $request['password'],
			'user_type' => '3',
			'txt_password' => $request['password'],
			'vn_email' => $request['email'],
			'status' => '1',
		]);

		$user->assignRole('Center-user');

		flash('User created successfully!')->success();
		return redirect()->back();
	}

	public function verify_mobile_otp(Request $request)
	{
		$locale = $request->query('locale'); 
	// 	dd($request->all(),$locale);
		$request->validate([
			'mobile-no' => 'required|numeric',
			'otp' => [
				'required',
				Rule::exists('otp_master', 'otp')->where('phone_no', $request->input('mobile-no'))
			]
		]);
		// if(session('locale'))
		$locale = session('locale');
		// $locale = app()->getLocale();
		// dd($locale);

		$mobileNo = $request->input('mobile-no');


		$otp = OTPMaster::where('phone_no', '=', $mobileNo)
			->where('otp', '=', $request->input('otp'))
			->first();

		if (!$otp)
			return redirect()->back()->withErrors(['otp' => 'Invalid OTP or mobile number.']);

		$otp->delete();
		$key = $request->filled('name-vn') ? $request->input('name-vn') : null;

		if (Session::get('buttonUse') == 'prep') {
			$request->session()->put('mobile', $mobileNo);
			$request->session()->put('assessment', null);
			$request->session()->put('state', null);
			$request->session()->put('key', $key);

			// return redirect()->route('survey.prep-book-appoinment', compact('locale'));
			$url = $locale !== 'en' ? $locale . '/prep-consultation/book-appoinment' : '/prep-consultation/book-appoinment';
			return redirect($url);
			// return redirect()->route('survey.book-appoinment', $param);
		}

		$request->session()->put('mobile', $mobileNo);
		$request->session()->put('verify', true);
		$request->session()->put('key', $key);
		$request->session()->put('booking_option', true);

		// dd(url($locale.'/questionnaire'));
		return redirect($locale !== 'en' ? $locale . '/questionnaire' : '/questionnaire');
		// return redirect()->route('survey.questionnaire', ['locale' => $locale])->with('success', 'OTP verified successfully!');

		// return redirect()->route('survey.questionnaire')->with('success', 'OTP verified successfully!');
	}

	public function getQuestionnaire(Request $request)
	{
		// $ip = 'MH';
		$ip = new IPStack;
		$user_notification = 0;
		$notification_stage = 0;
		$last_msg_sent = date("Y-m-d H:i:s");

		// $ipState = 'MH';
		$ipState = $ip->state();
		$groupNo = [1, 2, 3, 4, 5];

		if (session('locale'))
			$locale = session('locale');
		// $locale = app()->getLocale();
		$questionnaire = RiskAssessmentQuestionnaire::getAllQuestionnaire($request, $locale);

		// $questionnaire = RiskAssessmentQuestionnaire::getAllQuestionnaire($request);
		$state = StateMaster::where('st_cd', $ipState)->first();
		$verify = session('verify') ? session('verify') : false;
		$mobileNo = session('mobile') ? session('mobile') : null;
		$vn = session('key') ? session('key') : null;
		$booking_option = session('booking_option') ? session('booking_option') : null;

		// latest one
		$meetIdData = MeetCounsellor::where('mobile_no', $mobileNo)->latest('created_at')->value('meet_id');
		;
		// first one
		// $meetIdData = MeetCounsellor::where('mobile_no', $mobileNo)->pluck('meet_id')->first();

		$existingRiskAssessment = RiskAssessment::where(RiskAssessment::mobile_no, $mobileNo)->orderByDesc(RiskAssessment::risk_assessment_id)->first();
		$existingRawData = [];

		$statez = StateMaster::get();
		if ($existingRiskAssessment) {
			$current = Carbon::parse(now());
			$updated = Carbon::parse($existingRiskAssessment[RiskAssessment::created_at]);
			$diff = $current->diffInMinutes($updated);
			// if ($diff <= intval(Config::get('app.sra_timer')))
			$existingRawData = $existingRiskAssessment[RiskAssessment::raw_answer_sheet];
		}

		if (empty($existingRawData)) {
			$riskAssessmentCount = RiskAssessment::count();
			$okToGo = true;
			if (isset($vn)) {
				$decoded = base64_decode(urldecode($vn));

				$position = strpos($decoded, "VN");
				if ($position === 0) {
					$checkIfExist = VmMaster::where(DB::raw('LOWER(`vncode`)'), strtolower($decoded))->first();

					if ($checkIfExist) {
						$nameExist = VmMaster::where(DB::raw('LOWER(`vncode`)'), strtolower($decoded))->first();
						if ($nameExist) {
							$decoded = $nameExist->name;
							$vn = $decoded;
						} else {
							$okToGo = false;
							$vn = null;
						}
					} else {
					}
				}
				if (!boolval(preg_match('//u', $decoded))) {
					$decoded = $vn;
				}

				if (strpos($decoded, '%20') !== false) {
					$decoded = str_replace('%20', ' ', $decoded);
				}
				if ($okToGo)
					$vnData = VmMaster::where(DB::raw('LOWER(`link_name`)'), strtolower($decoded))->first();
				else
					$vnData = null;
				if ($vnData != null) {
					$key_vn_id = $vnData->id;
				} else {
					$key_vn_id = null;
				}
			} else {
				$key_vn_id = null;
			}
			$rawData = [
				'mobile-number' => $mobileNo,
				// 'ipstack_data' => ''
				'ipstack_data' => $ip->getIPDetails()
			];

			$riskAssessment = [
				RiskAssessment::state_id => $state['id'],
				RiskAssessment::vn_id => $key_vn_id,
				RiskAssessment::unique_id => 'NETREACH/' . $ipState . '/ASSESSMENT/' . ++$riskAssessmentCount,
				RiskAssessment::mobile_no => $mobileNo,
				RiskAssessment::risk_score => 0,
				RiskAssessment::raw_answer_sheet => $rawData,
				RiskAssessment::user_notification => $user_notification,
				RiskAssessment::notification_stage => $notification_stage,
				RiskAssessment::last_msg_sent => $last_msg_sent,
				RiskAssessment::meet_id => $meetIdData
			];
			$riskAssessment = RiskAssessment::addOrUpdate($riskAssessment);
		}

		$riskAssessmentID = empty($existingRawData) ? $riskAssessment[RiskAssessment::risk_assessment_id] : $existingRiskAssessment[RiskAssessment::risk_assessment_id];
		$stateID = empty($existingRawData) ? $riskAssessment[RiskAssessment::state_id] : $existingRiskAssessment[RiskAssessment::state_id];

		$rawData = $existingRawData;

		return view('home.survey.questionnaire', compact('questionnaire', 'statez', 'stateID', 'riskAssessmentID', 'rawData', 'groupNo', 'state', 'verify', 'mobileNo', 'vn', 'booking_option'));
	}

	public function addAnswer(Request $request)
	{

		try {
			DB::beginTransaction();

			$assessment = RiskAssessment::find($request->integer(RiskAssessment::risk_assessment_id));

			if ($request->question_id == "5") {
				RiskAssessment::where(RiskAssessment::risk_assessment_id, $request->integer(RiskAssessment::risk_assessment_id))
					->update([
						RiskAssessment::state_id => intval($request->answer_id)
					]);
				// DB::commit();
				// return true;
			}
			$question = RiskAssessmentQuestionnaire::find($request->integer(RiskAssessmentQuestionnaire::question_id));

			$rawData = $assessment[RiskAssessment::raw_answer_sheet];
			$rawData[$question[RiskAssessmentQuestionnaire::question_slug]] = is_array($request->input(RiskAssessmentAnswer::answer_id)) ? $request->input(RiskAssessmentAnswer::answer_id) : $request->integer(RiskAssessmentAnswer::answer_id);
			$jsonData = collect($rawData);
			$jsonData = $jsonData->except(['vn', 'state', 'mobile-number', 'ipstack_data']);
			$jsonIDs = collect()->make();

			foreach ($jsonData as $item) {
				if (is_array($item)) {
					foreach ($item as $value)
						$jsonIDs->push(intval($value));
				} else
					$jsonIDs->push(intval($item));
			}

			$riskScore = RiskAssessmentAnswer::whereIn(RiskAssessmentAnswer::answer_id, $jsonIDs->all())->sum(RiskAssessmentAnswer::weight);

			RiskAssessment::where(RiskAssessment::risk_assessment_id, $request->integer(RiskAssessment::risk_assessment_id))
				->update([
					RiskAssessment::risk_score => intval($riskScore),
					RiskAssessment::raw_answer_sheet => $rawData
				]);
			DB::commit();
			RiskAssessmentItems::where(RiskAssessmentItems::risk_assessment_id, $request->integer(RiskAssessment::risk_assessment_id))
				->where(RiskAssessmentItems::question_id, $request->integer(RiskAssessmentQuestionnaire::question_id))
				->delete();

			if ($question[RiskAssessmentQuestionnaire::answer_input_type] == IN_RADIO) {
				RiskAssessmentItems::create([
					RiskAssessmentItems::risk_assessment_id => $request->integer(RiskAssessment::risk_assessment_id),
					RiskAssessmentItems::question_id => $request->integer(RiskAssessmentQuestionnaire::question_id),
					RiskAssessmentItems::answer_id => $request->integer(RiskAssessmentAnswer::answer_id)
				]);
			} else {
				$checkedData = collect()->make();

				foreach ($request->input(RiskAssessmentAnswer::answer_id) as $answer) {
					$checkedData->push([
						RiskAssessmentItems::risk_assessment_id => $request->integer(RiskAssessment::risk_assessment_id),
						RiskAssessmentItems::question_id => $request->integer(RiskAssessmentQuestionnaire::question_id),
						RiskAssessmentItems::answer_id => intval($answer)
					]);
				}
				RiskAssessmentItems::insert($checkedData->all());
			}

			DB::commit();

			return true;
		} catch (\Throwable $th) {
			DB::rollBack();
			logger($th);
		}
	}

	public function addSurvey(Request $request)
	{
		// Retrieve the RiskAssessment instance
		$assessment = RiskAssessment::find($request->integer(RiskAssessment::risk_assessment_id));
		if (is_null($assessment)) {
			// Handle the case where the risk assessment is not found
			return redirect()->back()->withErrors('Risk Assessment not found.');
		}

		$mobileNo = $assessment->mobile_no ?? null;

		if ($request->filled('mobile') && is_null($mobileNo)) {
			$mobileNo = Crypt::decryptString($request->input('mobile'));
		}

		$user_notification = $request->user_notification;
		$riskAssessmentID = $assessment->risk_assessment_id;
		$score = $assessment->risk_score;
		$stateID = $assessment->state_id;

		// Check if 'vn' is passed in the request
		$vn = $request->filled('vn') ? $request->input('vn') : null;

		if (strpos($vn, '%20') !== false) {
			$vn = str_replace('%20', ' ', $vn);
		}

		if (!is_null($vn)) {
			// Decode and sanitize the 'vn' value
			$decoded = base64_decode(urldecode($vn));
			if (!boolval(preg_match('//u', $decoded))) {
				$decoded = $vn;
			}

			// Find the corresponding VN data in the VmMaster model
			$vnData = VmMaster::where(DB::raw('LOWER(`name`)'), strtolower($decoded))->first();

			// Update the assessment's vn_id if VN data is found
			$assessment->vn_id = $vnData ? $vnData->id : null;
			// Save the updated assessment record
			$assessment->save();
		}
		if (isset($user_notification)) {
			$assessment->user_notification = $user_notification;
			$assessment->save();
		}

		$isLanding = true;
		$request->session()->put('mobile', $request->input('mobile'));
		$request->session()->put('assessment', $riskAssessmentID);
		$request->session()->put('state', $stateID);
		$request->session()->put('key', $vn);

		return view('home.survey.success', compact('mobileNo', 'riskAssessmentID', 'score', 'stateID', 'vn', 'isLanding'));
	}

	public function translator(Request $request)
	{
		$datax = json_decode($request->jsonData, true);
		$res = false;
		foreach ($datax as $data) {
			$res = CentreMaster::where('id', $data["id"])->update([
				"address_" . $request->lang => $data["payload"]
			]);
		}
		echo $res;
	}
	public function bookAppoinment(Request $request)
	{
		$mobileNo = Session::get('mobile');
		$session_assessment = Session::get('assessment');
		$state = Session::get('state');
		$key = Session::get('key');

		if (Session::get('buttonUse') == "prep") {

			$filteredCentres = CentreMaster::where('services_available', 'LIKE', '%,3,%')
				->orWhere('services_available', 'LIKE', '3,%')
				->orWhere('services_available', 'LIKE', '%,3')
				->orWhere('services_available', '=', '3')
				->pluck('state_code');
			$states = StateMaster::whereIn('state_code', $filteredCentres)->orderBy('state_name')->get();
		} else {
			$states = StateMaster::orderBy('state_name')->get();
		}


		$vn = $request->filled('key') ? $request->input('key') : $key;
		// $ipState = 'MH';
		$ipState = (new IPStack)->state();
		$assessmentID = $request->filled('assessment') ? Crypt::decryptString($request->input('assessment')) : $session_assessment;
		$assessment = !is_null($assessmentID) ? RiskAssessment::find($assessmentID) : null;

		return view('home.survey.book-appointment', compact('mobileNo', 'vn', 'assessment', 'states', 'ipState'));
	}

	public function pin_code(Request $request)
	{
		$pincode = $request->pin_code;
		$results = CentreMaster::where('pin_code', 'LIKE', "%$pincode%")->orWhere('address', 'LIKE', "%$pincode%")->orderBy('centre_master.name', 'asc')->get();
		echo json_encode(array("results" => $results));
		exit;
	}

	public function letsgo_sumit(Request $request)
	{
		$age_limt = $request->age_limt;
		$request->session()->put('age_limt', $age_limt);
		$token = "page_third";
		$keys = Crypt::encryptString($token);
		return redirect("letsgo/$keys");
	}
	public function letsgo_third(Request $request)
	{
		$identify = $request->identify;
		$fname = $request->fname;
		$age_limt = Session::get('age_limt');
		$request->session()->put('identify', $identify);
		$request->session()->put('fname', $fname);
		$token = "page_fourth";
		$keys = Crypt::encryptString($token);
		return redirect("letsgo/$keys");
	}
	public function letsgo_five(Request $request)
	{
		$sexually = $request->sexually;
		$request->session()->put('sexually', $sexually);
		$token = "page_five";
		$keys = Crypt::encryptString($token);
		return redirect("letsgo/$keys");
	}
	public function letsgo_six(Request $request)
	{
		$hivinfection = $request->hivinfection;
		$request->session()->put('hivinfection', $hivinfection);
		$token = "page_six";
		$risk_leavel = '';
		if (in_array(1, $hivinfection))
			$risk_leavel = 'High Risk';
		else if (in_array(2, $hivinfection))
			$risk_leavel = 'High Risk';
		else if (in_array(3, $hivinfection))
			$risk_leavel = 'High Risk';
		else if (in_array(4, $hivinfection))
			$risk_leavel = 'High Risk';
		else if (in_array(5, $hivinfection))
			$risk_leavel = 'High Risk';
		else if (in_array(6, $hivinfection))
			$risk_leavel = 'Medium Risk';
		else if (in_array(7, $hivinfection))
			$risk_leavel = 'Medium Risk';
		else if (in_array(8, $hivinfection))
			$risk_leavel = 'May be Low Risk';
		$request->session()->put('risk_leavel', $risk_leavel);
		$keys = Crypt::encryptString($token);
		return redirect("letsgo/$keys");
	}
	public function register_client(Request $request)
	{
		return view('home.survey.client-inform');
	}
	public function lets_go_disclaimer(Request $request)
	{
		$token = "page_second";
		$keys = Crypt::encryptString($token);
		$name = $request->name;
		$checkVal = $request->disclaimer;
		$buttonUse = $request->buttonUse;
		if ($checkVal > 0) {

			$disclaimer = $checkVal;
			$request->session()->put('disclaimer', $disclaimer);
			$request->session()->put('buttonUse', $buttonUse);
			$request->session()->put('name', $name);
			// 	if (session('locale'))
			// 		$url = session('locale') . "/self-risk-assessment";
			// 	echo json_encode(array("disclaimer" => "Checked", "disclaimer_url" => $url));
			// } else {
			// 	echo json_encode(array("disclaimer" => "Not_Checked", "disclaimer_url" => ''));
			// }
			if ($buttonUse == "hiv") {

				if (session('locale') && session('locale') != 'en')
					$url = session('locale') . "/hiv-testing/verify-number";
				else
					$url = "hiv-testing/verify-number";
			} elseif ($buttonUse == "prep") {
				if (session('locale') && session('locale') != 'en')
					$url = session('locale') . "/prep-consultation/verify-number";
				else
					$url = "prep-consultation/verify-number";
			} elseif ($buttonUse == "meet") {
				if (session('locale') && session('locale') != 'en')
					$url = session('locale') . "/talk-to-a-counsellor";
				else
					$url = "talk-to-a-counsellor";
			} else {
				echo json_encode(array("disclaimer" => "Not_Checked", "disclaimer_url" => ''));
			}
			echo json_encode(array("disclaimer" => "Checked", "disclaimer_url" => $url));
		} else {
			echo json_encode(array("disclaimer" => "Not_Checked", "disclaimer_url" => ''));
		}

	}
	// -----------------------------Meet Counsellor functions-------------------------
	public function meetCounsellorHome()
	{
		$locale = app()->getLocale();
		$statez = StateMaster::orderBy('state_name', 'asc')->get();
		return view('home.survey.meet-counsellor', compact('statez', 'locale'));
	}

	public function meetCounsellorFormSubmit(Request $request)
	{
		$validated = $request->validate([
			'name' => ['required', 'string'],
			'mobile_no' => ['required', 'string', 'min:10', 'regex:/^[789]\d{9}$/'],
			'state_id' => ['required'],
			'message' => ['required', 'string']
		]);
		$name = $request->name;
		$mobile = $request->mobile_no;
		if ($validated == true) {
			$meetCounsellor = new MeetCounsellor();
			$meetCounsellor->name = $name;
			$meetCounsellor->mobile_no = $mobile;
			$meetCounsellor->state_id = $request->state_id;
			$meetCounsellor->message = $request->message;

			$stateName = StateMaster::getOneStateName($request->state_id);
			$region = StateMaster::getRegionByState($request->state_id);
			$meetCounsellor->state_name = $stateName;
			$meetCounsellor->region = $region;
			$meetCounsellor->save();

			// send sms to user

			(new SMS)->sendTalkToCounsellorMsg($name, $mobile);
			(new WhatsApp)->sendTalkToCounsellorMsg($name, $mobile);

			return redirect()->back()->withSuccess('Form Submitted Successfully');
		} else {
			return redirect()->back()->withErrors($validated)->withInput();
		}
	}
	public function meetCounsellorAdmin(Request $request)
	{
		$counsellorData = collect();
		$count = 1;
		$roleName = "";
		$user_type = Auth::user()->user_type;

		$filter = false;
		if (isset($request->meet_id) || isset($request->name) || isset($request->mobile_no) || isset($request->state_id) || isset($request->from_date) || isset($request->to_date) || isset($request->has_followup)) {
			$filter = true;
		}

		if ($user_type == 1) {
			$roleName = SUPER_ADMIN;
		}
		if ($user_type == 2) {
			$roleName = VN_USER_PERMISSION;
		}
		if ($user_type == 3) {
			$roleName = PO_PERMISSION;
		}
		if ($roleName == VN_USER_PERMISSION) {
			$userId = Auth::user()->vms_details_ids;
			$vnStateCodes = VmMaster::where('id', $userId)->pluck('state_code')->first();
			$array = explode(',', $vnStateCodes);
			$stateIds = StateMaster::whereIn('state_code', $array)->pluck('id')->toArray();
			$state_list = StateMaster::whereIn('id', $stateIds)->orderBy('state_name', 'ASC')->get();
			$query = MeetCounsellor::with('followups')
				->whereIn("state_id", $stateIds);
			if ($filter) {
				$query = $this->applyMeetCounsellorFilters($query, $request);
			}
			$meetCounsellor = $query->get();
		} else if ($roleName == PO_PERMISSION) {
			$userId = Auth::user()->vms_details_ids;
			$vnData = VmMaster::where('id', $userId)->first();

			if ($vnData->regions_list != null) {
				// $regions_list = json_decode($vnData->regions_list, true);
				$regions_list = $vnData->regions_list;
				$vals = [];
				foreach ($regions_list as $reg) {
					if ($reg == "north")
						$vals[] = 1;
					if ($reg == "south")
						$vals[] = 2;
					if ($reg == "east")
						$vals[] = 3;
					if ($reg == "west")
						$vals[] = 4;
				}
				$stateIds = StateMaster::whereIn('region', $vals)->pluck('id');
				$state_list = StateMaster::whereIn('id', $stateIds)->orderBy('state_name', 'ASC')->get();
				// $meetCounsellor = MeetCounsellor::whereIn("state_id", $stateIds)->get();
				$query = MeetCounsellor::with('followups')
					->whereIn("state_id", $stateIds);
				if ($filter) {
					$query = $this->applyMeetCounsellorFilters($query, $request);
				}
				$meetCounsellor = $query->get();
				// $meetCounsellor = MeetCounsellor::with('followups')->whereIn("state_id", $stateIds)->get();
			} else {

				$region = $vnData->region;
				if ($region == "north")
					$regx[] = 1;
				if ($region == "south")
					$regx[] = 2;
				if ($region == "east")
					$regx[] = 3;
				if ($region == "west")
					$regx[] = 4;
				$stateIds = StateMaster::where('region', $regx)->pluck('id');
				$state_list = StateMaster::whereIn('id', $stateIds)->orderBy('state_name', 'ASC')->get();
				// $meetCounsellor = MeetCounsellor::whereIn("state_id", $stateIds)->get();
				$query = MeetCounsellor::with('followups')
					->whereIn("state_id", $stateIds);
				if ($filter) {
					$query = $this->applyMeetCounsellorFilters($query, $request);
				}
				$meetCounsellor = $query->get();
				// $meetCounsellor = MeetCounsellor::with('followups')->whereIn("state_id", $stateIds)->get();
			}
		} else {
			$state_list = StateMaster::orderBy('state_name', 'ASC')->get();
			// $meetCounsellor = MeetCounsellor::all();
			$query = MeetCounsellor::with('followups');
			if ($filter) {
				$query = $this->applyMeetCounsellorFilters($query, $request);
			}
			$meetCounsellor = $query->get();
			// $meetCounsellor = MeetCounsellor::with('followups')->get();
		}
		// ---------------------------export data----------------------
		foreach ($meetCounsellor as $value) {
			$followups = $value->followups;
			if ($followups->isEmpty()) {
				$counsellorData->push([
					MeetCounsellor::meet_id => $value[MeetCounsellor::meet_id],
					MeetCounsellor::name => $value[MeetCounsellor::name],
					MeetCounsellor::mobile_no => $value[MeetCounsellor::mobile_no],
					MeetCounsellor::state_name => $value->state_name,
					MeetCounsellor::region => MeetCounsellor::getRegionName($value->region),
					MeetCounsellor::message => $value[MeetCounsellor::message],
					MeetCounsellor::created_at => $value[MeetCounsellor::created_at]->format('d-m-Y H:i:s'),
					'contacted' => '-',
					'action_taken' => '-',
					'follow_up_image' => '-',
					'follow_up_date' => '-'
				]);
			} else {
				$contactedArr = [];
				$actionTakenArr = [];
				$followupImageArr = [];
				$followupDateArr = [];
				foreach ($value->followups as $followup) {
					$contactedArr[] = $followup->contacted ?? '-';
					$actionTakenArr[] = $followup->action_taken ?? '-';
					$followupImageArr[] = basename($followup->follow_up_image) ?? '-';
					$followupDateArr[] = $followup->created_at->format('d-m-Y H:i:s') ?? '-';
				}
				$counsellorData->push([
					MeetCounsellor::meet_id => $value[MeetCounsellor::meet_id],
					MeetCounsellor::name => $value[MeetCounsellor::name],
					MeetCounsellor::mobile_no => $value[MeetCounsellor::mobile_no],
					MeetCounsellor::state_name => $value->state_name,
					MeetCounsellor::region => MeetCounsellor::getRegionName($value->region),
					MeetCounsellor::message => $value[MeetCounsellor::message],
					MeetCounsellor::created_at => $value[MeetCounsellor::created_at]->format('d-m-Y H:i:s'),
					'contacted' => implode("\n", array_map(function ($val) {
						return $val == 1 ? 'Yes' : 'No';
					}, $contactedArr)),
					'action_taken' => implode("\n", $actionTakenArr),
					'follow_up_image' => implode("\n", $followupImageArr),
					'follow_up_date' => implode("\n", $followupDateArr)

				]);
			}
			// ---------------------------export code ends----------------------
		}
		if ($request->filled('export'))
			return new MeetCounsellorExport($counsellorData->all());
		return view('self.admin.meet-counsellor', compact('meetCounsellor', 'state_list'));
	}
	private function applyMeetCounsellorFilters($query, Request $request)
	{
		return $query->where(function ($q) use ($request) {
			if ($request->filled('meet_id')) {
				$q->where('meet_id', $request->meet_id);
			}
			if ($request->filled('name')) {
				$q->where('name', 'LIKE', '%' . $request->name . '%');
			}
			if ($request->filled('mobile_no')) {
				$q->where('mobile_no', 'LIKE', '%' . $request->mobile_no . '%');
			}
			if ($request->filled('state_id')) {
				$q->where('state_id', $request->state_id);
			}
			if ($request->filled('from_date') && $request->filled('from_date')) {
				$q->whereBetween('created_at', [$request->from_date, $request->to_date]);
			} elseif ($request->filled('from_date')) {
				$q->whereDate('created_at', $request->from_date);
			} elseif ($request->filled('to_date')) {
				$q->whereDate('created_at', $request->to_date);
			}
			if ($request->filled('has_followup')) {
				$hasFollowup = $request->has_followup;
				if ($hasFollowup == '1') {
					$q->has('followups');
				} elseif ($hasFollowup == '0') {
					$q->doesntHave('followups');
				}
			}
		});
	}

	public function saveFollowUp(Request $request)
	{
		$user_id = Auth::user()->vms_details_ids;
		$request->validate([
			'meet_id' => 'required|exists:meet_counsellor,meet_id',
			'contacted' => 'required|boolean',
			'action_taken' => 'required|string',
			'follow_up_image' => 'nullable|file|max:2048',
		]);

		if ($request->hasFile('follow_up_image')) {
			$file = $request->file('follow_up_image');
			// Store file and get the path
			$filePath = mediaOperations(
				FOLLOWUP_PATH,
				$file,
				FL_CREATE,
				MDT_STORAGE,
				STD_PUBLIC,
				getFileName() . '.' . $file->getClientOriginalExtension()
			);
		}
		MeetCounsellorFollowUp::create([
			'meet_id' => $request->meet_id,
			'user_id' => $user_id,
			'contacted' => $request->contacted,
			'action_taken' => $request->action_taken,
			'follow_up_image' => $filePath
		]);
		flash('Follow-up added successfully!')->success();
		return redirect()->back();
	}
	public function getFollowUps($meet_id)
	{
		$followups = MeetCounsellorFollowUp::where('meet_id', $meet_id)->latest()->get();
		$html = view('self.admin.ajax.viewFollowups', compact('followups'))->render(); // <-- You forgot to render

		return response()->json(['html' => $html]);
	}
	// -----------------------------Meet Counsellor functions ends-------------------------

	public function user_register(Request $request)
	{
		$name = session('name');
		$phone_number = session('phone_number');
		$email = session('email');
		$exist_otp = OTPMaster::WHERE(["phone_no" => $phone_number])->first();
		if ($exist_otp->otp != $request->otp) {
			return json_encode(array('statusCode' => 400, 'msg' => "otp not valid"));
		} else {
			if ($request->user == "2") {
				$user = Customer::create([
					'name' => $name,
					'anony' => 2,
					'email' => '',
					'password' => 123456,
					'email_verified_at' => date('Y-m-d H:i:s'),
					'status' => 1,
				]);
				$exist_ids = $user->id;
				$client_type = 1;
			} else if ($request->user == "1") {
				$exist = Customer::WHERE(["phone_number" => $phone_number])->get();
				if ($exist->count() > 0) {
					$exist_ids = $exist[0]->id;
					$client_type = 2;
				} else {
					$user = Customer::create([
						'name' => $name,
						'phone_number' => $phone_number,
						'email' => $email,
						'password' => 123456,
						'email_verified_at' => date('Y-m-d H:i:s'),
						'status' => 1,
					]);
					$exist_ids = $user->id;
					$client_type = 1;
				}
			}
			if ($exist_ids > 0) {
				$disclaimer = session('disclaimer');
				$age_limt = session('age_limt');
				$identify = session('identify');
				$sexually = session('sexually');
				$hivinfection = session('hivinfection');
				$risk_leavel = session('risk_leavel');
				$fname = session('fname');
				$manual_link = session('book_by_link');
				try {
					if ($identify == 1 && (count($sexually) == 1 && in_array("Male", $sexually)) && (count($hivinfection) > 0 && !in_array("7", $hivinfection)))
						$Target_population = 'MSM';
					else if ($identify == 3 && count($sexually) > 0 && count($hivinfection) > 0)
						$Target_population = 'TG';
					else if ($identify == 1 && count($sexually) > 0 && (count($hivinfection) == 1 && in_array("7", $hivinfection)))
						$Target_population = 'MSW';
					else if ($identify == 2 && count($sexually) > 0 && (count($hivinfection) == 1 && in_array("7", $hivinfection)))
						$Target_population = 'FSW';
					else if (($identify == 1 || $identify == 2 || $identify == 3 || $identify == 4) && count($sexually) > 0 && (count($hivinfection) == 1 && in_array("4", $hivinfection)))
						$Target_population = 'PWID';
					else if (($identify == 1 || $identify == 2) && (count($sexually) > 0 && !in_array("Transgender", $sexually)) && !in_array("4", $hivinfection) && ($age_limt >= 18 && $age_limt <= 24))
						$Target_population = 'Adolescents and Youths (18-24)';
					else if (($identify == 1 || $identify == 2) && (count($sexually) > 0 && !in_array("Transgender", $sexually)) && !in_array("4", $hivinfection) && $age_limt < 24)
						$Target_population = 'Men and Women (above 24 yrs)';
					else if ($identify == 5 && count($sexually) > 0 && !in_array("4", $hivinfection) && ($age_limt >= 18 && $age_limt <= 24))
						$Target_population = 'Adolescents and Youths (18-24)';
					else if ($identify == 5 && count($sexually) > 0 && !in_array("4", $hivinfection) && $age_limt < 24)
						$Target_population = 'Men and Women (above 24 yrs)';
					else
						$Target_population = '';
					$survery = new Surveys();
					$survery->user_id = $exist_ids;
					$survery->client_type = $client_type;
					$survery->your_age = $age_limt;
					$survery->identify_yourself = $identify;
					$survery->identify_others = $fname;
					$survery->sexually = json_encode($sexually);
					$survery->hiv_infection = json_encode($hivinfection);
					$survery->risk_level = $risk_leavel;
					$survery->hiv_test = $request->hiv_test;
					$survery->manual_flag = $manual_link;
					$survery->save();
					if ($survery->id > 0) {
						$ip_address = request()->getClientIp();
						$details = $this->get_geolocation($ip_address);
						$updateIP = Surveys::find($survery->id);
						$updateIP->survey_details = $details;
						$updateIP->target_population = $Target_population;
						$updateIP->save();
						$request->session()->put('survery_id', $survery->id);
						$request->session()->put('user_id', $exist_ids);
						Session::forget('disclaimer');
						Session::forget('age_limt');
						Session::forget('identify');
						Session::forget('sexually');
						Session::forget('hivinfection');
						Session::forget('risk_leavel');
						Session::forget('fname');
						Session::forget('name');
						Session::forget('phone_number');
						Session::forget('email');
						DB::table('otp_master')->where('phone_no', $phone_number)->delete();
						return json_encode(array('statusCode' => 200, 'msg' => 'sucess', "survey_ids" => $survery->id));
					}
				} catch (\Exception $e) {
					Log::error($e);
					//json_encode(array('statusCode'=>200,'msg'=>'sucess'));
				}
				return json_encode(array('statusCode' => 200, 'msg' => 'sucess'));
			}
		}
	}

	public function resend_otp(Request $request)
	{
		$phone_number = session('phone_number');
		DB::table('otp_master')->where('phone_no', $phone_number)->delete();
		$otp = rand(1000, 9999);

		$msg = "" . $otp . " is the OTP for NETREACH website. \n Validity 60 seconds only \n The Humsafar Trust";

		// $msg = "Welcome to NETREACH";

		// $msg = "Welcome to NETREACH \n Dear Abhishek Dalvi, \n UID: 111 \n Center: Mumbai \n Appointment Date: 01-02-1994 \n Service Requested: HIV Test \n VN Name: DELHI \n VN Contact: 111111111 \n \n The Humsafar Trust – NETREACH";

		Log::info('ResendSend OTP MSG :', $msg);

		$ph = $phone_number;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "http://49.50.67.32/smsapi/httpapi.jsp?username=hamsaotp&password=hum@678&from=THEHUM&to=" . $ph . "&text=" . urlencode($msg) . "&pe_id=1701166074335356091&template_id=1707166607845969067");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		$response = curl_exec($ch);

		Log::info('ResendSend OTP MSG RESPONSE :', [$response]);

		curl_close($ch);
		// sending otp via whatsapp
		$this->send_whatsapp_otp($mobileNo, $otp);
		$user = OTPMaster::create([
			'otp' => $otp,
			'phone_no' => $phone_number,
		]);

		$otp = OTPMaster::where('phone_no', '=', $request->input('mobile-no'))
			->where('otp', '=', $request->input('otp'))
			->first();


		// return json_encode(array('statusCode' => 200, 'msg' => 'otp sent successfully' . $otp));

		//  WhatsApp Message Send for ResendOTP
		$messageData = [
			'message' => [
				'channel' => 'WABA',
				'content' => [
					'preview_url' => false,
					'text' => $msg,
					'type' => 'AUTO_TEMPLATE',
				],
				'recipient' => [
					'to' => '91' . $phone_number,
					//	'recipient_type' => 'individual',
					'reference' => [
						'cust_ref' => '',
						'messageTag1' => '',
						'conversationId' => '',
					],
				],
				'sender' => [
					'name' => 'Humsafar_netrch',
					'from' => env('AISENSY_FROM_NO'),
				],
				'preferences' => [
					'webHookDNId' => '1001',
				],
			],
			'metaData' => [
				'version' => 'v1.0.9',
			],
		];

		Log::info('WtsUp_ResendOTPMessage_Data', [$messageData]);

		Log::info('...ResendOTP...');

		$response = $this->aisensyService->sendMessage($messageData);

		$responseArray = json_decode($response, true);

		Log::info('...ResendOTP...');

		if (isset($responseArray['statusCode']) && $responseArray['statusCode'] == 200) {
			return json_encode(array('statusCode' => 200, 'msg' => 'otp sent successfully' . $otp));
		} else {
			return json_encode(array('statusCode' => 201, 'msg' => 'otp not sent successfully'));
		}

		// return view('home.survey.varify-otp',compact('name','phone_number','email'));
	}

	public function varify_otp(Request $request)
	{
		$rule = array();
		if ($request->user == "2") {
			$rule["name"] = "required";
		} else {
			$rule["phone_number"] = "required";
			$rule["name"] = "required";
		}
		$validator = Validator::make($request->all(), $rule);
		if ($validator->fails()) {
			return redirect('client-information')
				->withErrors($validator)
				->withInput();
		}
		$name = $request->name;
		$phone_number = $request->phone_number;
		$email = $request->email;
		DB::table('otp_master')->where('phone_no', $phone_number)->delete();
		$otp = rand(1000, 9999);
		// $msg = "" . $otp . " is the OTP for NETREACH website.\n Validity 60 seconds only \n The Humsafar Trust";

		$msg = "" . $otp . " is the OTP for NETREACH website. Validity 60 seconds only The Humsafar Trust";

		// Log::info('Verify OTP MSG :' . $msg, []);
		Log::info('Verify OTP MSG', ['msg' => $msg]);

		$ph = $phone_number;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "http://49.50.67.32/smsapi/httpapi.jsp?username=hamsaotp&password=hum@678&from=THEHUM&to=" . $ph . "&text=" . urlencode($msg) . "&pe_id=1701166074335356091&template_id=1707166607845969067");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		$response = curl_exec($ch);

		Log::info('Verify OTP RESPONSE :', ['response' => $response]);

		curl_close($ch);

		$user = OTPMaster::create([
			'otp' => $otp,
			'phone_no' => $phone_number,
		]);
		session(['name' => $name]);
		//session(['phone_number'=> $phone_number]);
		$request->session()->put('phone_number', $phone_number);
		session(['email' => $email]);


		//WhatsApp Message Send for VerifyOTP
		$messageData = [
			'message' => [
				'channel' => 'WABA',
				'content' => [
					'preview_url' => false,
					'type' => 'TEMPLATE',
					'template' => [
						'templateId' => 'otp',
						'parameterValues' => (object) [
							"0" => $otp
						]
					],
					'shorten_url' => true
				],
				'recipient' => [
					'to' => '91' . $ph,
					'recipient_type' => 'individual',
					'reference' => [
						'cust_ref' => '',
						'messageTag1' => '',
						'conversationId' => ''
					]
				],
				'sender' => [
					'name' => 'Humsafar_netrch',
					'from' => env('AISENSY_FROM_NO')
				],
				'preferences' => [
					'webHookDNId' => '1001'
				]
			],
			'metaData' => [
				'version' => 'v1.0.9'
			]
		];

		// dd(json_encode($messageData));

		Log::info('WtsUp_Message_Data', [$messageData]);

		Log::info('...WtsUp_OTP_VERIFY...');

		$response = $this->aisensyService->sendMessage($messageData);

		$responseArray = json_decode($response, true);

		if (isset($responseArray['statusCode']) && $responseArray['statusCode'] == 200) {
			return json_encode(array('statusCode' => 200, 'msg' => 'otp sent successfully ' . $otp));
		} else {
			return json_encode(array('statusCode' => 201, 'msg' => 'otp not sent successfully'));
		}

		// return view('home.survey.varify-otp',compact('name','phone_number','email'));
	}

	public function get_geolocation($visitorIP = '')
	{
		if (empty($visitorIP))
			$visitorIP = $_SERVER['REMOTE_ADDR'];

		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://api.ipstack.com/$visitorIP?access_key=b2f24e08b257afe5b083c46dc9e372d4",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'GET',
		));
		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);
		//echo $response;
		if ($err) {
			return "cURL Error #:" . $err;
		} else {
			$JsonObj = json_decode($response, true);
			$JsonArr = array(
				"country_code" => $JsonObj["country_code"],
				"country_name" => $JsonObj["country_name"],
				"city" => $JsonObj["city"],
				"postal" => $JsonObj["zip"],
				"latitude" => $JsonObj["latitude"],
				"longitude" => $JsonObj["longitude"],
				"IPv4" => $JsonObj["ip"],
				"state" => $JsonObj["region_name"],
				"timezone" => $JsonObj["time_zone"],
				"location" => $JsonObj["location"],
				"currency" => $JsonObj["currency"],
				"connection" => $JsonObj["connection"]
			);
			return json_encode($JsonArr);
		}
	}
	public function services_required_submit(Request $request)
	{

		$services = $request->services;
		$survery_id = Session::get('survery_id');
		$survery_obj = Surveys::find($survery_id);
		$survery_obj->services_required = $services;
		$survery_obj->save();
		return redirect("book-appoinment");
	}

	public function services_required()
	{
		return view('home.survey.services-required');
	}

	public function get_district_list(Request $request)
	{
		$state_id = $request->state_id;
		$results = DistrictMaster::where('state_id', $state_id)->get();
		$centre_results = CentreMaster::where(['state_code' => $state_id])->orderBy('centre_master.name', 'asc')->get();
		echo json_encode(array("results" => $results, "centre_results" => $centre_results));
		exit;
	}
	public function serch_by_district_centre(Request $request)
	{
		$district_id = $request->district_id;
		$results = CentreMaster::where(['district_id' => $district_id])->orderBy('centre_master.name', 'asc')->get();
		echo json_encode(array("results" => $results));
		exit;
	}
	public function home_custom(Request $request)
	{
		return view('home.index');
	}
	public function about_us(Request $request, $lang = null)
	{
		$locale = app()->getLocale();
		$post = Post::where('slug', 'about-us')->first();
		if ($locale == 'mr') {
			$content = $post->post_body_mr;
		} elseif ($locale == 'hi') {
			$content = $post->post_body_hi;
		} elseif ($locale == 'ta') {
			$content = $post->post_body_ta;
		} elseif ($locale == 'te') {
			$content = $post->post_body_te;
		} else {
			$content = $post->post_body;
		}
		return view('home.about-us', compact('content'));
	}
	public function privacy_policy(Request $request)
	{
		$content = Post::where(["slug" => "privacy-policy"])->first()->post_body;
		return view('home.privacy-policy', compact('content'));
	}
	public function faq_us(Request $request)
	{
		$locale = app()->getLocale();
		$post = Post::where('slug', 'faqs')->first();
		if ($locale == 'mr') {
			$content = $post->post_body_mr;
		} elseif ($locale == 'hi') {
			$content = $post->post_body_hi;
		} elseif ($locale == 'ta') {
			$content = $post->post_body_ta;
		} elseif ($locale == 'te') {
			$content = $post->post_body_te;
		} else {
			$content = $post->post_body;
		}
		// $content = $post->post_body;
		return view('home.faqs', compact('content'));
	}
	public function contact_us(Request $request)
	{
		return view('home.contact-us');
	}

	public function our_team(Request $request)
	{
		return view('home.our-team');
	}

	public function blog(Request $request)
	{
		if (request('search') != "") {
			$blogs = Blog::orderBy('blog_id', 'DESC')->where('title', 'like', '%' . request('search') . '%')
				->orWhere('tags', 'like', '%' . request('search') . '%')
				->paginate(6);
		} else {
			$locale = app()->getlocale();
			$blogs = Blog::where('status', 1)->orderBy('blog_id', 'DESC')->paginate(6);
		}

		return view('home.blog', compact('blogs', 'locale'));
	}
	// public function blog_details($id, $title, $lang = 'en')
	// {
	// 	// $locale = session('locale');
	// 	$locale = app()->getLocale(); // Get current locale from Laravel

	// 	// Retrieve the blog post based on the provided ID
	// 	$blog = Blog::with('blogCategories')->with('users')->find($id);

	// 	// Retrieve related blogs, excluding the current blog
	// 	$related_blogs = Blog::orderBy('blog_id', 'DESC')
	// 						 ->where("blog_id", "!=", $id)
	// 						 ->limit(3)
	// 						 ->get();

	// 	// Return the view with the data
	// 	return view('home.blog_details', compact('blog', 'related_blogs', 'locale'));
	// }
	// public function blog_details($lang, $id, $title)
	// public function blog_details($id, $title)

	public function blog_details2($id, $title)
	{
		// $locale = session('locale');
		$locale = app()->getlocale();
		$blog = Blog::with('blogCategories')->with('users')->find($id);
		$related_blogs = Blog::orderBy('blog_id', 'DESC')->where("blog_id", "!=", $id)->limit(3)->get();
		return view('home.blog_details', compact('blog', 'related_blogs', 'locale'));
	}
	public function blog_details($lang, $id, $title)
	{
		// $locale = session('locale');
		$locale = app()->getlocale();
		$blog = Blog::with('blogCategories')->with('users')->find($id);
		$related_blogs = Blog::orderBy('blog_id', 'DESC')->where("blog_id", "!=", $id)->limit(3)->get();
		return view('home.blog_details', compact('blog', 'related_blogs', 'locale'));
	}



	public function disclaimer()
	{
		// if (session('locale'))
		// 	$locale = session('locale');
		// else
		// 	$locale = app()->getlocale();

		// dd($locale);
		return view('home.disclaimer');
	}

	public function getSurvayUniqueid($txtid)
	{
		$results = BookAppinmentMaster::where(["survey_unique_ids" => $txtid])->get();
		if ($results->count() > 0) {
			$digits = 10;
			$uniqueAPIReqNo = time() . rand(pow(10, $digits - 1), pow(10, $digits) - 1);
			self::getSurvayUniqueid($uniqueAPIReqNo);
		} else {
			return $txtid;
		}
	}

	public function book_appoinment_submit(Request $request)
	{
		$rule = array();
		if ($request->search_by == "by_ditrict") {
			$rule['state'] = 'required';
		} else if ($request->search_by == "by_pin_code") {
			$rule['pincode'] = 'required|regex:/\b\d{6}\b/';
		}
		$rule['search_by'] = 'required';
		$rule['app_date'] = 'required|date_format:Y-m-d';
		$rule['center'] = 'required';
		$validator = Validator::make($request->all(), $rule);
		if ($validator->fails()) {
			return redirect('book-appoinment')
				->withErrors($validator)
				->withInput();
		}
		$digits = 10;
		$uniqueAPIReqNo = time() . rand(pow(10, $digits - 1), pow(10, $digits) - 1);
		$txnt = $this->getSurvayUniqueid($uniqueAPIReqNo);
		$survery_id = session('survery_id');
		$user_id = session('user_id');
		try {
			$obj = new BookAppinmentMaster();
			$obj->survey_unique_ids = $txnt;
			$obj->e_referral_no = date('dmYHis');
			$obj->serach_by = $request->search_by;
			if ($request->search_by == "by_ditrict") {
				if (!empty($request->district)) {
					$obj->district_id = $request->district;
				} else {
					$centreWithOutCity = CentreMaster::where('id', $request->center)->first();
					$obj->district_id = $centreWithOutCity->district_id;
				}
				$obj->state_id = $request->state;
			} else if ($request->search_by == "by_pin_code") {
				$obj->pincode = $request->pincode;
				$centreInfoByPin = CentreMaster::select('district_master.state_code', 'district_master.district_code')
					->join('district_master', 'district_master.district_code', '=', 'centre_master.district_id')
					->where('pin_code', $request->pincode)
					->first();
				$obj->district_id = $centreInfoByPin->district_code;
				$obj->state_id = $centreInfoByPin->state_code;
			}
			$obj->appoint_date = $request->app_date;
			$obj->user_id = $user_id;
			$obj->survey_id = $survery_id;
			$obj->center_ids = $request->center;
			$obj->save();
			if ($obj->id > 0) {
				$SurUpCtr = BookAppinmentMaster::where(["survey_id" => $survery_id])->get();
				if ($SurUpCtr->count() > 0) {
					$SurveysUpdate = Surveys::find($survery_id);
					$newPost = $SurveysUpdate->replicate();
					$newPost->created_at = date('Y-m-d H:i:s');
					$newPost->save();
					if ($newPost->id > 0) {
						$updateBook = BookAppinmentMaster::find($obj->id);
						$updateBook->survey_id = $newPost->id;
						$updateBook->save();
					}
				}
				$book_results = BookAppinmentMaster::select('surveys.user_id', 'surveys.your_age', 'surveys.identify_yourself', 'surveys.identify_others', 'surveys.sexually', 'surveys.hiv_infection', 'surveys.risk_level', 'surveys.services_required', 'customers.name as client_name', 'customers.email as client_email', 'customers.phone_number', 'book_appinment_master.survey_unique_ids', 'book_appinment_master.e_referral_no', 'book_appinment_master.serach_by', 'book_appinment_master.pincode', 'book_appinment_master.district_id', 'book_appinment_master.state_id', 'book_appinment_master.appoint_date', 'book_appinment_master.created_at as book_date', 'centre_master.name as center_name', 'centre_master.name_counsellor', 'vm_master.name as vm_name', 'vm_master.mobile_number as vm_phone', 'vm_master.vncode', 'state_master.st_cd as statecode', 'book_appinment_master.state_id as state_code_id')
					->join('surveys', 'surveys.id', '=', 'book_appinment_master.survey_id')
					->join('customers', 'customers.id', '=', 'book_appinment_master.user_id')
					->join('centre_master', 'centre_master.id', '=', 'book_appinment_master.center_ids')
					->join('district_master', 'district_master.id', '=', 'centre_master.district_id')
					->leftjoin('vm_master', 'vm_master.state_code', '=', 'district_master.state_code')
					->join('state_master', 'state_master.id', '=', 'district_master.state_id')
					->where('book_appinment_master.id', $obj->id)
					->first();
				$vn_info = VmMaster::select('vm_master.parent_id', 'vm_master.vncode', 'vm_master.name', 'vm_master.last_name', 'vm_master.email', 'vm_master.mobile_number', 'vm_master.region', 'vm_master.state_code')
					->join('users as U', 'U.vms_details_ids', '=', 'vm_master.id')
					->where(["U.user_type" => 2, 'vm_master.status' => 1])->whereRaw('FIND_IN_SET(' . $book_results->state_code_id . ',state_code)')->first();
				if ($vn_info == '') {
					$vn_info = VmMaster::select('vm_master.parent_id', 'vm_master.vncode', 'vm_master.name', 'vm_master.last_name', 'vm_master.email', 'vm_master.mobile_number', 'vm_master.region', 'vm_master.state_code')
						->join('users as U', 'U.vms_details_ids', '=', 'vm_master.id')
						->where(["U.user_type" => 4, 'vm_master.status' => 1])->whereRaw('FIND_IN_SET(' . $book_results->state_code_id . ',state_code)')->first();
				}
				$starting_vms = VmCountStartMaster::where(["state_id" => $book_results->state_code_id])->first();
				if (isset($starting_vms->vm_counting_start) && !empty($starting_vms->vm_counting_start)) {
					$walk_no = ($starting_vms->vm_counting_start + 1);
				} else {
					$walk_no = 1;
				}
				$Manually_Create_Appoinments = 0;
				$existUser = Customer::where('id', $user_id)->whereNotNull('uid')->get();
				if ($existUser->count() > 0) {
					$vnms_id = $existUser[0]->uid;
				} else {
					$booking_by_vn = session('booking_by_vn');
					//echo $booking_by_vn;die;
					if (!empty($booking_by_vn)) {
						$vn_info = '';
						$SmanualVnId = session('link_by_user_id');
						$ctr_by_link = CountVnByLink::where(["user_id" => session('link_by_user_id')])->get();
						if ($ctr_by_link->count() > 0) {
							$ctr = ($ctr_by_link[0]->vn_ctr + 1);
							CountVnByLink::where('user_id', session('link_by_user_id'))->update(['vn_ctr' => $ctr]);
						} else {
							$ctr = 1;
							$ctrSql = new CountVnByLink();
							$ctrSql->vn_ctr = $ctr;
							$ctrSql->user_id = session('link_by_user_id');
							$ctrSql->save();
						}
						$vnms_id = 'NETREACH/' . strtoupper($book_results->statecode) . '/' . strtoupper($booking_by_vn) . '/A' . sprintf('%04d', $ctr);
						$surSql = Surveys::find($survery_id);
						$surSql->platform_id = session('platform_id');
						$surSql->survey_manual_vn_id = $SmanualVnId;
						$surSql->save();
						/*$vn_info = VmMaster::select('vm_master.vncode', 'vm_master.name', 'vm_master.last_name', 'vm_master.email','vm_master.mobile_number','vm_master.region','vm_master.state_code','vm_master.status','vm_master.created_at','vm_master.updated_at')->join('users', 'users.vms_details_ids', '=', 'vm_master.id')->where('users.id', $SmanualVnId)->get();*/
						$vn_info = VmMaster::select('vm_master.parent_id', 'vm_master.vncode', 'vm_master.name', 'vm_master.last_name', 'vm_master.email', 'vm_master.mobile_number', 'vm_master.region', 'vm_master.state_code', 'vm_master.status', 'vm_master.created_at', 'vm_master.updated_at')
							->join('users as U', 'U.vms_details_ids', '=', 'vm_master.id')
							->where(["U.user_type" => 2, 'U.status' => 1, "U.id" => $SmanualVnId])->first();
						Session::forget('booking_by_vn');
						Session::forget('platform_id');
						Session::forget('link_by_user_id');
						Session::forget('book_by_link');
					} else {
						// Genrated 
						VmCountStartMaster::where('state_id', $book_results->state_code_id)->update(['vm_counting_start' => $walk_no]);
						$vnms_id = 'NETREACH/' . strtoupper($book_results->statecode) . '/WALK/A' . sprintf('%04d', $walk_no);
					}
					Customer::where('id', $user_id)->update(['uid' => $vnms_id]);
				}
				$serviceJson = [];
				if (isset($book_results->services_required)) {
					$servicesArr = json_decode($book_results->services_required);
					$services = array(
						"1" => "HIV Test",
						"2" => "STI Services",
						"3" => "PrEP",
						"4" => "PEP",
						"5" => "Counselling on Mental Health",
						"6" => "Referral to TI services",
						"7" => "ART Linkages"
					);
					foreach ($services as $key => $value) {
						if (in_array($key, $servicesArr))
							$serviceJson[] = $value;
					}
				}
				$s = implode(",", $serviceJson);
				$pdf = PDF::loadView('pdf.document', ["book_results" => $book_results, "UID" => $vnms_id, 'vn_info' => $vn_info]);
				$name = $txnt . '.pdf';
				$path = storage_path("app/public/pdf/" . $name);
				$pdf->save($path);
				$reg = date("Y-m-d", strtotime($book_results->book_date));
				//echo $rg;die;				
				$center_name = str_replace("-", " ", $book_results->center_name);
				$center_name = substr($center_name, 0, 25);
				// $contact = $vn_info->mobile_number . " " . $vn_info->name;
				// $msg = "Dear ".$book_results->client_name." UID:".$vnms_id." Center:".$center_name." Appointment Date:".$book_results->appoint_date." Service Req:".$s." Contact:".$contact." The Humsafar Trust - NETREACH";
				if (!empty($vn_info)) {
					$msg = "Your appointment is booked successfully. For any further assistance, please contact " . $vn_info->name . " on mobile number " . $vn_info->mobile_number . " . The Humsafar Trust - NETREACH";

					Log::info('Book Appointment MSG :', $msg);

					$ph = $book_results->phone_number . ',' . $vn_info->mobile_number;
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, "http://49.50.67.32/smsapi/httpapi.jsp?username=hamsaotp&password=hum@678&from=THEHUM&to=" . $ph . "&text=" . urlencode($msg) . "&pe_id=1701166074335356091&template_id=1707168078030025497");
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($ch, CURLOPT_HEADER, 0);

					$response_appointment = curl_exec($ch);

					Log::info('Book Appointment RESPONSE :', [$response_appointment]);

					curl_close($ch);

					//$this->whatsaap_api($book_results->client_name, $vnms_id, $center_name, $book_results->appoint_date, $s, $book_results->phone_number, $vn_info->name, $vn_info->mobile_number);
				}
				$full_id = $txnt . "$$" . $obj->id;
				$newTnx = Crypt::encryptString($full_id);
				$request->session()->put('confirm_txnt', $newTnx);
				$request->session()->put('confirm_id', $obj->id);
				return redirect("appointment-confirmed/$newTnx");
			}
		} catch (\Exception $e) {
			Log::error($e);
			return redirect('book-appoinment')
				->withErrors("Virtual Nnavigator(VN) is Not Avaliable for this State :")
				->withInput();
		}
	}

	public function appointment_confirmed(Request $request, $pdf_id)
	{
		$name = $request->name;
		$decrypted = Crypt::decryptString($pdf_id);
		$ids = explode("$$", $decrypted);
		$obj = BookAppinmentMaster::select('book_appinment_master.survey_unique_ids', 'customers.uid')
			->join('customers', 'customers.id', '=', 'book_appinment_master.user_id')
			->where('book_appinment_master.id', end($ids))
			->get();
		//$obj = BookAppinmentMaster::where(["id"=>end($ids)])->get();
		if ($obj->count() > 0) {
			$book_pdf = $obj[0]->survey_unique_ids . ".pdf";
			$uid = $obj[0]->uid;
		} else {
			return redirect("/");
		}
		return view('home.survey.appointment-confirmed', ['book_pdf' => $book_pdf, "uid" => $uid, "name" => $name]);
	}

	public function generate_pdf()
	{
		$data = ['foo' => 'bar'];
		$pdf = PDF::loadView('pdf.document', $data);
		// there is extra 'dot' that I removed
		$name = 'contract' . time() . '.pdf';
		$path = storage_path("app/public/pdf/" . $name);
		// to save to storage folder
		$pdf->save($path);
		return $pdf->stream('document.pdf');
	}
	// Admin Part
	public function whatsaap_api($client_name, $vnms_id, $center_name, $appoint_date, $s, $phone_number, $name, $mobile_number)
	{
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://rcmapi.instaalerts.zone/services/rcm/sendMessage',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => '{ 
			   "message":{ 
			      "channel":"WABA", 
			      "content":{ 
			         "preview_url":false, 
			         "type":"TEMPLATE", 
			         "template":{ 
			            "templateId":"whatsaap_new_one_28012023", 
			            "parameterValues":{ 
			              "0":"' . $client_name . '",
			               "1":"' . $vnms_id . '",
			               "2":"' . $center_name . '",
			               "3":"' . $appoint_date . '",
			               "4":"' . $s . '",
			               "5":"' . $phone_number . '",
			               "6":"' . $name . '",
			               "7":"' . $mobile_number . '"
			            } 
			         } 
			      }, 
			      "recipients": [
			            {
			                "to":"' . $phone_number . '",
			                "recipient_type": "individual"
			            },
			            {
			                "to":"' . $mobile_number . '",
			                "recipient_type": "individual"
			            }],
			      "sender":{ 
			         "from":"918097522280" 
			      }, 
			      "preferences":{ 
			         "webHookDNId":"1001" 
			      } 
			   }, 
			   "metaData":{ 
			      "version":"v1.0.9" 
			   } 
			} 
			',
			CURLOPT_HTTPHEADER => array(
				'Content-Type: application/json',
				'Authentication: Bearer ssBVvBA0CQCEJNFjiLjjCg==',
				'Authorization: Basic SHVtc2FmYXJfbmV0cmNoOk5ldHJlYWNoQDEyMw=='
			),
		));
		$response = curl_exec($curl);
		curl_close($curl);
		echo $response;
	}
}
