<?php

namespace App\Models\Outreach;

use App\Models\CentreMaster;
use App\Models\ClientType;
use App\Models\DistrictMaster;
use App\Models\EducationalAttainment;
use App\Models\Occupation;
use App\Models\ReasonForNotAccessingService;
use App\Models\ServiceType;
use App\Models\StateMaster;
use App\Models\STIService;
use App\Models\TIService;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;

class ReferralService extends Model
{
    use HasFactory;

    const referred_state = 'referred_state';
    const test_centre_state = 'test_centre_state';
    const referred_district = 'referred_district';
    const test_centre_district = 'test_centre_district';
    const outreach_referral_service = 'outreach_referral_service';
    const referral_service_id = 'referral_service_id';
    const profile_id = 'profile_id';
    const client_type_id = 'client_type_id';
    const educational_attainment_id = 'educational_attainment_id';
    const occupation_id = 'occupation_id';
    const ti_service_id = 'ti_service_id';
    const service_type_id = 'service_type_id';
    const other_service_type = 'other_service_type';
    const user_id = 'user_id';
    const netreach_uid_number = 'netreach_uid_number';
    const client_name = 'client_name';
    const provided_client_with_information_bcc = 'provided_client_with_information_bcc';
    const bcc_provided = 'bcc_provided';
    const other_services = 'other_services';
    const other_ti_services = 'other_ti_services';
    const other_referred_service = 'other_referred_service';
    const counselling_service = 'counselling_service';
    const prevention_programme = 'prevention_programme';
    const type_of_facility_where_referred = 'type_of_facility_where_referred';
    const name_of_different_center = 'name_of_different_center';
    const referral_date = 'referral_date';
    const referred_district_id = 'referred_district_id';
    const referred_state_id = 'referred_state_id';
    const referral_center_id = 'referral_center_id';
    const type_of_facility_where_tested = 'type_of_facility_where_tested';
    const access_service = 'access_service';
    const service_accessed = 'service_accessed';
    const service_accessed_center_id = 'service_accessed_center_id';
    const client_access_service = 'client_access_service';
    const test_centre_district_id = 'test_centre_district_id';
    const test_centre_state_id = 'test_centre_state_id';
    const date_of_accessing_service = 'date_of_accessing_service';
    const applicable_for_hiv_test = 'applicable_for_hiv_test';
    const sti_service_id = 'sti_service_id';
    const other_sti_service = 'other_sti_service';
    const reason_id = 'reason_id';
    const others_target_population = 'others_target_population';
    const follow_up_date = 'follow_up_date';
    const status = 'status';
    const is_deleted = 'is_deleted';
    const age_client = "age_client";
    const target_id = "target_id";
    const is_active = "is_active";
    const pre_art_no = "pre_art_no";
    const on_art_no = "on_art_no";
    const media_path = 'media_path';

    const evidence_path = 'evidence_path';
    const evidence_path_2 = 'evidence_path_2';
    const evidence_path_3 = 'evidence_path_3';
    const evidence_path_4 = 'evidence_path_4';
    const evidence_path_5 = 'evidence_path_5';
    const pid_or_other_unique_id_of_the_service_center = 'pid_or_other_unique_id_of_the_service_center';
    const type_of_test = 'type_of_test';
    const outcome_of_the_service_sought = 'outcome_of_the_service_sought';
    const remarks = 'remarks';
    const created_at = 'created_at';
    const updated_at = 'updated_at';



    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = self::outreach_referral_service;
    protected $primaryKey = self::referral_service_id;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;


    protected $fillable = [
        self::profile_id,
        self::client_type_id,
        self::educational_attainment_id,
        self::occupation_id,
        self::ti_service_id,
        self::service_type_id,
        self::other_service_type,
        self::user_id,
        self::netreach_uid_number,
        self::client_name,
        self::other_service_type,
        self::provided_client_with_information_bcc,
        self::bcc_provided,
        self::other_services,
        self::other_ti_services,
        self::other_referred_service,
        self::counselling_service,
        self::prevention_programme,
        self::type_of_facility_where_referred,
        self::name_of_different_center,
        self::referral_date,
        self::referred_district_id,
        self::referred_state_id,
        self::referral_center_id,
        self::type_of_facility_where_tested,
        self::access_service,
        self::service_accessed,
        self::service_accessed_center_id,
        self::client_access_service,
        self::test_centre_district_id,
        self::test_centre_state_id,
        self::date_of_accessing_service,
        self::applicable_for_hiv_test,
        self::sti_service_id,
        self::other_sti_service,
        self::reason_id,
        self::others_target_population,
        self::follow_up_date,
        self::status,
        self::created_at,
        self::is_deleted,
        self::age_client,
        self::target_id,
        self::is_active,
        self::pre_art_no,
        self::on_art_no,
        self::media_path,
        self::evidence_path,
        self::evidence_path_2,
        self::evidence_path_3,
        self::evidence_path_4,
        self::evidence_path_5,
        self::pid_or_other_unique_id_of_the_service_center,
        self::type_of_test,
        self::outcome_of_the_service_sought,
        self::remarks,
    ];

    protected function mediaPath(): Attribute
    {
        return Attribute::make(
            get: fn($value) => !empty($value) && mediaOperations($value, null, FL_CHECK_EXIST) ? mediaOperations($value, null, FL_GET_URL, MDT_STORAGE) : null
        );
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, self::user_id);
    }

    public function client_type(): BelongsTo
    {
        return $this->belongsTo(ClientType::class, self::client_type_id, ClientType::client_type_id);
    }

    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class, self::profile_id, Profile::profile_id);
    }

    public function educational_attainment(): BelongsTo
    {
        return $this->belongsTo(EducationalAttainment::class, self::educational_attainment_id, EducationalAttainment::educational_attainment_id);
    }

    public function occupation(): BelongsTo
    {
        return $this->belongsTo(Occupation::class, self::occupation_id, Occupation::occupation_id);
    }

    public function ti_service(): BelongsTo
    {
        return $this->belongsTo(TIService::class, self::ti_service_id, TIService::ti_service_id);
    }

    public function service_type(): BelongsTo
    {
        return $this->belongsTo(ServiceType::class, self::service_type_id, ServiceType::service_type_id);
    }

    public function referred_district(): BelongsTo
    {
        return $this->belongsTo(DistrictMaster::class, self::referred_district_id);
    }

    public function referred_state(): BelongsTo
    {
        return $this->belongsTo(StateMaster::class, self::referred_state_id);
    }

    public function referral_center(): BelongsTo
    {
        return $this->belongsTo(CentreMaster::class, self::referral_center_id);
    }

    public function service_accessed_center(): BelongsTo
    {
        return $this->belongsTo(CentreMaster::class, self::service_accessed_center_id);
    }

    public function test_centre_district(): BelongsTo
    {
        return $this->belongsTo(DistrictMaster::class, self::test_centre_district_id);
    }

    public function test_centre_state(): BelongsTo
    {
        return $this->belongsTo(StateMaster::class, self::test_centre_state_id);
    }

    public function sti(): BelongsTo
    {
        return $this->belongsTo(STIService::class, self::sti_service_id, STIService::sti_service_id);
    }

    public function reason(): BelongsTo
    {
        return $this->belongsTo(ReasonForNotAccessingService::class, self::reason_id, ReasonForNotAccessingService::reason_id);
    }
    public static function getOutcomeOfTheServiceSought($id)
    {
        if ($id == 1) {
            return "Reactive";
        } elseif ($id == 2) {
            return "Non-reactive";
        } elseif ($id == 3) {
            return "Not Disclosed";
        } else {
            return "-";
        }
    }
    public static function getTypeOfTest($id)
    {
        if ($id == 1) {
            return "Screening Test";
        } elseif ($id == 2) {
            return "Confirmatory Test";
        } else {
            return "-";
        }
    }
}
