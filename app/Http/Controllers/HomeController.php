<?php


namespace App\Http\Controllers;

use App\Exports\{QuestionariesExport, SelfAppointments, SelfRiskAssessment};
use App\Models\SelfModule\{Appointments, RiskAssessment, RiskAssessmentAnswer, RiskAssessmentItems, RiskAssessmentQuestionnaire};
use App\Models\Platform;
use App\Models\CentreMaster;
use App\Models\DistrictMaster;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Surveys;
use App\Models\Outreach\Profile;
use App\Models\VmMaster;
use App\Models\BookAppinmentMaster;
use App\Models\StateMaster;
use App\Models\Customer;
use App\Services\GoogleAnalyticsService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;


class HomeController extends Controller
{

		public function test(){
			if(request()->is('api/*')){

				return response()->json(['message' => 'API working fine']);
			}
				dd('asdsad');
			// dd(base_path(env('FIREBASE_CREDENTIALS')));
		}






	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */

	protected $analytics;

	public function __construct(GoogleAnalyticsService $analytics)
	{
		$this->analytics = $analytics;
	}
	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Contracts\Support\Renderable
	 */
	const REASON_FOR_NOT_ACCESSING = array(1 => 'Covid issues', 2 => 'Testing center closed', 3 => 'Unable to reach on time', 4 => 'Inconvenient timings', 5 => 'Out of station', 6 => 'Lack of time', 7 => 'Fear of being positive', 8 => 'Unwell', 9 => 'Center staff behaviour', 10 => 'Testing kit unavailable', 11 => 'Centre is crowded', 12 => 'Weather issue', 13 => 'Lost contact with client', 14 => 'Centre is far away', 15 => 'Afraid of being noticed', 16 => 'Long waiting time', 17 => 'No update from client', 18 => 'Unable to locate centre', 19 => 'Expensive', 99 => 'Others');
	const OUTCOME = array(1 => 'Reactive', 2 => 'Non-reactive', 3 => 'Not disclosed');
	public function index()
	{
		$conArr = [0, 1];
		if (Auth::user()->hasRole('VN User Permission')) {
			$vms_details_ids = Auth::user()->vms_details_ids;
			$results = VmMaster::find($vms_details_ids);
			if (!empty($results->state_code)) {
				$stateArr = explode(",", $results->state_code);
			} else {
				$stateArr = StateMaster::pluck('id')->toArray();
			}
		} else if (Auth::user()->hasRole('Counsellor-Permission')) {
			$stateArr = array();
			$state_code_ids = '';
			$vms_details_ids = Auth::user()->vms_details_ids;
			$results = VmMaster::where(["parent_id" => $vms_details_ids])->get();
			if ($results->count() > 0) {
				foreach ($results as $key => $val) {
					if ($val->state_code == '')
						continue;
					$state_code_ids .= $val->state_code . ",";
				}
				$state_code_ids = rtrim($state_code_ids, ',');
			} else {
				$stateArr = StateMaster::pluck('id')->toArray();
			}
			$conArr = [1];
			if (!empty($state_code_ids))
				$stateArr = explode(",", $state_code_ids);
		} else if (Auth::user()->hasRole('PO-Permission')) {
			$region = Auth::user()->vndetails()->first()->region;
			if (Auth::user()->vndetails()->first()->regions_list != null) {

				$regions_list = Auth::user()->vndetails()->first()->regions_list;
				$vals = [];
				foreach ($regions_list as $reg) {
					if ($reg == "north") $vals[] = 1;
					if ($reg == "south") $vals[] = 2;
					if ($reg == "east") $vals[] = 3;
					if ($reg == "west") $vals[] = 4;
				}
				$stateArr = StateMaster::whereIn('region', $vals)->pluck('id')->toArray();
			} else {
				if ($region == "north") $regx[] = 1;
				if ($region == "south") $regx[] = 2;
				if ($region == "east") $regx[] = 3;
				if ($region == "west") $regx[] = 4;
				$stateArr = StateMaster::where('region', $regx)->pluck('id')->toArray();
			}
		} else {
			$stateArr = StateMaster::pluck('id')->toArray();
		}

		/* Newly Added Count */
		if (Auth::user()->id == 1) {
			$newlyAddedCountVar = RiskAssessment::whereDate('created_at', date('Y-m-d'))->get();
		} else {
			$newlyAddedCountVar = RiskAssessment::whereIn('state_id', $stateArr)->whereDate('created_at', date('Y-m-d'))->get();
		}

		/*$newlyadded = Surveys::join('book_appinment_master', 'book_appinment_master.survey_id', '=', 'surveys.id')->where(["client_type"=>1])->get();	*/
		$followupcnts = Surveys::select(
			'U.name AS client_name',
			'U.phone_number as client_phone_number',
			'surveys.client_type',
			'BAM.created_at as book_date',
			'D.district_name',
			'SM.state_name',
			'surveys.your_age',
			'surveys.identify_yourself',
			'surveys.target_population',
			'surveys.risk_level',
			'U.uid',
			'surveys.services_required',
			'CM.services_avail',
			'BAM.appoint_date',
			'CM.name as center_name',
			'platforms.name as platforms_name',
			'surveys.hiv_test',
			'surveys.id as survey_ids',
			'surveys.flag',
			'vn_upload_survey_files.acess_date',
			'vn_upload_survey_files.pid',
			'vn_upload_survey_files.outcome'
		)
			->join('customers as U', 'U.id', '=', 'surveys.user_id')
			->join('book_appinment_master as BAM', 'BAM.survey_id', '=', 'surveys.id')
			->join('centre_master as CM', 'CM.id', '=', 'BAM.center_ids')
			->join('district_master as D', 'D.id', '=', 'CM.district_id')
			->join('state_master as SM', 'SM.state_code', '=', 'D.state_code')
			->leftJoin('platforms', 'platforms.id', '=', 'surveys.platform_id')
			->leftJoin('vn_upload_survey_files', 'vn_upload_survey_files.survey_id', '=', 'surveys.id')
			->whereIn('BAM.state_id', $stateArr)
			->where(["surveys.client_type" => 2])
			->whereIn('surveys.survey_co_flag', $conArr)
			->groupBy('surveys.id')
			->get();
		/* Followup Count */
		$followupCountVar = Surveys::select('*')
			->join('book_appinment_master as BAM', 'BAM.survey_id', '=', 'surveys.id')
			->whereIn('BAM.state_id', $stateArr)
			->where(["surveys.client_type" => 2])
			->whereIn('surveys.survey_co_flag', $conArr)
			->groupBy('surveys.id')
			->get();
		// $client_take_test = Appointments::all();
		if (Auth::user()->id == 1) {
			$client_take_test = Appointments::whereNotNull("outcome_of_the_service_sought")
				->where("outcome_of_the_service_sought", '!=', 3)
				->get();
		} else {
			$client_take_test = Appointments::whereIn('state_id', $stateArr)->whereNotNull("outcome_of_the_service_sought")
				->where("outcome_of_the_service_sought", '!=', 3)
				->get();
		}

		if (Auth::user()->id == 1) {
			$report_results = Appointments::where("outcome_of_the_service_sought", 1)->get();
		} else {
			$report_results = Appointments::where("outcome_of_the_service_sought", 1)->whereIn('state_id', $stateArr)->get();
		}
		/*$report_results = Surveys::join('book_appinment_master', 'book_appinment_master.survey_id', '=', 'surveys.id')
		->join('vn_upload_survey_files','vn_upload_survey_files.survey_id', '=', 'surveys.id')->where(["vn_upload_survey_files.outcome"=>2])->get();*/
		$evidence_shared = Surveys::select(
			'U.name AS client_name',
			'U.phone_number as client_phone_number',
			'surveys.client_type',
			'BAM.created_at as book_date',
			'D.district_name',
			'SM.state_name',
			'surveys.your_age',
			'surveys.identify_yourself',
			'surveys.target_population',
			'surveys.risk_level',
			'U.uid',
			'surveys.services_required',
			'CM.services_avail',
			'BAM.appoint_date',
			'CM.name as center_name',
			'platforms.name as platforms_name',
			'surveys.hiv_test',
			'surveys.id as survey_ids',
			'surveys.flag',
			'vn_upload_survey_files.acess_date',
			'vn_upload_survey_files.pid',
			'vn_upload_survey_files.outcome'
		)
			->join('customers as U', 'U.id', '=', 'surveys.user_id')
			->join('book_appinment_master as BAM', 'BAM.survey_id', '=', 'surveys.id')
			->join('centre_master as CM', 'CM.id', '=', 'BAM.center_ids')
			->join('district_master as D', 'D.id', '=', 'CM.district_id')
			->join('state_master as SM', 'SM.state_code', '=', 'D.state_code')
			->leftJoin('platforms', 'platforms.id', '=', 'surveys.platform_id')
			->leftJoin('vn_upload_survey_files', 'vn_upload_survey_files.survey_id', '=', 'surveys.id')
			->whereIn('BAM.state_id', $stateArr)
			->where("surveys.flag", '=', 1)
			->whereIn('surveys.survey_co_flag', $conArr)
			->groupBy('surveys.id')
			->get();
		/*$evidence_shared  = Surveys::join('book_appinment_master', 'book_appinment_master.survey_id', '=', 'surveys.id')->where("surveys.platform_id",'>',0)->get();*/

		if (Auth::user()->id == 1) {
			$man_cre_app = Profile::all();
		} elseif (Auth::user()->user_type == 3) {
			$query =  Profile::with(['user', 'state', 'district', 'client_type', 'target', 'platform', 'mentioned_platform', 'gender', 'response', 'referral_service'])->where(Profile::is_deleted, false);

			// if (in_array(Auth::user()->getRoleNames()->first(), [VN_USER_PERMISSION, COUNSELLOR_PERMISSION])) $query = $query->where(Profile::user_id, Auth::id());

			if (Auth::user()->getRoleNames()->first() == PO_PERMISSION && !empty(Auth::user()->vndetails()->first())) {
				$regions_list = Auth::user()->vndetails()->first()->regions_list;
				if ($regions_list) {
					$vals = [];
					foreach ($regions_list as $reg) {
						if ($reg == "north") $vals[] = 1;
						if ($reg == "south") $vals[] = 2;
						if ($reg == "east") $vals[] = 3;
						if ($reg == "west") $vals[] = 4;
					}
					$query = $query->whereIn(Profile::region_id, $vals);
				} else {

					$query = $query->where(Profile::region_id, array_search(ucwords(Auth::user()->vndetails()->first()->region), REGION));
				}
			}

			$man_cre_app = $query->get();
		} else {
			$man_cre_app = Profile::where("user_id", Auth::user()->id)->get();
		}

		if (Auth::user()->id == 1) {
			$book = Appointments::all();
			$today_book = Appointments::whereDate('appointment_date', date('Y-m-d'))->get();
		} else {

			$book = Appointments::whereIn('state_id', $stateArr)->get();
			$today_book = Appointments::whereDate('appointment_date', date('Y-m-d'))->whereIn('state_id', $stateArr)->get();
		}

		if (Auth::user()->id == 1) {
			$total_no_of_clients_not_taken_test = Appointments::where(function ($query) {
				$query->whereNull("outcome_of_the_service_sought")
					->orWhere("outcome_of_the_service_sought", 3);
			})->get();
		} else {
			$total_no_of_clients_not_taken_test = Appointments::whereIn('state_id', $stateArr)->where(function ($query) {
				$query->whereNull("outcome_of_the_service_sought")
					->orWhere("outcome_of_the_service_sought", 3);
			})->get();
		}



		$totalPageViews = 0;

		try {
			$propertyId = env('GOOGLE_ANALYTICS_PROPERTY_ID');
			$startDate = '2015-08-14';
			$endDate = Carbon::now()->format('Y-m-d');
			$data = $this->analytics->getAnalyticsData(
				$propertyId,
				$startDate,
				$endDate,
				['screenPageViews'],
				[]
			);

			// Sum the screenPageViews
			foreach ($data as $row) {
				$totalPageViews += $row->getMetricValues()[0]->getValue();
			}
		} catch (\Throwable $th) {
			//throw $th;
		}

		return view('home', compact('book', 'today_book', 'followupcnts', 'client_take_test', 'report_results', 'evidence_shared', 'man_cre_app', 'total_no_of_clients_not_taken_test', 'followupCountVar', 'newlyAddedCountVar', 'totalPageViews'));
	}
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function refreshCaptcha()
	{
		return response()->json(['captcha' => captcha_img('flat')]);
	}
	public function dashboard_report(Request $request)
	{
		// dd(Auth::user(), $request->report_pos);
		$report_pos = (int)$request->report_pos;


		$conArr = [0, 1];
		//dd(Auth::user()->vms_details_ids);
		if (Auth::user()->hasRole('VN User Permission')) {
			$vms_details_ids = Auth::user()->vms_details_ids;
			$results = VmMaster::find($vms_details_ids);
			if (!empty($results->state_code)) {
				$stateArr = explode(",", $results->state_code);
			} else {
				$stateArr = StateMaster::pluck('id')->toArray();
			}
		} else if (Auth::user()->hasRole('Counsellor-Permission')) {
			$stateArr = array();
			$state_code_ids = '';
			$vms_details_ids = Auth::user()->vms_details_ids;
			$results = VmMaster::where(["parent_id" => $vms_details_ids])->get();
			if ($results->count() > 0) {
				foreach ($results as $key => $val) {
					if ($val->state_code == '')
						continue;
					$state_code_ids .= $val->state_code . ",";
				}
				$state_code_ids = rtrim($state_code_ids, ',');
			} else {
				$stateArr = StateMaster::pluck('id')->toArray();
			}
			$conArr = [1];
			if (!empty($state_code_ids))
				$stateArr = explode(",", $state_code_ids);
		} else if (Auth::user()->hasRole('PO-Permission')) {
			$region = $request->user()->vndetails()->first()->region;
			if ($request->user()->vndetails()->first()->regions_list != null) {

				$regions_list = $request->user()->vndetails()->first()->regions_list;
				$vals = [];
				foreach ($regions_list as $reg) {
					if ($reg == "north") $vals[] = 1;
					if ($reg == "south") $vals[] = 2;
					if ($reg == "east") $vals[] = 3;
					if ($reg == "west") $vals[] = 4;
				}
				$stateArr = StateMaster::whereIn('region', $vals)->pluck('id')->toArray();
			} else {
				if ($region == "north") $regx[] = 1;
				if ($region == "south") $regx[] = 2;
				if ($region == "east") $regx[] = 3;
				if ($region == "west") $regx[] = 4;
				$stateArr = StateMaster::where('region', $regx)->pluck('id')->toArray();
			}
		} else {

			$stateArr = null;
		}
		if ($report_pos == 1 || $report_pos == 4 || $report_pos == 3 || $report_pos == 9 || $report_pos == 5) {


			$dataholder = Appointments::getAllAppointmentsDashboard($request, $stateArr, $report_pos);
			$survey = $dataholder['data'];
			$count = $dataholder['count'];


			$appointments = collect()->make();
			foreach ($survey as $value) {

				$id = $value[Appointments::appointment_id];
				$direct = $request->filled('export') ? 'Direct Link' : view('self.admin.ajax.direct')->render();
				$temp = [
					'sr_no' => $id,
					'assessment_no' => $value[Appointments::assessment_id],
					// 'html' => $html,
					'ra_date' => Carbon::parse($value[Appointments::created_at])->format(READABLE_DATETIME),
					RiskAssessment::risk_score => !empty($value['assessment']) ? $value['assessment'][RiskAssessment::risk_score] : 0,
					Appointments::appointment_date => Carbon::parse($value[Appointments::appointment_date])->format('d M Y'),
					Appointments::date_of_accessing_service => $value[Appointments::date_of_accessing_service],
					Appointments::not_access_the_service_referred => !empty($value[Appointments::not_access_the_service_referred]) ? self::REASON_FOR_NOT_ACCESSING[$value[Appointments::not_access_the_service_referred]] : null,
					Appointments::pid_provided_at_the_service_center => $value[Appointments::pid_provided_at_the_service_center],
					'vn_name' => !empty($value['vn_details']) ? $value['vn_details']['name'] : $direct,
					Appointments::full_name => $value[Appointments::full_name],
					Appointments::mobile_no => $value[Appointments::mobile_no],
					Appointments::services => $value[Appointments::service_list],
					'state' => isset($value['state']) && !empty($value['state']) ? $value['state']['state_name'] : null,
					'district' => isset($value['district']) && !empty($value['district']) ? $value['district']['district_name'] : null,
					'center' => isset($value['center']) && !empty($value['center']) ? $value['center']['name'] : null,
					Appointments::referral_no => $value[Appointments::referral_no],
					Appointments::uid => $value[Appointments::uid],
					Appointments::type_of_test => is_null($value[Appointments::type_of_test]) ? null : ($value[Appointments::type_of_test] == 1 ? "Screening" : "Confirmatory"),
					Appointments::treated_state_id => is_null($value[Appointments::treated_state_id]) ? null : StateMaster::getOneStateName($value[Appointments::treated_state_id]),
					Appointments::treated_district_id => is_null($value[Appointments::treated_district_id]) ? null :  DistrictMaster::getOneDistrictName($value[Appointments::treated_district_id]),
					Appointments::treated_center_id => is_null($value[Appointments::treated_center_id]) ? null : CentreMaster::getOneCentreName($value[Appointments::treated_center_id]),
					Appointments::outcome_of_the_service_sought => !empty($value[Appointments::outcome_of_the_service_sought]) ? self::OUTCOME[$value[Appointments::outcome_of_the_service_sought]] : null,
					Appointments::remark => $value[Appointments::remark],
					Appointments::pre_art_no => is_null($value[Appointments::pre_art_no]) ? null : $value[Appointments::pre_art_no],
					Appointments::on_art_no => is_null($value[Appointments::on_art_no]) ? null : $value[Appointments::on_art_no],
					Appointments::updated_by => is_null($value[Appointments::updated_by]) ? null : $value['updatedBy']['name'],
					Appointments::updated_at => is_null($value[Appointments::updated_at]) ? null : parseDateTime($value[Appointments::updated_at], READABLE_DATETIME)
				];

				if ($request->filled('export')) {
					$temp['ra-month'] = is_null($value[Appointments::created_at]) ? null : Carbon::parse($value[Appointments::created_at])->format(MONTH_YEAR);
					$temp['appointment-month'] = is_null($value[Appointments::appointment_date]) ? null : Carbon::parse($value[Appointments::appointment_date])->format(MONTH_YEAR);
					$temp['month-of-accessing-service'] = is_null($value[Appointments::date_of_accessing_service]) ? null : Carbon::parse($value[Appointments::date_of_accessing_service])->format(MONTH_YEAR);
				}

				$appointments->push($temp);
			}



			if ($request->filled('export'))
				return new SelfAppointments($appointments->all());



			$survey = $appointments;


			$report_heading = "TOTAL NO. OF CLIENTS BOOKED APPOINTMENT";
		} else if ($report_pos == 3 || $report_pos == 4 || $report_pos == 5 || $report_pos == 6) {

			if ($report_pos == 2) {

				$report_heading = "NEWLY ADDED";
				$condition = ["surveys.client_type" => 1];
				if (Auth::user()->id == 1) {
					$survey = RiskAssessment::whereDate('created_at', date('Y-m-d'))->get();
				} else {
					$survey = RiskAssessment::whereIn("state_id", $stateArr)->whereDate('created_at', date('Y-m-d'))->get();
				}

				// if ($request->filled('export')) {
				// 	$questionnaire = RiskAssessmentQuestionnaire::getAllQuestionnaire($request);
				// 	$header2 = $questionnaire->pluck(RiskAssessmentQuestionnaire::question);
				// 	$slug = $questionnaire->pluck(RiskAssessmentQuestionnaire::question_slug);
				// 	return new SelfRiskAssessment($header2->all(), $slug->all(), $survey, false);
				// }
			} else if ($report_pos == 3) {
				$report_heading = "TOTAL NO. OF CLIENTS TAKEN TEST";
			} else if ($report_pos == 4) {
				$report_heading = "Total No. of Clients Identified +ve";
			} else if ($report_pos == 5) {
				$report_heading = "TODAY'S APPOINTMENTS";
				$condition = ["BAM.appoint_date" => date('Y-m-d')];
			} else if ($report_pos == 6) {
				$report_heading = "FOLLOW-UP/OLD CLIENTS";
				$condition = ["surveys.client_type" => 2];
			}
		} elseif ($report_pos == 2) {
			$data = RiskAssessment::whereDate('created_at', date('Y-m-d'));
			$count = $data->count();
			$survey = $data
				->skip($request->integer('start', 0))
				->take($request->integer('length', 10))
				->get();
		} else if ($report_pos == 7) {
			$report_heading = "EVIDENCE SHARED";
			$survey = Surveys::select(
				'U.name AS client_name',
				'U.phone_number as client_phone_number',
				'surveys.client_type',
				'BAM.created_at as book_date',
				'D.district_name',
				'SM.state_name',
				'surveys.your_age',
				'surveys.identify_yourself',
				'surveys.target_population',
				'surveys.risk_level',
				'U.uid',
				'surveys.services_required',
				'CM.services_avail',
				'BAM.appoint_date',
				'CM.name as center_name',
				'platforms.name as platforms_name',
				'surveys.hiv_test',
				'surveys.id as survey_ids',
				'surveys.flag',
				'vn_upload_survey_files.acess_date',
				'vn_upload_survey_files.pid',
				'vn_upload_survey_files.outcome'
			)
				->join('customers as U', 'U.id', '=', 'surveys.user_id')
				->join('book_appinment_master as BAM', 'BAM.survey_id', '=', 'surveys.id')
				->join('centre_master as CM', 'CM.id', '=', 'BAM.center_ids')
				->join('district_master as D', 'D.id', '=', 'CM.district_id')
				->join('state_master as SM', 'SM.state_code', '=', 'D.state_code')
				->leftJoin('platforms', 'platforms.id', '=', 'surveys.platform_id')
				->leftJoin('vn_upload_survey_files', 'vn_upload_survey_files.survey_id', '=', 'surveys.id')
				->whereIn('BAM.state_id', $stateArr)
				->where("surveys.flag", '=', 1)
				->whereIn('surveys.survey_co_flag', $conArr)
				->groupBy('surveys.id')->get();
		} else if ($report_pos == 8) {
			$report_heading = "MANUALLY CREATE APPOINMENTS";





			$data = array();

			$query =  Profile::with(['user', 'state', 'district', 'client_type', 'target', 'platform', 'mentioned_platform', 'gender', 'response', 'referral_service'])->where(Profile::is_deleted, false);

			if (in_array(Auth::user()->getRoleNames()->first(), [VN_USER_PERMISSION, COUNSELLOR_PERMISSION])) $query = $query->where(Profile::user_id, Auth::id());

			if (Auth::user()->getRoleNames()->first() == PO_PERMISSION && !empty($request->user()->vndetails()->first())) {
				$regions_list = $request->user()->vndetails()->first()->regions_list;
				if ($regions_list) {
					$vals = [];
					foreach ($regions_list as $reg) {
						if ($reg == "north") $vals[] = 1;
						if ($reg == "south") $vals[] = 2;
						if ($reg == "east") $vals[] = 3;
						if ($reg == "west") $vals[] = 4;
					}
					$query = $query->whereIn(Profile::region_id, $vals);
				} else {

					$query = $query->where(Profile::region_id, array_search(ucwords($request->user()->vndetails()->first()->region), REGION));
				}
			}



			$count = $query->count();
			$query = $query->skip($request->start)->take($request->length)->orderByDesc(Profile::profile_id)->get();

			if ($query->count() > 0) {
				foreach ($query as $value) {
					$id = $value[Profile::profile_id];
					$unique_serial_number = $value->unique_serial_number;
					$referral = $value->referral_service;

					$statusID = $value->status;
					$status = isset(PROFILE_STATUS[$statusID]) ? PROFILE_STATUS[$statusID] : null;
					if (!empty($status)) $status = view('outreach.ajax.status', compact('statusID', 'status'))->render();
					$statusText = match ($value->status) {
						0 => "Not Assigned",
						1 => "Pending",
						2 => "Accepted",
						3 => "Rejected",
						default => "",
					};

					$data[] = array(
						'profile_id' => $value->profile_id,
						'status_text' => $statusText,
						'comment' => $value->comment,
						'uid' => $value->uid,
						'user_name' => !empty($value->user) ? $value->user->name : null,
						'unique_serial_number' => $value->unique_serial_number,
						'registration_date' => $value->registration_date,
						'state_name' => !empty($value->state) ? $value->state->state_name : null,
						'district_name' => !empty($value->district) ? $value->district->district_name : null,
						'platform_name' => !empty($value->platform) ? $value->platform[Platform::name] : null,
						'other_platform' => $value->other_platform,
						'profile_name' => $value->profile_name,
						'phone_number' => $value->phone_number,
						'remarks' => $value->remarks,
						'age' => $value->age
					);



					// $data[] = array(
					// 	$statusText,
					// 	$value->comment,
					// 	$value->uid,
					// 	!empty($value->user) ? $value->user->name : null,
					// 	$value->unique_serial_number,
					// 	$value->registration_date,
					// 	!empty($value->state) ? $value->state->state_name : null,
					// 	!empty($value->district) ? $value->district->district_name : null,
					// 	!empty($value->platform)  ? $value->platform[Platform::name] : null,
					// 	$value->other_platform,
					// 	$value->profile_name,
					// 	$value->phone_number,
					// 	$value->remarks
					// );
				}
			}
			$survey = $data;
			// $json_data = array(
			// 	"draw"            => intval($request->draw),
			// 	"recordsTotal"    => $total,
			// 	"recordsFiltered" => $total,
			// 	"data"            => $data   // total data array
			// );

			// echo json_encode($json_data);  // send data as json format			
			// exit;






















































			// if (Auth::user()->id == 1) {
			// 	$count = Profile::count();

			// 	$survey = Profile::skip($request->integer('start', 0))
			// 		->take($request->integer('length', 10))->get();
			// } else {
			// 	$survey = Profile::where("user_id", Auth::user()->id)->get();
			// 	$count = $survey->count();
			// }
		} else if ($report_pos == 9) {
			$report_heading = "TOTAL NO. OF CLIENTS NOT TAKEN TEST";
		}
		$genderArr = array("1" => "Male", "2" => "Female", "3" => "Transgender", "4" => "I prefer not to say", "5" => "I prefer not to say", "6" => "Other");
		$services = array("1" => "HIV Test", "2" => "STI Services", "3" => "PrEP", "4" => "PEP", "5" => "Counselling on Mental Health", "6" => "Referral to TI services", "7" => "ART Linkages");

		$json_data = array(
			"draw" => intval($request->draw),
			"recordsTotal" => $count,
			"recordsFiltered" => $count,
			"data" => $survey
		);

		echo json_encode($json_data);
		exit;
	}
	public function get_user_exist_or_not(Request $request)
	{
		$ph_email = $request->ph_email;
		if ($request->type == "mobile") {
			$results = Customer::where(["phone_number" => $ph_email])->get();
			$found = "mobile";
		} else if ($request->type == "email") {
			$results = Customer::where(["email" => $ph_email])->get();
			$found = "email";
		}
		if ($results->count() > 0) {
			echo json_encode(array("results" => "exist", "result_find" => $found));
			exit;
		} else {
			echo json_encode(array("results" => "exist_not", "result_find" => ''));
			exit;
		}
	}


}
