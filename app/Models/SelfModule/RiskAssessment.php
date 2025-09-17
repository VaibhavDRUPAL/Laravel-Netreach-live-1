<?php

namespace App\Models\SelfModule;

use App\Models\StateMaster;
use App\Models\VmMaster;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RiskAssessment extends Model
{
    use HasFactory;

    const self_risk_assessment_master = 'self_risk_assessment_master';
    const risk_assessment_id = 'risk_assessment_id';
    const vn_id = 'vn_id';
    const state_id = 'state_id';
    const unique_id = 'unique_id';
    const mobile_no = 'mobile_no';
    const risk_score = 'risk_score';
    const raw_answer_sheet = 'raw_answer_sheet';
    const user_notification = 'user_notification';
    const notification_stage = 'notification_stage';
    const last_msg_sent = 'last_msg_sent';
    const last_msg_sent_count = 'last_msg_sent_count';
    const created_at = 'created_at';
    const meet_id = 'meet_id';

    // Table Details
    protected $table = self::self_risk_assessment_master;
    protected $primaryKey = self::risk_assessment_id;
    public $timestamps = false;

    // Fillable
    protected $fillable = [
        self::vn_id,
        self::state_id,
        self::unique_id,
        self::mobile_no,
        self::risk_score,
        self::raw_answer_sheet,
        self::user_notification,
        self::notification_stage,
        self::last_msg_sent,
        self::last_msg_sent_count,
        self::meet_id
    ];

    // Casts
    protected $casts = [
        self::raw_answer_sheet => 'array'
    ];

    public function vn_details()
    {
        return $this->belongsTo(VmMaster::class, self::vn_id);
    }

    public function items()
    {
        return $this->hasMany(RiskAssessmentItems::class, RiskAssessmentItems::risk_assessment_id, self::risk_assessment_id);
    }

    public function state()
    {
        return $this->belongsTo(StateMaster::class, self::state_id, 'id');
    }

    public function appointment()
    {
        return $this->hasOne(Appointments::class, Appointments::assessment_id, self::risk_assessment_id);
    }

    // Set Request Parameters
    protected static function setRequest($self, $request)
    {
        if (isset($request[self::vn_id]))
        $self->vn_id = $request[self::vn_id];
        $self->state_id = $request[self::state_id];
        $self->mobile_no = $request[self::mobile_no];
        $self->risk_score = $request[self::risk_score];
        $self->unique_id = $request[self::unique_id];
        $self->raw_answer_sheet = $request[self::raw_answer_sheet];
        $self->user_notification = $request[self::user_notification];
        $self->notification_stage = $request[self::notification_stage];
        $self->last_msg_sent = $request[self::last_msg_sent];
        $self->meet_id = $request[self::meet_id];
        // $self->last_msg_sent_count = $request[self::last_msg_sent_count];
        $self->created_at = currentDateTime();

        return $self;
    }

    // Add OR Update Record
    public static function addOrUpdate($request)
    {
        $data = self::setRequest(new self, $request);

        if ($data)
            $data->save();

        return $data ? $data : null;
    }

    // Get all Risk Assessments

    public static function getAllRiskAssessmentsBACKUP($request, $isCount = false)
    {
        $data = new self;

        if ($request->filled(self::vn_id))
            $data = is_array($request->input(self::vn_id)) ? $data->where(self::vn_id, $request->input(self::vn_id)) : $data->where(self::vn_id, $request->integer(self::vn_id));

        if ($request->filled(self::mobile_no))
            $data = $data->where(self::mobile_no, 'like', '%' . $request->string(self::mobile_no)->trim() . '%');

        if ($request->filled(self::risk_score)) {
            $data = $data->whereBetween(self::risk_score, json_decode(json_encode(explode('-', $request->string(self::risk_score)->trim()), JSON_NUMERIC_CHECK)));
        }

        if ($request->filled('from') && $request->filled('to'))
            $data = $data->whereBetween(self::created_at, [$request->date('from')->format('Y-m-d'), $request->date('to')->format('Y-m-d')]);

        if ($request->filled(Appointments::full_name)) {
            $data = $data->whereHas('appointment', function ($query) use ($request) {
                return $query->where(DB::raw('LOWER(' . Appointments::full_name . ')'), 'like', '%' . strtolower($request->string(Appointments::full_name)->trim()) . '%');
            });
        }

        if ($request->filled(Appointments::services)) {
            $data = $data->whereHas('appointment', function ($query) use ($request) {
                return $query->whereJsonContains(Appointments::services, $request->input(Appointments::services));
            });
        }

        if ($request->filled(Appointments::state_id)) {
            if (is_array($request->input(Appointments::state_id))) {
                $data = $data->orwhereHas('appointment', function ($query) use ($request) {
                    return $query->whereIn(Appointments::state_id, $request->input(Appointments::state_id));
                });
            } else {
                $data = $data->whereHas('appointment', function ($query) use ($request) {
                    return $query->where(Appointments::state_id, $request->integer(Appointments::state_id));
                });
            }
        }

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

        if ($isCount) {
            return $data->count();
        }

        $data = $data->with(
            [
                'items' => function ($query) {
                    return $query->with(['question', 'answer']);
                },
                'state',
                'vn_details',
                'appointment' => function ($query) {
                    return $query->with(
                        [
                            'vn_details',
                            'state',
                            'district',
                            'center',
                        ]
                    );
                }
            ]
        )->withExists('appointment');

        if (!$request->filled('export'))
            $data = $data->skip($request->integer('start', 0))->take($request->integer('length', 10));

        $data = $data->orderByDesc(self::risk_assessment_id)->get();

        return $data;
    }
    public static function getAllRiskAssessments($request, $isCount = false)
    {
        $data = new self;
        if ($request->filled(self::risk_assessment_id)) {
            $data = $data->where(self::risk_assessment_id, $request->integer(self::risk_assessment_id));
        } {
            if ($request->filled(self::vn_id))
                $data = is_array($request->input(self::vn_id)) ? $data->where(self::vn_id, $request->input(self::vn_id)) : $data->where(self::vn_id, $request->integer(self::vn_id));

            if ($request->filled(self::mobile_no))
                $data = $data->where(self::mobile_no, 'like', '%' . $request->string(self::mobile_no)->trim() . '%');

            if ($request->filled(self::risk_score)) {
                $data = $data->whereBetween(self::risk_score, json_decode(json_encode(explode('-', $request->string(self::risk_score)->trim()), JSON_NUMERIC_CHECK)));
            }

            if ($request->filled('from') && $request->filled('to'))
                $data = $data->whereBetween(self::created_at, [$request->date('from')->format('Y-m-d'), $request->date('to')->format('Y-m-d')]);

            if ($request->filled(Appointments::full_name)) {
                $data = $data->whereHas('appointment', function ($query) use ($request) {
                    return $query->where(DB::raw('LOWER(' . Appointments::full_name . ')'), 'like', '%' . strtolower($request->string(Appointments::full_name)->trim()) . '%');
                });
            }

            if ($request->filled(Appointments::services)) {
                $data = $data->whereHas('appointment', function ($query) use ($request) {
                    return $query->whereJsonContains(Appointments::services, $request->input(Appointments::services));
                });
            }

            if ($request->filled(Appointments::state_id)) {
                if (is_array($request->input(Appointments::state_id))) {
                    $data = $data->orwhereHas('appointment', function ($query) use ($request) {
                        return $query->whereIn(Appointments::state_id, $request->input(Appointments::state_id));
                    });
                } else {
                    $data = $data->whereHas('appointment', function ($query) use ($request) {
                        return $query->where(Appointments::state_id, $request->integer(Appointments::state_id));
                    });
                }
            }

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
        if ($isCount) {
            return $data->count();
        }

        $data = $data->with(
            [
                'items' => function ($query) {
                    return $query->with(['question', 'answer']);
                },
                'state',
                'vn_details',
                'appointment' => function ($query) {
                    return $query->with(
                        [
                            'vn_details',
                            'state',
                            'district',
                            'center',
                        ]
                    );
                }
            ]
        )->withExists('appointment');

        if (!$request->filled('export'))
            $data = $data->skip($request->integer('start', 0))->take($request->integer('length', 10));

        $data = $data->orderByDesc(self::risk_assessment_id)->get();

        return $data;
    }

    public static function getAllRiskAssessmentsPo($request, $directLink = false)
    {

        $data = new self;
        if ($request->filled(self::risk_assessment_id)) {
            $data = $data->where(self::risk_assessment_id, $request->integer(self::risk_assessment_id));
        } {


            if ($directLink) {
                $data =  $data->whereNull(self::vn_id);
            }
            if (!$directLink) {
                if ($request->filled(self::vn_id))
                    $data = is_array($request->input(self::vn_id)) ? $data->whereIn(self::vn_id, $request->input(self::vn_id)) : $data->where(self::vn_id, $request->integer(self::vn_id));
            }
            if ($request->filled(self::mobile_no))
                $data = $data->where(self::mobile_no, 'like', '%' . $request->string(self::mobile_no)->trim() . '%');

            if ($request->filled(self::risk_score)) {
                $data = $data->whereBetween(self::risk_score, json_decode(json_encode(explode('-', $request->string(self::risk_score)->trim()), JSON_NUMERIC_CHECK)));
            }

            if ($request->filled('from') && $request->filled('to'))
                $data = $data->whereBetween(self::created_at, [$request->date('from')->format('Y-m-d'), $request->date('to')->format('Y-m-d')]);

            if ($request->filled(Appointments::full_name)) {
                $data = $data->whereHas('appointment', function ($query) use ($request) {
                    return $query->where(DB::raw('LOWER(' . Appointments::full_name . ')'), 'like', '%' . strtolower($request->string(Appointments::full_name)->trim()) . '%');
                });
            }

            if ($request->filled(Appointments::services)) {
                $data = $data->whereHas('appointment', function ($query) use ($request) {
                    return $query->whereJsonContains(Appointments::services, $request->input(Appointments::services));
                });
            }


            // if ($directLink) {
            if ($request->filled(Appointments::state_id)) {
                if (is_array($request->input(Appointments::state_id))) {
                    $data = $data->whereHas('appointment', function ($query) use ($request) {
                        return $query->whereIn(Appointments::state_id, $request->input(Appointments::state_id));
                    });
                } else {
                    $data = $data->whereHas('appointment', function ($query) use ($request) {
                        return $query->where(Appointments::state_id, $request->integer(Appointments::state_id));
                    });
                }
            }
            // }

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

        $data = $data->with(
            [
                'items' => function ($query) {
                    return $query->with(['question', 'answer']);
                },
                'state',
                'vn_details',
                'appointment' => function ($query) {
                    return $query->with(
                        [
                            'vn_details',
                            'state',
                            'district',
                            'center',
                        ]
                    );
                }
            ]
        )->withExists('appointment');

        if (!$request->filled('export'))
            $data = $data->skip($request->integer('start', 0))->take($request->integer('length', 10));

        $data = $data->orderByDesc(self::risk_assessment_id)->get();

        return ["data" => $data, "count" => $count];
    }
    public static function getAllPodata($request, $poId, $vn_id, $state_id, $export)
    {
        $porefHolder = RiskAssessment::getPoReferrals($poId);
        $poRef = $porefHolder['data'];
        $vnRawHolder = RiskAssessment::getAllVnData($vn_id, $state_id, $export, $request, true);
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
        $data = $data->with(
            [
                'items' => function ($query) {
                    return $query->with(['question', 'answer']);
                },
                'state',
                'vn_details',
                'appointment' => function ($query) {
                    return $query->with(
                        [
                            'vn_details',
                            'state',
                            'district',
                            'center',
                        ]
                    );
                }
            ]
        )->withExists('appointment');
        $data = $data->orderByDesc(self::risk_assessment_id)->get();
        return ["data" => $data, "count" => $count];
    }

    public static function getVnDataByfilters($vn_id, $state_id, $export = false, $request)
    {
        $rawData = RiskAssessment::getAllVnData($vn_id, $state_id, $export, $request, true);
        $data = $rawData['data'];
        $filteredData = $data->filter(function ($item) use ($request) {
            $matches = true;
            if (isset($item->appointment)) {
                if ($request->filled(Appointments::full_name)) {
                    $matches = $matches && (stripos($item->appointment->full_name, $request->string(Appointments::full_name)->trim()) !== false);
                }
                if ($request->filled(Appointments::services)) {
                    $matches = $matches && in_array($request->input(Appointments::services), $item->appointment->services);
                }
                if ($request->filled(Appointments::state_id)) {
                    if (is_array($request->input(Appointments::state_id))) {
                        $matches = $matches && in_array($item->appointment->state_id, $request->input(Appointments::state_id));
                    } else {
                        $matches = $matches && ($item->appointment->state_id == $request->integer(Appointments::state_id));
                    }
                }
                if ($request->filled(Appointments::district_id)) {
                    $matches = $matches && ($item->appointment->district_id == $request->integer(Appointments::district_id));
                }
                if ($request->filled(Appointments::center_id)) {
                    $matches = $matches && ($item->appointment->center_id == $request->integer(Appointments::center_id));
                }
            } else {
                if ($request->filled(self::risk_assessment_id) || $request->filled(self::mobile_no) || $request->filled(self::risk_score) || $request->filled('from') || $request->filled('to'))
                    $matches = true;
                else
                    $matches = false;
            }

            if ($request->filled(self::risk_assessment_id)) {
                $matches = $matches && (strpos($item->risk_assessment_id, $request->string(self::risk_assessment_id)->trim()) !== false);
            }
            if ($request->filled(self::mobile_no)) {
                $matches = $matches && (strpos($item->mobile_no, $request->string(self::mobile_no)->trim()) !== false);
            }

            if ($request->filled(self::risk_score)) {
                $range = json_decode(json_encode(explode('-', $request->string(self::risk_score)->trim())), true);
                $matches = $matches && ($item->risk_score >= $range[0] && $item->risk_score <= $range[1]);
            }
            if ($request->filled('from') && $request->filled('to')) {
                $from = $request->date('from')->format('Y-m-d');
                $to = $request->date('to')->format('Y-m-d');
                $matches = $matches && ($item->created_at >= $from && $item->created_at <= $to);
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
        $dataByIdHolder = RiskAssessment::getVnEntriesById($vn_id);
        $dataById = $dataByIdHolder['data'];
        $dataByNullHolder = RiskAssessment::getVnDirectEntries($state_id);
        $dataByNull = $dataByNullHolder['data'];
        $data = $dataById->merge($dataByNull);
        $count = $dataByIdHolder['count'] + $dataByNullHolder['count'];
        $data = $data->sortByDesc('risk_assessment_id');
        if ($raw) {
            return ["data" => $data->sortByDesc('risk_assessment_id'), "count" => $count];
        }
        if (!$export) {
            $data = $data->slice($request->integer('start', 0), $request->integer('length', 10))->values();
        }
        return ["data" => $data->sortByDesc('risk_assessment_id'), "count" => $count];
    }
    public static function getVnEntriesById($vn_id)
    {
        $data = new self;
        $data = is_array($vn_id) ? $data->whereIn(self::vn_id, $vn_id) : $data->where(self::vn_id, $vn_id);
        $count = $data->count();
        $data = $data->with(
            [
                'items' => function ($query) {
                    return $query->with(['question', 'answer']);
                },
                'state',
                'vn_details',
                'appointment' => function ($query) {
                    return $query->with(
                        [
                            'vn_details',
                            'state',
                            'district',
                            'center',
                        ]
                    );
                }
            ]
        )->withExists('appointment');
        $data = $data->orderByDesc(self::risk_assessment_id)->get();
        return ["data" => $data, "count" => $count];
    }
    public static function getVnDirectEntries($state_id)
    {
        // $state_id=$state_id->toArray();
        $data = new self;
        $data =  $data->whereNull(self::vn_id);
        if (is_array($state_id)) {
            $data = $data->whereHas('appointment', function ($query) use ($state_id) {
                return $query->whereIn(Appointments::state_id, $state_id);
            });
        } else {
            $data = $data->whereHas('appointment', function ($query) use ($state_id) {
                return $query->where(Appointments::state_id, $state_id);
            });
        }

        $count = $data->count();

        $data = $data->with(
            [
                'items' => function ($query) {
                    return $query->with(['question', 'answer']);
                },
                'state',
                'vn_details',
                'appointment' => function ($query) {
                    return $query->with(
                        [
                            'vn_details',
                            'state',
                            'district',
                            'center',
                        ]
                    );
                }
            ]
        )->withExists('appointment');
        $data = $data->orderByDesc(self::risk_assessment_id)->get();

        return ["data" => $data, "count" => $count];
    }
}
