<?php

namespace App\Models\Outreach;

use App\Models\CentreMaster;
use App\Models\ClientType;
use App\Models\DistrictMaster;
use App\Models\StateMaster;
use App\Models\STIService as ParentSTIService;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class STIService extends Model
{
    use HasFactory;

    const treated = 'treated';
    const outreach_sti_services = 'outreach_sti_services';
    const sti_services_id = 'sti_services_id';
    const profile_id = 'profile_id';
    const client_type_id = 'client_type_id';
    const referral_service_id = 'referral_service_id';
    const state_id = 'state_id';
    const district_id = 'district_id';
    const center_id = 'center_id';
    const user_id = 'user_id';
    const date_of_sti = 'date_of_sti';
    const pid_or_other_unique_id_of_the_service_center = 'pid_or_other_unique_id_of_the_service_center';
    const sti_service_id = 'sti_service_id';
    const type_facility_where_treated = 'type_facility_where_treated';
    const applicable_for_syphillis = 'applicable_for_syphillis';
    const other_sti_service = 'other_sti_service';
    const remarks = 'remarks';
    const is_treated = 'is_treated';
    const status = 'status';
    const created_at = 'created_at';
    const is_deleted = 'is_deleted';

    // Table Details
    protected $table = self::outreach_sti_services;
    protected $primaryKey = self::sti_services_id;
    public $timestamps = false;

    // Fillable
    protected $fillable = [
        self::profile_id,
        self::client_type_id,
        self::referral_service_id,
        self::state_id,
        self::district_id,
        self::center_id,
        self::user_id,
        self::date_of_sti,
        self::pid_or_other_unique_id_of_the_service_center,
        self::sti_service_id,
        self::type_facility_where_treated,
        self::applicable_for_syphillis,
        self::other_sti_service,
        self::remarks,
        self::is_treated,
        self::status,
        self::created_at,
        self::is_deleted
    ];
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, self::user_id);
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(DistrictMaster::class, self::district_id);
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(StateMaster::class, self::state_id);
    }

    public function client_type(): BelongsTo
    {
        return $this->belongsTo(ClientType::class, self::client_type_id, ClientType::client_type_id);
    }

    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class, self::profile_id, Profile::profile_id);
    }

    public function referral_service(): BelongsTo
    {
        return $this->belongsTo(ReferralService::class, self::referral_service_id, ReferralService::referral_service_id);
    }

    public function center(): BelongsTo
    {
        return $this->belongsTo(CentreMaster::class, self::center_id);
    }

    public function sti_service(): BelongsTo
    {
        return $this->belongsTo(ParentSTIService::class, self::sti_service_id, ParentSTIService::sti_service_id);
    }
}