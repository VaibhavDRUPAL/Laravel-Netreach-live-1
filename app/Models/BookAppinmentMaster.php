<?php

namespace App\Models;

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
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Illuminate\Database\Eloquent\Model;

class BookAppinmentMaster extends Model
{
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
    const user_id = 'user_id';
    const netreach_uid_number = 'netreach_uid_number';
    const other_service_type = 'other_service_type';
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
    const pid_or_other_unique_id_of_the_service_center = 'pid_or_other_unique_id_of_the_service_center';
    const outcome_of_the_service_sought = 'outcome_of_the_service_sought';
    const reason_id = 'reason_id';
    const other_not_access = 'other_not_access';
    const follow_up_date = 'follow_up_date';
    const remarks = 'remarks';
    const status = 'status';
    const created_at = 'created_at';
    protected $table = 'book_appinment_master';

    protected $fillable = [
        "user_id",
        "state_id",
        "survey_id",
        "district_id",
        "survey_unique_ids",
        "e_referral_no",
        "center_ids",
        "search_by",
        "pincode",
        "appoint_date",
        "created_at",
        "updated_at",
        'date_of_accessing_service',
        'access_service',
        'applicable_for_hiv_test',
        'client_type_id',
        'service_type_id',
        'counselling_service',
        'prevention_programme',
        'status',
        'sti_service_id',
        'other_sti_service',
        'pid_or_other_unique_id_of_the_service_center',
        'outcome_of_the_service_sought',
        'reason_id',
        'other_not_access',
        'follow_up_date',
        'remarks',
        'educational_attainment_id',
        'occupation_id',
    ];


    public function client_type(): BelongsTo
    {
        return $this->belongsTo(ClientType::class, self::client_type_id, ClientType::client_type_id);
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
}
