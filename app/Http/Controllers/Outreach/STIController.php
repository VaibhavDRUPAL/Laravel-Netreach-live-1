<?php

namespace App\Http\Controllers\Outreach;

use App\Http\Controllers\Controller;
use App\Http\Requests\Outreach\STIRequest;
use App\Models\ClientType;
use App\Models\Outreach\Profile;
use App\Models\Outreach\ReferralService;
use App\Models\Outreach\STIService;
use App\Models\StateMaster;
use App\Models\STIService as ParentSTIService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class STIController extends Controller
{
    const CLIENT_TYPE  = array(1 => "New client", 2 => "Follow up client");
    const TYPE_STI_SERVICE = array(
        1 => "Syphillis(rpr/vdrl)",
        2 => "Vaginal/ Cervical Discharge(VCD)",
        3 => "Genital Ulcer (GUD)-non herpetic",
        4 => "Lower abdominal pain(LAP)",
        5 => "Urethral DRscharge(UD)",
        6 => "Ano-rectal DRscharge (ARD)",
        7 => "Inguinal Bubo(IB)",
        8 => "Painful scrotal swelling (SS)",
        9 => "Genital warts",
        10 => "Hepatitis B",
        11 => "Hepatitis C",
        12 => "Gonorrhea",
        13 => "Chlamydia",
        99 => "Others"
    );
    const TYPE_FACILITY = array(1 => 'Govt.', 2 => 'Private', 3 => 'NGO/CBO', 4 => 'TI');

    public static function index(Request $request)
    {
        $unique_serial_number = urldecode(request()->query('sno'));
        $profileID = request()->query('profile');
        return view('outreach.sti.index', compact('unique_serial_number', 'profileID'));
    }

    public function takeAction(Request $request)
    {
        STIService::whereIn('id', $request->input('data'))->update(['status' => $request->input('status')]);
        return true;
    }
    
    public static function create(Request $request)
    {
        $unique_serial_number = request()->query('sno');
        $profileID = request()->query('profile');
        $user_id = request()->query(STIService::user_id);
        $states = StateMaster::orderBy('state_name')->pluck('state_name', 'id');
        $client = ClientType::orderBy(ClientType::client_type_id)->get();
        $sti = ParentSTIService::orderBy(STIService::sti_service_id)->get();
        $referral = ReferralService::select([ReferralService::referral_service_id, ReferralService::pid_or_other_unique_id_of_the_service_center, ReferralService::date_of_accessing_service])->where(ReferralService::profile_id, $profileID)->orderByDesc(ReferralService::referral_service_id)->first();
        $profile = Profile::select([Profile::profile_name, Profile::registration_date])->where(Profile::profile_id, $profileID)->first();
        $exists = STIService::where(STIService::profile_id, $profileID)->exists();
        $exists = $exists ? 2 : 1;

        return view('outreach.sti.create')
            ->with('exists', $exists)
            ->with('user_id', $user_id)
            ->with('referral', $referral)
            ->with('profile', $profile)
            ->with('TYPE_STI_SERVICE', $sti)
            ->with('CLIENT_TYPE', $client)
            ->with('TYPE_FACILITY', self::TYPE_FACILITY)
            ->with('unique_serial_number', $unique_serial_number)
            ->with('profileID', $profileID)
            ->with('states', $states);
    }

    /**
     * Return a JSON listing of the resource.
     */
    public function list(Request $request)
    {
        $data = array();

        $query =  STIService::with(['user', 'sti_service'])->where(STIService::is_deleted, false);

        if ($request->filled(Profile::profile_id)) $query = $query->where(STIService::profile_id, $request->integer(Profile::profile_id));

        if (in_array(Auth::user()->getRoleNames()->first(), [VN_USER_PERMISSION, COUNSELLOR_PERMISSION])) $query = $query->where(STIService::user_id, Auth::id());

        if ($request->filled('search')) {
            $query = $query->whereHas('profile', function ($query) use ($request) {
                $search = strtolower($request->search);
                return $query->where(DB::raw('lower(' . Profile::unique_serial_number . ')'), 'like', '%' . $search . '%')
                    ->orWhere(DB::raw('lower(' . Profile::profile_name . ')'), 'like', '%' . $search . '%')
                    ->orWhere(Profile::phone_number, 'like', '%' . $search . '%');
            });
        }

        if ($request->filled(Profile::unique_serial_number)) {
            $query = $query->whereHas('profile', function ($query) use ($request) {
                return $query->where(Profile::unique_serial_number, $request->input(Profile::unique_serial_number));
            });
        }

        $total = $query->count();

        $query = $query->skip($request->start)->take($request->length)->orderByDesc(STIService::sti_services_id)->get();

        if ($query->count() > 0) {
            foreach ($query as $value) {

                $editLink = '<a href="' . route('outreach.sti.edit', [$value[STIService::sti_services_id], 'sno' => urlencode($value[Profile::profile][Profile::unique_serial_number]), 'profile' => $value[Profile::profile_id]]) . '">✎ ' . $value[Profile::profile][Profile::unique_serial_number] . ' </a>';

                $statusID = $value->status;
                $status = isset(PROFILE_STATUS[$statusID]) ? PROFILE_STATUS[$statusID] : null;
                if (!empty($status)) $status = view('outreach.ajax.status', compact('statusID', 'status'))->render();

                $id = $value->id;

                $select = view('outreach.ajax.select', compact('id', 'statusID'))->render();

                $data[] = array(
                    $select,
                    $editLink,
                    !empty($value->user) ? $value->user->name : null,
                    $status,
                    !empty($value[ClientType::client_type]) ? $value[ClientType::client_type][ClientType::client_type] : null,
                    $value->date_of_sti,
                    $value->pid_or_other_unique_id_of_the_service_center,
                    !empty($value->sti_service) ? $value->sti_service[ParentSTIService::sti_service] : null,
                    $value->applicable_for_syphillis,
                    $value->other_sti_service,
                    $value->is_treated ? 'Yes' : 'No',
                    $value->remarks
                );
            }
        }

        $json_data = array(
            "draw"            => intval($request->draw),
            "recordsTotal"    => $total,
            "recordsFiltered" => $total,
            "data"            => $data   // total data array
        );

        echo json_encode($json_data);  // send data as json format			
        exit;
    }

    public static function store(STIRequest $request)
    {
        $request->merge([
            STIService::user_id => Auth::id(),
            STIService::created_at => currentDateTime()
        ]);
        
        STIService::create($request->all());

        flash('STI created successfully!')->success();
        return redirect()->back();
    }

    public static function edit(STIService $sti)
    {
        $unique_serial_number = request()->query('sno');
        $profileID = request()->query('profile');
        $states = StateMaster::orderBy('state_name')->pluck('state_name', 'id');
        $client = ClientType::orderBy(ClientType::client_type_id)->get();
        $stiservice = ParentSTIService::orderBy(STIService::sti_service_id)->get();

        return view('outreach.sti.create')
        ->with('stiservices', $sti)
            ->with('TYPE_STI_SERVICE', $stiservice)
            ->with('CLIENT_TYPE', $client)
            ->with('TYPE_FACILITY', self::TYPE_FACILITY)
            ->with('unique_serial_number', $unique_serial_number)
            ->with('profileID', $profileID)
            ->with('states', $states);
    }

    public function update(STIRequest $request, STIService $stiservices)
    {
        // $request->merge([
        //     STIService::applicable_for_sti_service => json_encode($request->input('applicable_for_sti_service'), JSON_NUMERIC_CHECK),
        // ]);

        $stiservices->update($request->all());
        flash('STI updated successfully!')->success();
        return redirect()->back();
    }
}