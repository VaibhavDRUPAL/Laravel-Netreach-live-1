<?php

namespace App\Http\Controllers\Outreach;

use App\Http\Controllers\Controller;
use App\Models\CentreMaster;
use App\Models\Outreach\PLHIV;
use App\Models\TargetPopulation;
use Illuminate\Http\Request;
use App\Models\StateMaster;
use App\Models\DistrictMaster;
use App\Http\Requests\Outreach\PLHIVRequest;
use App\Models\ClientType;
use App\Models\Outreach\Profile;
use App\Models\Outreach\ReferralService;
use App\Models\ServiceType;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Exports\OutreachPlhivExport;

class PLHIVController extends Controller
{

    const CLIENT_TYPE = array(1 => "New client", 2 => "Follow up client");
    const TYPE_FACILITY = array(1 => 'Govt.', 2 => 'Private', 3 => 'NGO/CBO', 4 => 'TI');
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $unique_serial_number = urldecode(request()->query('sno'));
        $profileID = request()->query('profile');
        return view('outreach.plhiv.index', ['unique_serial_number' => $unique_serial_number, 'profileID' => $profileID]);
    }

    public function takeAction(Request $request)
    {
        PLHIV::whereIn('id', $request->input('data'))->update(['status' => $request->input('status')]);
        return true;
    }
    public function assign(Request $request)
    {
        PLHIV::whereIn('id', $request->input('data'))->update(['status' => 1]);
        return true;
    }
    public function listExport(Request $request)
    {
        // export data
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
        if ($roleName == VN_USER_PERMISSION || $roleName == PO_PERMISSION) {
            $data = ReferralService::where('is_active', true)
                ->where('outcome_of_the_service_sought', 1)
                ->where(ReferralService::user_id, Auth::id())
                ->get();
        } else {
            $data = ReferralService::where('is_active', true)
                ->where('outcome_of_the_service_sought', 1)
                ->get();
        }
        $plhivData = collect()->make();
        $count = 1;
        foreach ($data as $value) {
            $plhivData->push([
                'sr_no' => $count++,
                'profile_name' => Profile::getNameById($value->profile_id),
                ReferralService::client_name => $value[ReferralService::client_name],
                ReferralService::user_id => User::getOneUserById($value->user_id),
                ReferralService::age_client => $value[ReferralService::age_client],
                ReferralService::service_type_id => isset(ReferralServiceController::TYPE_SERVICE[$value->service_type_id]) ? ReferralServiceController::TYPE_SERVICE[$value->service_type_id] : '',
                ReferralService::other_service_type => $value[ReferralService::other_service_type],
                ReferralService::referred_state_id => StateMaster::getOneStateName($value->referred_state_id),
                ReferralService::referred_district_id => DistrictMaster::getOneDistrictName($value->referred_district_id),
                ReferralService::referral_center_id => CentreMaster::getOneCentreName($value->referral_center_id),
                ReferralService::referral_service_id => $value[ReferralService::referral_service_id],
                ReferralService::netreach_uid_number => $value[ReferralService::netreach_uid_number],
                ReferralService::referral_date => $value[ReferralService::referral_date],
                ReferralService::target_id => ReferralService::target_id ? TargetPopulation::getTypeById($value->target_id) : '',
                ReferralService::others_target_population => $value[ReferralService::others_target_population],
                ReferralService::type_of_test => ReferralService::getTypeOfTest(ReferralService::type_of_test),
                ReferralService::test_centre_state_id => StateMaster::getOneStateName($value->test_centre_state_id),
                ReferralService::test_centre_district_id => DistrictMaster::getOneDistrictName($value->test_centre_district_id),
                ReferralService::service_accessed_center_id => CentreMaster::getOneCentreName($value->service_accessed_center_id),
                ReferralService::outcome_of_the_service_sought => ReferralService::getOutcomeOfTheServiceSought($value->outcome_of_the_service_sought),
                ReferralService::date_of_accessing_service => $value[ReferralService::date_of_accessing_service],
                ReferralService::pid_or_other_unique_id_of_the_service_center => $value[ReferralService::pid_or_other_unique_id_of_the_service_center],
                ReferralService::remarks => $value[ReferralService::remarks],
                ReferralService::pre_art_no => $value[ReferralService::pre_art_no],
                ReferralService::on_art_no => $value[ReferralService::on_art_no],
                ReferralService::created_at => $value[ReferralService::created_at],
                ReferralService::updated_at => $value[ReferralService::updated_at],

            ]);
        }
        return new OutreachPlhivExport($plhivData->all());
    }

    /**
     * Return a JSON listing of the resource.
     */
    public function list(Request $request)
    {
        $query = ReferralService::with(
            [
                'user',
                'client_type',
                'profile',
                'educational_attainment',
                'occupation',
                'ti_service',
                'service_type',
                'referred_district',
                'referred_state',
                'referral_center',
                'service_accessed_center',
                'test_centre_district',
                'test_centre_state',
                'sti',
                'reason'
            ]
        )->where(ReferralService::is_deleted, false)
            ->where(ReferralService::is_active, true)
            ->where('outcome_of_the_service_sought', 1);
        // dd($query);
        $data = array();
        if ($request->filled(Profile::profile_id))
            $query = $query->where(ReferralService::profile_id, $request->integer(Profile::profile_id));

        if (in_array(Auth::user()->getRoleNames()->first(), [VN_USER_PERMISSION, COUNSELLOR_PERMISSION]))
            $query = $query->where(ReferralService::user_id, Auth::id());

        if (in_array(CENTER_USER, Auth::user()->getRoleNames()->toArray()) || in_array(CBO_PARTNER, Auth::user()->getRoleNames()->toArray())) {
            $centre = DB::table('centre_master')->where('user_id', Auth::id())->first();
            if ($centre !== null) {
                $query = $query->where('referral_center_id', $centre->id);
            } else {
                $query = $query->where('referral_center_id', '==', '-1');
            }
        }
        if ($request->filled('search')) {
            $query = $query->whereHas('profile', function ($query) use ($request) {
                $search = strtolower($request->search);
                return $query->where(DB::raw('lower(' . ReferralService::referral_service_id . ')'), 'like', '%' . $search . '%')
                    ->orWhere(DB::raw('lower(' . Profile::profile_name . ')'), 'like', '%' . $search . '%');
                // ->orWhere(Profile::phone_number, 'like', '%' . $search . '%');
            });
        }
        if ($request->filled(Profile::unique_serial_number)) {
            $query = $query->whereHas('profile', function ($query) use ($request) {
                return $query->where(Profile::unique_serial_number, $request->input(Profile::unique_serial_number));
            });
        }


        $total = $query->count();
        $query = $query->skip($request->start)->take($request->length)->orderByDesc(ReferralService::referral_service_id)->get();
        // $query = $query->skip($request->start)->take($request->length)->orderByDesc(ReferralService::referral_service_id)->get();
        // dd($query);

        if ($query->count() > 0) {
            foreach ($query as $value) {
                // dd($value);
                // $editLink = '<a href="' . route('outreach.plhiv.edit', [$value[PLHIV::plhiv_id], 'sno' => urlencode($value[Profile::profile][Profile::unique_serial_number]), 'profile' => $value[Profile::profile_id]]) . '">✎ ' . $value[Profile::profile][Profile::unique_serial_number] . ' </a>';

                $statusID = $value->status;
                $status = isset(PROFILE_STATUS[$statusID]) ? PROFILE_STATUS[$statusID] : null;
                if (!empty($status))
                    $status = view('outreach.ajax.status', compact('statusID', 'status'))->render();

                // $id = $value[PLHIV::plhiv_id];
                $id = $value[ReferralService::referral_service_id];
                // $media = "";
                $media = $value[ReferralService::media_path];
                $evidence = $value[ReferralService::evidence_path];
                $evidence2 = $value[ReferralService::evidence_path_2];
                $evidence3 = $value[ReferralService::evidence_path_3];
                $evidence4 = $value[ReferralService::evidence_path_4];
                $evidence5 = $value[ReferralService::evidence_path_5];

                $select = view('outreach.ajax.select', compact('id', 'statusID'))->render();

                $data[] = array(
                    $select,
                    $value[Profile::profile][Profile::profile_name],
                    $value->client_name,
                    !empty($value->user) ? $value->user->name : null,
                    $value->age_client,
                    !empty($value->service_type) ? $value->service_type[ServiceType::service_type] : null,
                    $value->other_service_type,
                    !empty($value->referred_state) ? $value->referred_state->state_name : null,
                    !empty($value->referred_district) ? $value->referred_district->district_name : null,
                    !empty($value->referral_center) ? $value->referral_center->name : null,
                    $value[ReferralService::referral_service_id],
                    $value[ReferralService::netreach_uid_number],
                    $value->referral_date,
                    !empty($value->target_id) ? TargetPopulation::where('target_id', $value->target_id)->pluck('target_type') : null,
                    $value->others_target_population,
                    !empty($value->type_of_test) ? ReferralService::getTypeOfTest($value->type_of_test) : null,
                    // $value->type_of_test,
                    !empty($value->test_centre_state_id) ? StateMaster::getOneStateName($value->test_centre_state_id) : null,
                    !empty($value->test_centre_district_id) ? DistrictMaster::getOneDistrictName($value->test_centre_district_id) : null,
                    !empty($value->service_accessed_center_id) ? CentreMaster::getOneCentreName($value->service_accessed_center_id) : null,
                    $value->date_of_accessing_service,
                    $value->pid_or_other_unique_id_of_the_service_center,
                    $value->remarks,
                    !empty($value->pre_art_no) ? $value->pre_art_no : null,
                    !empty($value->on_art_no) ? $value->on_art_no : null,
                    view('self.admin.ajax.invoice-btn', compact('media', 'evidence', 'evidence2', 'evidence3', 'evidence4', 'evidence5'))->render(),
                    $value->created_at,
                    $value->updated_at,
                );
            }
        }
        // $data = array();

        // $query = PLHIV::with(['user', 'state', 'district', 'profile', 'referral_service'])->where(PLHIV::is_deleted, false)->where(PLHIV::is_active, true);

        // if ($request->filled(Profile::profile_id))
        //     $query = $query->where(PLHIV::profile_id, $request->integer(Profile::profile_id));

        // if (in_array(Auth::user()->getRoleNames()->first(), [VN_USER_PERMISSION, COUNSELLOR_PERMISSION]))
        //     $query = $query->where(PLHIV::user_id, Auth::id());

        // if ($request->filled('search')) {
        //     $query = $query->whereHas('profile', function ($query) use ($request) {
        //         $search = strtolower($request->search);
        //         return $query->where(DB::raw('lower(' . Profile::unique_serial_number . ')'), 'like', '%' . $search . '%')
        //             ->orWhere(DB::raw('lower(' . Profile::profile_name . ')'), 'like', '%' . $search . '%')
        //             ->orWhere(Profile::phone_number, 'like', '%' . $search . '%');
        //     });
        // }

        // if ($request->filled(Profile::unique_serial_number)) {
        //     $query = $query->whereHas('profile', function ($query) use ($request) {
        //         return $query->where(Profile::unique_serial_number, $request->input(Profile::unique_serial_number));
        //     });
        // }

        // $total = $query->count();

        // $query = $query->skip($request->start)->take($request->length)->orderByDesc(PLHIV::plhiv_id)->get();

        // if ($query->count() > 0) {
        //     foreach ($query as $value) {

        //         $editLink = '<a href="' . route('outreach.plhiv.edit', [$value[PLHIV::plhiv_id], 'sno' => urlencode($value[Profile::profile][Profile::unique_serial_number]), 'profile' => $value[Profile::profile_id]]) . '">✎ ' . $value[Profile::profile][Profile::unique_serial_number] . ' </a>';

        //         $statusID = $value->status;
        //         $status = isset(PROFILE_STATUS[$statusID]) ? PROFILE_STATUS[$statusID] : null;
        //         if (!empty($status))
        //             $status = view('outreach.ajax.status', compact('statusID', 'status'))->render();

        //         $id = $value[PLHIV::plhiv_id];

        //         $select = view('outreach.ajax.select', compact('id', 'statusID'))->render();

        //         $data[] = array(
        //             $select,
        //             $editLink,
        //             !empty($value->user) ? $value->user->name : null,
        //             // $value[PLHIV::registration_date],
        //             // !empty($value->referral_service) ? $value->referral_service[ReferralService::netreach_uid_number] : null,
        //             // $status,
        //             !empty($value->profile) ? $value->profile[Profile::uid] : null,
        //             // !empty($value[ClientType::client_type]) ? $value[ClientType::client_type][ClientType::client_type] : null,
        //             $value->pid_or_other_unique_id_of_the_service_center,
        //             !empty($value->profile) ? $value->profile[Profile::profile_name] : null,
        //             // $value->date_of_confirmatory,
        //             $value->date_of_art_reg,
        //             $value->pre_art_reg_number,
        //             $value->date_of_on_art,
        //             $value->on_art_reg_number,
        //             // isset(self::TYPE_FACILITY[$value->type_of_facility_where_treatment_sought]) ? self::TYPE_FACILITY[$value->type_of_facility_where_treatment_sought] : null,
        //             !empty($value->center) ? $value->center->name : null,
        //             !empty($value->district) ? $value->district->district_name : null,
        //             !empty($value->state) ? $value->state->state_name : null,
        //             // $value->remarks
        //         );
        //     }
        // }

        $json_data = array(
            "draw" => intval($request->draw),
            "recordsTotal" => $total,
            "recordsFiltered" => $total,
            "data" => $data   // total data array
        );

        echo json_encode($json_data);  // send data as json format			
        exit;
    }

    public function Importplhiv(Request $request)
    {
        $request->file('efile')->storeAs('outreach/', $request->file('efile')->getClientOriginalName(), 'local');
        Artisan::call('db:seed --class=OutreachSeeder');

        flash('Imported successfully.')->success();
        return redirect('outreach/plhiv')->with('message', 'Imported successfully.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $unique_serial_number = request()->query('sno');
        $profileID = request()->query('profile');
        $referral = ReferralService::select([ReferralService::referral_service_id, ReferralService::pid_or_other_unique_id_of_the_service_center, ReferralService::date_of_accessing_service])->where(ReferralService::profile_id, $profileID)->orderByDesc(ReferralService::referral_service_id)->first();
        $states = StateMaster::orderBy('state_name')->pluck('state_name', 'id');
        $exists = PLHIV::where(PLHIV::profile_id, $profileID)->exists();
        $exists = $exists ? 2 : 1;
        $profile = Profile::select([Profile::profile_name, Profile::registration_date])->where(Profile::profile_id, $profileID)->first();
        $client = ClientType::orderBy(ClientType::client_type_id)->get();

        return view('outreach.plhiv.create')
            ->with('states', $states)
            ->with('CLIENT_TYPE', $client)
            ->with('TYPE_FACILITY', self::TYPE_FACILITY)
            ->with('referral', $referral)
            ->with('exists', $exists)
            ->with('profile', $profile)
            ->with('profileID', $profileID)
            ->with('unique_serial_number', $unique_serial_number);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->merge([
            PLHIV::user_id => Auth::id(),
            PLHIV::created_at => currentDateTime()
        ]);

        $clientData = $request->all();

        PLHIV::create($clientData);

        flash('PLHIV entry created successfully!')->success();
        return redirect()->route('outreach.plhiv.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(PLHIV $plhiv)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PLHIV $plhiv)
    {
        $unique_serial_number = request()->query('sno');
        $profileID = request()->query('profile');
        $states = StateMaster::orderBy('state_name')->pluck('state_name', 'id');
        $districts = DistrictMaster::pluck('district_name');
        $referral = ReferralService::select(ReferralService::referral_service_id)->whereRaw('LOWER(' . ReferralService::netreach_uid_number . ') = ?', strtolower(urldecode($unique_serial_number)))->first();
        $exists = PLHIV::where(PLHIV::profile_id, $profileID)->exists();
        $exists = $exists ? 2 : 1;
        $canTakeAction = in_array(Auth::user()->getRoleNames()->first(), [SUPER_ADMIN, PO_PERMISSION]);
        $client = ClientType::orderBy(ClientType::client_type_id)->get();
        $profile = Profile::select(Profile::profile_name)->where(Profile::profile_id, $profileID)->first();

        return view('outreach.plhiv.create')
            ->with('states', $states)
            ->with('districts', $districts)
            ->with('CLIENT_TYPE', $client)
            ->with('TYPE_FACILITY', self::TYPE_FACILITY)
            ->with('plhiv', $plhiv)
            ->with('canTakeAction', $canTakeAction)
            ->with('referral', $referral)
            ->with('exists', $exists)
            ->with('profile', $profile)
            ->with('profileID', $profileID)
            ->with('unique_serial_number', $unique_serial_number);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PLHIV $plhiv)
    {
        $plhiv->update($request->all());
        flash('PLHIV entry updated successfully!')->success();
        return redirect()->route('outreach.plhiv.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PLHIV $plhiv)
    {
        //
    }
}
