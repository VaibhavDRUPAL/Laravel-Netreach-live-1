<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Gender;
use App\Models\Outreach\ReferralService;
use App\Models\NetreachPeer;
use App\Models\Platform;
use App\Models\TargetPopulation;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NetreachPeerController extends Controller
{


    const CHOICES = array(1 => "Yes", 2 => "No");
    const CLIENT_TYPE  = array(1 => "New client", 2 => "Follow up client", 3 => 'Repeat client', 4 => 'Repeat service/Retest', 5 => 'Confirmatory test');

    const TYPE_SERVICE = array(1 => 'HIV Testing', 2 => 'STI Services', 3 => 'PrEP', 4 => 'PEP', 5 => 'HIV and STI counselling', 6 => 'Referral for mental health counselling', 7 => 'ART linkages', 8 => 'Referral to TI for other services', 9 => 'OST', 10 => 'SRS', 11 => 'Social Entitlements', 13 => 'Gender Based Violence', 14 => 'Crisis cases', 15 => 'Referral to Care & Support centre', 16 => 'Referral to de-addiction centre', 17 => 'Referral for enrolling in Social Welfare schemes', 18 => 'Sexual & Reproductive Health', 19 => 'Social Protection Scheme', 20 => 'NACO Helpline (1097)', 99 => 'Others');
    const REFERRED_FOR_TI_SERVICE = array(1 => 'Drop-in Center (DIC)', 2 => 'Condom', 3 => 'Lubricant', 4 => 'Doctor consultation', 5 => 'Counseling', 6 => 'OST', 7 => 'Social Entitlements', 8 => 'Gender Based Violence', 9 => 'Crisis cases', 10 => 'Social Welfare schemes/Protection scheme', 11 => 'Other Sexual & Reproductive Health', 99 => 'Others');
    const PREVENTION_PROGRAMME = array(1 => 'TI', 2 => 'Other HIV prevention programme', 3 => 'No', 4 => 'Not availing service in TI since last 6 months');
    const TYPE_FACILITY = array(1 => 'Govt.', 2 => 'Private', 3 => 'NGO/CBO', 4 => 'TI');
    const TYPE_HIV_TEST = array(1 => 'Screening', 2 => 'Confirmatory');
    const TYPE_STI_SERVICE = array(1 => 'Syphillis(rpr/vdrl)', 2 => 'Others');
    const OUTCOME = array(1 => 'Reactive', 2 => 'Non-reactive', 3 => 'Not disclosed');
    const REASON_FOR_NOT_ACCESSING = array(1 => 'Covid issues', 2 => 'Testing center closed', 3 => 'Unable to reach on time', 4 => 'Inconvenient timings', 5 => 'Out of station', 6 => 'Lack of time', 7 => 'Fear of being positive', 8 => 'Unwell', 9 => 'Center staff behaviour', 10 => 'Testing kit unavailable', 11 => 'Centre is crowded', 12 => 'Weather issue', 13 => 'Lost contact with client', 14 => 'Centre is far away', 15 => 'Afraid of being noticed', 16 => 'Long waiting time', 17 => 'No update from client', 18 => 'Unable to locate centre', 19 => 'Expensive', 99 => 'Others');
    const EDUCATION = array(1 => 'No education', 2 => 'Primary (Class 1-5)', 3 => 'Secondary (Class 6-10)', 4 => 'Higher Secondary (Class 11-12)', 5 => 'Graduate', 6 => 'Post Graduate & above', 7 => 'Not disclosed');
    const OCCUPATION = array(1 => 'Govt. job', 2 => 'Private job', 3 => 'Self-employed', 4 => 'Daily Wage Labourer', 5 => 'Agricultural', 6 => 'Household work', 7 => 'Student', 8 => 'Pensioner', 9 => 'Sex work', 10 => 'Begging', 11 => 'Badhai', 12 => 'Unemployed', 98 => 'Not Disclosed', 99 => 'Others (Specify)');


    const Gender  = array(1 => "Male", 2 => "Female", 3 => 'TG', 4 => 'Not disclosed', 5 => 'Other');
    const Type_of_Target_Population  = array(1 => "MSM", 2 => "FSW", 3 => 'MSW', 4 => 'TG', 5 => 'PWID', 6 => 'Adolescents and Youths (18-24)', 7 => 'Men and Women with High risk behavior accessing virtual platforms (above 24 yrs)', 8 => 'Other');


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //dd(auth()->user()->getRoleNames());
        $vms_details_ids = Auth::user();

        if ($vms_details_ids->center) {
            $center_query =  DB::table('centre_master')->where('id', $vms_details_ids->center)->first();
            if ($center_query) {
                $query =  DB::table('outreach_referral_service')->where('user_id', $vms_details_ids->id)->get();
            }
        } else {
            $query =  DB::table('outreach_referral_service')->get();
        }

        return view('Netreach-Peer.index', ['results' => $query]);
    }

    /**
     * Return a JSON listing of the resource.
     */
    public function list(Request $request)
    {
        $data = array();

        $query =  DB::table('netreach_peers');
        //$query =  DB::table('outreach_referral_service');netreach_peer_Code
        if ($request->has('search')) {
            $query = $query->where('netreach_peer_Code', 'like', '%' . $request->search . '%');
        }
        if (in_array( Auth::user()->getRoleNames()->first() , [NETREACH_PEER])) {
            $query = $query->where('created_by', Auth::user()->id);
        }

        $query = $query->skip($request->start)->take($request->length)->get();

        if ($query->count() > 0) {
            foreach ($query as $value) {

                // $client_type = ($value->client_type == 1) ? "New Client" : "Follow up client";
                // $netreach_peer_Code = $value->netreach_peer_Code;
                $actionData =  '<a href="' . route('Netreach-Peer.edit', $value->id) . '" class="px-1"><i class="fas text-primary fa-edit"></i></a><a href="' . route('Netreach-Peer.destroy', $value->id) . '" class="px-1"><i class="fas text-danger fa-trash"></i></a>';
                $platformName = optional(Platform::find($value->name_of_appplatform_client))->name;
                $genderName = optional(Gender::find($value->gender))->gender;
                $targetPopulationType = optional(TargetPopulation::find($value->type_of_target_population))->target_type;
                
                $data[] = array(

                    $value->netreach_peer_Code,
                    // $value->netreach_uid_number,
                    // $value->netreach_peer_Code,
                    $value->date_of_outreach,
                    $value->location_of_client,
                    $platformName,
                    $value->name_of_client,
                    $value->clients_Age,
                    $genderName,
                    $targetPopulationType,
                    $value->phone_number,
                    $actionData
                );
            }
        }

        $query =  DB::table('netreach_peers')->get();

        $json_data = array(
            "draw"            => intval($request->draw),
            "recordsTotal"    => intval($query->count()),
            "recordsFiltered" => intval($query->count()),
            "data"            => $data   // total data array
        );

        echo json_encode($json_data);  // send data as json format			
        exit;
    }


    /**
     * Show the form for creating a new resource.
     */
    public function getNetreachPeerCode() {
        $digits = 10;
        $uniqueId = time() . rand(pow(10, $digits - 1), pow(10, $digits) - 1);
        $results = NetreachPeer::where(["netreach_peer_Code" => $uniqueId])->get();
    
        if ($results->count() > 0) {
            return self::getNetreachPeerCode();
        } else {
            return $uniqueId;
        }
    }
    
    public function create()
    {
        // print_r('ncccc');
        // die;

        $unique_serial_number = request()->query('sno');
        $netreach_peer_Code = $this->getNetreachPeerCode();
        $apps = Platform::orderBy('name', 'asc')->pluck('name', 'id');
        $gender = Gender::orderBy('gender','asc')->pluck('gender', 'gender_id');
        $netreach_peer = new NetreachPeer();
        $type_of_Target_Population = TargetPopulation::orderBy('target_type','asc')->pluck('target_type', 'target_id');
        // $states = StateMaster::all();
        // $states = $states?->pluck('state_code')->combine($states?->pluck('state_name'));
        // $districts = DistrictMaster::pluck('district_name');

        return view('Netreach-Peer.create')
            ->with('netreach_peer',$netreach_peer)
            ->with('Gender', $gender)
            ->with('Type_of_Target_Population', $type_of_Target_Population)
            ->with('unique_serial_number', $unique_serial_number)
            ->with('netreach_peer_Code', $netreach_peer_Code)
            ->with('APPS', $apps);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $clientData = $request->all();
        // $clientData['unique_serial_number'] = "VN12345";
        // $clientData['uid'] = "UUID12345";
        // $clientData['netreach_uid_number'] = "NETREACH1234";
        $clientData['created_by'] = Auth::id();
        $user = NetreachPeer::create($clientData);

        flash('Netreach Peer created successfully!')->success();
        return redirect()->route('Netreach-Peer');
    }

    /**
     * Display the specified resource. 
     */
    public function show(ReferralService $outreach_referral_service)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NetreachPeer $netreach_peer)
    {
        $vms_details_ids = Auth::user();
        $unique_serial_number = request()->query('sno');
        $netreach_peer_Code = $netreach_peer->netreach_peer_Code;
        //sort by name
        // $apps = Platform::pluck('name', 'id');
        $apps = Platform::orderBy('name', 'asc')->pluck('name', 'id');
        // $gender = Gender::pluck('gender', 'gender_id');
        $gender = Gender::orderBy('gender','asc')->pluck('gender', 'gender_id');

        //$states = StateMaster::pluck('state_name', 'id');
        //$districts = DistrictMaster::pluck('district_name', 'id');
        return view('Netreach-Peer.create')
        ->with('netreach_peer', $netreach_peer)
        ->with('Gender', $gender)
        ->with('Type_of_Target_Population', self::Type_of_Target_Population)
        ->with('unique_serial_number', $unique_serial_number)
        ->with('netreach_peer_Code', $netreach_peer_Code)
        ->with('APPS', $apps);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, NetreachPeer $netreach_peer)
    {
            //  echo '<pre>';
            // print_r($netreach_peer);
            // die;

        $request->validate([
            'serial_number_of_client' => 'required',
            'date_of_outreach' => 'required',
            'location_of_client' => 'required',
            'name_of_appplatform_client' => 'required',
            'name_of_client' => 'required',
            'clients_age' => 'required',
            'gender' => 'required',
            'type_of_target_population' => 'required',
            'phone_number' => 'required',
        ]);

        $clientData = $request->all();
        // $clientData['unique_serial_number'] = "VN12345";
        // $clientData['uid'] = "UUID12345";
        // $clientData['netreach_uid_number'] = "NETREACH1234";

        $netreach_peer->update($clientData);
        flash('Netreach Peer updated successfully!')->success();
        return redirect()->route('Netreach-Peer');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( NetreachPeer $netreach_peer)
    {
        $netreach_peer->delete();
        flash('Netreach Peer deleted successfully!')->success();
        return redirect()->route('Netreach-Peer');
    }
}