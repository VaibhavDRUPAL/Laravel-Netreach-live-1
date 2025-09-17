<?php


namespace App\Http\Controllers;

use App\Exports\CenterExport;
use App\Imports\CentreImport;
use App\Models\AdminNotification;
use App\Models\CentreMaster;
use App\Models\DistrictMaster;
use App\Models\FCMToken;
use App\Models\StateMaster;
use App\Models\User;
use App\Models\VmMaster;
use App\Services\FirebaseService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class DistrictController extends Controller
{
	//
	protected $firebaseService;

	public function __construct(FirebaseService $firebaseService)
	{
		if (!request()->ajax()) {
			// $this->middleware('permission:view-district');
			$this->firebaseService = $firebaseService;
		}
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{

		if ($request->has('search')) {
			$district = DistrictMaster::where('district_name', 'like', '%' . $request->search . '%')->orderBy('district_name', 'ASC')->paginate(setting('record_per_page', 15));
		} else {
			$district = DistrictMaster::orderBy('district_name', 'ASC')->paginate(setting('record_per_page', 15));
		}
		$title = 'Manage District';
		return view('district.index', compact('district', 'title'));
	}

	public function create_center(Request $request)
	{
		$title = 'Add Center';
		$state = StateMaster::orderBy('state_name')->pluck('state_name', 'state_code');
		$district = DistrictMaster::orderBy('district_name')->pluck('district_name', 'id');
		$userType = Auth::user()->user_type;
		$vn = VmMaster::where('status', 1)->pluck('name', 'name');
		return view('center.create_center', compact('state', 'title', 'district', 'vn', 'userType'));
	}
	public function admin_notification(Request $request)
	{
		$vn_list = User::role('VN User Permission')->get();
		$query = AdminNotification::select('C.*', 'U.name as vn_name', 'S.state_name', 'D.district_name')
			->leftJoin('centre_master as C', 'C.id', '=', 'admin_notification.center_id')
			->leftJoin('state_master as S', 'S.state_code', '=', 'C.state_code')
			->leftJoin('district_master as D', 'D.id', '=', 'C.district_id')
			->leftJoin('users as U', 'U.id', '=', 'C.user_id');


		if (Auth::id() != 1) {
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
			if ($roleName == PO_PERMISSION) {
				$region = $request->user()->vndetails()->first()->region;
				if (is_array($request->user()->vndetails()->first()->regions_list)) {
					$regions_list = $request->user()->vndetails()->first()->regions_list;
				} else
					$regions_list = json_decode($request->user()->vndetails()->first()->regions_list, true);
				if ($request->user()->vndetails()->first()->regions_list != null) {
					$vnIDs = VmMaster::select('id')->where('region', $regions_list)
						->whereHas('user', function ($query) {
							return $query->where('user_type', 2);
						})
						->get();
				} else {
					$vnIDs = VmMaster::select('id')->where('region', $region)
						->whereHas('user', function ($query) {
							return $query->where('user_type', 2);
						})
						->get();
				}
				$vn_idx = [];
				foreach ($vnIDs as $value) {
					array_push($vn_idx, $value['id']);
				}
				$vns = User::whereIn("vms_details_ids", $vn_idx)->pluck('id')->toArray();
				array_push($vns, Auth::id());
				$query->whereIn('U.id', $vns);
			}
		}



		// Handle search and filters
		if ($request->ajax()) {

			if ($request->filled('vn_name')) {
				$query->where('users.id', $request->get('vn_name'));
			}

			if ($request->filled('state_id')) {
				$query->where('centre_master.state_code', $request->get('state_id'));
			}
			if ($request->filled('district_id')) {
				$query->where('centre_master.district_id', $request->get('district_id'));
			}

			// Handle pagination and sorting
			$totalData = $query->count();
			$start = $request->get('start', 0);
			$length = $request->get('length', 10);
			$orderColumn = $request->get('columns')[$request->get('order')[0]['column']]['data'] ?? 'centre_master.name';
			$dir = $request->get('order')[0]['dir'] ?? 'asc';

			$data = $query->offset($start)
				->limit($length)
				->orderBy($orderColumn, $dir)
				->get();

			$data = $data->map(function ($value) {
				$id = $value->id;
				$editUrl = "/edit/{$id}";

				return [
					'address' => $value->address ?? '',
					'centre_contact_no' => $value->centre_contact_no ?? '',
					'contact_no' => $value->contact_no ?? '',
					'created_at' => Carbon::parse($value->created_at)->format('Y-m-d H:i:s'),
					'district_id' => $value->district_id ?? '',
					'district_name' => $value->district_name ?? '',
					'id' => $value->id,
					'incharge' => $value->incharge ?? '',
					'latitude' => $value->latitude ?? '',
					'longitude' => $value->longitude ?? '',
					'name' => $value->name ?? '-',
					'name_counsellor' => $value->name_counsellor ?? '',
					'pin_code' => $value->pin_code ?? '',
					'services_avail' => $value->services_avail ?? '',
					'services_available' => $value->services_available ?? '',
					'state_code' => $value->state_code ?? '',
					'state_name' => $value->state_name ?? '',
					'status' => $value->status ?? '',
					'vn_name' => $value->vn_name ?? '',
					'action' => "<a href='{$editUrl}' class='btn btn-primary btn-sm'>Edit</a>"
				];
			});

			$json_data = array(
				"draw" => intval($request->get('draw')),
				"recordsTotal" => intval($totalData),
				"recordsFiltered" => intval($totalData),
				"data" => $data
			);
			return response()->json($json_data);
		} else {
			$title = 'Manage Centre';
			$state = StateMaster::orderBy('state_name', 'ASC')->get();
			$district = DistrictMaster::all();
			$centre = $query->paginate(50);
			return view('admin_notification', compact('title', 'district', 'state', 'centre', 'vn_list'));
		}
	}

	public function add_center(Request $request)
	{
		$request->validate([
			'centre_name' => 'required',
			'pin_code' => 'required',
			'state_id' => 'required',
			'district_id' => 'required',
			'name_counsellor' => '',
			'seravail' => 'required',
			'faculty' => 'required'
		]);
		$centerData['name'] = $request->centre_name;
		$centerData['address'] = $request->address;
		$centerData['pin_code'] = $request->pin_code;
		$centerData['state_code'] = $request->state_id;
		$centerData['district_id'] = $request->district_id;
		$centerData['name_counsellor'] = $request->name_counsellor;
		$centerData['centre_contact_no'] = $request->centre_contact_no;
		$centerData['incharge'] = $request->incharge;
		$centerData['user_id'] = $request->user()->id;
		$centerData['status'] = 1;
		$centerData['services_avail'] = !empty($request->seravail) ? implode(",", $request->seravail) : '';
		$centerData['services_available'] = !empty($request->seravail) ? implode(",", $request->faculty) : '';
		$centerData['created_at'] = date('Y-m-d H:i:s');
		$centreSave = CentreMaster::create($centerData);
		$lastImportCentre = $centreSave->id;

		if (Auth::user()->roles->contains('name', 'VN User Permission')) {
			$regionsList = VmMaster::where('email', Auth::user()->vn_email)->first();

			$regionsList = $regionsList['regions_list'];

			$superAdminIds = User::role('super-admin')
				->pluck('id');

			if (!empty($regionsList)) {
				$allUsersEmails = VmMaster::where(function ($query) use ($regionsList) {
					foreach ($regionsList as $region) {
						$query->orWhereJsonContains('regions_list', $region);
					}
				})->pluck('email');

				if (!empty($allUsersEmails)) {
					$posUsers = User::whereIn('vn_email', $allUsersEmails)
						->role('PO-Permission')
						->pluck('id');

					// Merge and deduplicate IDs
					$mergedUserIds = $posUsers->merge($superAdminIds)
						->unique()
						->values()
						->all();

					// Get FCM tokens for these users
					$tokens = FCMToken::whereIn('user_id', $mergedUserIds)
						->pluck('token')
						->toArray();
				}
			}

			$title = "New Center added";
			$body = "New center added by " . Auth::user()->name;
			$url = "/all-centre";

			if ($centreSave) {
				$centreNew['center_id'] = $lastImportCentre;
				AdminNotification::create($centreNew);
			}

			// Send the notification
			if (isset($tokens) && !empty($tokens))
				$this->firebaseService->sendNotification($title, $body, $url, $tokens);
		}

		flash('Center created successfully!')->success();
		return redirect()->route('all.centre.index');
	}

	/**
	 * Return a json listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function list(Request $request)
	{
		$districts = DistrictMaster::all();
		return response()->json($districts);
	}


	public function get_state(Request $request)
	{

		if ($request->has('search')) {
			$state = StateMaster::where('state_name', 'like', '%' . $request->search . '%')->orderBy('state_name', 'ASC')->paginate(setting('record_per_page', 15));
		} else {
			$state = StateMaster::orderBy('state_name', 'ASC')->paginate(setting('record_per_page', 15));
		}
		$title = 'Manage State';
		return view('district.state', compact('state', 'title'));
	}


	public function get_centre(Request $request)
	{
		$vn_list = User::role('VN User Permission')->get();
		$query = CentreMaster::select('centre_master.*', 'S.state_name', 'D.district_name', 'users.name as vn_name')
			->leftJoin('state_master as S', 'S.state_code', '=', 'centre_master.state_code')
			->leftJoin('district_master as D', 'D.id', '=', 'centre_master.district_id')
			->leftJoin('users', 'users.id', '=', 'centre_master.user_id');

		if (Auth::id() != 1) {
			$query->where('users.id', Auth::id());
		}
		if ($request->ajax()) {
			if ($request->input('search')['value'] != '') {
				$searchTerm = $request->input('search')['value'];
				// return response()->json($request->input('search')['value']);
				$res = CentreMaster::where('address', 'LIKE', "%{$searchTerm}%")
					->orWhere('name', 'LIKE', "%{$searchTerm}%")
					->orWhere('pin_code', 'LIKE', "%{$searchTerm}%")
					->orWhere('state_code', 'LIKE', "%{$searchTerm}%")
					->orWhere('name_counsellor', 'LIKE', "%{$searchTerm}%")
					->orWhere('name_counsellor', 'LIKE', "%{$searchTerm}%")
					->orWhere('centre_contact_no', 'LIKE', "%{$searchTerm}%")
					->orWhere('incharge', 'LIKE', "%{$searchTerm}%")
					->orWhere('contact_no', 'LIKE', "%{$searchTerm}%");

				$totalData = $res->count();
				$start = $request->get('start', 0);
				$length = $request->get('length', 10);
				$orderColumn = $request->get('columns')[$request->get('order')[0]['column']]['data'] ?? 'centre_master.name';
				$data = $res->offset($start)
					->limit($length)
					->get();

				$data = $data->map(function ($value) {
					$id = $value->id;
					$editUrl = "/edit/{$id}";

					return [
						'address' => $value->address ?? '',
						'centre_contact_no' => $value->centre_contact_no ?? '',
						'contact_no' => $value->contact_no ?? '',
						'created_at' => $value->created_at,
						'district_id' => $value->district_id ?? '',
						'district_name' => $value->district_name ?? '',
						'id' => $value->id,
						'incharge' => $value->incharge ?? '',
						'latitude' => $value->latitude ?? '',
						'longitude' => $value->longitude ?? '',
						'name' => $value->name ?? '-',
						'name_counsellor' => $value->name_counsellor ?? '',
						'pin_code' => $value->pin_code ?? '',
						'services_avail' => $value->services_avail ?? '',
						'services_available' => $value->services_available ?? '',
						'state_code' => $value->state_code ?? '',
						'state_name' => $value->state_name ?? '',
						'status' => $value->status ?? '',
						'vn_name' => $value->vn_name ?? '',
						'action' => "<a href='{$editUrl}' class='btn btn-primary btn-sm'>Edit</a>"
					];
				});

				$json_data = array(
					"draw" => intval($request->get('draw')),
					"recordsTotal" => intval($totalData),
					"recordsFiltered" => intval($totalData),
					"data" => $data
				);
				return response()->json($json_data);
			}
			if ($request->filled('vn_name')) {
				$query->where('users.id', $request->get('vn_name'));
			}

			if ($request->filled('state_id')) {
				$query->where('centre_master.state_code', $request->get('state_id'));
			}
			if ($request->filled('district_id')) {
				$query->where('centre_master.district_id', $request->get('district_id'));
			}

			// Handle pagination and sorting
			$totalData = $query->count();
			$start = $request->get('start', 0);
			$length = $request->get('length', 10);
			$orderColumn = $request->get('columns')[$request->get('order')[0]['column']]['data'] ?? 'centre_master.name';
			$dir = $request->get('order')[0]['dir'] ?? 'asc';
			$servicesAvailableOptions = [
				1 => 'HIV Test',
				2 => 'STI Services',
				3 => 'PrEP',
				4 => 'Counselling for Mental Health',
				5 => 'Referral to TI services',
				6 => 'ART Linkages',
				7 => 'Others'
			];
				$facilityOptions = [
				1 => 'ICTC',
				2 => 'FICTC',
				3 => 'ART',
				4 => 'TI',
				5 => 'private lab'
			];
			$data = $query->offset($start)
				->limit($length)
				->orderBy($orderColumn, $dir)
				->get();

			$data = $data->map(function ($value)use ($facilityOptions, $servicesAvailableOptions) {
				$id = $value->id;
				$editUrl = "/edit/{$id}";

				return [
					'address' => $value->address ?? '',
					'centre_contact_no' => $value->centre_contact_no ?? '',
					'contact_no' => $value->contact_no ?? '',
					'created_at' => $value->created_at,
					'district_id' => $value->district_id ?? '',
					'district_name' => $value->district_name ?? '',
					'id' => $value->id,
					'incharge' => $value->incharge ?? '',
					'latitude' => $value->latitude ?? '',
					'longitude' => $value->longitude ?? '',
					'name' => $value->name ?? '-',
					'name_counsellor' => $value->name_counsellor ?? '',
					'pin_code' => $value->pin_code ?? '',
					// 'services_avail' => $value->services_avail ?? '',
					// 'services_available' => $value->services_available ?? '',
					'services_avail' => collect(explode(',', $value->services_avail))
						->map(fn($id) => $servicesAvailableOptions[$id] ?? '')
						->filter()
						->implode(', '),

					'services_available' => collect(explode(',', $value->services_available))
						->map(fn($id) => $facilityOptions[$id] ?? '')
						->filter()
						->implode(', '),
					'state_code' => $value->state_code ?? '',
					'state_name' => $value->state_name ?? '',
					'status' => $value->status ?? '',
					'vn_name' => $value->vn_name ?? '',
					'action' => "<a href='{$editUrl}' class='btn btn-primary btn-sm'>Edit</a>"
				];
			});

			$json_data = array(
				"draw" => intval($request->get('draw')),
				"recordsTotal" => intval($totalData),
				"recordsFiltered" => intval($totalData),
				"data" => $data
			);
			return response()->json($json_data);
		} else {
			$title = 'Manage Centre';
			$state = StateMaster::orderBy('state_name', 'ASC')->get();
			$district = DistrictMaster::all();
			$centre = $query->paginate(50);
			return view('district.display_centre', compact('title', 'district', 'state', 'centre', 'vn_list'));
		}
	}

	public function downloadTemplate()
	{
		return Storage::disk('public')->download('sample_data.xlsx');
	}


	public function export_centre()
	{
		$centre = CentreMaster::select('centre_master.*', 'S.state_name', 'D.district_name')
			->join('state_master as S', 'S.state_code', '=', 'centre_master.state_code')
			->join('district_master as D', 'D.district_code', '=', 'centre_master.district_id')
			->get();

		return Excel::download(new CenterExport($centre), 'Centers-' . date('Y-m-d') . '.xlsx');
	}

	public function store_centre(Request $request)
	{
		$sid = $request->state_id;
		$did = $request->district_id;

		$fps = '';
		if ($request->hasfile('efile')) {
			$p = public_path('uploads') . '/';
			$fname = 'excel_' . time() . '.' . $request->file('efile')->getClientOriginalExtension();
			$request->file('efile')->move($p, $fname);
			$fps = $p . $fname;
		}

		Excel::import(new CentreImport($sid, $did), $fps);
		flash('Imported successfully.')->success();
		return redirect('/all-centre')->with('message', 'Imported successfully.');
	}
	public function center_edit($id)
	{

		$title = 'Edit Centre';
		$state = StateMaster::orderBy('state_name')->pluck('state_name', 'state_code');
		$centre = CentreMaster::where(["id" => $id])->first();
		$districtName = DistrictMaster::select('district_name')->where('id', $centre->district_id)->first();
		//print_r($centre);

		$centre['district_name'] = $districtName ? $districtName->district_name : '';
		$user = User::where('id', $centre->user_id)->first();
		$email = $user?->email;
		$password = $user?->txt_password;
		$status = $user?->status;
		$vn = VmMaster::where('status', 1)->pluck('name', 'name');
		$userType = Auth::user()->user_type;
		return view('district.centre_edit', compact('state', 'title', 'centre', 'id', 'password', 'email', 'status', 'vn', 'userType'));
	}

	public function get_district_by_state(Request $request)
	{

		$str_code = $request->std_code;

		$city = DistrictMaster::where(['state_code' => $str_code])->orderBy('district_name')->get();
		$optionHtml = '<option value="">Select District...</option>';

		if ($city->count() > 0) {
			foreach ($city as $key => $val) {
				$select = "";
				// if($request->district_id==$val->id){
				// 	$select = "selected";
				// }
				$optionHtml .= '<option value="' . $val->id . '" ' . $select . '>' . $val->district_name . '</option>';
			}
		}
		echo json_encode(array("resultsHtml" => $optionHtml));
		exit;
	}

	public function get_city_by_state(Request $request)
	{

		$str_code = $request->std_code;

		$city = DistrictMaster::where(['state_code' => $str_code])->orderBy('district_name')->get();
		$optionHtml = '<option value="">Select District...</option>';

		if ($city->count() > 0) {
			foreach ($city as $key => $val) {
				$select = "";
				if ($request->district_id == $val->id) {
					$select = "selected";
				}
				$optionHtml .= '<option value="' . $val->id . '" ' . $select . '>' . $val->district_name . '</option>';
			}
		}
		echo json_encode(array("resultsHtml" => $optionHtml));
		exit;
	}

	public function updateCentre(Request $request)
	{
		$rule = array();

		$rule["centre_name"] = "required";
		// $rule["address"] = "required";
		$rule["state_id"] = "required";
		$rule["district_id"] = "required";

		$validator = Validator::make($request->all(), $rule);

		if ($validator->fails()) {

			$url = "edit/" . $request->cen_id;
			return redirect($url)
				->withErrors($validator)
				->withInput();
		}

		$sql = CentreMaster::find($request->cen_id);

		if (!empty($request->faculty) && $request->faculty <> 'null' && count($request->faculty) > 0) {
			$faculty = implode(",", $request->faculty);
		} else {
			$faculty = $sql->services_avail;
		}

		if (!empty($request->seravail) && $request->seravail <> 'null' && count($request->seravail) > 0) {
			$seravail = implode(",", $request->seravail);
		} else {
			$seravail = $sql->services_available;
		}

		$sql->name = $request->centre_name;
		$sql->address = $request->address;
		$sql->pin_code = $request->pin_code;
		$sql->state_code = $request->state_id;
		$sql->district_id = $request->district_id;
		$sql->services_avail = $faculty;
		$sql->services_available = $seravail;
		$sql->name_counsellor = $request->name_counsellor;
		$sql->centre_contact_no = $request->centre_contact_no;
		$sql->incharge = $request->incharge;
		// $sql->user_id = $user->id;
		$sql->save();

		flash('Centre Update successfully!')->success();
		return redirect('edit/' . $request->cen_id);
	}

	public function getDistricts(Request $request)
	{
		$isPrep = $request->session()->get('buttonUse') == 'prep';

		if (!$isPrep && $request->filled('services'))
			$isPrep = collect($request->input('services'))->contains(3);

		$data = DistrictMaster::select('district_name', 'district_name_mr', 'district_name_hi', 'district_name_ta', 'district_name_te', 'id')->where('state_id', $request->input('state_code'))->orderBy('district_name');

		if ($isPrep) {
			$data = $data->with(
				[
					'centres' => function ($query) {
						return $query->whereNotNull('services_available');
					}
				]
			)->whereHas('centres', function ($query) {
				return $query->whereNotNull('services_available');
			});
		} else
			$data = $data->whereHas('centres');

		$data = $data->get();
		// $data = $data->orderBy('district_name')->get();

		if ($isPrep) {
			$data = $data->filter(function ($item) {

				$centers = $item['centres']->filter(function ($center) {
					if (collect($center['center_services'])->contains(3))
						return $center;
				});

				if ($centers->count() > 0)
					return $item;
			});
		}

		return json_encode([STATUS => OK, DATA => $data]);
	}

	public function getAllTestCentres(Request $request)
	{
		$isPrep = $request->session()->get('buttonUse') == 'prep';

		if (!$isPrep && $request->filled('services'))
			$isPrep = collect($request->input('services'))->contains(3);

		$center = CentreMaster::select('id', 'name', 'name_mr', 'name_hi', 'name_te', 'name_ta', 'address', 'address_mr', 'address_hi', 'address_ta', 'address_te', 'services_available')
			->where('district_id', $request->input('district_id'))->orderBy('name');

		if ($isPrep)
			$center = $center->whereNotNull('services_available');

		$center = $center->get();

		if ($isPrep) {
			$center = $center->filter(function ($item) {
				if (collect($item['center_services'])->contains(3))
					return $item;
			});
		}

		return [STATUS => OK, DATA => $center];
	}
}
