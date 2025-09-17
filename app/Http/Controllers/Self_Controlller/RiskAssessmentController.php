<?php

namespace App\Http\Controllers\Self_Controlller;

use App\Exports\{QuestionariesExport, SelfAppointments, SelfRiskAssessment};
use App\Http\Controllers\Controller;
use App\Models\Counter;
use App\Http\Requests\Self\Admin\Appointment;
use App\Models\CentreMaster;
use App\Models\DistrictMaster;
use App\Models\OTPMaster;
use App\Models\SelfModule\{Appointments, RiskAssessment, RiskAssessmentAnswer, RiskAssessmentItems, RiskAssessmentQuestionnaire};
use App\Models\StateMaster;
use App\Models\VmMaster;
use Carbon\Carbon;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{App, Auth, Cache, Config, Crypt, DB, Lang, Storage, Validator};
use Illuminate\Validation\Rule;
use App\Common\{IPStack, SMS, WhatsApp};
use Google\Service\AndroidEnterprise\Resource\Users;
use PDF;

use function Termwind\render;

class RiskAssessmentController extends Controller
{
    const REASON_FOR_NOT_ACCESSING = array(1 => 'Covid issues', 2 => 'Testing center closed', 3 => 'Unable to reach on time', 4 => 'Inconvenient timings', 5 => 'Out of station', 6 => 'Lack of time', 7 => 'Fear of being positive', 8 => 'Unwell', 9 => 'Center staff behaviour', 10 => 'Testing kit unavailable', 11 => 'Centre is crowded', 12 => 'Weather issue', 13 => 'Lost contact with client', 14 => 'Centre is far away', 15 => 'Afraid of being noticed', 16 => 'Long waiting time', 17 => 'No update from client', 18 => 'Unable to locate centre', 19 => 'Expensive', 99 => 'Others');
    const OUTCOME = array(1 => 'Reactive', 2 => 'Non-reactive', 3 => 'Not disclosed');

    public static function sra()
    {
        return view('self.index');
    }
    public static function index(Request $request, $mobile = null)
    {
        $groupNo = [1, 2, 3, 4, 5];
        try {
            $ipState = (new IPStack)->state();
            $questionnaire = RiskAssessmentQuestionnaire::getAllQuestionnaire($request);
            $state = StateMaster::where('st_cd', $ipState)->first();
            $verify = $request->filled('verify') ? $request->input('verify') : false;
            $mobileNo = !empty($mobile) ? Crypt::decryptString($mobile) : null;
            $vn = $request->filled('key') ? $request->input('key') : null;

            return view('home.survey.questionnaire', compact('questionnaire', 'state', 'verify', 'mobileNo', 'vn'));
        } catch (DecryptException $th) {
            logger($th);
            return redirect()->route('self.index')->withErrors(['mobile' => 'Invalid mobile number, please try again!']);
        }
    }

    public static function getQuestionSlug(Request $request)
    {
        $slug = RiskAssessmentQuestionnaire::select(RiskAssessmentQuestionnaire::question_slug)->orderBy(RiskAssessmentQuestionnaire::priority)->get()->pluck(RiskAssessmentQuestionnaire::question_slug);
        return $slug;
    }

    public static function storeRiskAssessment(Request $request)
    {
        try {
            DB::beginTransaction();

            $questionnaire = RiskAssessmentQuestionnaire::getAllQuestionnaire($request);
            $fields = $questionnaire->pluck(RiskAssessmentQuestionnaire::question_slug);

            $validator = collect()->make();
            $messages = collect()->make();
            foreach ($fields as $key => $value) {
                $count = $key;
                $rule = $value == 'mobile-number' ? 'required|digits_between:10,10|regex:' . MOB_REGEX : 'required';
                $validator->put($value, $rule);
                $messages->put($value, Lang::get('validation.custom.sra.required', ['value' => ++$count]));
            }

            $validate = Validator::make($request->all(), $validator->all(), $messages->all());
            if ($validate->fails())
                return redirect()->back()->withInput()->withErrors($validate->errors());

            $states = StateMaster::select('id', 'state_name', 'weight', 'st_cd')->whereNot('weight', 0)->get();

            $stateID = $request->input('state');
            $stateCode = !empty($states->where('id', $stateID)->first()) ? $states->where('id', $stateID)->first()['st_cd'] : '-';
            $score = !empty($states->where('id', $stateID)->first()) ? $states->where('id', $stateID)->first()['weight'] : 0;
            $requestedData = $request->except(['vn', 'state', 'mobile-number', '_token']);
            $mobileNo = $request->input('mobile-number');
            $vn = $request->filled('vn') ? $request->input('vn') : null;

            $questionnaireSlug = $questionnaire->pluck(RiskAssessmentQuestionnaire::question_slug);

            foreach ($questionnaireSlug as $slug) {
                if (isset($requestedData[$slug])) {
                    if (is_array($requestedData[$slug])) {
                        $answer = $questionnaire->where(RiskAssessmentQuestionnaire::question_slug, $slug)->first()['answers'];
                        $answer = $answer->whereIn(RiskAssessmentAnswer::answer_id, $requestedData[$slug]);
                        $score += $answer->sum(RiskAssessmentAnswer::weight);
                    } else {
                        $answer = $questionnaire->where(RiskAssessmentQuestionnaire::question_slug, $slug)->first()['answers'];
                        $score += $answer->where(RiskAssessmentAnswer::answer_id, $requestedData[$slug])->first()[RiskAssessmentAnswer::weight];
                    }
                }
            }

            $riskAssessmentItems = collect()->make();
            $riskAssessmentCount = RiskAssessment::count();
            $questionnaireData = $questionnaire->pluck(RiskAssessmentQuestionnaire::question_slug)->combine($questionnaire->pluck(RiskAssessmentQuestionnaire::question_id));
            $rawData = array_merge($request->except('_token'), ['ipstack_data' => (new IPStack)->getIPDetails()]);

            $riskAssessment = [
                RiskAssessment::state_id => $request->input('state'),
                RiskAssessment::unique_id => 'NETREACH/' . $stateCode . '/ASSESSMENT/' . ++$riskAssessmentCount,
                RiskAssessment::mobile_no => $mobileNo,
                RiskAssessment::risk_score => $score,
                RiskAssessment::raw_answer_sheet => $rawData
            ];

            if (!is_null($vn)) {

                $decoded = base64_decode(urldecode($vn));

                if (boolval(preg_match('//u', $decoded)) === false)
                    $decoded = $vn;

                $vnData = VmMaster::where(DB::raw('LOWER(`name`)'), strtolower($decoded))->first();
                $riskAssessment[RiskAssessment::vn_id] = is_null($vnData) ? null : $vnData['id'];
            }

            $riskAssessment = RiskAssessment::addOrUpdate($riskAssessment);
            $riskAssessmentID = $riskAssessment[RiskAssessment::risk_assessment_id];

            foreach ($requestedData as $key => $answer) {
                $questionID = $questionnaireData->get($key);
                if (is_array($answer)) {
                    foreach ($answer as $value) {
                        $riskAssessmentItems->push([
                            RiskAssessmentItems::risk_assessment_id => $riskAssessmentID,
                            RiskAssessmentItems::question_id => $questionID,
                            RiskAssessmentItems::answer_id => intval($value)
                        ]);
                    }
                } else {
                    $riskAssessmentItems->push([
                        RiskAssessmentItems::risk_assessment_id => $riskAssessmentID,
                        RiskAssessmentItems::question_id => $questionID,
                        RiskAssessmentItems::answer_id => intval($answer)
                    ]);
                }
            }

            RiskAssessmentItems::addOrUpdate($riskAssessmentItems->all());

            DB::commit();

            $isFromSRA = true;
            $data = ['score' => $score, 'mobileNo' => $mobileNo, 'stateID' => $stateID, 'vn' => $vn, 'riskAssessmentID' => $riskAssessmentID, 'isFromSRA' => $isFromSRA];
            Cache::put('self_risk_assessment_form_submit_cache', $data, 60);

            return view('self.success', $data);
        } catch (\Throwable $th) {
            DB::rollBack();
            logger($th);
            return redirect()->back()->withInput()->withErrors(['error' => 'Something went wrong!']);
        }
    }

    public static function selfSuccess(Request $request)
    {
        $data = Cache::get('self_risk_assessment_form_submit_cache');

        if (!$data)
            return abort(404);

        $score = $data['score'];
        $mobileNo = $data['mobileNo'];
        $stateID = $data['stateID'];
        $vn = $data['vn'];
        $riskAssessmentID = $data['riskAssessmentID'];
        Cache::forget('self_risk_assessment_form_submit_cache');

        return view('self.success', compact('score', 'mobileNo', 'stateID', 'vn', 'riskAssessmentID'));
    }

    public static function verifyOTP(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'mobile-no' => 'bail|required',
            'otp' => [
                'required',
                Rule::exists(OTPMaster::class, 'otp')->where('phone_no', $request->input('mobile-no'))
            ]
        ]);
        if ($validate->fails())
            return redirect()->back()->withErrors($validate->errors());

        $otp = OTPMaster::where('phone_no', $request->input('mobile-no'))->where('otp', $request->input('otp'))->exists();
        if ($otp)
            OTPMaster::where('phone_no', $request->input('mobile-no'))->where('otp', $request->input('otp'))->delete();

        $key = $request->filled('vn') ? $request->input('vn') : null;

        return redirect()->route('self.index', ['mobile' => Crypt::encryptString($request->input('mobile-no')), 'verify' => true, 'key' => $key]);
    }
    public static function getDistricts(Request $request)
    {
        $districts = DistrictMaster::where('state_id', $request->input('state_id'))->orderBy('district_name')->get();

        return [STATUS => OK, DATA => $districts];
    }
    public static function getDistricts2(Request $request)
    {
        $districts = DistrictMaster::where('state_code', $request->input('state_code'))->orderBy('district_name')->get();
        return [STATUS => OK, DATA => $districts];
    }
    public static function getTestingCenters(Request $request)
    {
        $centers = CentreMaster::where('district_id', $request->input('district'))->orderBy('name')->get();

        return [STATUS => OK, DATA => $centers];
    }
    public static function getBookAppointment(Request $request)
    {
        try {
            $ipState = (new IPStack)->state();

            $mobileNo = Crypt::decryptString($request->input('mobile'));
            $stateID = $request->input('state');
            $vn = $request->filled('key') ? $request->input('key') : null;
            $assessment = $request->filled('assessment') ? Crypt::decryptString($request->input('assessment')) : null;
            $states = StateMaster::select('id', 'state_name', 'st_cd')->orderBy('state_name')->get();
            $districts = DistrictMaster::where('state_code', $ipState)->get();

            return view('self.book-appointment', compact('mobileNo', 'states', 'stateID', 'vn', 'assessment', 'districts'));
        } catch (DecryptException $th) {
            return redirect()->route('self.index')->withErrors(['mobile' => 'Invalid mobile number, please try again!']);
        }
    }
    public static function addCounter(Request $request)
    {
        RiskAssessmentQuestionnaire::counterIncrement($request);
        return [STATUS => OK, DATA => true];
    }
    public static function bookAppointment(Request $request)
    {
        $assessment = !is_null($request->assessment_id) ? RiskAssessment::find($request->assessment_id) : null;
        if (!$assessment == null) {
            $user_notification = $request->user_notification;
            if (isset($user_notification)) {
                $assessment->user_notification = $user_notification;
                $assessment->save();
            }
        }

        try {
            $validate = Validator::make($request->all(), [
                Appointments::full_name => 'required|max:250',
                Appointments::state_id => 'required',
                Appointments::district_id => 'required',
                Appointments::services => 'required|array|min:1',
                Appointments::center_id => 'present|nullable|numeric',
                Appointments::appointment_date => [
                    'required',
                    'after_or_equal:' . currentDateTime(DEFAULT_DATE_FORMAT),
                    'before_or_equal:' . getFutureDate(MONTHLY, 1, false, DEFAULT_DATE_FORMAT),
                ]
            ]);
            if ($validate->fails())
                return redirect()->back()->withInput()->withErrors($validate->errors());

            DB::beginTransaction();

            $isLocal = App::environment('local');
            $state = StateMaster::find($request->input('state_id'));
            $center = CentreMaster::find($request->input('center_id'));
            $count = Appointments::count(Appointments::appointment_id);

            $referralNo = Carbon::now()->format('dmYHis');
            $counter = Counter::pluck('appointmentCounter')->first();
            $newCounter = $counter + 1;
            $uid = 'NETREACH/' . $state['st_cd'] . '/SELF/' . $newCounter;
            Counter::query()->update(['appointmentCounter' => $newCounter]);
            $vnname = null;
            $vnmobile = null;


            if ($request->filled('vn')) {
                $decoded = base64_decode(urldecode($request->input('vn')));
                if (!boolval(preg_match('//u', $decoded))) {
                    $decoded = $request->input('vn');
                }

                // Find the corresponding VN data in the VmMaster model
                $vnDetails = VmMaster::where(DB::raw('LOWER(`link_name`)'), strtolower($decoded))->first();
                $vnname = $vnDetails?->name;
                $vnmobile = $vnDetails?->mobile_number;
                $request->merge([
                    Appointments::vn_id => $vnDetails?->id
                ]);
            } else {
                $state = StateMaster::where('st_cd', $state['st_cd'])->first();
                $region = REGION[intval($state['region'])];
                $vnDetails = VmMaster::where('region', $region)->get();
                if (!is_null($vnDetails)) {
                    $vnDetails = $vnDetails->filter(function ($value) use ($state) {
                        if (collect($value['state_list'])->contains($state['state_code']))
                            return $value;
                    });
                    $vnDetails = $vnDetails->first();
                    $vnname = $vnDetails?->name;
                    $vnmobile = $vnDetails?->mobile_number;
                }
            }
            $pdfData = [
                Appointments::full_name => $request->input(Appointments::full_name),
                Appointments::services => $request->input(Appointments::services),
                Appointments::uid => $uid,
                Appointments::referral_no => $referralNo,
                Appointments::appointment_date => Carbon::parse($request->input(Appointments::appointment_date))->format('Y-m-d'),
                'today' => Carbon::now()->format('Y-m-d'),
                'center' => !empty($center) && isset($center['name']) ? $center['name'] : '',
                'vnname' => $vnname,
                'vnmobile' => $vnmobile
            ];
            $filename = Carbon::now()->timestamp . '.pdf';
            $path = 'pdf/' . $filename;

            if (!$isLocal) {
                $pdf = PDF::loadView('pdf.self-document', compact('pdfData'));
                $pdfPath = 'app/public/' . $path;
                $file_url = Storage::disk('public')->url($path);
                $pdf->save(storage_path($pdfPath));
            }

            $request->merge([
                Appointments::media_path => isset($path) ? $path : Config::get('app.url')
            ]);

            $request->merge($pdfData);

            $requestedServices = collect()->make();
            Appointments::addOrUpdate($request);

            foreach ($request->input('services') as $key => $value) {
                $requestedServices->push(SERVICES[(int) $value]);
            }

            $requestedServices = $requestedServices->implode(',');

            if (!$isLocal && $file_url) {
                (new WhatsApp)->appointmentBooked(
                    $request->input('mobile_no'),
                    $request->input('full_name'),
                    $uid,
                    $center['name'],
                    $request->input('appointment_date'),
                    $requestedServices,
                    isset($vnname) ? $vnname : '-',
                    isset($vnmobile) ? $vnmobile : '-',
                    $file_url,
                    isset($filename) ? $filename : Config::get('app.name')
                );
                // whatsapp msg to vn on appointment booked
                if ($vnname && $vnmobile) {
                    (new WhatsApp)->appointmentBooked(
                        $vnmobile,
                        $request->input('full_name'),
                        $uid,
                        $center['name'],
                        $request->input('appointment_date'),
                        $requestedServices,
                        isset($vnname) ? $vnname : '-',
                        isset($vnmobile) ? $vnmobile : '-',
                        $file_url,
                        isset($filename) ? $filename : Config::get('app.name')
                    );
                }
            }

            if ($vnname && $vnmobile) {
                (new SMS)->appointmentBooked($request->input('mobile_no'), $vnname, $vnmobile);
                (new SMS)->appointmentBooked($request->input('vnmobile'), $vnname, $vnmobile);
            }

            DB::commit();

            $isLanding = $request->filled('landing') ? true : false;

            return view('self.booked', compact('uid', 'path', 'isLanding'));
        } catch (\Throwable $th) {
            DB::rollBack();
            logger($th);
            return redirect()->back()->withInput()->withErrors(['error' => 'Something went wrong!']);
        }
    }
    public static function getAllQuestionnaire(Request $request)
    {
        // dd('dflfdjlkdjbkl');
        $data = RiskAssessmentQuestionnaire::getAllQuestionnaire($request);
        $questionaries = collect()->make();
        $count = 1;

        foreach ($data as $value) {
            $questionaries->push([
                'sr_no' => $count++,
                RiskAssessmentQuestionnaire::question => $value[RiskAssessmentQuestionnaire::question],
                RiskAssessmentQuestionnaire::counter => $value[RiskAssessmentQuestionnaire::counter],
            ]);
        }
        if ($request->filled('export'))
            return new QuestionariesExport($questionaries->all());
        return view('self.admin.questionnaire', compact('data'));
    }

    public static function getAllSelfRiskAssessments(Request $request)
    {
        if (isset($request->export))
            $export = true;
        else
            $export = false;
        $isCombineList = collect($request->segments())->contains('master-line-list');
        $questionnaire = RiskAssessmentQuestionnaire::getAllQuestionnaire($request);
        $header = $questionnaire->pluck(RiskAssessmentQuestionnaire::question_id);
        $header2 = $questionnaire->pluck(RiskAssessmentQuestionnaire::question);
        $slug = $questionnaire->pluck(RiskAssessmentQuestionnaire::question_slug);

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
        $request->merge([
            "rolename" => $roleName
        ]);
        $riskAssessments = collect()->make();
        $vnDetails = $request->user()->vndetails()?->first();

        $selflink = null;
        $oldSelflink = null;

        if (in_array($roleName, [VN_USER_PERMISSION, PO_PERMISSION])) {
            $selflink = route('self.sra', ['key' => $vnDetails->link_name]);
            $oldSelflink = route('self.sra', ['key' => urlencode(base64_encode($vnDetails->link_name))]);
            // $selflink = url('self.sra', ['key' => $vnDetails->name]);
            // $oldSelflink = url('self.sra', ['key' => urlencode(base64_encode($vnDetails->name))]);
        }
        $filter = false;
        if (isset($request->risk_score) || isset($request->full_name) || isset($request->risk_assessment_id) || isset($request->mobile_no) || isset($request->services) || isset($request->state_id) || isset($request->from) || isset($request->to)) {
            $filter = true;
        }
        $setVn = false;
        if (isset($request->vn_id)) {
            $setVn = true;
        }

        if ($roleName == PO_PERMISSION) {
            if ($filter || $setVn) {
                if ($filter && !$setVn) {
                    $region = $request->user()->vndetails()->first()->region;
                    if ($request->user()->vndetails()->first()->regions_list != null) {
                        $regions_list = $request->user()->vndetails()->first()->regions_list;
                        // $regions_list = json_decode($request->user()->vndetails()->first()->regions_list, true);
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
                        $stateIds = StateMaster::whereIn('region', $vals)->pluck('id');
                    } else {
                        if ($region == "north")
                            $regx[] = 1;
                        if ($region == "south")
                            $regx[] = 2;
                        if ($region == "east")
                            $regx[] = 3;
                        if ($region == "west")
                            $regx[] = 4;
                        $stateIds = StateMaster::where('region', $regx)->pluck('id');
                    }
                    if (!isset($request->state_id)) {

                        if ($stateIds) {
                            $request->merge([
                                RiskAssessment::state_id => $stateIds->toArray()
                            ]);
                        }
                    }
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
                    if ($vn_idx) {
                        $request->merge([
                            RiskAssessment::vn_id => $vn_idx
                        ]);
                    }
                    $dataHolder = RiskAssessment::getAllRiskAssessmentsPo($request, true);
                    $data = $dataHolder['data'];

                    $stateCodes_po = StateMaster::whereIn('region', $vals)->pluck('state_code')->toArray();
                    $status = 1;
                    $vnx = [];
                    $vn_ids_po = VmMaster::whereHas('User', function ($query) use ($status) {
                        return $query->where('status', $status);
                    })->get();
                    foreach ($stateCodes_po as $stcode) {
                        foreach ($vn_ids_po->toArray() as $vnk) {
                            $tempcodes = $vnk["state_code"];
                            if (strpos($tempcodes, ',') !== false) {
                                $tempcodes_po = explode(',', $tempcodes);
                                if (in_array($stcode, $tempcodes_po)) {
                                    if (!in_array($vnk["id"], $vnx)) {
                                        array_push($vnx, $vnk['id']);
                                    } else
                                        continue;
                                } else
                                    continue;
                            } else {
                                if ($stcode == $tempcodes) {
                                    if (!in_array($vnk["id"], $vnx)) {
                                        array_push($vnx, $vnk['id']);
                                    } else
                                        continue;
                                } else
                                    continue;
                            }
                        }
                    }
                    $request->merge([
                        RiskAssessment::vn_id => $vnx
                    ]);
                    $dataHolder2 = RiskAssessment::getAllRiskAssessmentsPo($request);
                    $data = $data->merge($dataHolder2['data']);
                    $total = $dataHolder['count'] + $dataHolder2['count'];
                }
            } else {
                $poId = $request->user()->vndetails()->first()->id;
                $region = $request->user()->vndetails()->first()->region;
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
                    $stateIds = StateMaster::whereIn('region', $vals)->pluck('id');
                } else {
                    if ($region == "north")
                        $regx[] = 1;
                    if ($region == "south")
                        $regx[] = 2;
                    if ($region == "east")
                        $regx[] = 3;
                    if ($region == "west")
                        $regx[] = 4;
                    $stateIds = StateMaster::where('region', $regx)->pluck('id');
                }
                if ($stateIds) {
                    $request->merge([
                        RiskAssessment::state_id => $stateIds->toArray()
                    ]);
                }
                if ($request->user()->vndetails()->first()->regions_list != null) {
                    $stateCodes_po = StateMaster::whereIn('region', $vals)->pluck('state_code')->toArray();
                } else {
                    if ($region == "north")
                        $regx[] = 1;
                    if ($region == "south")
                        $regx[] = 2;
                    if ($region == "east")
                        $regx[] = 3;
                    if ($region == "west")
                        $regx[] = 4;
                    $stateCodes_po = StateMaster::where('region', $regx)->pluck('state_code')->toArray();
                }
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
                $stateIds = StateMaster::whereIn('state_code', $state_id)->pluck('id')->toArray();
                $poDataHolder = RiskAssessment::getAllPodata($request, $poId, $vnx, $stateIds, $export);
                $data = $poDataHolder['data'];
            }
        }

        if ($setVn) {
            if (count($request->vn_id) > 1) {
                $stateCodes = VmMaster::whereIn('id', $request->vn_id)->pluck('state_code');
            } else {

                $stateCodes = VmMaster::where('id', $request->vn_id)->pluck('state_code');
            }
            $collectcodes = [];
            foreach ($stateCodes as $value) {
                $array = explode(',', $value);
                $collectcodes = array_merge($collectcodes, $array);
            }
            $stateIds = StateMaster::whereIn('state_code', $collectcodes)->pluck('id')->toArray();
            if ($filter) {
                $dataHolder = RiskAssessment::getVnDataByfilters($request->vn_id, $stateIds, $export, $request);
                $data = $dataHolder['data'];
            } else {
                $dataHolder = RiskAssessment::getAllVnData($request->vn_id, $stateIds, $export, $request, false);
                $data = $dataHolder['data'];
            }
        }



        if ($vnDetails) {
            if (in_array($roleName, [VN_USER_PERMISSION])) {
                $stateCodes = $vnDetails->state_code;
                $array = explode(',', $stateCodes);
                $stateIds = StateMaster::whereIn('state_code', $array)->pluck('id')->toArray();
            }
        }

        if ($roleName == VN_USER_PERMISSION) {
            if ($filter) {
                $dataHolder = RiskAssessment::getVnDataByfilters($vnDetails->id, $stateIds, $export, $request);
                $data = $dataHolder['data'];
            } else {
                $dataHolder = RiskAssessment::getAllVnData($vnDetails->id, $stateIds, $export, $request, false);
                $data = $dataHolder['data'];
            }
        }


        if ($roleName == SUPER_ADMIN && !$setVn) {
            $data = RiskAssessment::getAllRiskAssessments($request);
        }
        $appointment = (new Appointments)->getFillable();
        foreach ($data as $value) {
            $direct = $request->filled('export') ? 'Direct Link' : view('self.admin.ajax.direct')->render();
            $hasAppointment = $request->filled('export') ? ($value->appointment_exists ? 'Yes' : 'No') : view('self.admin.ajax.appointment', compact('value'))->render();
            $json = isset($value[RiskAssessment::raw_answer_sheet]) ? $value[RiskAssessment::raw_answer_sheet] : null;
            $ipData = isset($json['ipstack_data']) ? $json['ipstack_data'] : null;

            $temp = collect()->make();
            $temp->put('sr-no', $value[RiskAssessment::risk_assessment_id]);
            $temp->put('appointment-no', !empty($value['appointment']) ? $value['appointment'][Appointments::appointment_id] : '-');
            $temp->put('risk-score', $value[RiskAssessment::risk_score]);
            $temp->put('meet_id', $value[RiskAssessment::meet_id]);
            $temp->put('vn-name', !empty($value['vn_details']) ? $value['vn_details']['name'] : $direct);
            $temp->put('has-appointment', $hasAppointment);
            $temp->put('mobile-number', $value[RiskAssessment::mobile_no]);
            $temp->put('ra-date', parseDateTime($value[RiskAssessment::created_at], READABLE_DATETIME));
            $temp->put('state', isset($value['state']) && !empty($value['state']) ? $value['state']['state_name'] : null);
            // $temp->put('ip', '');
            // $temp->put('ip-country', '');
            // $temp->put('ip-state', '');
            // $temp->put('ip-city', '');

            $temp->put('ip', is_null($ipData) || $ipData == '' ? '-' : $json['ipstack_data']['ip']);
            $temp->put('ip-country', is_null($ipData) || $ipData == '' ? '-' : $json['ipstack_data']['country_name']);
            $temp->put('ip-state', is_null($ipData) || $ipData == '' ? '-' : $json['ipstack_data']['region_name']);
            $temp->put('ip-city', is_null($ipData) || $ipData == '' ? '-' : $json['ipstack_data']['city']);

            if ($request->filled('export'))
                $temp->put('ra-month', is_null($value[RiskAssessment::created_at]) ? null : parseDateTime($value[RiskAssessment::created_at], MONTH_YEAR));

            if ($isCombineList || $request->filled('export'))
                $temp->put('full-name', empty($value['appointment']) ? null : $value['appointment'][Appointments::full_name]);

            if ($isCombineList) {
                $appointment = $value['appointment'];
                $serviceSought = empty($appointment) ? null : $appointment[Appointments::outcome_of_the_service_sought];

                $temp->put('referral-no', empty($appointment) ? null : $appointment[Appointments::referral_no]);
                $temp->put('uid', empty($appointment) ? null : $appointment[Appointments::uid]);
                $temp->put('mobile-no', empty($appointment) ? null : $appointment[Appointments::mobile_no]);
                $temp->put('services', empty($appointment) ? null : $appointment[Appointments::service_list]);
                $temp->put('appointment-date', empty($appointment) ? null : parseDateTime($appointment[Appointments::appointment_date], READABLE_DATETIME));
                $temp->put('not-access-the-service-referred', empty($appointment) ? null : $appointment[Appointments::not_access_the_service_referred]);
                $temp->put('date-of-accessing-service', empty($appointment) ? null : $appointment[Appointments::date_of_accessing_service]);
                $temp->put('pid-provided-at-the-service-center', empty($appointment) ? null : $appointment[Appointments::pid_provided_at_the_service_center]);
                $temp->put('outcome-of-the-service-sought', !isset(self::OUTCOME[$serviceSought]) ? null : self::OUTCOME[$serviceSought]);
                $temp->put('remark', empty($appointment) ? null : $appointment[Appointments::remark]);
                $temp->put('booked-at', empty($appointment) ? null : parseDateTime($appointment[Appointments::created_at], READABLE_DATETIME));
                $temp->put('appointment-state', $value->appointment?->state?->state_name);
                $temp->put('district', $value->appointment?->district?->district_name);
                $temp->put('center', $value->appointment?->center?->name);
                $temp->put('pre-art-no', empty($appointment) ? null : $appointment[Appointments::pre_art_no]);
                $temp->put('on-art-no', empty($appointment) ? null : $appointment[Appointments::on_art_no]);
                $temp->put('updated-by', empty($appointment) || empty($appointment[Appointments::updated_by]) ? null : $appointment['updatedBy']['name']);
                $temp->put('updated-at', empty($appointment) || empty($appointment[Appointments::updated_at]) ? null : parseDateTime($appointment[Appointments::updated_at], READABLE_DATETIME));

                if ($request->filled('export')) {
                    $temp->put('appointment-month', is_null($appointment) || is_null($appointment[Appointments::appointment_date]) ? null : parseDateTime($appointment[Appointments::appointment_date], MONTH_YEAR));
                    $temp->put('month-of-accessing-service', is_null($appointment) || is_null($appointment[Appointments::date_of_accessing_service]) ? null : parseDateTime($appointment[Appointments::date_of_accessing_service], MONTH_YEAR));
                    $temp->put('booked-month', is_null($appointment) || is_null($appointment[Appointments::created_at]) ? null : parseDateTime($appointment[Appointments::created_at], MONTH_YEAR));
                }
            }

            foreach ($value['items'] as $item) {
                if (!empty($item['question'])) {
                    $answer = !is_null($item['answer']) ? $item['answer'][RiskAssessmentAnswer::answer] : null;
                    $operator = $request->filled('export') ? ', ' : '<br>';
                    if ($temp->has($item['question'][RiskAssessmentQuestionnaire::question_slug]))
                        $temp->put($item['question'][RiskAssessmentQuestionnaire::question_slug], $temp->get($item['question'][RiskAssessmentQuestionnaire::question_slug]) . $operator . $answer);
                    else
                        $temp->put($item['question'][RiskAssessmentQuestionnaire::question_slug], $answer);
                }
            }

            foreach ($slug as $headerSlug) {
                if (!$temp->has($headerSlug))
                    $temp->put($headerSlug, '-');
            }

            if (!$request->filled('export')) {
                $delete = Auth::user()->user_type == 1
                    ? '<form method="post" onsubmit="return confirmDeleteSubmit()" action="' . route('admin.self-risk-assessment.delete', ['id' => $value->risk_assessment_id]) . '">' . csrf_field() . '<button type="submit" class="btn btn-danger btn-sm">Delete</button></form>'
                    : '<b>No Permission</b>';
                $temp->put('delete-column', $delete);
            }

            $riskAssessments->push($temp->all());
        }

        if ($request->filled('export'))
            return new SelfRiskAssessment($header2->all(), $slug->all(), $riskAssessments->all(), $isCombineList);
        if ($roleName == VN_USER_PERMISSION) {
            $total = $dataHolder['count'];
        } else {
            if ($roleName == PO_PERMISSION && !$setVn) {
                if (!$filter) {
                    $total = $poDataHolder['count'];
                }
            }
        }

        if ($setVn) {
            if ($filter) {
                $total = $dataHolder['count'];
            } else {
                $total = $dataHolder['count'];
            }
        }
        if ($roleName == SUPER_ADMIN && !$setVn) {
            $total = RiskAssessment::getAllRiskAssessments($request, true);
        }
        if ($request->ajax()) {
            $json_data = array(
                "draw" => intval($request->draw),
                "recordsTotal" => $total,
                "recordsFiltered" => $total,
                "data" => $riskAssessments->all()
            );

            echo json_encode($json_data);
            exit;
        }

        // $state_list = StateMaster::orderBy('state_name', 'ASC')->get();
        if (in_array($roleName, [VN_USER_PERMISSION])) {

            $state_list = StateMaster::orderBy('state_name', 'ASC')->get();
        } else if (in_array($roleName, haystack: [PO_PERMISSION])) {
            if ($request->user()->vndetails()->first()->regions_list != null) {
                $state_list = StateMaster::whereIn('region', $vals)->get();
            } else {
                if ($region == "north")
                    $regx[] = 1;
                if ($region == "south")
                    $regx[] = 2;
                if ($region == "east")
                    $regx[] = 3;
                if ($region == "west")
                    $regx[] = 4;
                $state_list = StateMaster::where('region', $regx)->get();
            }
        } else {
            $state_list = StateMaster::orderBy('state_name', 'ASC')->get();
        }
        // $vn_list = VmMaster::orderBy('name')->get();
        if ($roleName == PO_PERMISSION) {
            // $vn_list = DB::select("SELECT * FROM vm_master WHERE status = 1  AND region = '$region' ORDER BY name");
            $vn_list = VmMaster::whereIn("id", $vnx)->get();
        } else {

            $vn_list = DB::select("SELECT * FROM vm_master WHERE status = 1 ORDER BY name");
        }
        $center_list = CentreMaster::all();

        return $isCombineList
            ? view('self.admin.combine-list', compact('header', 'header2', 'selflink', 'oldSelflink', 'state_list', 'vn_list', 'center_list'))
            : view('self.admin.index', compact('header', 'header2', 'selflink', 'oldSelflink', 'state_list', 'vn_list', 'center_list'));
    }

    // public static function setVnForSRA(Request $request,$lang, $key)
    public static function setVnForSRA(Request $request, $key, $locale = 'en')
    {
        if ($locale != 'en') {
            $lang = $key;
            $key = $locale;
            $locale = $lang;
        }
        return view('self.index', compact('key'));
    }
    public static function getAllAppointments(Request $request)
    {
        $vnDetails = $request->user()->vndetails()?->first();
        $state_list = StateMaster::orderBy('state_name', 'ASC')->get();
        $vn_list = VmMaster::orderBy('name')->get();
        $center_list = CentreMaster::all();

        $filter = false;
        if (isset($request->risk_score) || isset($request->full_name) || isset($request->appointment_id) || isset($request->mobile_no) || isset($request->services) || isset($request->state_id) || isset($request->from) || isset($request->to)) {
            $filter = true;
        }
        $setVn = false;
        if (isset($request->vn_id)) {
            $setVn = true;
        }

        if (isset($request->export))
            $export = true;
        else
            $export = false;

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
        $request->merge([
            "rolename" => $roleName
        ]);






        if ($roleName == PO_PERMISSION) {

            if ($filter || $setVn) {

                if ($filter && !$setVn) {
                    $region = $request->user()->vndetails()->first()->region;
                    if ($request->user()->vndetails()->first()->regions_list != null) {
                        $regions_list = $request->user()->vndetails()->first()->regions_list;
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
                        $stateIds = StateMaster::whereIn('region', $vals)->pluck('id');
                    } else {
                        if ($region == "north")
                            $regx[] = 1;
                        if ($region == "south")
                            $regx[] = 2;
                        if ($region == "east")
                            $regx[] = 3;
                        if ($region == "west")
                            $regx[] = 4;
                        $stateIds = StateMaster::where('region', $regx)->pluck('id');
                    }
                    if (!isset($request->state_id)) {
                        if ($stateIds) {
                            $request->merge([
                                Appointments::state_id => $stateIds->toArray()
                            ]);
                        }
                    }
                    if ($request->user()->vndetails()->first()->regions_list != null) {
                        $vnIDs = VmMaster::select('id')->where('region', $regions_list)
                            ->whereHas('user', function ($query) {
                                return $query->where('user_type', 2);
                            })->get();
                    } else {
                        $vnIDs = VmMaster::select('id')->where('region', $region)
                            ->whereHas('user', function ($query) {
                                return $query->where('user_type', 2);
                            })->get();
                    }
                    $vn_idx = [];
                    foreach ($vnIDs as $value) {
                        array_push($vn_idx, $value['id']);
                    }
                    if ($vn_idx) {
                        $request->merge([
                            Appointments::vn_id => $vn_idx
                        ]);
                    }
                    $dataHolder = Appointments::getAllAppointmentsPo($request, true);
                    $data = $dataHolder['data'];

                    $stateCodes_po = StateMaster::whereIn('region', $vals)->pluck('state_code')->toArray();
                    $status = 1;
                    $vnx = [];
                    $vn_ids_po = VmMaster::whereHas('User', function ($query) use ($status) {
                        return $query->where('status', $status);
                    })->get();
                    foreach ($stateCodes_po as $stcode) {
                        foreach ($vn_ids_po->toArray() as $vnk) {
                            $tempcodes = $vnk["state_code"];
                            if (strpos($tempcodes, ',') !== false) {
                                $tempcodes_po = explode(',', $tempcodes);
                                if (in_array($stcode, $tempcodes_po)) {
                                    if (!in_array($vnk["id"], $vnx)) {
                                        array_push($vnx, $vnk['id']);
                                    } else
                                        continue;
                                } else
                                    continue;
                            } else {
                                if ($stcode == $tempcodes) {
                                    if (!in_array($vnk["id"], $vnx)) {
                                        array_push($vnx, $vnk['id']);
                                    } else
                                        continue;
                                } else
                                    continue;
                            }
                        }
                    }
                    $request->merge([
                        Appointments::vn_id => $vnx
                    ]);

                    $dataHolder2 = Appointments::getAllAppointmentsPo($request);
                    $data = $data->merge($dataHolder2['data']);
                    $total = $dataHolder['count'] + $dataHolder2['count'];
                }
            } else {


                $poId = $request->user()->vndetails()->first()->id;
                $region = $request->user()->vndetails()->first()->region;
                if ($request->user()->vndetails()->first()->regions_list != null) {
                    if (is_array($request->user()->vndetails()->first()->regions_list)) {
                        $regions_list = $request->user()->vndetails()->first()->regions_list;
                    } else
                        $regions_list = $request->user()->vndetails()->first()->regions_list;
                    // $regions_list = json_decode($request->user()->vndetails()->first()->regions_list, true);
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

                    $stateCodes_po = StateMaster::whereIn('region', $vals)->pluck('state_code')->toArray();
                } else {
                    if ($region == "north")
                        $regx[] = 1;
                    if ($region == "south")
                        $regx[] = 2;
                    if ($region == "east")
                        $regx[] = 3;
                    if ($region == "west")
                        $regx[] = 4;
                    $stateCodes_po = StateMaster::where('region', $regx)->pluck('state_code')->toArray();
                }
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
                $stateIds = StateMaster::whereIn('state_code', $state_id)->pluck('id')->toArray();
                $poDataHolder = Appointments::getAllPodata($request, $poId, $vnx, $stateIds, $export);
                $data = $poDataHolder['data'];
            }
            if (!$filter && !$setVn)
                $vn_list = VmMaster::whereIn("id", $vnx)->get();
        }

        if (!$request->ajax() && !$request->filled('export'))
            return view('self.admin.appointments', compact('state_list', 'vn_list', 'center_list'));

        if ($vnDetails) {
            if (in_array($roleName, [VN_USER_PERMISSION])) {
                $stateCodes = $vnDetails->state_code;
                $array = explode(',', $stateCodes);
                $stateIds = StateMaster::whereIn('state_code', $array)->pluck('id')->toArray();
            }
        }

        if ($roleName == VN_USER_PERMISSION) {
            if ($filter) {
                $dataHolder = Appointments::getVnDataByfilters($vnDetails->id, $stateIds, $export, $request);
                $data = $dataHolder['data'];
            } else {
                $dataHolder = Appointments::getAllVnData($vnDetails->id, $stateIds, $export, $request, false);
                $data = $dataHolder['data'];
            }
        }


        if ($setVn) {
            if (count($request->vn_id) > 1) {
                $stateCodes = VmMaster::whereIn('id', $request->vn_id)->pluck('state_code');
            } else {

                $stateCodes = VmMaster::where('id', $request->vn_id)->pluck('state_code');
            }
            $collectcodes = [];
            foreach ($stateCodes as $value) {
                $array = explode(',', $value);
                $collectcodes = array_merge($collectcodes, $array);
            }
            $stateIds = StateMaster::whereIn('state_code', $collectcodes)->pluck('id')->toArray();
            if ($filter) {
                $dataHolder = Appointments::getVnDataByfilters($request->vn_id, $stateIds, $export, $request);
                $data = $dataHolder['data'];
            } else {
                $dataHolder = Appointments::getAllVnData($request->vn_id, $stateIds, $export, $request, false);
                $data = $dataHolder['data'];
            }
        }

        $appointments = collect()->make();
        if ($roleName == SUPER_ADMIN && !$setVn) {
            $dataholder = Appointments::getAllAppointments($request);
            $data = $dataholder['data'];
        }
        foreach ($data as $value) {
            // dd($value);
            $media = $value[Appointments::media_path];
            $evidence = $value[Appointments::evidence_path];
            $evidence2 = $value[Appointments::evidence_path_2];
            $evidence3 = $value[Appointments::evidence_path_3];
            $evidence4 = $value[Appointments::evidence_path_4];
            $evidence5 = $value[Appointments::evidence_path_5];
            $id = $value[Appointments::appointment_id];
            $html = view('self.admin.ajax.link', compact('id'))->render();
            $direct = $request->filled('export') ? 'Direct Link' : view('self.admin.ajax.direct')->render();
            $temp = [
                'sr_no' => $id,
                'assessment_no' => $value[Appointments::assessment_id],
                'html' => $html,
                'ra_date' => Carbon::parse($value[Appointments::created_at])->format(READABLE_DATETIME),
                RiskAssessment::risk_score => !empty($value['assessment']) ? $value['assessment'][RiskAssessment::risk_score] : 0,
                Appointments::appointment_date => Carbon::parse($value[Appointments::appointment_date])->format('d M Y'),
                Appointments::media_path => view('self.admin.ajax.invoice-btn', compact('media', 'evidence', 'evidence2', 'evidence3', 'evidence4', 'evidence5'))->render(),
                Appointments::date_of_accessing_service => $value[Appointments::date_of_accessing_service],
                Appointments::not_access_the_service_referred => !empty($value[Appointments::not_access_the_service_referred]) ? self::REASON_FOR_NOT_ACCESSING[$value[Appointments::not_access_the_service_referred]] : null,
                Appointments::pid_provided_at_the_service_center => $value[Appointments::pid_provided_at_the_service_center],
                'vn_name' => !empty($value['vn_details']) ? $value['vn_details']['name'] : $direct,
                Appointments::full_name => $value[Appointments::full_name],
                Appointments::mobile_no => $value[Appointments::mobile_no],
                Appointments::services => $value[Appointments::service_list],
                'state' => isset($value['state']) && !empty($value['state']) ? $value['state']['state_name'] : null,
                'district' => isset($value['district']) && !empty($value['district']) ? $value['district']['district_name'] : null,
                'center' => isset($value['center']) && !empty($value['center']) ? $value['center']['name'] : null,
                Appointments::referral_no => $value[Appointments::referral_no],
                Appointments::uid => $value[Appointments::uid],
                Appointments::type_of_test => is_null($value[Appointments::type_of_test]) ? null : ($value[Appointments::type_of_test] == 1 ? "Screening" : "Confirmatory"),
                Appointments::treated_state_id => is_null($value[Appointments::treated_state_id]) ? null : StateMaster::getOneStateName($value[Appointments::treated_state_id]),
                Appointments::treated_district_id => is_null($value[Appointments::treated_district_id]) ? null : DistrictMaster::getOneDistrictName($value[Appointments::treated_district_id]),
                Appointments::treated_center_id => is_null($value[Appointments::treated_center_id]) ? null : CentreMaster::getOneCentreName($value[Appointments::treated_center_id]),
                Appointments::outcome_of_the_service_sought => !empty($value[Appointments::outcome_of_the_service_sought]) ? self::OUTCOME[$value[Appointments::outcome_of_the_service_sought]] : null,
                Appointments::remark => $value[Appointments::remark],
                Appointments::pre_art_no => is_null($value[Appointments::pre_art_no]) ? null : $value[Appointments::pre_art_no],
                Appointments::on_art_no => is_null($value[Appointments::on_art_no]) ? null : $value[Appointments::on_art_no],
                Appointments::updated_by => is_null($value[Appointments::updated_by]) ? null : $value['updatedBy']['name'],
                Appointments::updated_at => is_null($value[Appointments::updated_at]) ? null : parseDateTime($value[Appointments::updated_at], READABLE_DATETIME)
            ];

            if ($request->filled('export')) {
                $temp['ra-month'] = is_null($value[Appointments::created_at]) ? null : Carbon::parse($value[Appointments::created_at])->format(MONTH_YEAR);
                $temp['appointment-month'] = is_null($value[Appointments::appointment_date]) ? null : Carbon::parse($value[Appointments::appointment_date])->format(MONTH_YEAR);
                $temp['month-of-accessing-service'] = is_null($value[Appointments::date_of_accessing_service]) ? null : Carbon::parse($value[Appointments::date_of_accessing_service])->format(MONTH_YEAR);
            }

            $appointments->push($temp);
        }

        if ($request->filled('export'))
            return new SelfAppointments($appointments->all());
        if ($roleName == VN_USER_PERMISSION) {
            $total = $dataHolder['count'];
        } else {
            if ($roleName == PO_PERMISSION && !$setVn) {
                if (!$filter) {
                    $total = $poDataHolder['count'];
                }
            }
        }

        if ($setVn) {
            if ($filter) {
                $total = $dataHolder['count'];
            } else {
                $total = $dataHolder['count'];
            }
        }
        if ($roleName == SUPER_ADMIN && !$setVn) {
            $total = $dataholder['count'];
        }
        $json_data = array(
            "draw" => intval($request->draw),
            "recordsTotal" => $total,
            "recordsFiltered" => $total,
            "data" => $appointments->all()
        );

        echo json_encode($json_data);
        exit;
    }
    public static function getAppointmentByID(Request $request, $id)
    {
        $appointment = Appointments::find($id);
        $states = StateMaster::orderBy('state_name')->pluck('state_name', 'id');

        return view('self.admin.appointment-edit', compact('states'))
            ->with('appointment', $appointment)
            ->with('OUTCOME', self::OUTCOME)
            ->with('REASON_FOR_NOT_ACCESSING', self::REASON_FOR_NOT_ACCESSING);
    }
    public static function updateAppointment(Appointment $request)
    {
        Appointments::updateAppointment($request);

        flash('Appointment updated!')->success();
        return redirect()->back();
    }
    public static function getAnalytics()
    {
        $positive = Appointments::select(Appointments::appointment_id)
            ->where(Appointments::outcome_of_the_service_sought, 1)
            ->whereNotNull(Appointments::date_of_accessing_service)
            ->whereNotNull(Appointments::treated_center_id)
            ->whereNotNull(Appointments::pid_provided_at_the_service_center)
            ->where(Appointments::type_of_test, 2)
            ->whereJsonContains(Appointments::services, "1")
            ->count();

        $negative = Appointments::select(Appointments::appointment_id)
            ->where(Appointments::outcome_of_the_service_sought, 2)
            ->count();

        $notdisclosed = Appointments::select(Appointments::appointment_id)
            ->where(Appointments::outcome_of_the_service_sought, 3)
            ->count();

        $withevidence = Appointments::select(Appointments::appointment_id)
            ->whereNotNull(Appointments::evidence_path)
            ->count();

        $withoutevidence = Appointments::select(Appointments::appointment_id)
            ->whereNull(Appointments::evidence_path)
            ->count();

        return view('self.admin.analytics', compact('positive', 'negative', 'notdisclosed', 'withevidence', 'withoutevidence'));
    }
    public static function getAppointmentListByService(Request $request)
    {
        $data = Appointments::select("*")
            ->with('vn_details', 'assessment', 'state', 'district', 'center');

        if ($request->input('type') == 'service')
            $data = $data->where(Appointments::outcome_of_the_service_sought, $request->integer('data'))->whereNotNull(Appointments::date_of_accessing_service)
                ->whereNotNull(Appointments::treated_center_id)
                ->whereNotNull(Appointments::pid_provided_at_the_service_center)
                ->where(Appointments::type_of_test, 2)
                ->whereJsonContains(Appointments::services, "1");
        else
            $data = $request->boolean('data') ? $data->whereNotNull(Appointments::evidence_path) : $data->whereNull(Appointments::evidence_path);

        $total = $data->count();

        $data = $data->skip($request->integer('start', 0))->take($request->integer('length', 10))->get();

        $data = $data->toArray();

        $count = 0;

        $appointment = collect()->make();

        foreach ($data as $value) {
            $appointment->push([
                'sr_no' => ++$count,
                Appointments::uid => $value[Appointments::uid],
                'vn_name' => !empty($value['vn_details']) ? $value['vn_details']['name'] : '',
                Appointments::appointment_id => $value[Appointments::appointment_id],
                RiskAssessment::risk_score => !empty($value['assessment']) ? $value['assessment'][RiskAssessment::risk_score] : 0,
                Appointments::full_name => $value[Appointments::full_name],
                Appointments::mobile_no => $value[Appointments::mobile_no],
                Appointments::services => $value[Appointments::service_list],
                Appointments::type_of_test => is_null($value[Appointments::type_of_test]) ? null : ($value[Appointments::type_of_test] == 1 ? "Screening" : "Confirmatory"),
                Appointments::treated_state_id => is_null($value[Appointments::treated_state_id]) ? null : StateMaster::getOneStateName($value[Appointments::treated_state_id]),
                Appointments::treated_district_id => is_null($value[Appointments::treated_district_id]) ? null : DistrictMaster::getOneDistrictName($value[Appointments::treated_district_id]),
                Appointments::treated_center_id => is_null($value[Appointments::treated_center_id]) ? null : CentreMaster::getOneCentreName($value[Appointments::treated_center_id]),
                Appointments::remark => $value[Appointments::remark],
                Appointments::pre_art_no => is_null($value[Appointments::pre_art_no]) ? null : $value[Appointments::pre_art_no],
                Appointments::on_art_no => is_null($value[Appointments::on_art_no]) ? null : $value[Appointments::on_art_no]
            ]);
        }
        ;

        echo json_encode([
            "draw" => intval($request->draw),
            "recordsTotal" => $total,
            "recordsFiltered" => $total,
            "data" => $appointment->all()
        ]);

        exit;
    }
    public function updateNotificationStage(Request $request)
    {
        $stage = $request->notification_stage;
        $assessment = RiskAssessment::find($request->integer(RiskAssessment::risk_assessment_id));
        if (isset($stage)) {
            $assessment->notification_stage = $stage;
            $assessment->save();
        }
    }
}
