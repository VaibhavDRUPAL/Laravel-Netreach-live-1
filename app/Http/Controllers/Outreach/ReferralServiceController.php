<?php

namespace App\Http\Controllers\Outreach;

use App\Http\Controllers\Controller;
use App\Models\CentreMaster;
use App\Models\Outreach\ReferralService;
use App\Models\SelfModule\Appointments;
use Illuminate\Http\Request;
use App\Models\StateMaster;
use App\Models\DistrictMaster;
use App\Http\Requests\Outreach\ReferralServiceRequest;
use App\Models\ClientType;
use App\Models\EducationalAttainment;
use App\Models\Occupation;
use App\Models\Outreach\Profile;
use App\Models\Outreach\RiskAssessment;
use App\Models\ReasonForNotAccessingService;
use App\Models\ServiceType;
use App\Models\STIService;
use App\Models\TIService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\TargetPopulation;
use App\Models\User;
use App\Exports\OutreachReferralExport;
use App\Models\Counter;
use App\Models\VmMaster;
use Illuminate\Support\Facades\{App, Storage, Config};
use PDF;

class ReferralServiceController extends Controller
{
    const CHOICES = array(1 => "Yes", 2 => "No");
    const CLIENT_TYPE = array(1 => "New client", 2 => "Follow up client", 3 => 'Repeat client', 4 => 'Repeat service/Retest', 5 => 'Confirmatory test');

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
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $unique_serial_number = urldecode(request()->query('sno'));
        $profileID = request()->query('profile');
        return view('outreach.referral-service.index', ['unique_serial_number' => $unique_serial_number, 'profileID' => $profileID]);
    }
    public function assign(Request $request)
    {
        ReferralService::whereIn('id', $request->input('data'))->update(['status' => 1]);
        return true;
    }
    public function takeAction(Request $request)
    {
        ReferralService::whereIn('id', $request->input('data'))->update(['status' => $request->input('status')]);
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
                ->where(ReferralService::user_id, Auth::id())
                ->get();
        } else {
            $data = ReferralService::where('is_active', true)->get();
        }
        $referralData = collect()->make();
        $count = 1;
        foreach ($data as $value) {
            $referralData->push([
                'sr_no' => $count++,
                'unique_serial_no' => Profile::getUniqueSerialNoById($value->profile_id),
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
        return new OutreachReferralExport($referralData->all());
    }

    /**
     * Return a JSON listing of the resource.
     */
    public function list(Request $request)
    {
        $data = array();

        $vms_details_ids = Auth::user();

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
            ->where(ReferralService::is_active, true);

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

        if ($query->count() > 0) {
            foreach ($query as $value) {
                $id = $value[ReferralService::referral_service_id];
                $media = $value[ReferralService::media_path];
                // $media = "";
                $evidence = $value[ReferralService::evidence_path];
                $evidence2 = $value[ReferralService::evidence_path_2];
                $evidence3 = $value[ReferralService::evidence_path_3];
                $evidence4 = $value[ReferralService::evidence_path_4];
                $evidence5 = $value[ReferralService::evidence_path_5];
                $editLink = '<a href="' . route('outreach.referral-service.edit', [$id, 'sno' => urlencode($value[Profile::profile][Profile::unique_serial_number]), 'profile' => $value[Profile::profile_id]]) . '">✎ ' . $value[Profile::profile][Profile::unique_serial_number] . ' </a>';

                $statusID = $value->status;
                $status = isset(PROFILE_STATUS[$statusID]) ? PROFILE_STATUS[$statusID] : null;
                if (!empty($status))
                    $status = view('outreach.ajax.status', compact('statusID', 'status'))->render();

                $select = view('outreach.ajax.select', compact('id', 'statusID'))->render();
                $data[] = array(
                    $select,
                    $editLink,
                    // $value[Profile::profile][Profile::unique_serial_number],
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
                    isset(self::OUTCOME[$value->outcome_of_the_service_sought]) ? self::OUTCOME[$value->outcome_of_the_service_sought] : null,
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

        $json_data = array(
            "draw" => intval($request->draw),
            "recordsTotal" => $total,
            "recordsFiltered" => $total,
            "data" => $data   // total data array
        );

        echo json_encode($json_data);  // send data as json format			
        exit;
    }

    public function ImportReferralService(Request $request)
    {
        $request->file('efile')->storeAs('outreach/', $request->file('efile')->getClientOriginalName(), 'local');
        Artisan::call('db:seed --class=OutreachSeeder');

        flash('Imported successfully.')->success();
        return redirect('outreach/referral-service')->with('message', 'Imported successfully.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $unique_serial_number = request()->query('sno');
        $profileID = request()->query('profile');
        $states = StateMaster::orderBy('state_name')->pluck('state_name', 'id');
        $districts = DistrictMaster::pluck('district_name');
        $riskAssessment = RiskAssessment::select(RiskAssessment::date_of_risk_assessment)->where(RiskAssessment::profile_id, $profileID)->orderByDesc(RiskAssessment::risk_assesment_id)->first();
        $exists = ReferralService::where(ReferralService::profile_id, $profileID)->exists();
        $exists = $exists ? 2 : 1;
        $client = ClientType::orderBy(ClientType::client_type_id)->get();
        $servicetypes = ServiceType::orderBy(ServiceType::service_type_id)->get();
        $tiservices = TIService::orderBy(TIService::ti_service_id)->get();
        $stiservices = STIService::orderBy(STIService::sti_service_id)->get();
        $reasons = ReasonForNotAccessingService::orderBy(ReasonForNotAccessingService::reason_id)->get();
        $education = EducationalAttainment::orderBy(EducationalAttainment::educational_attainment_id)->get();
        $occupation = Occupation::orderBy(Occupation::occupation_id)->get();
        $profile = Profile::select([Profile::profile_name, Profile::registration_date])->where(Profile::profile_id, $profileID)->first();
        $target = TargetPopulation::orderBy(TargetPopulation::target_id)->get();

        return view('outreach.referral-service.create')
            ->with('CLIENT_TYPE', $client)
            ->with('TYPE_SERVICE', $servicetypes)
            ->with('REFERRED_FOR_TI_SERVICE', $tiservices)
            ->with('PREVENTION_PROGRAMME', self::PREVENTION_PROGRAMME)
            ->with('TYPE_FACILITY', self::TYPE_FACILITY)
            ->with('states', $states)
            ->with('districts', $districts)
            ->with('TYPE_HIV_TEST', self::TYPE_HIV_TEST)
            ->with('TYPE_STI_SERVICE', $stiservices)
            ->with('OUTCOME', self::OUTCOME)
            ->with('REASON_FOR_NOT_ACCESSING', self::REASON_FOR_NOT_ACCESSING)
            ->with('EDUCATION', $education)
            ->with('OCCUPATION', $occupation)
            ->with('CHOICES', self::CHOICES)
            ->with('exists', $exists)
            ->with('TARGET_POPULATION', $target)
            ->with('riskAssessment', $riskAssessment)
            ->with('profile', $profile)
            ->with('profileID', $profileID)
            ->with('unique_serial_number', $unique_serial_number);
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $isLocal = App::environment('local');
        // Validate referral_date not earlier than profile registration_date
        $profile = Profile::where('profile_id', $request->profile_id)->first();

        $request->validate([
            'referral_date' => [
                'required',
                'date',
                function ($attribute, $value, $fail) use ($profile) {
                    if ($profile && $value < $profile->registration_date) {
                        $fail('The referral date cannot be earlier than the registration date (' . $profile->registration_date . ').');
                    }
                },
            ],
        ]);

        // Merge user_id and created_at before saving
        $request->merge([
            ReferralService::user_id => Auth::id(),
            ReferralService::created_at => now(),
        ]);

        // Create a new referral service entry
        $referral = ReferralService::create($request->all());


        $vncode = Auth::user()->user_type == 2 ? VmMaster::where("id", $request->user()->vms_details_ids)->pluck("vncode")->first() : 'ADMIN';
        $vnName = VmMaster::where("vncode", $vncode)->pluck("name")->first();
        $vnmobile = VmMaster::where("vncode", $vncode)->pluck("mobile_number")->first();
        $state_id = Profile::where('profile_id', $request->profile_id)->pluck('state_id');
        $state_code = StateMaster::where('id', $state_id)->first()->st_cd;
        $counter = Counter::pluck('appointmentCounter')->first();
        $newCounter = $counter + 1;
        $referral->netreach_uid_number = 'NETREACH/' . $state_code . '/' . $vncode . '/' . $newCounter;
        $service = isset($request->service_type_id) && ($request->service_type_id != 99) ? ReferralServiceController::TYPE_SERVICE[$request->service_type_id] : $request->other_service_type;
        $referral_center_id = CentreMaster::getOneCentreName($request->referral_center_id);
        $referralNo = Carbon::now()->format('dmYHis');



        // ---------------------------e-referral slip pdf generation and saving-----------------
        $pdfData = [
            Appointments::full_name => $request->client_name,
            Appointments::services => $service,
            Appointments::uid => $referral->netreach_uid_number,
            Appointments::referral_no => $referralNo,
            Appointments::appointment_date => $request->referral_date,
            'today' => Carbon::now()->format('Y-m-d'),
            'center' => $referral_center_id,
            'vnname' => $vnName,
            'vnmobile' => $vnmobile,
        ];
        $filename = Carbon::now()->timestamp . '.pdf';
        $path = 'pdf/outreach/' . $filename;

        if (!$isLocal) {

            $pdf = PDF::loadView('pdf.self-document', compact('pdfData'));
            $pdfPath = 'app/public/' . $path;
            $file_url = Storage::disk('public')->url($path);
            $pdf->save(storage_path($pdfPath));
            $referral->media_path = $path;
        }
        $request->merge([
            ReferralService::media_path => isset($path) ? $path : Config::get('app.url')
        ]);

        $request->merge($pdfData);
        // ---------------------------e-referral slip pdf generation and saving ends-----------------


        $referral->save();
        Counter::query()->update(['appointmentCounter' => $newCounter]);

        // Check if file exists

        if ($request->hasFile(ReferralService::evidence_path)) {

            $file = $request->file(ReferralService::evidence_path);
            // Store file and get the path
            $evidence_path = mediaOperations(
                EVIDENCE_PATH,
                $file,
                FL_CREATE,
                MDT_STORAGE,
                STD_PUBLIC,
                getFileName() . '.' . $file->getClientOriginalExtension()
            );


            // Update the referral record with the file path
            $referral->update([
                ReferralService::evidence_path => $evidence_path,
            ]);
        }
        if ($request->hasFile(ReferralService::evidence_path_2)) {

            $file = $request->file(ReferralService::evidence_path_2);

            $evidence_path = mediaOperations(
                EVIDENCE_PATH,
                $file,
                FL_CREATE,
                MDT_STORAGE,
                STD_PUBLIC,
                getFileName() . '.' . $file->getClientOriginalExtension()
            );


            // Update the referral record with the file path
            $referral->update([
                ReferralService::evidence_path_2 => $evidence_path,
            ]);
        }
        if ($request->hasFile(ReferralService::evidence_path_3)) {

            $file = $request->file(ReferralService::evidence_path_3);

            $evidence_path = mediaOperations(
                EVIDENCE_PATH,
                $file,
                FL_CREATE,
                MDT_STORAGE,
                STD_PUBLIC,
                getFileName() . '.' . $file->getClientOriginalExtension()
            );


            // Update the referral record with the file path
            $referral->update([
                ReferralService::evidence_path_3 => $evidence_path,
            ]);
        }
        if ($request->hasFile(ReferralService::evidence_path_4)) {

            $file = $request->file(ReferralService::evidence_path_4);

            $evidence_path = mediaOperations(
                EVIDENCE_PATH,
                $file,
                FL_CREATE,
                MDT_STORAGE,
                STD_PUBLIC,
                getFileName() . '.' . $file->getClientOriginalExtension()
            );


            // Update the referral record with the file path
            $referral->update([
                ReferralService::evidence_path_4 => $evidence_path,
            ]);
        }
        if ($request->hasFile(ReferralService::evidence_path_5)) {

            $file = $request->file(ReferralService::evidence_path_5);

            $evidence_path = mediaOperations(
                EVIDENCE_PATH,
                $file,
                FL_CREATE,
                MDT_STORAGE,
                STD_PUBLIC,
                getFileName() . '.' . $file->getClientOriginalExtension()
            );


            // Update the referral record with the file path
            $referral->update([
                ReferralService::evidence_path_5 => $evidence_path,
            ]);
        }

        flash('Referral created successfully!')->success();
        return redirect()->route('outreach.referral-service.index');
    }


    // public function store(Request $request)
    // {
    //     $request->merge([
    //         ReferralService::user_id => Auth::id(),
    //         ReferralService::created_at => currentDateTime()
    //     ]);
    //     // ReferralService::create($request->all());
    //     $referral = ReferralService::create($request->all());
    //     $lastInsertedId = $referral->id;


    //     if ($request->hasFile(ReferralService::evidence_path)){

    //         $evidence_path = mediaOperations(EVIDENCE_PATH, $request->file(ReferralService::evidence_path), FL_CREATE, MDT_STORAGE, STD_PUBLIC, getFileName() . DOT . $request->file(ReferralService::evidence_path)->getClientOriginalExtension());

    //     }


    //     flash('Referral created successfully!')->success();
    //     return redirect()->route('outreach.referral-service.index');
    // }

    /**
     * Display the specified resource.
     */
    public function show(ReferralService $referral_service)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ReferralService $referral_service)
    {
        $unique_serial_number = request()->query('sno');
        $profileID = request()->query('profile');
        $exists = ReferralService::where(ReferralService::profile_id, $profileID)->exists();
        $exists = $exists ? 2 : 1;
        $canTakeAction = in_array(Auth::user()->getRoleNames()->first(), [SUPER_ADMIN, PO_PERMISSION]);
        $riskAssessment = RiskAssessment::select(RiskAssessment::date_of_risk_assessment)->where(RiskAssessment::profile_id, $profileID)->first();
        $vms_details_ids = Auth::user();
        $states = StateMaster::orderBy('state_name')->pluck('state_name', 'id');
        $districts = DistrictMaster::pluck('district_name', 'id');
        $client = ClientType::orderBy(ClientType::client_type_id)->get();
        $servicetypes = ServiceType::orderBy(ServiceType::service_type_id)->get();
        $tiservices = TIService::orderBy(TIService::ti_service_id)->get();
        $stiservices = STIService::orderBy(STIService::sti_service_id)->get();
        $reasons = ReasonForNotAccessingService::orderBy(ReasonForNotAccessingService::reason_id)->get();
        $education = EducationalAttainment::orderBy(EducationalAttainment::educational_attainment_id)->get();
        $occupation = Occupation::orderBy(Occupation::occupation_id)->get();
        $profile = Profile::where(Profile::profile_id, $profileID)->first();
        // $referral_service = ReferralService::where(ReferralService::profile_id, $profileID)->first();
        $target = TargetPopulation::orderBy(TargetPopulation::target_id)->get();

        return view('outreach.referral-service.create')
            ->with('unique_serial_number', $referral_service->unique_serial_number)
            ->with('referral_service', $referral_service)
            ->with('CLIENT_TYPE', $client)
            ->with('TYPE_SERVICE', $servicetypes)
            ->with('REFERRED_FOR_TI_SERVICE', $tiservices)
            ->with('PREVENTION_PROGRAMME', self::PREVENTION_PROGRAMME)
            ->with('TYPE_FACILITY', self::TYPE_FACILITY)
            ->with('states', $states)
            ->with('districts', $districts)
            ->with('TYPE_HIV_TEST', self::TYPE_HIV_TEST)
            ->with('TYPE_STI_SERVICE', $stiservices)
            ->with('OUTCOME', self::OUTCOME)
            ->with('REASON_FOR_NOT_ACCESSING', $reasons)
            ->with('EDUCATION', $education)
            ->with('OCCUPATION', $occupation)
            ->with('CHOICES', self::CHOICES)
            ->with('center', $vms_details_ids->center)
            ->with('canTakeAction', $canTakeAction)
            ->with('exists', $exists)
            ->with('unique_serial_number', $unique_serial_number)
            ->with('riskAssessment', $riskAssessment)
            ->with('profile', $profile)
            ->with('TARGET_POPULATION', $target)
            ->with('profileID', $profileID)
            ->with('referral_service', $referral_service);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ReferralService $referral_service)
    {
        // Update the non-file fields first
        $referral_service->update($request->except([
            ReferralService::evidence_path,
            ReferralService::evidence_path_2,
            ReferralService::evidence_path_3,
            ReferralService::evidence_path_4,
            ReferralService::evidence_path_5,
        ]));

        if ($request->hasFile(ReferralService::evidence_path)) {

            $file = $request->file(ReferralService::evidence_path);
            // Store file and get the path
            $evidence_path = mediaOperations(
                EVIDENCE_PATH,
                $file,
                FL_CREATE,
                MDT_STORAGE,
                STD_PUBLIC,
                getFileName() . '.' . $file->getClientOriginalExtension()
            );


            // Update the referral record with the file path
            $referral_service->update([
                ReferralService::evidence_path => $evidence_path,
            ]);
        }
        if ($request->hasFile(ReferralService::evidence_path_2)) {

            $file = $request->file(ReferralService::evidence_path_2);

            $evidence_path = mediaOperations(
                EVIDENCE_PATH,
                $file,
                FL_CREATE,
                MDT_STORAGE,
                STD_PUBLIC,
                getFileName() . '.' . $file->getClientOriginalExtension()
            );


            // Update the referral record with the file path
            $referral_service->update([
                ReferralService::evidence_path_2 => $evidence_path,
            ]);
        }
        if ($request->hasFile(ReferralService::evidence_path_3)) {
            $file = $request->file(ReferralService::evidence_path_3);

            $evidence_path = mediaOperations(
                EVIDENCE_PATH,
                $file,
                FL_CREATE,
                MDT_STORAGE,
                STD_PUBLIC,
                getFileName() . '.' . $file->getClientOriginalExtension()
            );


            // Update the referral record with the file path
            $referral_service->update([
                ReferralService::evidence_path_3 => $evidence_path,
            ]);
        }
        if ($request->hasFile(ReferralService::evidence_path_4)) {

            $file = $request->file(ReferralService::evidence_path_4);

            $evidence_path = mediaOperations(
                EVIDENCE_PATH,
                $file,
                FL_CREATE,
                MDT_STORAGE,
                STD_PUBLIC,
                getFileName() . '.' . $file->getClientOriginalExtension()
            );


            // Update the referral record with the file path
            $referral_service->update([
                ReferralService::evidence_path_4 => $evidence_path,
            ]);
        }
        if ($request->hasFile(ReferralService::evidence_path_5)) {

            $file = $request->file(ReferralService::evidence_path_5);

            $evidence_path = mediaOperations(
                EVIDENCE_PATH,
                $file,
                FL_CREATE,
                MDT_STORAGE,
                STD_PUBLIC,
                getFileName() . '.' . $file->getClientOriginalExtension()
            );


            // Update the referral record with the file path
            $referral_service->update([
                ReferralService::evidence_path_5 => $evidence_path,
            ]);
        }

        flash('Referral updated successfully!')->success();
        return redirect()->route('outreach.referral-service.index', ['profile' => $request->input(ReferralService::profile_id)]);
    }




    // public function update(Request $request, ReferralService $referral_service)
    // {
    //     $referral_service->update($request->all());
    //     flash('Referral updated successfully!')->success();
    //     return redirect()->route('outreach.referral-service.index', ['profile' => $request->input(ReferralService::profile_id)]);
    // }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ReferralService $referral_service)
    {
        //
    }
}
