<?php

namespace App\Models\SelfModule;

use Illuminate\Support\Arr;
use App\Casts\Self\Appointment\ServiceList;
use App\Models\CentreMaster;
use App\Models\DistrictMaster;
use App\Models\StateMaster;
use App\Models\User;
use App\Models\VmMaster;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Appointments extends Model
{
    use HasFactory;

    const service_list = 'service_list';
    const self_appointment_book_master = 'self_appointment_book_master';
    const appointment_id = 'appointment_id';
    const assessment_id = 'assessment_id';
    const vn_id = 'vn_id';
    const state_id = 'state_id';
    const district_id = 'district_id';
    const center_id = 'center_id';
    const referral_no = 'referral_no';
    const uid = 'uid';
    const full_name = 'full_name';
    const mobile_no = 'mobile_no';
    const services = 'services';
    const appointment_date = 'appointment_date';
    const not_access_the_service_referred = 'not_access_the_service_referred';
    const date_of_accessing_service = 'date_of_accessing_service';
    const pid_provided_at_the_service_center = 'pid_provided_at_the_service_center';
    const outcome_of_the_service_sought = 'outcome_of_the_service_sought';
    const media_path = 'media_path';
    const treated_state_id = 'treated_state_id';
    const treated_district_id = 'treated_district_id';
    const treated_center_id = 'treated_center_id';
    const evidence_path = 'evidence_path';
    const evidence_path_2 = 'evidence_path_2';
    const evidence_path_3 = 'evidence_path_3';
    const evidence_path_4 = 'evidence_path_4';
    const evidence_path_5 = 'evidence_path_5';
    const pre_art_no = 'pre_art_no';
    const on_art_no = 'on_art_no';
    const type_of_test = 'type_of_test';
    const remark = 'remark';
    const created_at = 'created_at';
    const updated_by = 'updated_by';
    const updated_at = 'updated_at';

    // Table Details
    protected $table = self::self_appointment_book_master;
    protected $primaryKey = self::appointment_id;
    public $timestamps = false;

    // Fillable
    protected $fillable = [
        self::assessment_id,
        self::vn_id,
        self::state_id,
        self::district_id,
        self::center_id,
        self::referral_no,
        self::uid,
        self::full_name,
        self::mobile_no,
        self::services,
        self::appointment_date,
        self::not_access_the_service_referred,
        self::date_of_accessing_service,
        self::pid_provided_at_the_service_center,
        self::outcome_of_the_service_sought,
        self::media_path,
        self::treated_state_id,
        self::treated_district_id,
        self::treated_center_id,
        self::evidence_path,
        self::evidence_path_2,
        self::evidence_path_3,
        self::evidence_path_4,
        self::evidence_path_5,
        self::pre_art_no,
        self::on_art_no,
        self::type_of_test,
        self::remark,
        self::created_at,
        self::updated_by,
        self::updated_at
    ];

    // Cast
    protected $appends = [
        self::service_list
    ];

    // Cast
    protected $casts = [
        self::services => 'array',
        self::service_list => ServiceList::class,
        self::appointment_date => 'datetime:d M Y',
        self::updated_at => 'datetime:d M Y H:i a'
    ];

    protected function mediaPath(): Attribute
    {
        return Attribute::make(
            get: fn($value) => !empty($value) && mediaOperations($value, null, FL_CHECK_EXIST) ? mediaOperations($value, null, FL_GET_URL, MDT_STORAGE) : null
        );
    }
    // protected function evidencePath(): Attribute
    // {
    //     return Attribute::make(
    //         get: function ($value) {
    //             // Check if the value is valid JSON
    //             $isJson = $this->isValidJson($value);

    //             if ($isJson) {
    //                 // Decode the JSON and return the URL for each file if it exists
    //                 $decoded = json_decode($value, true);

    //                 if (is_array($decoded)) {
    //                     // Process multiple files
    //                     return array_map(function ($file) {
    //                         return mediaOperations($file, null, FL_CHECK_EXIST)
    //                             ? mediaOperations($file, null, FL_GET_URL, MDT_STORAGE)
    //                             : null;
    //                     }, $decoded);
    //                 }
    //             }

    //             // If not JSON, handle it as a single file
    //             return !empty($value) && mediaOperations($value, null, FL_CHECK_EXIST)
    //                 ? mediaOperations($value, null, FL_GET_URL, MDT_STORAGE)
    //                 : null;
    //         }
    //     );
    // }

    // Helper method to check if a string is valid JSON
    private function isValidJson($string): bool
    {
        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
    }

    // protected function evidencePath(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn($value) => !empty($value) && mediaOperations($value, null, FL_CHECK_EXIST) ? mediaOperations($value, null, FL_GET_URL, MDT_STORAGE) : null
    //     );
    // }

    public function vn_details()
    {
        return $this->belongsTo(VmMaster::class, self::vn_id);
    }

    public function assessment()
    {
        return $this->belongsTo(RiskAssessment::class, self::assessment_id, RiskAssessment::risk_assessment_id);
    }

    public function state()
    {
        return $this->belongsTo(StateMaster::class, self::state_id, 'id');
    }

    public function district()
    {
        return $this->belongsTo(DistrictMaster::class, self::district_id, 'id');
    }

    public function center()
    {
        return $this->belongsTo(CentreMaster::class, self::center_id, 'id');
    }

    public function treated_state()
    {
        return $this->belongsTo(StateMaster::class, self::treated_state_id, 'id');
    }

    public function treated_district()
    {
        return $this->belongsTo(DistrictMaster::class, self::treated_district_id, 'id');
    }

    public function treated_center()
    {
        return $this->belongsTo(CentreMaster::class, self::treated_center_id, 'id');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, self::updated_by, 'id');
    }


    // Set Request Parameters
    protected static function setRequest($self, $request)
    {
        $self->assessment_id = $request->input(self::assessment_id);
        if ($request->filled(self::vn_id)) $self->vn_id = $request->input(self::vn_id);
        $self->state_id = $request->input(self::state_id);
        $self->district_id = $request->input(self::district_id);
        $self->center_id = $request->input(self::center_id);
        $self->referral_no = $request->input(self::referral_no);
        $self->uid = $request->input(self::uid);
        $self->full_name = $request->input(self::full_name);
        $self->mobile_no = $request->input(self::mobile_no);
        $self->services = $request->input(self::services);
        $self->appointment_date = $request->input(self::appointment_date);
        $self->media_path = $request->input(self::media_path);
        $self->created_at = currentDateTime();

        return $self;
    }

    // Add OR Update Record
    public static function addOrUpdate($request)
    {
        $data = self::setRequest(new self, $request);

        if ($data) $data->save();

        return $data ? $data : null;
    }

    public static function updateAppointment($request)
    {
        $data = self::find($request->input(self::appointment_id));

        if ($data) {
            $data->not_access_the_service_referred = $request->input(self::not_access_the_service_referred);
            $data->date_of_accessing_service = $request->input(self::date_of_accessing_service);
            $data->pid_provided_at_the_service_center = $request->input(self::pid_provided_at_the_service_center);
            $data->outcome_of_the_service_sought = $request->input(self::outcome_of_the_service_sought);

            if ($request->filled(self::treated_state_id)) {
                $data->treated_state_id = $request->integer(self::treated_state_id);
            }
            if ($request->filled(self::treated_district_id)) {
                $data->treated_district_id = $request->integer(self::treated_district_id);
            }
            if ($request->filled(self::treated_center_id)) {
                $data->treated_center_id = $request->integer(self::treated_center_id);
            }


            if ($request->hasFile(self::evidence_path)) $data->evidence_path = mediaOperations(EVIDENCE_PATH, $request->file(self::evidence_path), FL_CREATE, MDT_STORAGE, STD_PUBLIC, getFileName() . DOT . $request->file(self::evidence_path)->getClientOriginalExtension());

            if ($request->hasFile(self::evidence_path_2)) $data->evidence_path_2 = mediaOperations(EVIDENCE_PATH, $request->file(self::evidence_path_2), FL_CREATE, MDT_STORAGE, STD_PUBLIC, getFileName() . DOT . $request->file(self::evidence_path_2)->getClientOriginalExtension());

            if ($request->hasFile(self::evidence_path_3)) $data->evidence_path_3 = mediaOperations(EVIDENCE_PATH, $request->file(self::evidence_path_3), FL_CREATE, MDT_STORAGE, STD_PUBLIC, getFileName() . DOT . $request->file(self::evidence_path_3)->getClientOriginalExtension());

            if ($request->hasFile(self::evidence_path_4)) $data->evidence_path_4 = mediaOperations(EVIDENCE_PATH, $request->file(self::evidence_path_4), FL_CREATE, MDT_STORAGE, STD_PUBLIC, getFileName() . DOT . $request->file(self::evidence_path_4)->getClientOriginalExtension());

            if ($request->hasFile(self::evidence_path_5)) $data->evidence_path_5 = mediaOperations(EVIDENCE_PATH, $request->file(self::evidence_path_5), FL_CREATE, MDT_STORAGE, STD_PUBLIC, getFileName() . DOT . $request->file(self::evidence_path_5)->getClientOriginalExtension());
            $data->remark = $request->input(self::remark);

            if ($request->filled(self::pre_art_no)) {
                $data->pre_art_no = $request->input(self::pre_art_no);
            }
            if ($request->filled(self::on_art_no)) {
                $data->on_art_no = $request->input(self::on_art_no);
            }
            if ($request->filled(self::type_of_test)) {
                $data->type_of_test = $request->integer(self::type_of_test);
            }
            if (Auth::check()) {
                $data->updated_by = Auth::id();
            }

            $data->updated_at = currentDateTime();
            $data->save();
        }

        return $data ? $data : null;
    }




    public static function getAllAppointmentsDashboard($request = null, $stateArr = null, $report_pos = 1)
    {
        $data = new self;


        $data = $data->with(['vn_details', 'assessment', 'state', 'district', 'center', 'updatedBy']);

        // $data = $data->orderByDesc(self::appointment_id)->get();


        if ($stateArr != null) {
            $data = $data->whereIn("state_id", $stateArr);
        }
        if ($report_pos == 4)
            $data = $data->where("outcome_of_the_service_sought", 1);
        if ($report_pos == 3)


            $data = $data->whereNotNull("outcome_of_the_service_sought")
                ->where("outcome_of_the_service_sought", '!=', 3);
        if ($report_pos == 9)
            $data = $data->where(function ($query) {
                $query->whereNull("outcome_of_the_service_sought")
                    ->orWhere("outcome_of_the_service_sought", 3);
            });

        if ($report_pos == 5)
            $data  = $data->whereDate('appointment_date', date('Y-m-d'));

        $count = $data->count();



        if (!$request->filled('export')) $data = $data->skip($request->integer('start', 0))->take($request->integer('length', 10));

        $data = $data->orderByDesc(self::appointment_id)->get();
        return ["data" => $data, "count" => $count];
    }
    public static function getAllAppointments($request, $isCount = false)
    {

        $data = new self;
        if ($request->filled(self::appointment_id)) {
            $data = $data->where(self::appointment_id, $request->integer(self::appointment_id));
        } {
            // if ($request->filled(self::vn_id)) $data = is_array($request->input(self::vn_id)) ? $data->whereIn(self::vn_id, $request->input(self::vn_id)) : $data->where(self::vn_id, $request->integer(self::vn_id));
            if ($request->filled(self::vn_id)) $data = is_array($request->input(self::vn_id)) ? $data->whereIn(self::vn_id, Arr::flatten($request->input(self::vn_id))) : $data->where(self::vn_id, $request->integer(self::vn_id));

            if ($request->filled(self::mobile_no)) $data = $data->where(self::mobile_no, 'like', '%' . $request->string(self::mobile_no)->trim() . '%');

            if ($request->filled(RiskAssessment::risk_score)) {
                $data = $data->whereHas('assessment', function ($query) use ($request) {
                    return $query->whereBetween(RiskAssessment::risk_score, explode('-', $request->string(RiskAssessment::risk_score)->trim()));
                });
            }

            if ($request->filled(Appointments::full_name)) $data = $data->where(DB::raw('LOWER(' . Appointments::full_name . ')'), 'like', '%' . strtolower($request->string(Appointments::full_name)->trim()) . '%');

            if ($request->filled(Appointments::services)) $data = $data->whereJsonContains(Appointments::services, $request->input(Appointments::services));

            if ($request->filled(Appointments::state_id)) $data = $data->orwhere(Appointments::state_id, $request->integer(Appointments::state_id));

            if ($request->filled(Appointments::district_id)) $data = $data->where(Appointments::district_id, $request->integer(Appointments::district_id));

            if ($request->filled(Appointments::center_id)) $data = $data->where(Appointments::center_id, $request->integer(Appointments::center_id));

            if ($request->filled('from') && $request->filled('to')) $data = $data->whereBetween(Appointments::appointment_date, [$request->date('from')->format('Y-m-d'), $request->date('to')->format('Y-m-d')]);
        }
        $count = $data->count();

        $data = $data->with(['vn_details', 'assessment', 'state', 'district', 'center', 'updatedBy']);

        if ($request->filled('type')) {
            if ($request->input('type') == 'service') $data = $data->where(Appointments::outcome_of_the_service_sought, $request->integer('data'));
            else $data = $request->boolean('data') ? $data->whereNotNull(Appointments::evidence_path) : $data->whereNull(Appointments::evidence_path);
        }
        if (!$request->filled('export')) $data = $data->skip($request->integer('start', 0))->take($request->integer('length', 10));

        $data = $data->orderByDesc(self::appointment_id)->get();
        return ["data" => $data, "count" => $count];
    }


    public static function getAllAppointmentsPo($request, $directLink = false)
    {
        $data = new self;
        if ($request->filled(self::appointment_id)) {
            $data = $data->where(self::appointment_id, $request->integer(self::appointment_id));
        } {


            if ($directLink) {
                $data =  $data->whereNull(self::vn_id);
            }
            if (!$directLink) {
                if ($request->filled(self::vn_id))
                    $data = is_array($request->input(self::vn_id)) ? $data->whereIn(self::vn_id, $request->input(self::vn_id)) : $data->where(self::vn_id, $request->integer(self::vn_id));
            }

            if ($request->filled(self::mobile_no)) $data = $data->where(self::mobile_no, 'like', '%' . $request->string(self::mobile_no)->trim() . '%');

            if ($request->filled(RiskAssessment::risk_score)) {
                $data = $data->whereHas('assessment', function ($query) use ($request) {
                    return $query->whereBetween(RiskAssessment::risk_score, explode('-', $request->string(RiskAssessment::risk_score)->trim()));
                });
            }

            if ($request->filled(Appointments::full_name)) $data = $data->where(DB::raw('LOWER(' . Appointments::full_name . ')'), 'like', '%' . strtolower($request->string(Appointments::full_name)->trim()) . '%');

            if ($request->filled(Appointments::services)) $data = $data->whereJsonContains(Appointments::services, $request->input(Appointments::services));


            // if ($directLink) {
            if ($request->filled(Appointments::state_id)) {
                if (is_array($request->input(Appointments::state_id))) {
                    $data = $data->whereIn(Appointments::state_id, $request->input(Appointments::state_id));
                } else {
                    $data = $data->where(Appointments::state_id, $request->input(Appointments::state_id));
                }
            }
            // }
            if ($request->filled(Appointments::district_id)) $data = $data->where(Appointments::district_id, $request->integer(Appointments::district_id));

            if ($request->filled(Appointments::center_id)) $data = $data->where(Appointments::center_id, $request->integer(Appointments::center_id));

            if ($request->filled('from') && $request->filled('to')) $data = $data->whereBetween(Appointments::appointment_date, [$request->date('from')->format('Y-m-d'), $request->date('to')->format('Y-m-d')]);



            if ($request->filled(Appointments::district_id)) {
                $data = $data->whereHas('appointment', function ($query) use ($request) {
                    return $query->where(Appointments::district_id, $request->integer(Appointments::district_id));
                });
            }

            if ($request->filled(Appointments::center_id)) {
                $data = $data->whereHas('appointment', function ($query) use ($request) {
                    return $query->where(Appointments::center_id, $request->integer(Appointments::center_id));
                });
            }

            if ($request->filled('from') && $request->filled('to')) {
                $data = $data->whereHas('appointment', function ($query) use ($request) {
                    return $query->whereBetween(Appointments::appointment_date, [$request->date('from')->format('Y-m-d'), $request->date('to')->format('Y-m-d')]);
                });
            }
        }

        $count = $data->count();

        $data = $data->with(['vn_details', 'assessment', 'state', 'district', 'center', 'updatedBy']);


        if ($request->filled('type')) {
            if ($request->input('type') == 'service') $data = $data->where(Appointments::outcome_of_the_service_sought, $request->integer('data'));
            else $data = $request->boolean('data') ? $data->whereNotNull(Appointments::evidence_path) : $data->whereNull(Appointments::evidence_path);
        }

        if (!$request->filled('export')) $data = $data->skip($request->integer('start', 0))->take($request->integer('length', 10));

        $data = $data->get();

        return ["data" => $data, "count" => $count];
    }






    public static function getAllPodata($request, $poId, $vn_id, $state_id, $export)
    {
        $porefHolder = Appointments::getPoReferrals($poId);
        $poRef = $porefHolder['data'];
        $vnRawHolder = Appointments::getAllVnData($vn_id, $state_id, $export, $request, true);
        $vnRawData = $vnRawHolder['data'];
        $data = $poRef->merge($vnRawData);
        $count = $porefHolder['count'] + $vnRawHolder['count'];
        if (!$export) {
            $data = $data->slice($request->integer('start', 0), $request->integer('length', 10))->values();
        }
        return ["data" => $data->sortByDesc('created_at'), "count" => $count];
    }
    public static function getPoReferrals($poId)
    {

        $data = new self;
        if ($poId)
            $data = is_array($poId) ? $data->whereIn(self::vn_id, $poId) : $data->where(self::vn_id, $poId);
        else
            return;
        $count = $data->count();
        $data = $data->with(['vn_details', 'assessment', 'state', 'district', 'center', 'updatedBy']);
        $data = $data->orderByDesc(self::appointment_id)->get();
        return ["data" => $data, "count" => $count];
    }









    public static function getVnDataByfilters($vn_id, $state_id, $export = false, $request)
    {
        $rawData = Appointments::getAllVnData($vn_id, $state_id, $export, $request, true);
        $data = $rawData['data'];


        $filteredData = $data->filter(function ($item) use ($request) {
            $matches = true;
            // Filter based on mobile number
            if ($request->filled(self::appointment_id)) {
                $matches = $matches && (strpos($item->appointment_id, $request->string(self::appointment_id)->trim()) !== false);
            }
            if ($request->filled(self::mobile_no)) {
                $matches = $matches && (strpos($item->mobile_no, $request->string(self::mobile_no)->trim()) !== false);
            }

            // Filter based on risk score range
            if ($request->filled(RiskAssessment::risk_score)) {
                $range = json_decode(json_encode(explode('-', $request->string(RiskAssessment::risk_score)->trim())), true);
                if (isset($item->assessment))
                    $matches = $matches && ($item->assessment->risk_score >= $range[0] && $item->assessment->risk_score <= $range[1]);
                else
                    $matches = false;
            }

            // Filter based on date range
            if ($request->filled('from') && $request->filled('to')) {
                $from = $request->date('from')->format('Y-m-d');
                $to = $request->date('to')->format('Y-m-d');
                $matches = $matches && ($item->created_at >= $from && $item->created_at <= $to);
            }

            // Extra filter: Type-based filter for service or evidence path
            if ($request->filled('type')) {
                if ($request->input('type') == 'service') {
                    $matches = $matches && ($item->outcome_of_the_service_sought == $request->integer('data'));
                } else {
                    $matches = $matches && ($request->boolean('data')
                        ? !is_null($item->evidence_path)
                        : is_null($item->evidence_path));
                }
            }

            // Filters related to appointment
            if (isset($item)) {
                if ($request->filled(Appointments::full_name)) {
                    $matches = $matches && (stripos($item->full_name, $request->string(Appointments::full_name)->trim()) !== false);
                }
                if ($request->filled(Appointments::services)) {
                    $matches = $matches && in_array($request->input(Appointments::services), $item->services);
                }
                if ($request->filled(Appointments::state_id)) {
                    if (is_array($request->input(Appointments::state_id))) {
                        $matches = $matches && in_array($item->state_id, $request->input(Appointments::state_id));
                    } else {
                        $matches = $matches && ($item->state_id == $request->integer(Appointments::state_id));
                    }
                }
                if ($request->filled(Appointments::district_id)) {
                    $matches = $matches && ($item->district_id == $request->integer(Appointments::district_id));
                }
                if ($request->filled(Appointments::center_id)) {
                    $matches = $matches && ($item->center_id == $request->integer(Appointments::center_id));
                }
                if ($request->filled('from') && $request->filled('to')) {
                    $from = $request->date('from')->format('Y-m-d');
                    $to = $request->date('to')->format('Y-m-d');
                    $matches = $matches && ($item->appointment_date >= $from && $item->appointment_date <= $to);
                }
            } else {
                $matches = false;
            }

            return $matches;
        });
        if (!$export) {
            $data = $filteredData->slice($request->integer('start', 0), $request->integer('length', 10))->values();
        }
        return [
            "data" => $data,
            "count" => $filteredData->count()
        ];
    }
    public static function getAllVnData($vn_id, $state_id, $export, $request, $raw)
    {
        $dataByIdHolder = Appointments::getVnEntriesById($vn_id);
        $dataById = $dataByIdHolder['data'];
        $dataByNullHolder = Appointments::getVnDirectEntries($state_id);
        $dataByNull = $dataByNullHolder['data'];
        $data = $dataById->merge($dataByNull);
        $count = $dataByIdHolder['count'] + $dataByNullHolder['count'];
        $data = $data->sortByDesc('appointment_id');
        if ($raw) {
            return ["data" => $data->sortByDesc('appointment_id'), "count" => $count];
        }
        if (!$export) {
            $data = $data->slice($request->integer('start', 0), $request->integer('length', 10))->values();
        }
        return ["data" => $data->sortByDesc('appointment_id'), "count" => $count];
    }
    public static function getVnEntriesById($vn_id)
    {
        $data = new self;
        $data = is_array($vn_id) ? $data->whereIn(self::vn_id, $vn_id) : $data->where(self::vn_id, $vn_id);
        $count = $data->count();
        $data = $data->with(['vn_details', 'assessment', 'state', 'district', 'center', 'updatedBy']);
        $data = $data->orderByDesc(self::appointment_id)->get();
        return ["data" => $data, "count" => $count];
    }
    public static function getVnDirectEntries($state_id)
    {
        $data = new self;
        $data =  $data->whereNull(self::vn_id);
        if (is_array($state_id)) {
            $data = $data->whereIn(Appointments::state_id, $state_id);
        } else {
            $data = $data->where(Appointments::state_id, $state_id);
        }
        $count = $data->count();
        $data = $data->with(['vn_details', 'assessment', 'state', 'district', 'center', 'updatedBy']);

        $data = $data->orderByDesc(self::appointment_id)->get();
        return ["data" => $data, "count" => $count];
    }
}
