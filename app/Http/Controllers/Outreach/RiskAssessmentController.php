<?php

namespace App\Http\Controllers\Outreach;

use App\Http\Controllers\Controller;
use App\Models\Outreach\RiskAssessment;
use Illuminate\Http\Request;
use App\Http\Requests\Outreach\RiskAssessmentRequest;
use App\Models\ClientType;
use App\Models\Outreach\Profile;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RiskAssessmentController extends Controller
{
    const CHOICES = array(1 => "Yes", 2 => "No", 3 => "Prefer not to say", 4 => "Question did not ask");

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $unique_serial_number = urldecode(request()->query('sno'));
        $profileID = request()->query('profile');
        $sra_key = Auth::user()->name;
        $sra_key = str_replace(" ", "-", $sra_key);
        $sra_key = strtolower($sra_key);
        $selflink = route('self.sra', ['key' => $sra_key]);

        return view('outreach.risk-assessment.index', ['unique_serial_number' => $unique_serial_number, 'profileID' => $profileID, 'selflink' => $selflink]);
    }
    public function assign(Request $request)
    {
        RiskAssessment::whereIn('id', $request->input('data'))->update(['status' => 1]);
        return true;
    }
    public function takeAction(Request $request)
    {
        RiskAssessment::whereIn('id', $request->input('data'))->update(['status' => $request->input('status')]);
        return true;
    }

    /**
     * Return a JSON listing of the resource.
     */
    public function list(Request $request)
    {
        $data = array();

        $query =  RiskAssessment::with(['user', 'profile'])->where(RiskAssessment::is_deleted, false);

        if ($request->filled(Profile::profile_id)) $query = $query->where(RiskAssessment::profile_id, $request->integer(Profile::profile_id));

        if (in_array(Auth::user()->getRoleNames()->first(), [VN_USER_PERMISSION, COUNSELLOR_PERMISSION])) $query = $query->where(RiskAssessment::user_id, Auth::id());

        if ($request->filled('search')) {
            $query = $query->whereHas('profile', function ($query) use ($request) {
                return $query->where(Profile::unique_serial_number, 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled(Profile::unique_serial_number)) {
            $query = $query->whereHas('profile', function ($query) use ($request) {
                $search = strtolower($request->search);
                return $query->where(DB::raw('lower(' . Profile::unique_serial_number . ')'), 'like', '%' . $search . '%')
                    ->orWhere(DB::raw('lower(' . Profile::profile_name . ')'), 'like', '%' . $search . '%')
                    ->orWhere(Profile::phone_number, 'like', '%' . $search . '%');
            });
        }

        $total = $query->count();

        $query = $query->skip($request->start)->take($request->length)->orderByDesc(RiskAssessment::risk_assesment_id)->get();

        if ($query->count() > 0) {
            foreach ($query as $value) {

                $editLink = '<a href="' . route('outreach.risk-assessment.edit', [$value[RiskAssessment::risk_assesment_id], 'sno' => urlencode($value[Profile::profile][Profile::unique_serial_number]), 'profile' => $value[Profile::profile_id]]) . '">✎ ' . $value[Profile::profile][Profile::unique_serial_number] . ' </a>';

                $statusID = $value->status;
                $status = isset(PROFILE_STATUS[$statusID]) ? PROFILE_STATUS[$statusID] : null;
                if (!empty($status)) $status = view('outreach.ajax.status', compact('statusID', 'status'))->render();

                $id = $value[RiskAssessment::risk_assesment_id];

                $select = view('outreach.ajax.select', compact('id', 'statusID'))->render();

                $data[] = array(
                    $select,
                    $editLink,
                    !empty($value->user) ? $value->user->name : null,
                    $status,
                    !empty($value[ClientType::client_type]) ? $value[ClientType::client_type][ClientType::client_type] : null,
                    $value->date_of_risk_assessment,
                    isset(self::CHOICES[$value->had_sex_without_a_condom]) ? self::CHOICES[$value->had_sex_without_a_condom] : null,
                    isset(self::CHOICES[$value->shared_needle_for_injecting_drugs]) ? self::CHOICES[$value->shared_needle_for_injecting_drugs] : null,
                    isset(self::CHOICES[$value->sexually_transmitted_infection]) ? self::CHOICES[$value->sexually_transmitted_infection] : null,
                    isset(self::CHOICES[$value->sex_with_more_than_one_partners]) ? self::CHOICES[$value->sex_with_more_than_one_partners] : null,
                    isset(self::CHOICES[$value->had_chemical_stimulantion_or_alcohol_before_sex]) ? self::CHOICES[$value->had_chemical_stimulantion_or_alcohol_before_sex] : null,
                    isset(self::CHOICES[$value->had_sex_in_exchange_of_goods_or_money]) ? self::CHOICES[$value->had_sex_in_exchange_of_goods_or_money] : null,
                    $value->other_reason_for_hiv_test,
                    $value->risk_category
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

    public function ImportRiskAssesment(Request $request)
    {
        $request->file('efile')->storeAs('outreach/', $request->file('efile')->getClientOriginalName(), 'local');
        Artisan::call('db:seed --class=OutreachSeeder');

        flash('Imported successfully.')->success();
        return redirect('outreach/risk-assessment')->with('message', 'Imported successfully.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $unique_serial_number = request()->query('sno');
        $profileID = request()->query('profile');
        $profile = Profile::select(Profile::registration_date)->where(Profile::profile_id, $profileID)->first();
        $exists = RiskAssessment::where(RiskAssessment::profile_id, $profileID)->exists();
        $exists = $exists ? 2 : 1;
        $client = ClientType::orderBy(ClientType::client_type_id)->get();

        return view('outreach.risk-assessment.create')
            ->with('CLIENT_TYPE', $client)
            ->with('CHOICES', self::CHOICES)
            ->with('exists', $exists)
            ->with('profileID', $profileID)
            ->with('profile', $profile)
            ->with('unique_serial_number', $unique_serial_number);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RiskAssessmentRequest $request)
    {
        $request->merge([
            RiskAssessment::user_id => Auth::id(),
            RiskAssessment::created_at => currentDateTime()
        ]);

        $clientData = $request->all();

        $clientData[RiskAssessment::risk_category] = 3;

        // compute risk category
        if ($clientData[RiskAssessment::sex_with_more_than_one_partners] == 1 || $clientData[RiskAssessment::had_chemical_stimulantion_or_alcohol_before_sex] == 1 || $clientData[RiskAssessment::had_sex_in_exchange_of_goods_or_money] == 1) {
            $clientData[RiskAssessment::risk_category] = 2;
        }

        if ($clientData[RiskAssessment::had_sex_without_a_condom] == 1 || $clientData[RiskAssessment::shared_needle_for_injecting_drugs] == 1 || $clientData[RiskAssessment::sexually_transmitted_infection] == 1) {
            $clientData[RiskAssessment::risk_category] = 1;
        }

        RiskAssessment::create($clientData);

        flash('Risk assessment created successfully!')->success();
        return redirect()->route('outreach.risk-assessment.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(RiskAssessment $risk_assessment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RiskAssessment $risk_assessment)
    {
        $unique_serial_number = request()->query('sno');
        $profileID = $risk_assessment[Profile::profile_id];
        $profile = Profile::select(Profile::registration_date)->where(Profile::profile_id, $profileID)->first();
        $exists = RiskAssessment::where(RiskAssessment::profile_id, $profileID)->exists();
        $exists = $exists ? 2 : 1;
        $canTakeAction = in_array(Auth::user()->getRoleNames()->first(), [SUPER_ADMIN, PO_PERMISSION]);
        $client = ClientType::orderBy(ClientType::client_type_id)->get();

        return view('outreach.risk-assessment.create')
            ->with('CLIENT_TYPE', $client)
            ->with('CHOICES', self::CHOICES)
            ->with('canTakeAction', $canTakeAction)
            ->with('exists', $exists)
            ->with('profile', $profile)
            ->with('profileID', $profileID)
            ->with('unique_serial_number', $unique_serial_number)
            ->with('risk_assessment', $risk_assessment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RiskAssessmentRequest $request, RiskAssessment $risk_assessment)
    {
        $clientData = $request->all();

        $clientData[RiskAssessment::risk_category] = 3;

        // compute risk category
        if ($clientData[RiskAssessment::sex_with_more_than_one_partners] == 1 || $clientData[RiskAssessment::had_chemical_stimulantion_or_alcohol_before_sex] == 1 || $clientData[RiskAssessment::had_sex_in_exchange_of_goods_or_money] == 1) {
            $clientData[RiskAssessment::risk_category] = 2;
        }

        if ($clientData[RiskAssessment::had_sex_without_a_condom] == 1 || $clientData[RiskAssessment::shared_needle_for_injecting_drugs] == 1 || $clientData[RiskAssessment::sexually_transmitted_infection] == 1) {
            $clientData[RiskAssessment::risk_category] = 1;
        }

        $risk_assessment->update($clientData);
        flash('Risk assessment updated successfully!')->success();
        return redirect()->route('outreach.risk-assessment.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RiskAssessment $risk_assessment)
    {
        //
    }
}
