<?php

namespace App\Http\Controllers\Outreach;

use App\Http\Controllers\Controller;
use App\Models\Outreach\Profile;
use Illuminate\Http\Request;
use App\Models\StateMaster;
use App\Models\Counter;
use App\Models\DistrictMaster;
use App\Http\Requests\Outreach\ProfileRequest;
use App\Models\ClientResponse;
use App\Models\ClientType;
use App\Models\Gender;
use App\Models\Outreach\Counselling;
use App\Models\Outreach\PLHIV;
use App\Models\Outreach\ReferralService;
use App\Models\Outreach\RiskAssessment;
use App\Models\Outreach\STIService;
use App\Models\Platform;
use App\Models\TargetPopulation;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\SelfModule\{Appointments};
use App\Models\VmMaster;
use App\Models\User;
use App\Exports\OutreachProfileExport;

class ProfileController extends Controller
{
    const APPS = array(
        1 => "Grinder",
        2 => "PlanetRomeo",
        3 => "Blued",
        4 => "Scruff",
        5 => "Tinder",
        6 => "OK CUPID",
        7 => "Bumble",
        8 => "WhatsApp",
        9 => "Instagram",
        10 => "Facebook",
        11 => "Brokers",
        12 => "Gay Friendly",
        13 => "TAMI",
        14 => "Telegram",
        15 => "WALLA",
        16 => "Telephone call",
        99 => "Others"
    );

    const GENDERS = array(1 => "Male", 2 => "Female", 3 => "TG", 4 => "Not disclosed", 5 => "Others");

    const TARGET_POPULATION = array(
        1 => "MSM",
        2 => "FSW",
        3 => "MSW",
        4 => "TG",
        5 => "PWID",
        6 => "Adolescents and Youths (18-24)",
        7 => "Men and Women with High risk behaviours accessing virtual platforms (above 24 yrs)",
        8 => "Not Disclosed",
        99 => "Others"
    );

    const CLIENT_TYPE = array(1 => "New client", 2 => "Follow up client");

    const CLIENT_INTRO = array(
        1 => "Responded",
        2 => "Client approached",
        3 => "Wants to get back later for service",
        4 => "Not interested",
        5 => "Did not respond",
        6 => "Blocked",
        7 => "Responded & blocked later"
    );

    const OTHER_VIRTUAL_PLATFORM = array(
        1 => "Grinder",
        2 => "PlanetRomeo",
        3 => "Blued",
        4 => "Scruff",
        5 => "Tinder",
        6 => "OK CUPID",
        7 => "Bumble",
        8 => "WhatsApp",
        9 => "Instagram",
        10 => "Facebook",
        11 => "Brokers",
        12 => "Gay Friendly",
        13 => "TAMI",
        14 => "Telegram",
        15 => "WALLA",
        98 => "Not disclosed",
        99 => "Others",
        '' => ''
    );

    const REFERRAL_LIST = array(
        1 => "One to One Outreach",
        2 => "NETREACH Websites (Direct Walk In)",
        5 => "META -Lead Campaign",
        6 => "META-KYR Traffic",
        7 => "Grindr",
        8 => "Jio Cinema",
        9 => "Hotstar",
        10 => "MX Player",
        11 => "Quora",
        12 => "VN Specific",
        99 => "Others",
    );
    const PURPOSE = array(
        1 => "Information",
        2 => "BCC",
        3 => "Counseling",
        4 => "HIV testing",
        5 => "STI Services",
        6 => "PrEP",
        99 => "Others"
    );
    const MEDIUM = array(
        1 => "Telephone call",
        2 => "Whatsapp",
        3 => "Instagram",
        4 => "Facebook",
        5 => "Grinder",
        6 => "Blued",
        99 => "Other"
    );
    /**
     * Display a listing of the resource.
     */
    public function index()
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

        return view('outreach.profile.index', compact("roleName"));
    }

    public function downloadSample(Request $request)
    {
        return response()->download(storage_path('app/outreach/sample/sample_sheet.xlsx'));
    }

    /**
     * Return a JSON list of search results.
     */
    public function search(Request $request)
    {
        if (!$request->has('q')) {
            return [];
        }

        $profiles = Profile::where('unique_serial_number', 'like', '%' . $request->q . '%')
            ->orWhere('profile_name', 'like', '%' . $request->q . '%')
            ->orderBy('unique_serial_number')->get();

        return response()->json($profiles);
    }

    public function assign(Request $request)
    {
        Profile::whereIn(Profile::profile_id, $request->input('data'))->update(['status' => 1]);
        return true;
    }

    public function takeAction(Request $request)
    {
        Profile::whereIn(Profile::profile_id, $request->input('data'))
            ->update([
                'status' => $request->input('status'),
                'comment' => $request->input('comment')
            ]);

        return true;
    }

    public function deleteProfile(Request $request)
    {
        $prodileID = $request->input(Profile::profile_id);

        Profile::where(Profile::profile_id, $prodileID)->update([Profile::is_deleted => true]);
        Counselling::where(Counselling::profile_id, $prodileID)->update([Counselling::is_deleted => true]);
        PLHIV::where(PLHIV::profile_id, $prodileID)->update([PLHIV::is_deleted => true]);
        ReferralService::where(ReferralService::profile_id, $prodileID)->update([ReferralService::is_deleted => true]);
        RiskAssessment::where(RiskAssessment::profile_id, $prodileID)->update([RiskAssessment::is_deleted => true]);
        STIService::where(STIService::profile_id, $prodileID)->update([STIService::is_deleted => true]);

        return true;
    }

    public function delete_evidence(Request $request)
    {
        $appointment_id = $request->appointment_id;
        $evidence = $request->evidence;
        $updated = Appointments::where('appointment_id', $appointment_id)->update([$evidence => null]);
        if ($updated) {
            return response()->json([
                'status' => true
            ], 200);
        } else {
            return response()->json(['status' => true, 'error' => 'No matching record found or update failed'], 404);
        }
    }
    public function delete_evidence_for_referral(Request $request)
    {
        $referral_service_id = $request->referral_service_id;
        $evidence = $request->evidence;
        $updated = ReferralService::where('referral_service_id', $referral_service_id)->update([$evidence => null]);
        if ($updated) {
            return response()->json([
                'status' => true
            ], 200);
        } else {
            return response()->json(['status' => true, 'error' => 'No matching record found or update failed'], 404);
        }
    }
    public function listExport()
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
            $data = Profile::where('is_active', true)
                ->where(ReferralService::user_id, Auth::id())
                ->get();
        } else {
            $data = Profile::where('is_active', true)->get();
        }
        $profileData = collect()->make();
        $count = 1;

        foreach ($data as $value) {
            $profileData->push([
                'sr_no' => $count++,
                Profile::profile_name => $value[Profile::profile_name],
                Profile::phone_number => $value[Profile::phone_number],
                Profile::status => $value[Profile::status],
                Profile::comment => $value->comment,
                Profile::uid => $value[Profile::uid],
                Profile::user_id => User::getOneUserById($value->user_id),
                Profile::unique_serial_number => $value[Profile::unique_serial_number],
                Profile::registration_date => $value[Profile::registration_date],
                Profile::state_id => StateMaster::getOneStateName($value->state_id),
                Profile::district_id => DistrictMaster::getOneDistrictName($value->district_id),
                Profile::platform_id => $value->platform_id ? ProfileController::APPS[$value->platform_id] : "",
                Profile::other_platform => $value[Profile::other_platform],
                Profile::remarks => $value[Profile::remarks],
            ]);
        }
        return new OutreachProfileExport($profileData->all());
    }

    /**
     * Return a JSON listing of the resource.
     */
    public function list(Request $request)
    {
        $datax = $request->datax;
        $data = array();

        $query = Profile::with(['user', 'state', 'district', 'client_type', 'target', 'platform', 'mentioned_platform', 'gender', 'response', 'referral_service'])->where(Profile::is_deleted, false)->where(Profile::is_active, true);
        if ($datax != 4) {
            $query = $query->where(Profile::status, $datax);
        }
        if (in_array(Auth::user()->getRoleNames()->first(), [VN_USER_PERMISSION, COUNSELLOR_PERMISSION]))
            $query = $query->where(Profile::user_id, Auth::id());

        if (Auth::user()->getRoleNames()->first() == PO_PERMISSION && !empty($request->user()->vndetails()->first())) {
            $regions_list = $request->user()->vndetails()->first()->regions_list;
            if ($regions_list) {
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
                $query = $query->whereIn(Profile::region_id, $vals);
            } else {

                $query = $query->where(Profile::region_id, array_search(ucwords($request->user()->vndetails()->first()->region), REGION));
            }
        }

        if ($request->has('search')) {
            $query = $query->where(function ($query) use ($request) {
                $search = strtolower($request->search);
                return $query->where(DB::raw('lower(' . Profile::unique_serial_number . ')'), 'like', '%' . $search . '%')
                    ->orWhere(DB::raw('lower(' . Profile::profile_name . ')'), 'like', '%' . $search . '%')
                    ->orWhere(Profile::phone_number, 'like', '%' . $search . '%');
            });
        }

        $total = $query->count();

        $query = $query->skip($request->start)->take($request->length)->orderByDesc(Profile::profile_id)->get();

        if ($query->count() > 0) {
            foreach ($query as $value) {
                $id = $value[Profile::profile_id];
                $unique_serial_number = $value->unique_serial_number;
                $referral = $value->referral_service;

                $statusID = $value->status;
                $status = isset(PROFILE_STATUS[$statusID]) ? PROFILE_STATUS[$statusID] : null;
                if (!empty($status))
                    $status = view('outreach.ajax.status', compact('statusID', 'status'))->render();
                $select = view('outreach.ajax.select', compact('id', 'statusID'))->render();
                $action = view('outreach.ajax.action', compact('id', 'statusID', 'unique_serial_number', 'referral'))->render();
                $statusText = match ($value->status) {
                    0 => "Not Assigned",
                    1 => "Pending",
                    2 => "Accepted",
                    3 => "Rejected",
                    default => "",
                };

                $data[] = array(
                    $select,
                    $action,
                    $statusText,
                    $value->profile_name,
                    $value->phone_number,
                    $value->comment,
                    // $value->uid,
                    !empty($value->user) ? $value->user->name : null,
                    $value->unique_serial_number,
                    $value->registration_date,
                    !empty($value->state) ? $value->state->state_name : null,
                    !empty($value->district) ? $value->district->district_name : null,
                    !empty($value->platform) ? $value->platform[Platform::name] : null,
                    $value->other_platform,
                    $value->remarks
                    // $status,
                    // !empty($value[ClientType::client_type]) ? $value[ClientType::client_type][ClientType::client_type] : null,
                    // $value->location,
                    // $value->age,
                    // !empty($value->gender) ? $value->gender[Gender::gender] : null,
                    // $value->other_gender,
                    // !empty($value->target) ? $value->target[TargetPopulation::target_type] : null,
                    // $value->others_target_population,
                    // !empty($value->response) ? $value->response[ClientResponse::response] : null,
                    // $value->virtual_platform,
                    // !empty($value->mentioned_platform) ? $value->mentioned_platform[Platform::name] : null,
                    // $value->others_mentioned,
                    // $value->reached_out,
                    // $value->follow_up_date,
                );
            }
        }

        $json_data = array(
            "draw" => intval($request->draw),
            "recordsTotal" => $total,
            "recordsFiltered" => $total,
            "data" => $data   // total data array
        );

        echo json_encode($json_data);  // send data as json format			
        exit;
    }

    public function ImportProfile(Request $request)
    {
        $request->file('efile')->storeAs('outreach/', $request->file('efile')->getClientOriginalName(), 'local');
        Artisan::call('db:seed --class=OutreachSeeder');

        flash('Imported successfully.')->success();
        return redirect('outreach/profile')->with('message', 'Imported successfully.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $states = StateMaster::orderBy('state_name')->pluck('state_name', 'id');
        $genders = Gender::orderBy(Gender::gender_id)->get();
        $target = TargetPopulation::orderBy(TargetPopulation::target_id)->get();
        $client = ClientType::orderBy(ClientType::client_type_id)->get();
        $apps = Platform::orderBy('id')->get();
        $response = ClientResponse::orderBy(ClientResponse::response_id)->get();

        return view('outreach.profile.create')
            ->with('GENDERS', $genders)
            ->with('TARGET_POPULATION', $target)
            ->with('CLIENT_TYPE', $client)
            ->with('states', $states)
            ->with('APPS', $apps)
            ->with('reffff', self::REFERRAL_LIST)
            ->with('purpose', self::PURPOSE)
            ->with('OTHER_VIRTUAL_PLATFORM', $apps)
            ->with('CLIENT_RESPONSE', $response);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->merge([
            Profile::user_id => Auth::id(),
            Profile::created_at => currentDateTime()
        ]);

        $clientData = $request->all();
        $clientData['region_id'] = StateMaster::where('id', $request->state_id)->first()->region;
        // $state_code = StateMaster::where('id', $request->state_id)->first()->st_cd;
        // $counter = Counter::pluck('appointmentCounter')->first();
        // $newCounter = $counter + 1;
        $profile = Profile::create($clientData);

        $vncode = Auth::user()->user_type == 2 ? VmMaster::where("id", $request->user()->vms_details_ids)->pluck("vncode")->first() : 'ADMIN';
        $profile->unique_serial_number = $vncode . "/" . $profile[Profile::profile_id];
        // $profile->uid = 'NETREACH/' . $state_code . '/' . $vncode . '/' . $newCounter;
        $profile->save();
        // Counter::query()->update(['appointmentCounter' => $newCounter]);
        flash('Client profile created successfully!')->success();
        return redirect()->route('outreach.profile.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Profile $outreach)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Profile $profile)
    {
        $states = StateMaster::orderBy('state_name')->pluck('state_name', 'id');
        $genders = Gender::orderBy(Gender::gender_id)->get();
        $target = TargetPopulation::orderBy(TargetPopulation::target_id)->get();
        $client = ClientType::orderBy(ClientType::client_type_id)->get();
        $apps = Platform::orderBy('id')->get();
        $response = ClientResponse::orderBy(ClientResponse::response_id)->get();
        $canTakeAction = in_array(Auth::user()->getRoleNames()->first(), [SUPER_ADMIN, PO_PERMISSION]);

        return view('outreach.profile.create')
            ->with('GENDERS', $genders)
            ->with('TARGET_POPULATION', $target)
            ->with('CLIENT_TYPE', $client)
            ->with('states', $states)
            ->with('APPS', $apps)
            ->with('reffff', self::REFERRAL_LIST)
            ->with('purpose', self::PURPOSE)
            ->with('OTHER_VIRTUAL_PLATFORM', $apps)
            ->with('CLIENT_RESPONSE', $response)
            ->with('canTakeAction', $canTakeAction)
            ->with('profile', $profile);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Profile $profile)
    {
        $district = DistrictMaster::where('id', $request->input('district_id'))->orWhere('district_name', $request->input('district_id'))->first();
        $clientData = $request->filled('status') ? $request->except(['unique_serial_number', 'uid']) : $request->except(['status', 'unique_serial_number', 'uid']);
        $clientData['region_id'] = StateMaster::find($request->state_id)->region;
        $clientData['district_id'] = $district['id'];

        $profile->update($clientData);

        flash('Client profile updated successfully!')->success();
        return redirect()->route('outreach.profile.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Profile $outreach)
    {
        //
    }
}
