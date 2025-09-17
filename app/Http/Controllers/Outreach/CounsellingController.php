<?php

namespace App\Http\Controllers\Outreach;
use App\Http\Controllers\Controller;
use App\Models\Outreach\Counselling;
use Illuminate\Http\Request;
use App\Models\StateMaster;
use App\Models\DistrictMaster;
use App\Http\Requests\Outreach\CounsellingRequest;
use App\Models\ClientType;
use App\Models\Gender;
use App\Models\Outreach\Profile;
use App\Models\TargetPopulation;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CounsellingController extends Controller
{
    const GENDERS = array(1=>'Male',2=>'Female',3=>'TG',4=>'Not disclosed',5=>'Others');
    const TARGET_POPULATION = array(1=>'MSM',2=>'FSW',3=>'MSW',4=>'TG',5=>'PWID',6=>'Adolescents and Youths (18-24)',
			7=>'Men and Women with High risk behaviours accessing virtual platforms (above 24 yrs)',8=>'Not Disclosed',99=>'Others');
    const CLIENT_TYPE  = array(1=>'New client',2=>'Follow up client', 3=>'Repeat');
    const REFERRED_FROM = array(1=>'Approached by the Client', 2=>'VN', 3=>'NETREACH Counsellor', 4=>'Self-Identified', 99=>'Others');
    const TYPE_OF_COUNSELLING = array(1 => 'Face to face', 2 => 'Telephonic', 3 => 'Email', 4 => 'Chat', 99 => 'Other Virtual Medium');
    const COUNSELLING_TYPE = array(1 => 'HIV Counselling', 2 => 'STI Counselling', 3 => 'Positive living Counselling', 4 => 'Family Counselling',5=> 'Mental Health Counselling',6=> 'Trauma and Violence', 99 => 'Other Virtual Medium');
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $unique_serial_number = urldecode(request()->query('sno'));
        $profileID = request()->query('profile');
        return view('outreach.counselling.index', ['unique_serial_number' => $unique_serial_number, 'profileID' => $profileID]);		
    }

    public function takeAction(Request $request)
    {
        Counselling::whereIn('id', $request->input('data'))->update(['status' => $request->input('status')]);
        return true;
    }
    public function assign(Request $request)
    {
        Counselling::whereIn('id', $request->input('data'))->update(['status' => 1]);
        return true;
    }
    /**
     * Return a JSON listing of the resource.
     */
    public function list(Request $request)
    {
        $data = array();

        $query =  Counselling::with(['user', 'client_type', 'profile'])->where(Counselling::is_deleted, false);

        if ($request->filled(Profile::profile_id)) $query = $query->where(Counselling::profile_id, $request->integer(Profile::profile_id));

        if (in_array(Auth::user()->getRoleNames()->first(), [VN_USER_PERMISSION, COUNSELLOR_PERMISSION])) $query = $query->where(Counselling::user_id, Auth::id());

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

        $query = $query->skip($request->start)->take($request->length)->orderByDesc(Counselling::counselling_services_id)->get();

        if ($query->count() > 0) {
            foreach ($query as $value) {

                $editLink = '<a href="' . route('outreach.counselling.edit', [$value[Counselling::counselling_services_id], 'sno' => urlencode($value[Profile::profile][Profile::unique_serial_number]), 'profile' => $value[Profile::profile_id]]) . '">✎ ' . $value[Profile::profile][Profile::unique_serial_number] . ' </a>';

                $statusID = $value->status;
                $status = isset(PROFILE_STATUS[$statusID]) ? PROFILE_STATUS[$statusID] : null;
                if (!empty($status)) $status = view('outreach.ajax.status', compact('statusID', 'status'))->render();

                $id = $value[Counselling::counselling_services_id];

                $select = view('outreach.ajax.select', compact('id', 'statusID'))->render();

                $data[] = array(
                    $select,
                    $editLink,
                    !empty($value->user) ? $value->user->name : null,
                    !empty($value->profile) ? $value->profile[Profile::uid] : null,
                    $status,
                    !empty($value[ClientType::client_type]) ? $value[ClientType::client_type][ClientType::client_type] : null,
                    isset(self::REFERRED_FROM[$value->referred_from]) ? self::REFERRED_FROM[$value->referred_from] : null,
                    $value->referral_source,
                    $value[Profile::profile][Profile::profile_name],
                    $value->date_of_counselling,
                    $value->phone_number,
                    isset(self::COUNSELLING_TYPE[intval($value->type_of_counselling_offered)]) ? self::COUNSELLING_TYPE[intval($value->type_of_counselling_offered)] : null,
                    $value->type_of_counselling_offered_other ? $value->type_of_counselling_offered_other : null,
                    isset(self::TYPE_OF_COUNSELLING[intval($value->counselling_medium)]) ? self::TYPE_OF_COUNSELLING[intval($value->counselling_medium)] : null,
                    $value->duration_of_counselling,
                    $value->key_concerns_discussed,
                    $value->follow_up_date,
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

    public function ImportCounselling(Request $request)
	{
        $request->file('efile')->storeAs('outreach/', $request->file('efile')->getClientOriginalName(), 'local');
        Artisan::call('db:seed --class=OutreachSeeder');
        
		flash('Imported successfully.')->success();
		return redirect('outreach/counselling')->with('message', 'Imported successfully.');
	}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $unique_serial_number = request()->query('sno');
        $profileID = request()->query('profile');
        $profile = Profile::select([Profile::profile_name, Profile::registration_date])->where(Profile::profile_id, $profileID)->first();
        $states = StateMaster::orderBy('state_name')->pluck('state_name', 'id');
        $exists = Counselling::where(Counselling::profile_id, $profileID)->exists();
        $exists = $exists ? 2 : 1;
        $genders = Gender::orderBy(Gender::gender_id)->get();
        $target = TargetPopulation::orderBy(TargetPopulation::target_id)->get();
        $client = ClientType::orderBy(ClientType::client_type_id)->get();
        
        return view('outreach.counselling.create')
            ->with('COUNSELLING_TYPE', self::COUNSELLING_TYPE)
            ->with('GENDERS', $genders)
            ->with('TARGET_POPULATION', $target)
            ->with('CLIENT_TYPE', $client)
            ->with('states', $states)
                ->with('REFERRED_FROM', self::REFERRED_FROM)
                ->with('TYPE_OF_COUNSELLING', self::TYPE_OF_COUNSELLING)
            ->with('profile', $profile)
            ->with('exists', $exists)
            ->with('profileID', $profileID)
                ->with('unique_serial_number', $unique_serial_number);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CounsellingRequest $request)
    {
        $request->merge([
            Counselling::user_id => Auth::id(),
            Counselling::created_at => currentDateTime()
        ]);

        $counselling = Counselling::create($request->all());

        $counselling->save();

        flash('Counselling service created successfully!')->success();
        return redirect()->route('outreach.counselling.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Counselling $outreach)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Counselling $counselling)
    {
        $unique_serial_number = request()->query('sno');
        $profileID = request()->query('profile');
        $profile = Profile::select(Profile::registration_date)->where(Profile::profile_id, $profileID)->first();
        $states = StateMaster::pluck('state_name', 'id');
        $districts = DistrictMaster::pluck('district_name', 'id');
        $exists = Counselling::where(Counselling::profile_id, $profileID)->exists();
        $exists = $exists ? 2 : 1;
        $canTakeAction = in_array(Auth::user()->getRoleNames()->first(), [SUPER_ADMIN, PO_PERMISSION]);
        $genders = Gender::orderBy(Gender::gender_id)->get();
        $target = TargetPopulation::orderBy(TargetPopulation::target_id)->get();
        $client = ClientType::orderBy(ClientType::client_type_id)->get();

        return view('outreach.counselling.create')
            ->with('COUNSELLING_TYPE', self::COUNSELLING_TYPE)
            ->with('GENDERS', $genders)
            ->with('TARGET_POPULATION', $target)
            ->with('CLIENT_TYPE', $client)
                ->with('states', $states)
                ->with('districts', $districts)
                ->with('REFERRED_FROM', self::REFERRED_FROM)
                ->with('TYPE_OF_COUNSELLING', self::TYPE_OF_COUNSELLING)
            ->with('canTakeAction', $canTakeAction)
            ->with('exists', $exists)
            ->with('profile', $profile)
            ->with('unique_serial_number', $unique_serial_number)
            ->with('profileID', $profileID)
                ->with('counselling', $counselling);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CounsellingRequest $request, Counselling $counselling)
    {
        $counselling->update($request->all());
        flash('Client Counselling updated successfully!')->success();
        return redirect()->route('outreach.counselling.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Counselling $outreach)
    {
        //
    }
}