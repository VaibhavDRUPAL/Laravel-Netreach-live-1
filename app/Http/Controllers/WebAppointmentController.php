<?php

namespace App\Http\Controllers;

use App\Models\BookAppinmentMaster;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\Outreach\ReferralService;
use DB;
use App\Models\StateMaster;
use App\Models\DistrictMaster;
use App\Models\ClientType;
use App\Models\EducationalAttainment;
use App\Models\Occupation;
use App\Models\Outreach\Profile;
use App\Models\Outreach\RiskAssessment;
use App\Models\ReasonForNotAccessingService;
use App\Models\ServiceType;
use App\Models\STIService;
use App\Models\TIService;

use Illuminate\Support\Facades\Auth;
class WebAppointmentController extends Controller
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
   
    public function index()
    {
        $unique_serial_number = urldecode(request()->query('sno'));
        $profileID = request()->query('profile');
        return view('web-appointment.index', ['unique_serial_number' => $unique_serial_number, 'profileID' => $profileID]);	

    }
    public function list()
    {
        $data = array();
        $request = request(); 


        $query = DB::table('book_appinment_master')
            ->select(
                'book_appinment_master.*',
                'surveys.user_id',
                'surveys.your_age',
                'surveys.identify_yourself',
                'surveys.identify_others',
                'surveys.sexually',
                'surveys.hiv_infection',
                'surveys.risk_level',
                'surveys.services_required',
                'customers.name as client_name',
                'customers.email as client_email',
                'customers.phone_number',
                'centre_master.name as center_name',
                'vm_master.name as vm_name',
                'vm_master.mobile_number as vm_phone',
                'district_master.state_code',
                'district_master.district_code',
                'state_master.st_cd as statecode',
                'state_master.state_name as statename',
                'district_master.district_name as districtname',
            )
            ->join('surveys', 'surveys.id', '=', 'book_appinment_master.survey_id')
            ->join('customers', 'customers.id', '=', 'book_appinment_master.user_id')
            ->join('centre_master', 'centre_master.id', '=', 'book_appinment_master.center_ids')
            ->join('district_master', 'district_master.id', '=', 'centre_master.district_id')
            ->join('state_master', 'state_master.id', '=', 'district_master.state_id')
            ->leftJoin('vm_master', 'vm_master.state_code', '=', 'district_master.state_code')
            ->orderBy('book_appinment_master.created_at');
        
        if (in_array( Auth::user()->getRoleNames()->first() , [CENTER_USER, CBO_PARTNER])) {
            $centre = DB::table('centre_master')->where('user_id', Auth::id())->first();
            if ($centre !== null) {
                $query = $query->where('center_ids', $centre->id);
            } else {
                $query = $query->where('center_ids', '==', '-1');
            }
        }
        if ($request->filled('search')) {
            $query = $query->where('customers.name', 'like', '%' . $request->search . '%');
        }
        
        $total = $query->count();
        $query = $query->skip($request->start)->take($request->length);

        $query = $query->get();
        $data = array();
        if ($query->count() > 0) {
            foreach ($query as $value) {
                $id = $value->id;
                $statusID = true;

                $editLink = '<a href="' . route('web-center-appointments.edit', $id) . '">✎ ' . $value->e_referral_no . ' </a>';


                $select = view('outreach.ajax.select', compact('id', 'statusID'))->render();
                $services = null;

                $statusID = $value->status;
                $status = isset(PROFILE_STATUS[$statusID]) ? PROFILE_STATUS[$statusID] : null;
                if (!empty($status)) $status = view('outreach.ajax.status', compact('statusID', 'status'))->render();

                $serviceArray = json_decode($value->services_required, true);
                foreach($serviceArray as $service){
                    $services = ServiceType::find($service)->service_type . ', ' . $services;
                }
                $services = rtrim($services, ', ');
                $data[] = array(
                    // $select,
                    $editLink,
                    $value->client_name,
                    !empty($value->services_required) ? $services : null,
                    $value->vm_name,
                    $value->center_name,

                    $value->statename,
                    $value->districtname,
                    $value->risk_level,
                    $value->your_age,

                    json_decode($value->sexually)[0],
                    $value->appoint_date,
                    $status,
                    !empty($value->client_type_id) ? ClientType::find($value->client_type_id)->client_type : null,
                    !empty($value->educational_attainment_id)? EducationalAttainment::find($value->educational_attainment_id)->educational_attainment: null,
                    !empty($value->occupation_id) ? Occupation::find($value->occupation_id)->occupation : null,
                    !empty($value->service_type_id) ? ServiceType::find($value->service_type_id)->service_type : null,
                    

                    isset(self::CHOICES[$value->counselling_service]) ? self::CHOICES[$value->counselling_service] : null,
                    isset(self::PREVENTION_PROGRAMME[$value->prevention_programme]) ? self::PREVENTION_PROGRAMME[$value->prevention_programme] : null,

                    // !empty($value->service_accessed_center) ? $value->service_accessed_center->name : null,
                    $value->date_of_accessing_service,
                    // isset(self::TYPE_HIV_TEST[$value->applicable_for_hiv_test]) ? self::TYPE_HIV_TEST[$value->applicable_for_hiv_test] : null,
                    // !empty($value->sti_service_id) ? STIService::find($value->sti_service_id)->service_type : null,

                    $value->pid_or_other_unique_id_of_the_service_center,
                    isset(self::OUTCOME[$value->outcome_of_the_service_sought]) ? self::OUTCOME[$value->outcome_of_the_service_sought] : null,
                    !empty($value->reason_id) ? ReasonForNotAccessingService::find($value->reason_id)->reason : null,
                    $value->other_not_access,
                    // $value->follow_up_date,
                    // $value->remarks
                    
                );
            }
        }


        $json_data = array(
            "draw"            => intval($request->draw),
            "recordsTotal"    => $total,
            "recordsFiltered" => $total,
            "data"            => $data,   // total data array
        );

        echo json_encode($json_data);  // send data as json format			
        exit;
    }

    public function update(Request $request, BookAppinmentMaster $appointment)
    {
        $requestData = $request->all();

        $updatedData = [
            'client_type_id' => $requestData['client_type_id'],
            'educational_attainment_id' => $requestData['educational_attainment_id'],
            'access_service' => $requestData['access_service'],
            'occupation_id' => $requestData['occupation_id'],
            'ti_service_id' => $requestData['ti_service_id'],
            'service_type_id' => $requestData['service_type_id'],
            'counselling_service' => $requestData['counselling_service'],
            'prevention_programme' => $requestData['prevention_programme'],
            'date_of_accessing_service' => $requestData['date_of_accessing_service'],
            'applicable_for_hiv_test' => $requestData['applicable_for_hiv_test'],
            'sti_service_id' => $requestData['sti_service_id'],
            'pid_or_other_unique_id_of_the_service_center' => $requestData['pid_or_other_unique_id_of_the_service_center'],
            'outcome_of_the_service_sought' => $requestData['outcome_of_the_service_sought'],
            'reason_id' => $requestData['reason_id'],
        ];

    $appointment->update($updatedData);
        flash('Appointment updated successfully!')->success();
        return redirect()->route('web-center-appointments');
    }

    public function edit(BookAppinmentMaster $appointment)
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
        $profile = Profile::select(Profile::profile_name)->where(Profile::profile_id, $profileID)->first();

        return view('web-appointment.edit')
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
        ->with('profileID', $profileID)
        ->with('appointment', $appointment);
    }
}
