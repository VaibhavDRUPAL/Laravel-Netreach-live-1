<?php

namespace App\Http\Controllers;

use App\Models\SelfModule\{Appointments};

use App\Http\Requests\Self\Admin\Appointment;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use App\Models\Surveys;
use App\Models\CentreMaster;
use App\Models\BookAppinmentMaster;
use App\Models\DistrictMaster;
use App\Models\StateMaster;
use App\Models\VmCountStartMaster;
use App\Models\VmMaster;
use App\Models\Customer;
use App\Models\VnUploadByResults;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;
use Validator;
use Session;
use Carbon\Carbon;

use PDF;
use Illuminate\Support\Facades\DB;
use GuzzleHttp;
use Illuminate\Support\Facades\Crypt;
use App\Exports\SurveysExport;
use App\Models\Outreach\ReferralService;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
	public function __construct()
	{
		// $this->middleware('permission:view-user|view_survey|m-e-user-views|m-e-user-download')->except(['profile', 'profileUpdate', 'display']);
		// $this->middleware('permission:create-user', ['only' => ['create', 'store']]);
		// $this->middleware('permission:update-user', ['only' => ['edit', 'update']]);
		// $this->middleware('permission:destroy-user', ['only' => ['destroy']]);
		//$this->middleware('permission:view_survey')->except(['display']);
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		// print_r('hhh');
		// die;
		if ($request->has('search')) {
			$users = User::where('name', 'like', '%' . $request->search . '%')->where(["user_type" => 1, "vms_details_ids" => 0])->paginate(setting('record_per_page', 15));
		} else {
			$users = User::where(["vms_details_ids" => 0])->paginate(setting('record_per_page', 15));
		}

		$title = 'Manage Users';
		return view('users.index', compact('users', 'title'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Contracts\View\View
	 */
	public function create()
	{
		//die('hello');
		$title = 'Create user';
		$roles = Role::pluck('name', 'id');
		$center = CentreMaster::pluck('name', 'id');
		$states = StateMaster::orderBy('state_name')->pluck('state_name', 'id');
		$districts = DistrictMaster::pluck('district_name');

		return view('users.create', compact('states', 'districts', 'roles', 'title', 'center'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(UserStoreRequest $request)
	{
		// die('hello');
		$userData = $request->except(['role', 'profile_photo']);
		// print_r($request->all());
		// //print_r($userData);
		// die;
		if ($request->profile_photo) {
			$userData['profile_photo'] = parse_url($request->profile_photo, PHP_URL_PATH);
		}
		$userData['vn_email'] = $request->email;
		$userData['txt_password'] = $request->password;

		$user = User::create($userData);
		// print_r($user->id);
		// die;
		if ($user && $request->test_center_id) {
			$referral_center = CentreMaster::find($request->test_center_id);
			$referral_center->user_id = $user->id;
			$referral_center->save();
		}

		if ($request['center']) {
			$vms_details_ids = Auth::user();
			$center = DB::table('centre_master')->where('id', $request['center'])->first();
			$center->user_id = $user->id;
		}



		$user->assignRole($request->role);
		flash('User created successfully!')->success();
		return redirect()->route('users.index');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\User  $user
	 * @return \Illuminate\Http\Response
	 */
	public function show(User $user)
	{
		$title = "User Details";
		$roles = Role::pluck('name', 'id');
		return view('users.show', compact('user', 'title', 'roles'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\User  $user
	 * @return \Illuminate\Contracts\View\View
	 */
	public function edit(User $user)
	{
		$title = "User Details";
		$roles = Role::pluck('name', 'id');
		$states = StateMaster::orderBy('state_name')->pluck('state_name', 'id');
		$districts = DistrictMaster::pluck('district_name', 'id');
		$district = '';
		$state = '';
		$userRole = $user->getRoleNames();
		//get id by role name
		$userRoleId = null;
		if ($userRole) {
			$userRole = $userRole->first();
			$userRoleId = Role::where('name', $userRole)->first()->id;
		}
		$centerState = '';
		$centre = new CentreMaster();
		// dd($userRole == 'Center User');
		// Define a regular expression pattern to match role names inside brackets
		// $pattern = '/\[\"(.+?)\"\]/';
		// $matches = ['Center User', 'CBO Partner'];
		// // Perform regex match
		// if (preg_match($pattern, $userRole, $matches)) {
		// 	// $matches[1] will contain the role name, e.g., "Center User"
		// 	$userRole = $matches[1];
		// }
		$centers = [];
		if ($userRole == 'Center User' || $userRole == 'CBO Partner' || false) {
			$centre = CentreMaster::where('user_id', $user->id)->first();
			if ($centre) {
				$district = DistrictMaster::where('id', $centre->district_id)->first();
				$state = StateMaster::where('id', $district->state_code)->first();
				$districts = DistrictMaster::where('state_code', $centre->state_code)->pluck('district_name', 'id');
				//pluck('district_name', 'id');
				$centers = CentreMaster::where('user_id', $user->id)->pluck('name', 'id')->toArray();
				$centerState = StateMaster::select('id')->where('state_code', $centre->state_code)->first();
				$centerState = $centerState ? $centerState->id : '';
			} else {
				$centre = new CentreMaster();
			}
		}
		return view('users.edit', compact('user', 'title', 'roles', 'centre', 'centers', 'district', 'state', 'states', 'districts', 'userRoleId', 'centerState'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\User  $user
	 * @return \Illuminate\Http\Response
	 */
	public function update(UserUpdateRequest $request, User $user)
	{
		$userData = $request->except(['role', 'profile_photo']);
		if ($request->profile_photo) {
			$userData['profile_photo'] = parse_url($request->profile_photo, PHP_URL_PATH);
		}
		$userData['vn_email'] = $request->email;
		$user->update($userData);
		$user->syncRoles($request->role);
		if ($user && $request->test_center_id) {
			$oldCenters = CentreMaster::where('user_id', $user->id)->get();
			foreach ($oldCenters as $oldCenter) {
				$oldCenter->user_id = null;
				$oldCenter->save();
			}
			$test_center = CentreMaster::find($request->test_center_id);
			$test_center->user_id = $user->id;
			$test_center->save();
		}

		flash('User updated successfully!')->success();
		return redirect()->route('users.index');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\User  $user
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(User $user)
	{
		if ($user->id == Auth::user()->id || $user->id == 1) {
			flash('You can not delete logged in user!')->warning();
			return back();
		}
		$user->delete();
		flash('User deleted successfully!')->info();
		return back();
	}


	public function profile(User $user)
	{

		$title = 'Edit Profile';
		$role = Auth::user()->getRoleNames()->first();
		$centreName = '';
		if (in_array($role, [CENTER_USER])) {
			$centre = CentreMaster::where('user_id', Auth::user()->id)->first();
			$centreName = $centre?->name ?? '';
		}
		return view('users.profile', compact('title', 'user', 'centreName', 'role'));
	}

	public function profileUpdate(UserUpdateRequest $request, User $user)
	{
		$userData = $request->except('profile_photo');
		if ($request->profile_photo) {
			$userData['profile_photo'] = parse_url($request->profile_photo, PHP_URL_PATH);
		}
		$password = $request->password;
		if ($password == null) {
			unset($userData['password_confirmation']);
			unset($userData['password']);
		}

		if ($request->vms_details_ids > 0) {
			$sql = VmMaster::find($request->vms_details_ids);
			$sql->name = $request->name;
			$sql->email = $request->vn_email;
			$sql->mobile_number = $request->phone_number;
			$sql->save();
		}

		$user->update($userData);
		flash('Profile updated successfully!')->success();
		return back();
	}

	public function display(Request $request)
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

			$stateArr = array();
			$state_code_ids = '';
			$vms_details_ids = Auth::user()->vms_details_ids;
			$results = VmMaster::where(["parent_id" => $vms_details_ids])->get();
			if ($results->count() > 0) {
				foreach ($results as $key => $val) {

					$ChildByPOCase = VmMaster::where(["parent_id" => $val->id])->get();
					if ($ChildByPOCase->count() > 0) {
						foreach ($ChildByPOCase as $key => $val) {
							if ($val->state_code == '')
								continue;

							$state_code_ids .= $val->state_code . ",";
						}
					}
				}
				$state_code_ids = rtrim($state_code_ids, ',');
			} else {
				$stateArr = StateMaster::pluck('id')->toArray();
			}

			if (!empty($state_code_ids))
				$stateArr = explode(",", $state_code_ids);
		} else {
			$stateArr = StateMaster::pluck('id')->toArray();
		}
		$state_list = StateMaster::whereIn('id', $stateArr)->orderBy('state_name', 'ASC')->get();


		/*$book_results = BookAppinmentMaster::select('surveys.user_id', 'surveys.your_age', 'surveys.identify_yourself', 'surveys.identify_others', 'surveys.sexually', 'surveys.hiv_infection', 'surveys.risk_level', 'surveys.services_required','users.name as client_name','users.email as client_email','users.phone_number','book_appinment_master.survey_unique_ids','book_appinment_master.e_referral_no','book_appinment_master.serach_by','book_appinment_master.pincode','book_appinment_master.district_id','book_appinment_master.state_id','book_appinment_master.appoint_date','book_appinment_master.created_at as book_date','centre_master.name as center_name','centre_master.name_counsellor','vm_master.name as vm_name','vm_master.mobile_number as vm_phone','vm_master.vncode','state_master.st_cd as statecode','state_master.state_code as state_code_id')
									  ->join('surveys', 'surveys.id', '=', 'book_appinment_master.survey_id')
									  ->join('users', 'users.id', '=', 'book_appinment_master.user_id')
									  ->join('centre_master', 'centre_master.id', '=', 'book_appinment_master.center_ids')
									  ->join('district_master', 'district_master.district_code', '=', 'centre_master.district_id')
									  ->join('vm_master', 'vm_master.state_code', '=', 'district_master.state_code')					
									  ->join('state_master', 'state_master.state_code', '=', 'district_master.state_code')					
								  ->where('book_appinment_master.id', $obj->id)
								  ->first();*/

		$title = "User Survey";
		if ($request->has('search')) {
			$survey = Surveys::where('name', 'like', '%' . $request->search . '%')->paginate(setting('record_per_page', 15));
		} else {
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
				'vn_upload_survey_files.outcome',
				'surveys.survey_co_flag',
				'surveys.po_status'
			)
				->join('customers as U', 'U.id', '=', 'surveys.user_id')
				->join('book_appinment_master as BAM', 'BAM.survey_id', '=', 'surveys.id')
				->join('centre_master as CM', 'CM.id', '=', 'BAM.center_ids')
				->join('district_master as D', 'D.district_code', '=', 'CM.district_id')
				->join('state_master as SM', 'SM.state_code', '=', 'D.state_code')
				->leftJoin('platforms', 'platforms.id', '=', 'surveys.platform_id')
				->leftJoin('vn_upload_survey_files', 'vn_upload_survey_files.survey_id', '=', 'surveys.id')
				->whereIn('BAM.state_id', $stateArr)
				->whereIn('surveys.survey_co_flag', $conArr)
				->groupBy('surveys.id')
				->orderBy('surveys.id', 'DESC')->paginate(setting('record_per_page', 15));
		}
		return view('survey.list', compact('survey', 'title', 'state_list'));
	}




	function survey_filter(Request $request)
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


			$stateArr = array();
			$state_code_ids = '';
			$vms_details_ids = Auth::user()->vms_details_ids;
			$results = VmMaster::where(["parent_id" => $vms_details_ids])->get();
			if ($results->count() > 0) {
				foreach ($results as $key => $val) {

					$ChildByPOCase = VmMaster::where(["parent_id" => $val->id])->get();
					if ($ChildByPOCase->count() > 0) {
						foreach ($ChildByPOCase as $key => $val) {
							if ($val->state_code == '')
								continue;

							$state_code_ids .= $val->state_code . ",";
						}
					}
				}
				$state_code_ids = rtrim($state_code_ids, ',');
			} else {
				$stateArr = StateMaster::pluck('id')->toArray();
			}

			if (!empty($state_code_ids))
				$stateArr = explode(",", $state_code_ids);
		} else {
			$stateArr = StateMaster::pluck('id')->toArray();
		}


		$state_list = StateMaster::whereIn('id', $stateArr)->orderBy('state_name', 'ASC')->get();


		if (!empty($request->vninputState) && $request->vninputState <> "Choose...") {
			$vn_list = VmMaster::where(["id" => $request->vninputState])->first();
			$stateArrCon[] = explode(",", $vn_list->state_code);
		} else {
			$stateArrCon[] = $request->state_id;
		}



		$title = "User Survey";
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
			'vn_upload_survey_files.outcome',
			'surveys.survey_co_flag',
			'surveys.po_status'
		)->join('customers as U', 'U.id', '=', 'surveys.user_id')
			->join('book_appinment_master as BAM', 'BAM.survey_id', '=', 'surveys.id')
			->join('centre_master as CM', 'CM.id', '=', 'BAM.center_ids')
			->join('district_master as D', 'D.district_code', '=', 'CM.district_id')
			->join('state_master as SM', 'SM.state_code', '=', 'D.state_code')
			->leftJoin('platforms', 'platforms.id', '=', 'surveys.platform_id')
			->leftJoin('vn_upload_survey_files', 'vn_upload_survey_files.survey_id', '=', 'surveys.id')
			->whereIn('BAM.state_id', $stateArrCon)
			->whereIn('surveys.survey_co_flag', $conArr)
			->groupBy('surveys.id')
			->orderBy('surveys.id', 'DESC')->paginate(setting('record_per_page', 15));

		return view('survey.list_filter', compact('survey', 'title', 'state_list'));
	}



	/*
			   Display by VMS
			 
			 */
	public function display_vms(Request $request)
	{

		if ($request->has('search')) {
			$vms_list = VmMaster::select('vm_master.*', 'users.txt_password')
				->join('users', 'vm_master.email', '=', 'users.vn_email')
				->where('vm_master.status', 1)
				->where(function ($query) use ($request) {
					return $query->where('vm_master.name', 'like', '%' . $request->search . '%')
						->orWhere('vm_master.vncode', 'like', '%' . $request->search . '%');
				})
				->paginate(setting('record_per_page', 15));
		} else {
			$vms_list = DB::select('select `vm_master`.*, `users`.`txt_password` from `vm_master` inner join `users` on `vm_master`.`email` = `users`.`vn_email`');
			$vms_list = collect($vms_list);
		}
		return view('users.vms', compact('vms_list'));
	}

	public function display_vms_create(Request $request)
	{

		$title = "User Vms Create";
		$state = StateMaster::orderBy('state_name', 'ASC')->pluck('state_name', 'state_code');
		$vms_list = VmMaster::pluck('name', 'id');
		$roles = Role::where('id', '<>', '1')->pluck('name', 'id');
		return view('users.create_vms', compact('state', 'title', 'vms_list', 'roles'));
	}

	public function edit_display_vms_create(Request $request)
	{

		$title = "Edit User Vns ";
		$state = StateMaster::orderBy('state_name', 'ASC')->pluck('state_name', 'state_code');
		$vms_list = VmMaster::pluck('name', 'id');
		$vns_results = DB::table('vm_master')->find($request->id);
		$users_password = User::pluck('txt_password', 'id');
		$users_results = User::find($request->id);

		$id = $request->id;
		$roles = Role::where('id', '<>', '1')->pluck('name', 'id');
		return view('users.edit_vms', compact('state', 'title', 'vms_list', 'roles', 'vns_results', 'id', 'users_results'));
	}

	public function viwe_display_vms_password($id)
	{
		// echo $id;
		$vmd = VmMaster::find($id);
		$password = User::where('vms_details_ids', $id)->select('password')->first();
		return view('users.preset', compact('vmd'));
	}

	public function viwe_display_vms_password2(Request $request)
	{


		$validator = Validator::make($request->all(), [
			'new_pass' => 'required',
		]);

		if ($request->new_pass <> $request->password_confirmation) {
			return redirect()->back()
				->withErrors('Password and confirm password has not same.')
				->withInput();
		}

		$txt_password = $request->new_pass;
		$password = Hash::make($request->new_pass);
		$vmid = $request->vmid;
		User::where('vms_details_ids', $vmid)->update(['password' => $password, 'txt_password' => $txt_password]);
		flash('Password updated successfully!')->success();
		return back();
	}

	public function store_vms(Request $request)
	{


		// validate incoming request

		$validator = Validator::make($request->all(), [
			'email' => 'required|email|unique:vm_master',
			'name' => 'required|string|max:50',
			'password' => 'required|confirmed|min:8',
			'phone_number' => 'required|regex:/[0-9]{10}/',
			'state' => 'required',
			'region' => 'required',
			'username' => 'required|unique:vm_master,vncode',
		]);

		if ($validator->fails()) {
			/*Session::flash('error', $validator->messages()->first());
									   return redirect()->back()->withInput();
									   */
			return redirect()->back()
				->withErrors($validator)
				->withInput();
		}

		$parent_id = empty($request->parent_id) ? 0 : $request->parent_id;

		$userData = array(
			"parent_id" => $parent_id,
			"name" => $request->name,
			"last_name" => $request->last_name,
			"email" => $request->email,
			"mobile_number" => $request->phone_number,
			"state_code" => implode(',', $request->state),
			"region" => $request->region[0],
			"regions_list" => $request->region,
			"vncode" => $request->username
		);

		//dd($userData);
		$user = VmMaster::create($userData);
		if ($user->id > 0) {


			$userData = array(
				"name" => $request->name,
				"email" => strtolower(trim($request->username)),
				"vn_email" => $request->email,
				"password" => $request->password,
				"phone_number" => $request->phone_number,
				"vms_details_ids" => $user->id,
				"user_type" => 2,
				"status" => 1
			);
			$user1 = User::create($userData);
			$user1->assignRole($request->role);
		}

		flash('VMs User created successfully!')->success();
		return redirect()->route('user.vms');
	}

	public function export()
	{
		if (Auth::user()->hasRole('VN User Permission')) {
			$vms_details_ids = Auth::user()->vms_details_ids;
			$results = VmMaster::find($vms_details_ids);
			if (!empty($results->state_code)) {
				$stateArr = explode(",", $results->state_code);
			} else {
				$stateArr = StateMaster::pluck('id')->toArray();
			}
		} else {
			$stateArr = StateMaster::pluck('id')->toArray();
		}

		$results = Surveys::select(
			'U.name AS client_name',
			'U.phone_number as client_phone_number',
			'surveys.client_type',
			'BAM.created_at as book_date',
			'D.district_name',
			'SM.state_name',
			'surveys.your_age',
			'surveys.manual_flag',
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
			'surveys.survey_details',
			'surveys.flag',
			'vn_upload_survey_files.acess_date',
			'vn_upload_survey_files.pid',
			'vn_upload_survey_files.outcome'
		)
			->join('customers as U', 'U.id', '=', 'surveys.user_id')
			->join('book_appinment_master as BAM', 'BAM.survey_id', '=', 'surveys.id')
			->join('centre_master as CM', 'CM.id', '=', 'BAM.center_ids')
			->join('district_master as D', 'D.district_code', '=', 'CM.district_id')
			->join('state_master as SM', 'SM.state_code', '=', 'D.state_code')
			->leftJoin('platforms', 'platforms.id', '=', 'surveys.platform_id')
			->leftJoin('vn_upload_survey_files', 'vn_upload_survey_files.survey_id', '=', 'surveys.id')
			->whereIn('BAM.state_id', $stateArr)
			->orderBy('surveys.id', 'DESC')->get();

		return Excel::download(new SurveysExport($results), 'Surveys-' . date('Y-m-d') . '.xlsx');
	}

	public function vn_upload_by_test(Request $request)
	{


		$validator = Validator::make($request->all(), [
			'acess_date' => 'required',
			'user_pid' => 'required',
			// 'files' => 'required',		   
			// 'files.*' => 'mimes:jpeg,png,jpg,gif,pdf|max:2048',		   
			'outcome' => 'required'
		]);

		if ($validator->fails()) {

			$data = $validator->messages();
			$error = array();
			$error["acess_date"] = !empty($validator->messages()->first('acess_date')) ? "The error for date is missing" : "";
			$error["user_pid"] = !empty($validator->messages()->first('user_pid')) ? "PID Required" : "";
			$error["detail"] = $validator->messages()->first('detail');
			$error["files"] = $validator->messages()->first('files');
			$error["outcome"] = $validator->messages()->first('outcome');
			return response()->json(["message" => "Please try again.", "error" => $error]);
		}

		//DB::enableQueryLog();
		$survey_id = $request->survey_id;
		$booked = BookAppinmentMaster::whereRaw("survey_id =$survey_id  AND DATE(created_at) < '$request->acess_date'")->get();
		//->where("created_at",">",$request->acess_date)->get();;
		//dd(DB::getQueryLog());

		if ($booked->count() == 0) {
			$error = array();
			$error["acess_date"] = " Access date cannot be smaller than Assessment Date";
			$error["user_pid"] = '';
			$error["detail"] = '';
			$error["files"] = '';
			$error["outcome"] = '';
			return response()->json(["message" => "Please try again.", "error" => $error]);
		}

		if (strtotime($request->acess_date) > strtotime(date("Y-m-d"))) {
			$error = array();
			$error["acess_date"] = " Access date cannot be smaller than Assessment Date";
			$error["user_pid"] = '';
			$error["detail"] = '';
			$error["files"] = '';
			$error["outcome"] = '';
			return response()->json(["message" => "Please try again.", "error" => $error]);
		}

		$file_upload = '';
		if ($request->has('files')) {
			$image = $request->file('files');

			foreach ($image as $file) {


				$filename = $file->getClientOriginalName();
				$extension = $file->getClientOriginalExtension();
				$originalExtension = strtolower($file->getClientOriginalExtension());
				$type_mime_image = $file->getMimeType();
				$sizeFile = $file->getSize();
				$thumbnail = Str::random(32) . '.' . $extension;
				$file->move(public_path('storage/uploads/reports'), $thumbnail);

				$data[] = $thumbnail;
			}

			$file_upload = json_encode($data);
		}

		$sql = new VnUploadByResults();
		$sql->created_by = Auth::user()->id;
		$sql->survey_id = $request->survey_id;
		$sql->acess_date = $request->acess_date;
		$sql->pid = $request->user_pid;
		$sql->detail = $request->detail;
		$sql->file_upload = $file_upload;
		$sql->outcome = $request->outcome;
		$sql->dontshare = $request->dontshare;
		$sql->save();

		if ($sql->id > 0) {
			$sur = Surveys::find($request->survey_id);
			$sur->flag = 1;
			$sur->save();
			return response()->json(["message" => "Success"]);
		}
		return response()->json(["message" => "Please try again.", "error" => $type_mime_image]);
	}

	public function edit_store_vns(Request $request)
	{




		$validator = Validator::make($request->all(), [
			'email' => 'required|email|unique:vm_master,email,' . $request->update_id,
			'name' => 'required',
			// 'phone_number' => 'required|numeric',
			// 'region' => 'required',		   
			'state' => 'required'
		]);

		if ($validator->fails()) {
			return redirect()->back()
				->withErrors($validator)
				->withInput();
		}
		$sql = DB::table('vm_master')
			->where('id', $request->update_id)
			->update([
				'parent_id' => $request->parent_id,
				'name' => $request->name,
				'last_name' => $request->last_name,
				'email' => $request->email,
				'mobile_number' => $request->phone_number,
				'region' => $request->region[0],
				'regions_list' => json_encode($request->region),
				'state_code' => implode(",", $request->state),
			]);

		$UserResults = User::where(["vms_details_ids" => $request->update_id])->get();
		if ($UserResults->count() > 0) {
			User::where('id', $UserResults[0]->id)->update(['vn_email' => $request->email, "phone_number" => $request->phone_number]);
		}

		flash('Vn User Update successfully!')->success();
		return redirect('user/vns/' . $request->update_id . '/edit');
	}


	public function flag_counseling_update(Request $request)
	{

		try {
			$sql = Surveys::find($request->sid);
			$sql->survey_co_flag = 1;
			$sql->save();
			echo json_encode(array("results" => "Success", "id" => $request->sid));
			exit;
		} catch (\Exception $e) {
			echo json_encode(array("results" => "failer", "message" => $e->getMessage()));
			exit;
			//return $e->getMessage();
		}
	}

	public function po_survey_action(Request $request)
	{



		$validator = Validator::make($request->all(), [
			'detail' => 'required',
			'action' => 'required',
			'survey_po_id' => 'required'
		]);

		if ($validator->fails()) {

			$data = $validator->messages();
			$error = array();
			$error["detail"] = $validator->messages()->first('detail');
			$error["action"] = $validator->messages()->first('action');
			return response()->json(["message" => "Please try again.", "error" => $error]);
		}

		$detail = $request->detail;
		$action = $request->action;
		$survey_po_id = $request->survey_po_id;

		$sur = Surveys::find($survey_po_id);
		$sur->po_status = $action;
		$sur->po_commented_on = $detail;
		$sur->po_status_created_on = strtotime(date('Y-m-d H:i:s'));
		$sur->po_status_created_by = Auth::user()->id;
		$sur->save();
		return response()->json(["message" => "Success", "action" => $action]);
	}




	public function podisplay(Request $request)
	{


		$conArr = [0, 1];
		$stateArr = StateMaster::pluck('id')->toArray();

		$title = "User Survey";
		if ($request->has('search')) {
			$survey = Surveys::where('name', 'like', '%' . $request->search . '%')->paginate(setting('record_per_page', 15));
		} else {

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
				'vn_upload_survey_files.outcome',
				'surveys.survey_co_flag',
				'surveys.po_status'
			)
				->join('customers as U', 'U.id', '=', 'surveys.user_id')
				->join('book_appinment_master as BAM', 'BAM.survey_id', '=', 'surveys.id')
				->join('centre_master as CM', 'CM.id', '=', 'BAM.center_ids')
				->join('district_master as D', 'D.district_code', '=', 'CM.district_id')
				->join('state_master as SM', 'SM.state_code', '=', 'D.state_code')
				->leftJoin('platforms', 'platforms.id', '=', 'surveys.platform_id')
				->leftJoin('vn_upload_survey_files', 'vn_upload_survey_files.survey_id', '=', 'surveys.id')
				->whereIn('BAM.state_id', $stateArr)
				->whereIn('surveys.survey_co_flag', $conArr)
				->groupBy('surveys.id')
				->orderBy('surveys.id', 'DESC')->paginate(setting('record_per_page', 15));
		}
		return view('survey.po_list', compact('survey', 'title'));
	}


	public function po_admin_wise_report(Request $request)
	{

		$search = $request->search["value"];
		$stateArr = StateMaster::pluck('id')->toArray();
		if (!empty($request->region)) {
			$stateArr = StateMaster::where(["region" => $request->region])->pluck('id')->toArray();
		}


		$start = ($request->start > 0) ? $request->start : 1;
		$results = Surveys::getPoReportCtr($request->report_type, $request->start, $request->length, $stateArr, $search);

		$total = Surveys::getPoReportCtr($request->report_type, '', '', $stateArr, $search);
		$data = array();
		if ($results->count() > 0) {
			$genderArr = array("1" => "Male", "2" => "Female", "3" => "Transgender", "4" => "I prefer not to say", "5" => "I prefer not to say", "6" => "Other");

			$services = array("1" => "HIV Test", "2" => "STI Services", "3" => "PrEP", "4" => "PEP", "5" => "Counselling on Mental Health", "6" => "Referral to TI services", "7" => "ART Linkages");

			$serviceAval = array("0" => "", 1 => "ICTC", 2 => "FICTC", 3 => "ART", 4 => "TI", 5 => "Private lab");

			foreach ($results as $list) {

				$service_required = '';
				$servicesArr = json_decode($list->services_required);

				foreach ($services as $key => $value) {
					if (!in_array($key, $servicesArr))
						continue;

					$service_required .= $value . ",";
				}

				$services_avail = '';
				if (isset($list->services_avail) && !empty($list->services_avail)) {

					if (!empty($list->services_avail)) {
						$serviceOrginAval = explode(",", $list->services_avail);
						foreach ($serviceOrginAval as $val) {
							$services_avail .= $serviceAval[$val] . ",";
						}
						$services_avail = rtrim($services_avail, ',');
					}
				}

				$outcome = '';
				if ($list->outcome == 1) {
					$outcome = 'Negative';
				} elseif ($list->outcome == 2) {
					$outcome = 'Positive';
				} elseif ($list->outcome == 3) {
					$outcome = 'Non-reactive';
				}

				$platforms_name = !empty($list->platforms_name) ? $list->platforms_name : 'Walk-in';
				$identify_yourself = isset($genderArr[$list->identify_yourself]) ? $genderArr[$list->identify_yourself] : "";
				$client_type = ($list->client_type == 1) ? 'New Client' : 'Follow Up Client';
				$hiv_test = ($list->hiv_test == 1) ? 'Yes' : 'No';
				$data[] = array(
					"client_type" => $client_type,
					"book_date" => date("d/m/Y", strtotime($list->book_date)),
					"state_name" => $list->state_name,
					"district_name" => $list->district_name,
					"platforms_name" => $platforms_name,
					"your_age" => $list->your_age,
					"identify_yourself" => $identify_yourself,
					"target_population" => $list->target_population,
					"client_phone_number" => $list->client_phone_number,
					"risk_level" => $list->risk_level,
					"uid" => $list->uid,
					"service_required" => rtrim($service_required, ","),
					"hiv_test" => $hiv_test,
					"services_avail" => $services_avail,
					"client_name" => $list->client_name,
					"appoint_date" => $list->appoint_date,
					"center_name" => $list->center_name,
					"acess_date" => $list->acess_date,
					"pid" => $list->pid,
					"outcome" => $outcome
				);
			}
		}


		$json_data = array(
			"draw" => intval($request->draw),
			"recordsTotal" => intval($total->count()),
			"recordsFiltered" => intval($total->count()),
			"data" => $data   // total data array
		);

		echo json_encode($json_data);  // send data as json format		
		exit;
	}


	public function district_state(Request $r)
	{
		$dist = DistrictMaster::where('state_id', $r->state_code)->orderBy('district_name', 'ASC')->get();
		$res = '<option selected>Choose...</option>';
		foreach ($dist as $d) {
			$res .= '<option value="' . $d->district_code . '">' . $d->district_name . '</option>';
		}
		echo json_encode(array("district_list" => $res));
		exit;
	}

	public function region_by_state(Request $request)
	{


		$state = StateMaster::where(["region" => $request->city_id])->get();
		$res = '<option selected>Choose...</option>';
		foreach ($state as $s) {
			$res .= '<option value="' . $s->id . '">' . $s->state_name . '</option>';
		}
		echo json_encode(array("state_list" => $res));
		exit;
	}

	public function state_by_district(Request $request)
	{
		$state = StateMaster::find($request->integer('state_code'))?->state_code;

		$results = VmMaster::select('vm_master.id', 'vm_master.parent_id', 'vm_master.vncode', 'vm_master.name', 'vm_master.last_name', 'vm_master.email', 'vm_master.mobile_number', 'vm_master.region', 'vm_master.state_code')
			->join('users as U', 'U.vms_details_ids', '=', 'vm_master.id')
			->where(["user_type" => 2])
			->whereRaw('FIND_IN_SET(' . $state . ',state_code)')->get();

		$res = '<option selected>Choose...</option>';
		foreach ($results as $s) {
			$res .= '<option value="' . $s->id . '">' . ucfirst($s->name . " " . $s->last_name) . "(" . $s->vncode . ")" . '</option>';
		}
		echo json_encode(array("user_list" => $res));
		exit;
	}


	public function displaysecond(Request $request)
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

			$conArr = [1, 2];

			if (!empty($state_code_ids))
				$stateArr = explode(",", $state_code_ids);
		} else if (Auth::user()->hasRole('PO-Permission')) {


			$stateArr = array();
			$state_code_ids = '';
			$vms_details_ids = Auth::user()->vms_details_ids;
			$results = VmMaster::where(["parent_id" => $vms_details_ids])->get();
			if ($results->count() > 0) {
				foreach ($results as $key => $val) {

					$ChildByPOCase = VmMaster::where(["parent_id" => $val->id])->get();
					if ($ChildByPOCase->count() > 0) {
						foreach ($ChildByPOCase as $key => $val) {
							if ($val->state_code == '')
								continue;

							$state_code_ids .= $val->state_code . ",";
						}
					}
				}
				$state_code_ids = rtrim($state_code_ids, ',');
			} else {
				$stateArr = StateMaster::pluck('id')->toArray();
			}

			if (!empty($state_code_ids))
				$stateArr = explode(",", $state_code_ids);
		} else {
			$stateArr = StateMaster::pluck('id')->toArray();
		}


		$state_list = StateMaster::whereIn('id', $stateArr)->orderBy('state_name', 'ASC')->get();


		$title = "User Survey";
		if ($request->has('search')) {

			$survey = Surveys::where('name', 'like', '%' . $request->search . '%')->paginate(setting('record_per_page', 15));
		} else {

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
				'vn_upload_survey_files.outcome',
				'surveys.survey_co_flag',
				'surveys.po_status'
			)
				->join('customers as U', 'U.id', '=', 'surveys.user_id')
				->join('book_appinment_master as BAM', 'BAM.survey_id', '=', 'surveys.id')
				->join('centre_master as CM', 'CM.id', '=', 'BAM.center_ids')
				->join('district_master as D', 'D.district_code', '=', 'CM.district_id')
				->join('state_master as SM', 'SM.state_code', '=', 'D.state_code')
				->leftJoin('platforms', 'platforms.id', '=', 'surveys.platform_id')
				->leftJoin('vn_upload_survey_files', 'vn_upload_survey_files.survey_id', '=', 'surveys.id')
				->whereIn('BAM.state_id', $stateArr)
				->whereIn('surveys.survey_co_flag', $conArr)
				->groupBy('surveys.id')
				->orderBy('surveys.id', 'DESC')->paginate(setting('record_per_page', 15));
		}

		return view('survey.list_second', compact('survey', 'title', 'state_list'));
	}

	public function all_survey_report(Request $request)
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

			$conArr = [1, 2];

			if (!empty($state_code_ids))
				$stateArr = explode(",", $state_code_ids);
		} else if (Auth::user()->hasRole('PO-Permission')) {


			$stateArr = array();
			$state_code_ids = '';
			$vms_details_ids = Auth::user()->vms_details_ids;
			;

			$results = VmMaster::where(["parent_id" => $vms_details_ids])->get();
			if ($results->count() > 0) {
				foreach ($results as $key => $val) {

					$ChildByPOCase = VmMaster::where(["parent_id" => $val->id])->get();
					if ($ChildByPOCase->count() > 0) {
						foreach ($ChildByPOCase as $key => $val) {
							if ($val->state_code == '')
								continue;

							$state_code_ids .= $val->state_code . ",";
						}
					} else {
						$state_code_ids .= $val->state_code . ",";
					}
				}
				$state_code_ids = rtrim($state_code_ids, ',');
			} else {
				$stateArr = StateMaster::pluck('id')->toArray();
			}

			if (!empty($state_code_ids))
				$stateArr = explode(",", $state_code_ids);
		} else {
			$stateArr = StateMaster::pluck('id')->toArray();
		}

		if (!empty($request->region) && $request->region <> 'Choose...') {
			$stateArr = StateMaster::where(["region" => $request->region])->pluck('id')->toArray();
		}

		if (!empty($request->state_id) && $request->state_id <> 'Choose...') {
			$stateArr = StateMaster::where(["state_code" => $request->state_id])->pluck('id')->toArray();
		}

		if (!empty($request->facility_type) && $request->facility_type <> 'Choose...') {
			$facility = $request->facility_type;
		} else {
			$facility = '';
		}

		$target_pop = '';
		if (!empty($request->target_pop) && $request->target_pop <> 'Choose...') {
			$target_pop = $request->target_pop;
		}


		$pid_survey = '';
		if (!empty($request->pid_survey)) {
			$pid_survey = $request->pid_survey;
		}

		$outcome = '';
		if (!empty($request->outcome) && $request->outcome <> 'Choose...') {
			$outcome = $request->outcome;
		}


		if ($request->date_type == "assessment_date") {
			$date_type = $request->date_type;
			$date_to = $request->asset_date_to;
			$date_from = $request->asset_date_from;
		} else if ($request->date_type == "referral_date") {
			$date_type = $request->date_type;
			$date_to = $request->refer_date_to;
			$date_from = $request->refer_date_from;
		} else if ($request->date_type == "acess_date") {
			$date_type = $request->date_type;
			$date_to = $request->acess_date_to;
			$date_from = $request->acess_date_from;
		} else {
			$date_type = '';
			$date_to = '';
			$date_from = '';
		}

		$servicesFilter = '';
		if (!empty($request->services) && $request->services <> 'Choose...') {
			$servicesFilter = $request->services;
		}


		$genderArr = array("1" => "Male", "2" => "Female", "3" => "Transgender", "4" => "I prefer not to say", "5" => "I prefer not to say", "6" => "Other");

		$services = array("1" => "HIV Test", "2" => "STI Services", "3" => "PrEP", "4" => "PEP", "5" => "Counselling on Mental Health", "6" => "Referral to TI services", "7" => "ART Linkages");

		$serviceAval = array("0" => "", 1 => "ICTC", 2 => "FICTC", 3 => "ART", 4 => "TI", 5 => "Private lab");


		$state_list = StateMaster::whereIn('id', $stateArr)->orderBy('state_name', 'ASC')->get();



		$start = ($request->start > 0) ? $request->start : 1;

		//DB::enableQueryLog();
		$results = Surveys::get_all_survey($request->start, $request->length, $stateArr, '', $conArr, $facility, $target_pop, $pid_survey, $outcome, $date_type, $date_to, $date_from, $servicesFilter);
		//$query = DB::getQueryLog();
		//dd($query);	
		$total = Surveys::get_all_survey('', '', $stateArr, '', $conArr, $facility, $target_pop, $pid_survey, $outcome, $date_type, $date_to, $date_from, $servicesFilter);

		$data = array();
		foreach ($results as $list) {

			$service_required = '';
			$servicesArr = json_decode($list->services_required);
			foreach ($services as $key => $value) {
				if (!empty($servicesArr) && is_array($servicesArr) && !in_array($key, $servicesArr))
					continue;
				$service_required .= $value . ",";
			}

			$services_avail = '';
			if (isset($list->services_avail) && !empty($list->services_avail)) {

				if (!empty($list->services_avail)) {
					$serviceOrginAval = explode(",", $list->services_avail);
					foreach ($serviceOrginAval as $val) {
						$services_avail .= $serviceAval[$val] . ",";
					}
					$services_avail = rtrim($services_avail, ',');
				}
			}


			$client_type = ($list->client_type == 1) ? 'New Client' : 'Follow Up Client';
			//$platforms_name = !empty($list->platforms_name)?$list->platforms_name:'Walk-in';

			if (!empty($list->platforms_name)) {
				$platforms_name = $list->platforms_name;
			} else {
				if ($list->manual_flag > 0) {
					$platforms_name = "Manual";
				} else {
					$platforms_name = "Walk-in";
				}
			}


			$identify_yourself = isset($genderArr[$list->identify_yourself]) ? $genderArr[$list->identify_yourself] : "";

			$hiv_test = ($list->hiv_test == 1) ? 'Yes' : 'No';

			$book_date = date("d/m/Y", strtotime($list->book_date));

			$appArr = '';
			if ($list->po_status == 0)
				$appArr = '<input type="checkbox" id="all" name="all" value="' . $list->id . '" class="multi_approve">';

			$htmlAction = '';
			if ($list->po_status == 0)
				$htmlAction = '<span class="badge badge-info">Pending</span>';
			else if ($list->po_status == 1)
				$htmlAction = '<span class="badge badge-success">Approve</span>';
			else if ($list->po_status == 2)
				$htmlAction = '<span class="badge badge-danger">Rejected</span>';

			$sexually = '';
			if (!empty($list->sexually)) {
				$sexually = implode(", ", json_decode($list->sexually));
			}

			$hiv_infection = '';
			if (!empty($list->hiv_infection)) {
				$hiv_infectionAtt = json_decode($list->hiv_infection);
				$strArr = array(
					"Had sex without a condom" => 1,
					"Had sex with more than one partner" => 2,
					"Had hi-fun sex" => 3,
					"shared needles for injecting Drugs" => 4,
					"You have a Sexually transmitted Infection" => 5,
					"Had sex in exchange for gifts or money" => 6,
					"None of the above" => 8
				);
				foreach ($hiv_infectionAtt as $key => $val) {
					if (in_array($val, $strArr))
						$hiv_infection .= array_search($val, $strArr) . ", ";
				}

				$hiv_infection = rtrim($hiv_infection, ", ");
			}

			$ip_address = '';
			if (!empty($list->survey_details) && $list->survey_details <> 'cURL Error #:Empty reply from server') {
				$ip_addressArr = json_decode($list->survey_details, true);
				$ip_address = !empty($ip_addressArr) && isset($ip_addressArr["IPv4"]) ? $ip_addressArr["IPv4"] : null;
				$user_state = !empty($ip_addressArr) && isset($ip_addressArr["state"]) ? $ip_addressArr["state"] : null;
				$user_country_name = !empty($ip_addressArr) && isset($ip_addressArr["country_name"]) ? $ip_addressArr["country_name"] : null;
				$user_city = !empty($ip_addressArr) && isset($ip_addressArr["city"]) ? $ip_addressArr["city"] : null;
			}

			$SurData = array(
				"checkbox" => $appArr,
				"htmlAction" => $htmlAction,
				"client_type" => $client_type,
				"sexually_attracted" => $sexually,
				"increase_risk_hiv" => $hiv_infection,
				"ip_address" => $ip_address,
				"user_state" => $user_state,
				"user_country_name" => $user_country_name,
				"user_city" => $user_city,
				"book_date" => $book_date,
				"state_name" => $list->state_name,
				"district_name" => $list->district_name,
				"platforms_name" => $platforms_name,
				"your_age" => $list->your_age,
				"identify_yourself" => $identify_yourself,
				"target_population" => $list->target_population,
				"client_phone_number" => $list->client_phone_number,
				"risk_level" => $list->risk_level,
				"uid" => $list->uid,
				"service_required" => rtrim($service_required, ","),
				"hiv_test" => $hiv_test,
				"services_avail" => $services_avail,
				"client_name" => $list->client_name,
				"appoint_date" => $list->appoint_date,
				"center_name" => $list->center_name,
				"acess_date" => $list->acess_date,
				"pid" => $list->pid
			);



			if ($list->outcome == 1) {
				$SurData["outcome"] = 'Negative';
			} elseif ($list->outcome == 2) {
				$SurData["outcome"] = 'Positive';
			} elseif ($list->outcome == 3) {
				$SurData["outcome"] = 'Non-reactive';
			} else {
				$SurData["outcome"] = '';
			}

			//can('vn-upload-doc')

			if (auth()->user()->can('vn-upload-doc')) {

				if ($list->flag == 0) {
					$SurData["flag"] = '<button type="button" class="btn btn-sm btn-default"  id="survey_id_' . $list->survey_ids . '" onclick="return uploadReport(' . $list->survey_ids . ');" >Upload</button>';
				} else {
					$SurData["flag"] = 'Uploaded';
				}
			} else {
				$SurData["flag"] = '';
			}
			//endcan

			if ($list->survey_co_flag == 0) {
				if (auth()->user()->can('appoin-to-counseling')) {
					//can('appoin-to-counseling')	
					$SurData["survey_co_flag"] = '<div id="div_con_btn_' . $list->survey_ids . '"><button type="button" class="btn btn-sm btn-info"  id="co_id_' . $list->survey_ids . '" onclick="return counseling(' . $list->survey_ids . ');" >Counseling</button></div>';
					//endcan
				} else {
					$SurData["survey_co_flag"] = '';
				}
			} else {

				if (auth()->user()->user_type == 4) {
					if ($list->survey_co_flag == 1) {
						$SurData["survey_co_flag"] = '<div id="div_con_btn_' . $list->survey_ids . '"><button type="button" class="btn btn-sm btn-info"  id="co_id_' . $list->survey_ids . '" data-surveyId="' . $list->survey_ids . '" onclick="return counseling_new(' . $list->survey_ids . ');" >Assign Counseling</button></div>';
					} else {
						$SurData["survey_co_flag"] = '<span class="badge badge-pill badge-info">Complete Counseling</span>';
					}
				} else {
					$SurData["survey_co_flag"] = '<span class="badge badge-pill badge-info">Assign Counseling</span>';
				}
			}


			//can('po-apporve-reject-action')	

			if (auth()->user()->can('po-apporve-reject-action')) {
				if ($list->po_status == 0) {
					$SurData["po_status"] = '<div id="div_po_btn_' . $list->survey_ids . '">											
												<a href="javascript:void(0);" id="po_id_' . $list->survey_ids . '" onclick="return po_action(' . $list->survey_ids . ');" class="btn btn-sm btn-info  mr-4 ">PO Action</a>
											</div>';
				} else {
					if ($list->po_status == 1) {
						$SurData["po_status"] = '<span class="badge badge-success">Approve</span>';
					} else {
						$SurData["po_status"] = '<span class="badge badge-danger">Rejected</span>';
					}
				}
			} else {
				$SurData["po_status"] = '';
			}
			//endcan
			if ($list->flag > 0)
				$SurData["vn_view_upload_files"] = '<span class="btn-inner--icon" onclick="return viewUploadedFiles(' . $list->file_upload_id . ');" style="cursor: pointer;"><i class="ni ni-laptop"></i></span>';
			else
				$SurData["vn_view_upload_files"] = '';

			if (auth()->user()->user_type == 1) {

				$SurData["vn_delete"] = '<button type="button" class="btn btn-sm btn-danger" id="" onclick="return deleteVnReportConfirm(' . $list->id . ');"><i class="ni ni-times"></i>Delete</button>';
			}

			$data[] = $SurData;
		}


		$json_data = array(
			"draw" => intval($request->draw),
			"recordsTotal" => intval($total->count()),
			"recordsFiltered" => intval($total->count()),
			"data" => $data   // total data array
		);

		echo json_encode($json_data);  // send data as json format			
		exit;
	}
	public function category_store(Request $request)
	{
		$input = $request->all();
		$input['category'] = $request->input('category');
		Post::create($input);
		return redirect()->route('posts.index');
	}
	public function user_status_update(Request $request)
	{


		$UpdateDetails = User::where('vms_details_ids', $request->ursid)->first();
		if (is_null($UpdateDetails)) {
			return false;
		}
		$status = ($request->type == "DeActive") ? 0 : 1;
		User::where('id', $UpdateDetails->id)->update(['status' => $status]);
		DB::table('vm_master')
			->where('id', $request->ursid)
			->update(['status' => $status]);
		echo json_encode(array("results" => "sdfsdf"));
		exit;
	}



	public function mul_po_survey_action(Request $request)
	{



		$validator = Validator::make($request->all(), [
			'detail' => 'required',
			'action' => 'required',
			'survey_po_id' => 'required'
		]);

		if ($validator->fails()) {

			$data = $validator->messages();
			$error = array();
			$error["detail"] = $validator->messages()->first('detail');
			$error["action"] = $validator->messages()->first('action');
			return response()->json(["message" => "Please try again.", "error" => $error]);
		}



		if (!empty($request->survey_po_id)) {
			$detail = $request->detail;
			$action = $request->action;
			$survey_po_id = $request->survey_po_id;

			$surArr = explode("_", $survey_po_id);

			foreach ($surArr as $key => $val) {
				$sur = Surveys::find($val);
				$sur->po_status = $action;
				$sur->po_commented_on = $detail;
				$sur->po_status_created_on = strtotime(date('Y-m-d H:i:s'));
				$sur->po_status_created_by = Auth::user()->id;
				$sur->save();
			}
			return response()->json(["message" => "Success", "action" => $action, "ids" => $surArr]);
		}
	}

	public function get_user_file_uploaded(Request $request)
	{

		$id = $request->fid;
		$results = VnUploadByResults::find($id);
		return response()->json(["message" => "Success", "file_upload" => json_decode($results->file_upload), "detail" => $results->detail]);
	}


	public function credit_survey(Request $request)
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


			$stateArr = array();
			$state_code_ids = '';
			$vms_details_ids = Auth::user()->vms_details_ids;
			$results = VmMaster::where(["parent_id" => $vms_details_ids])->get();
			if ($results->count() > 0) {
				foreach ($results as $key => $val) {

					$ChildByPOCase = VmMaster::where(["parent_id" => $val->id])->get();
					if ($ChildByPOCase->count() > 0) {
						foreach ($ChildByPOCase as $key => $val) {
							if ($val->state_code == '')
								continue;

							$state_code_ids .= $val->state_code . ",";
						}
					}
				}
				$state_code_ids = rtrim($state_code_ids, ',');
			} else {
				$stateArr = StateMaster::pluck('id')->toArray();
			}

			if (!empty($state_code_ids))
				$stateArr = explode(",", $state_code_ids);
		} else {
			$stateArr = StateMaster::pluck('id')->toArray();
		}



		$current_user_id = Auth::user()->id; // get user id


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
			'vn_upload_survey_files.outcome',
			'surveys.survey_co_flag',
			'surveys.po_status'
		)
			->join('customers as U', 'U.id', '=', 'surveys.user_id')
			->join('book_appinment_master as BAM', 'BAM.survey_id', '=', 'surveys.id')
			->join('centre_master as CM', 'CM.id', '=', 'BAM.center_ids')
			->join('district_master as D', 'D.district_code', '=', 'CM.district_id')
			->join('state_master as SM', 'SM.state_code', '=', 'D.state_code')
			->leftJoin('platforms', 'platforms.id', '=', 'surveys.platform_id')
			->leftJoin('vn_upload_survey_files', 'vn_upload_survey_files.survey_id', '=', 'surveys.id')
			->whereIn('BAM.state_id', $stateArr)
			->whereIn('surveys.survey_co_flag', $conArr)
			->where(["surveys.survey_manual_vn_id" => $current_user_id])
			->groupBy('surveys.id')
			->orderBy('surveys.id', 'DESC')->paginate(setting('record_per_page', 15));
		return view('survey.credit', compact('survey'));
	}


	public function eslip()
	{

		$state_list = StateMaster::orderBy('state_name', 'ASC')->get();
		$user_list = User::select("users.vms_details_ids", "vm.name", "vm.last_name", "vm.vncode", "vm.state_code")
			->join('vm_master as vm', 'users.vms_details_ids', '=', 'vm.id')
			->where(["users.user_type" => 2])
			->get();
		return view('survey.list_slip', compact('user_list', 'state_list'));
	}

	public function eslipNew()
	{

		$state_list = StateMaster::orderBy('state_name', 'ASC')->get();
		$user_list = User::select("users.vms_details_ids", "vm.name", "vm.last_name", "vm.vncode", "vm.state_code")
			->join('vm_master as vm', 'users.vms_details_ids', '=', 'vm.id')
			->where(["users.user_type" => 2])
			->get();
		return view('survey.list_slip_new', compact('user_list', 'state_list'));
	}

	function all_survey_report_slip_new(Request $request)
	{

		$user_type = Auth::user()->user_type;
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
			$query = Appointments::query();
			$vms_details_ids = Auth::user()->vms_details_ids;
			$results = VmMaster::find($vms_details_ids);
			if (!empty($results->state_code)) {
				$stateArr = explode(",", $results->state_code);
			} else {
				$stateArr = StateMaster::pluck('id')->toArray();
			}


			if ($request->filled('mobile_no')) {
				$query->where('mobile_no', $request->mobile_no);
			}
			if ($request->filled('uid')) {
				$query->where('uid', 'LIKE', '%' . $request->uid . '%');
				// dd($request->uid);
			}
			if ($request->filled('state_id')) {

				if ($request->filled('state_id') && in_array($request->state_id, $stateArr)) {
					$query->where('state_id', $request->state_id);
					$total = $query->count();
					$data = $query->skip($request->integer('start', 0))->take($request->integer('length', 10))->get();
				} else {
					$data = $query->skip($request->integer('start', 0))->take($request->integer('length', 10))->whereIn('state_id', $stateArr)->get();
					$total = $query->whereIn('state_id', $stateArr)->count();
				}
			} else {

				$data = $query->skip($request->integer('start', 0))->take($request->integer('length', 10))->whereIn('state_id', $stateArr)->get();
				$total = $query->whereIn('state_id', $stateArr)->count();
			}
		} else if ($roleName == PO_PERMISSION) {
			$stateArr = array();
			$vms_details_ids = Auth::user()->vms_details_ids;
			;



			if ($request->user()->vndetails()->first()->regions_list != null) {
				if (is_array($request->user()->vndetails()->first()->regions_list)) {
					$regions_list = $request->user()->vndetails()->first()->regions_list;
				} else
					$regions_list = json_decode($request->user()->vndetails()->first()->regions_list, true);
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
			} else {
				$region = $request->user()->vndetails()->first()->region;
				if ($region == "north")
					$regx[] = 1;
				if ($region == "south")
					$regx[] = 2;
				if ($region == "east")
					$regx[] = 3;
				if ($region == "west")
					$regx[] = 4;
			}



			$stateCodes_po = StateMaster::whereIn('region', $vals)->pluck('state_code')->toArray();
			$status = 1;
			$vnx = [];
			$state_id = [];
			$vn_ids_po = VmMaster::whereHas('User', function ($query) use ($status) {
				return $query->where('status', $status)->where('user_type', 2);
			})->get();
			foreach ($stateCodes_po as $stcode_po) {
				foreach ($vn_ids_po->toArray() as $vnk) {
					$tempcodes = $vnk["state_code"];
					if (strpos($tempcodes, ',') !== false) {
						$tempcodes_vn = explode(',', $tempcodes);
						if (in_array($stcode_po, $tempcodes_vn)) {
							if (!in_array($vnk["id"], $vnx)) {
								array_push($vnx, $vnk['id']);
								foreach ($tempcodes_vn as $value) {
									if (!in_array($value, $state_id))
										array_push($state_id, $value);
								}
							} else
								continue;
						} else
							continue;
					} else {
						if ($stcode_po == $tempcodes) {
							if (!in_array($vnk["id"], $vnx)) {
								array_push($vnx, $vnk['id']);
								if (!in_array($tempcodes, $state_id))
									array_push($state_id, $tempcodes);
							} else
								continue;
						} else
							continue;
					}
				}
			}
			$query = Appointments::query();
			$stateArr = StateMaster::whereIn('state_code', $state_id)->pluck('id')->toArray();
			if ($request->filled('uid')) {
				$query->where('uid', 'LIKE', '%' . $request->uid . '%');
			}
			if ($request->filled('mobile_no')) {
				$query->where('mobile_no', $request->mobile_no);
			}
			if ($request->filled('state_id')) {

				if ($request->filled('state_id') && in_array($request->state_id, $stateArr)) {
					$query->where('state_id', $request->state_id);
					$total = $query->count();
					$data = $query->skip($request->integer('start', 0))->take($request->integer('length', 10))->get();
				} else {
					$data = $query->skip($request->integer('start', 0))->take($request->integer('length', 10))->whereIn('state_id', $stateArr)->get();
					$total = $query->whereIn('state_id', $stateArr)->count();
				}
			} else {

				$data = $query->skip($request->integer('start', 0))->take($request->integer('length', 10))->whereIn('state_id', $stateArr)->get();
				$total = $query->whereIn('state_id', $stateArr)->count();
			}
		} else {


			$query1 = DB::table('self_appointment_book_master')
				->leftJoin('self_risk_assessment_master', 'self_risk_assessment_master.risk_assessment_id', '=', 'self_appointment_book_master.assessment_id')
				->select(
					'self_appointment_book_master.*',
					'self_risk_assessment_master.risk_score',
					'self_risk_assessment_master.created_at as risk_assessment_created_at'
				);

			$query2 = DB::table('self_risk_assessment_master')
				->rightJoin('self_appointment_book_master', 'self_risk_assessment_master.risk_assessment_id', '=', 'self_appointment_book_master.assessment_id')
				->select(
					'self_appointment_book_master.*',
					'self_risk_assessment_master.risk_score',
					'self_risk_assessment_master.created_at as risk_assessment_created_at'
				);

			$data = DB::query()->fromSub($query1->union($query2), 'appointments')
				->orderBy("appointment_id", "DESC");

			// Apply filters
			if ($request->filled('uid')) {
				$data->where('uid', 'LIKE', '%' . $request->uid . '%');
				// dd($request->uid);
			}
			if ($request->filled('mobile_no')) {
				$data->where('mobile_no', $request->mobile_no);
			}
			if ($request->filled('state_id')) {
				$data->where('state_id', $request->state_id);
			}

			$data = $data->skip($request->integer('start', 0))
				->take($request->integer('length', 10))
				->get();



			$query1 = DB::table('self_appointment_book_master')
				->leftJoin('self_risk_assessment_master', 'self_risk_assessment_master.risk_assessment_id', '=', 'self_appointment_book_master.assessment_id')
				->select(
					'self_appointment_book_master.*',
					'self_risk_assessment_master.risk_score'
				);

			$query2 = DB::table('self_risk_assessment_master')
				->rightJoin('self_appointment_book_master', 'self_risk_assessment_master.risk_assessment_id', '=', 'self_appointment_book_master.assessment_id')
				->select(
					'self_appointment_book_master.*',
					'self_risk_assessment_master.risk_score'
				);

			$totalQuery = DB::query()->fromSub($query1->union($query2), 'appointments');

			if ($request->filled('mobile_no')) {
				$totalQuery->where('mobile_no', $request->mobile_no);
			}
			if ($request->filled('state_id')) {
				$totalQuery->where('state_id', $request->state_id);
			}

			$total = $totalQuery->count();
		}
		$fina_data = [];

		$final = [];
		foreach ($data as $list) {
			$final = array(

				"book_date" => $list->risk_assessment_created_at ? date("d/m/Y", strtotime($list->risk_assessment_created_at)) : null,
				"state_name" => StateMaster::where('id', $list->state_id)->pluck("state_name")->first(),
				"district_name" => DistrictMaster::where('id', $list->district_id)->pluck("district_name")->first(),
				"client_phone_number" => $list->mobile_no,
				"risk_score" => $list->risk_score,
				"uid" => $list->uid
			);
			$final["dowload_e_slip"] = "<a href='" . Storage::url($list->media_path) . "' target='_blank' class='btn btn-primary'>Download E Slip</a>";
			$fina_data[] = $final;
		}

		$json_data = array(
			"draw" => intval($request->draw),
			"recordsTotal" => intval($total),
			"recordsFiltered" => intval($total),
			"data" => $fina_data   // total data array
		);
		echo json_encode($json_data);  // send data as json format			
		exit;
	}

	public function all_survey_report_slip(Request $request)
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


			$stateArr = array();
			$state_code_ids = '';
			$vms_details_ids = Auth::user()->vms_details_ids;
			;



			if ($request->user()->vndetails()->first()->regions_list != null) {
				if (is_array($request->user()->vndetails()->first()->regions_list)) {
					$regions_list = $request->user()->vndetails()->first()->regions_list;
				} else
					$regions_list = json_decode($request->user()->vndetails()->first()->regions_list, true);
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
			} else {
				$region = $request->user()->vndetails()->first()->region;
				if ($region == "north")
					$regx[] = 1;
				if ($region == "south")
					$regx[] = 2;
				if ($region == "east")
					$regx[] = 3;
				if ($region == "west")
					$regx[] = 4;
			}



			$stateCodes_po = StateMaster::whereIn('region', $vals)->pluck('state_code')->toArray();
			$status = 1;
			$vnx = [];
			$state_id = [];
			$vn_ids_po = VmMaster::whereHas('User', function ($query) use ($status) {
				return $query->where('status', $status)->where('user_type', 2);
			})->get();
			foreach ($stateCodes_po as $stcode_po) {
				foreach ($vn_ids_po->toArray() as $vnk) {
					$tempcodes = $vnk["state_code"];
					if (strpos($tempcodes, ',') !== false) {
						$tempcodes_vn = explode(',', $tempcodes);
						if (in_array($stcode_po, $tempcodes_vn)) {
							if (!in_array($vnk["id"], $vnx)) {
								array_push($vnx, $vnk['id']);
								foreach ($tempcodes_vn as $value) {
									if (!in_array($value, $state_id))
										array_push($state_id, $value);
								}
							} else
								continue;
						} else
							continue;
					} else {
						if ($stcode_po == $tempcodes) {
							if (!in_array($vnk["id"], $vnx)) {
								array_push($vnx, $vnk['id']);
								if (!in_array($tempcodes, $state_id))
									array_push($state_id, $tempcodes);
							} else
								continue;
						} else
							continue;
					}
				}
			}
			$stateArr = StateMaster::whereIn('state_code', $state_id)->pluck('id')->toArray();
		} else {
			$stateArr = StateMaster::pluck('id')->toArray();
		}

		if (!empty($request->region) && $request->region <> 'Choose...') {
			$stateArr = StateMaster::where(["region" => $request->region])->pluck('id')->toArray();
		}

		if (!empty($request->state_id) && $request->state_id <> 'Choose...') {
			$stateArr = StateMaster::where(["state_code" => $request->state_id])->pluck('id')->toArray();
		}

		if (!empty($request->facility_type) && $request->facility_type <> 'Choose...') {
			$facility = $request->facility_type;
		} else {
			$facility = '';
		}

		$target_pop = '';
		if (!empty($request->target_pop) && $request->target_pop <> 'Choose...') {
			$target_pop = $request->target_pop;
		}


		$pid_survey = '';
		if (!empty($request->pid_survey)) {
			$pid_survey = $request->pid_survey;
		}

		$outcome = '';
		if (!empty($request->outcome) && $request->outcome <> 'Choose...') {
			$outcome = $request->outcome;
		}


		if ($request->date_type == "assessment_date") {
			$date_type = $request->date_type;
			$date_to = $request->asset_date_to;
			$date_from = $request->asset_date_from;
		} else if ($request->date_type == "referral_date") {
			$date_type = $request->date_type;
			$date_to = $request->refer_date_to;
			$date_from = $request->refer_date_from;
		} else if ($request->date_type == "acess_date") {
			$date_type = $request->date_type;
			$date_to = $request->acess_date_to;
			$date_from = $request->acess_date_from;
		} else {
			$date_type = '';
			$date_to = '';
			$date_from = '';
		}

		$servicesFilter = '';
		if (!empty($request->services) && $request->services <> 'Choose...') {
			$servicesFilter = $request->services;
		}


		$genderArr = array("1" => "Male", "2" => "Female", "3" => "Transgender", "4" => "I prefer not to say", "5" => "I prefer not to say", "6" => "Other");

		$services = array("1" => "HIV Test", "2" => "STI Services", "3" => "PrEP", "4" => "PEP", "5" => "Counselling on Mental Health", "6" => "Referral to TI services", "7" => "ART Linkages");

		$serviceAval = array("0" => "", 1 => "ICTC", 2 => "FICTC", 3 => "ART", 4 => "TI", 5 => "Private lab");


		$state_list = StateMaster::whereIn('id', $stateArr)->orderBy('state_name', 'ASC')->get();



		$start = ($request->start > 0) ? $request->start : 1;

		//DB::enableQueryLog();
		$results = Surveys::get_all_survey($request->start, $request->length, $stateArr, '', $conArr, $facility, $target_pop, $pid_survey, $outcome, $date_type, $date_to, $date_from, $servicesFilter);
		//$query = DB::getQueryLog();
		//dd($query);	
		$total = Surveys::get_all_survey('', '', $stateArr, '', $conArr, $facility, $target_pop, $pid_survey, $outcome, $date_type, $date_to, $date_from, $servicesFilter);

		$data = array();
		foreach ($results as $list) {

			$service_required = '';
			$servicesArr = json_decode($list->services_required);
			foreach ($services as $key => $value) {
				if (!@in_array($key, $servicesArr))
					continue;
				$service_required .= $value . ",";
			}

			$services_avail = '';
			if (isset($list->services_avail) && !empty($list->services_avail)) {

				if (!empty($list->services_avail)) {
					$serviceOrginAval = explode(",", $list->services_avail);
					foreach ($serviceOrginAval as $val) {
						$services_avail .= $serviceAval[$val] . ",";
					}
					$services_avail = rtrim($services_avail, ',');
				}
			}


			$client_type = ($list->client_type == 1) ? 'New Client' : 'Follow Up Client';
			//$platforms_name = !empty($list->platforms_name)?$list->platforms_name:'Walk-in';

			if (!empty($list->platforms_name)) {
				$platforms_name = $list->platforms_name;
			} else {
				if ($list->manual_flag > 0) {
					$platforms_name = "Manual";
				} else {
					$platforms_name = "Walk-in";
				}
			}


			$identify_yourself = isset($genderArr[$list->identify_yourself]) ? $genderArr[$list->identify_yourself] : "";

			$hiv_test = ($list->hiv_test == 1) ? 'Yes' : 'No';

			$book_date = date("d/m/Y", strtotime($list->book_date));

			$appArr = '';
			if ($list->po_status == 0)
				$appArr = '<input type="checkbox" id="all" name="all" value="' . $list->id . '" class="multi_approve">';

			$htmlAction = '';
			if ($list->po_status == 0)
				$htmlAction = '<span class="badge badge-info">Pending</span>';
			else if ($list->po_status == 1)
				$htmlAction = '<span class="badge badge-success">Approve</span>';
			else if ($list->po_status == 2)
				$htmlAction = '<span class="badge badge-danger">Rejected</span>';

			$sexually = '';
			if (!empty($list->sexually)) {
				$sexually = implode(", ", json_decode($list->sexually));
			}

			$hiv_infection = '';
			if (!empty($list->hiv_infection)) {
				$hiv_infectionAtt = json_decode($list->hiv_infection);
				$strArr = array(
					"Had sex without a condom" => 1,
					"Had sex with more than one partner" => 2,
					"Had hi-fun sex" => 3,
					"shared needles for injecting Drugs" => 4,
					"You have a Sexually transmitted Infection" => 5,
					"Had sex in exchange for gifts or money" => 6,
					"None of the above" => 8
				);
				foreach ($hiv_infectionAtt as $key => $val) {
					if (in_array($val, $strArr))
						$hiv_infection .= array_search($val, $strArr) . ", ";
				}

				$hiv_infection = rtrim($hiv_infection, ", ");
			}

			$ip_address = '';
			if (!empty($list->survey_details) && $list->survey_details <> 'cURL Error #:Empty reply from server') {
				$ip_addressArr = json_decode($list->survey_details, true);
				$ip_address = $ip_addressArr["IPv4"];
				$user_state = $ip_addressArr["state"];
				$user_country_name = $ip_addressArr["country_name"];
				$user_city = $ip_addressArr["city"];
			}

			$SurData = array(
				"checkbox" => $appArr,
				"htmlAction" => $htmlAction,
				"client_type" => $client_type,
				"sexually_attracted" => $sexually,
				"increase_risk_hiv" => $hiv_infection,
				"ip_address" => $ip_address,
				"user_state" => $user_state,
				"user_country_name" => $user_country_name,
				"user_city" => $user_city,
				"book_date" => $book_date,
				"state_name" => $list->state_name,
				"district_name" => $list->district_name,
				"platforms_name" => $platforms_name,
				"your_age" => $list->your_age,
				"identify_yourself" => $identify_yourself,
				"target_population" => $list->target_population,
				"client_phone_number" => $list->client_phone_number,
				"risk_level" => $list->risk_level,
				"uid" => $list->uid,
				"service_required" => rtrim($service_required, ","),
				"hiv_test" => $hiv_test,
				"services_avail" => $services_avail,
				"client_name" => $list->client_name,
				"appoint_date" => $list->appoint_date,
				"center_name" => $list->center_name,
				"acess_date" => $list->acess_date,
				"pid" => $list->pid
			);



			if ($list->outcome == 1) {
				$SurData["outcome"] = 'Negative';
			} elseif ($list->outcome == 2) {
				$SurData["outcome"] = 'Positive';
			} elseif ($list->outcome == 3) {
				$SurData["outcome"] = 'Non-reactive';
			} else {
				$SurData["outcome"] = '';
			}

			//can('vn-upload-doc')

			if (auth()->user()->can('vn-upload-doc')) {

				if ($list->flag == 0) {
					$SurData["flag"] = '<button type="button" class="btn btn-sm btn-default"  id="survey_id_' . $list->survey_ids . '" onclick="return uploadReport(' . $list->survey_ids . ');" >Upload</button>';
				} else {
					$SurData["flag"] = 'Uploaded';
				}
			} else {
				$SurData["flag"] = '';
			}
			//endcan

			if ($list->survey_co_flag == 0) {
				if (auth()->user()->can('appoin-to-counseling')) {
					//can('appoin-to-counseling')	
					$SurData["survey_co_flag"] = '<div id="div_con_btn_' . $list->survey_ids . '"><button type="button" class="btn btn-sm btn-info"  id="co_id_' . $list->survey_ids . '" onclick="return counseling(' . $list->survey_ids . ');" >Counseling</button></div>';
					//endcan
				} else {
					$SurData["survey_co_flag"] = '';
				}
			} else {
				$SurData["survey_co_flag"] = '<div id="div_con_btn_' . $list->survey_ids . '"><button type="button" class="btn btn-sm btn-info"  id="co_id_' . $list->survey_ids . '" onclick="return counseling(' . $list->survey_ids . ');" >Counseling</button></div>';
			}


			//can('po-apporve-reject-action')	

			if (auth()->user()->can('po-apporve-reject-action')) {
				if ($list->po_status == 0) {
					$SurData["po_status"] = '<div id="div_po_btn_' . $list->survey_ids . '">											
												<a href="javascript:void(0);" id="po_id_' . $list->survey_ids . '" onclick="return po_action(' . $list->survey_ids . ');" class="btn btn-sm btn-info  mr-4 ">PO Action</a>
											</div>';
				} else {
					if ($list->po_status == 1) {
						$SurData["po_status"] = '<span class="badge badge-success">Approve</span>';
					} else {
						$SurData["po_status"] = '<span class="badge badge-danger">Rejected</span>';
					}
				}
			} else {
				$SurData["po_status"] = '';
			}
			//endcan

			$bookAppinment = BookAppinmentMaster::where("survey_id", $list['id'])->first();
			$pdfId = $bookAppinment['survey_unique_ids'];

			$SurData["dowload_e_slip"] = "<a href='/storage/pdf/" . $pdfId . ".pdf/' target='_blank' class='btn btn-primary'>Dowload E Slip</a>";


			if ($list->flag > 0)
				$SurData["vn_view_upload_files"] = '<span class="btn-inner--icon" onclick="return viewUploadedFiles(' . $list->file_upload_id . ');" style="cursor: pointer;"><i class="ni ni-laptop"></i></span>';
			else
				$SurData["vn_view_upload_files"] = '';


			$data[] = $SurData;
		}


		$json_data = array(
			"draw" => intval($request->draw),
			"recordsTotal" => intval($total->count()),
			"recordsFiltered" => intval($total->count()),
			"data" => $data   // total data array
		);

		echo json_encode($json_data);  // send data as json format			
		exit;
	}


	function survey_vn_by_region(Request $request)
	{

		$stateArr = StateMaster::where('region', $request->rid)->get();

		$vmsArr = array();
		$res = '<option selected>Choose...</option>';
		foreach ($stateArr as $key => $val) {

			$results = VmMaster::select('vm_master.id', 'vm_master.parent_id', 'vm_master.vncode', 'vm_master.name', 'vm_master.last_name', 'vm_master.email', 'vm_master.mobile_number', 'vm_master.region', 'vm_master.state_code')
				->join('users as U', 'U.vms_details_ids', '=', 'vm_master.id')
				->where(["user_type" => 2])
				->whereRaw('FIND_IN_SET(' . $val->state_code . ',vm_master.state_code)')
				->get();

			foreach ($results as $key => $value) {
				//$res.='<option value="'.str_replace(',','_',$value->state_code).'">'.ucfirst($value->name." ".$value->last_name)."(".$value->vncode.")".'</option>';
				$vmsArr[$value->id] = ucfirst($value->name . " " . $value->last_name) . "(" . $value->vncode . ")";
			}
		}
		foreach ($vmsArr as $key => $value) {
			$res .= '<option value="' . $key . '">' . $value . '</option>';
		}

		$optionState = "<option selected>Choose...</option>";
		foreach ($stateArr as $key => $val) {
			$optionState .= "<option value='" . $val . "'>" . $key . "</option>";
		}

		echo json_encode(array("vn_list" => $res, 'optionState' => $optionState));
		die;
	}


	public function get_report_by_pie_chart(Request $request)
	{
		$end_date = Carbon::now()->toDateTimeString(); // Get current date and time
		$star_date = Carbon::now()->subDays(7)->toDateTimeString(); // Get date 7 days before

		// dd($star_date); // Debug


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
			//echo $state_code_ids;
			if (!empty($state_code_ids))
				$stateArr = explode(",", $state_code_ids);
			//print_r($stateArr);
			//die;
		} else if (Auth::user()->hasRole('PO-Permission')) {
			$userId = Auth::user()->vms_details_ids;
			$vnData = VmMaster::where('id', $userId)->first();

			if ($vnData && $vnData->regions_list != null) {
				$regions_list = $vnData->regions_list; // if it's already decoded JSON, else decode
				if (is_string($regions_list)) {
					$regions_list = json_decode($regions_list, true);
				}

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

				$stateArr = StateMaster::whereIn('region', $vals)->pluck('id')->toArray();
			} else {
				$stateArr = StateMaster::pluck('id')->toArray();
			}

			// $stateArr = array();
			// $state_code_ids = '';
			// $vms_details_ids = Auth::user()->vms_details_ids;
			// $results = VmMaster::where(["parent_id" => $vms_details_ids])->get();
			// if ($results->count() > 0) {
			// 	foreach ($results as $key => $val) {
			// 		$ChildByPOCase = VmMaster::where(["parent_id" => $val->id])->get();
			// 		if ($ChildByPOCase->count() > 0) {
			// 			foreach ($ChildByPOCase as $key => $val) {
			// 				if ($val->state_code == '')
			// 					continue;
			// 				$state_code_ids .= $val->state_code . ",";
			// 			}
			// 		} else {
			// 			$state_code_ids .= $val->state_code . ",";
			// 		}
			// 	}
			// 	$state_code_ids = rtrim($state_code_ids, ',');
			// } else {
			// 	$stateArr = StateMaster::pluck('id')->toArray();
			// }
			// if (!empty($state_code_ids))
			// 	$stateArr = explode(",", $state_code_ids);
		} else {
			$stateArr = StateMaster::pluck('id')->toArray();
		}



		$end_date = Carbon::now()->toDateTimeString(); // Get current date and time
		$star_date = Carbon::now()->subDays(7)->toDateTimeString(); // Get date 7 days before





		$user_info = DB::table('self_appointment_book_master')
			->selectRaw('DATE(created_at) as created_at, COUNT(*) as total')
			->whereIn('state_id', $stateArr) // Fix: Correct `IN` clause usage
			->whereBetween('created_at', [$star_date, $end_date]) // Fix: Correct WHERE condition
			->groupByRaw('DATE(created_at)')
			->get();

		// $user_info = DB::select("
		// 		SELECT DATE(created_at) as created_at, COUNT(*) as total 
		// 		FROM self_appointment_book_master WHERE IN (state_id, $stateArr) AND
		// 		WHERE created_at BETWEEN '$star_date' AND '$end_date' 
		// 		GROUP BY DATE(created_at)
		// 	");
		$data = [];
		foreach ($user_info as $row) {
			$data[] = [
				'language' => date("M-d", strtotime($row->created_at)),
				'total' => $row->total,
				'color' => '#' . rand(100000, 999999)
			];
		}
		echo json_encode($data);
		exit;
	}

	// public function get_report_by_pie_chart(Request $request)
	// {

	// 	//BookAppinmentMaster

	// 	$end_date = date('Y-m-d');
	// 	$date = strtotime($end_date);
	// 	$date = strtotime("-7 day", $date);
	// 	$star_date =  date('Y-m-d', $date);
	// 	dd($star_date);
	// 	$user_info = DB::select("select `created_at`, count(*) as total from `self_appointment_book_master` where DATE(created_at)>='$star_date' AND DATE(created_at)<='$end_date' group by DATE(created_at)");

	// 	/*$user_info = BookAppinmentMaster::select('created_at', DB::raw('count(*) as total'))->whereRaw("DATE(created_at)>='$star_date' AND DATE(created_at)<='$end_date' ")->groupBy('DATE(created_at)')->toSql();*/
	// 	$data = array();
	// 	foreach ($user_info as $row) {
	// 		$data[] = array(
	// 			'language'		=>	date("M-d", strtotime($row->created_at)),
	// 			'total'			=>	$row->total,
	// 			'color'			=>	'#' . rand(100000, 999999) . ''
	// 		);
	// 	}
	// 	// dd($data);
	// 	echo json_encode($data);
	// 	exit;
	// }

	public function letsgonew(Request $request)
	{

		$hivinfection = $request->hivinfection;
		$request->session()->put('hivinfection', $hivinfection);

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
		// return redirect("letsgo/$keys"); 
	}
	public function abcd(Request $request)
	{
		try {
			$sql = Surveys::find($request->sid);
			$sql->survey_co_flag = 2;
			$sql->save();
			echo json_encode(array("results" => "Success", "id" => $request->sid));
			exit;
		} catch (\Exception $e) {
			echo json_encode(array("results" => "failer", "message" => $e->getMessage()));
			exit;
		}
	}

	public function flag_delete(Request $request, $id)
	{
		Surveys::find($id)->delete($id);

		return response()->json([
			'status' => 'success',
			'message' => 'Succesfully Deleted'
		]);
	}
}
