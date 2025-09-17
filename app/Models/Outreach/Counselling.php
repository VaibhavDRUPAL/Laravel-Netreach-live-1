<?php

namespace App\Models\Outreach;

use App\Models\ClientType;
use App\Models\DistrictMaster;
use App\Models\ServiceType;
use App\Models\StateMaster;
use App\Models\TargetPopulation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Counselling extends Model
{
    use HasFactory;

    const outreach_counselling_services = 'outreach_counselling_services';
    const counselling_services_id = 'counselling_services_id';
    const profile_id = 'profile_id';
    const client_type_id = 'client_type_id';
    const user_id = 'user_id';
    const referral_service_id = 'referral_service_id';
    const district_id = 'district_id';
    const state_id = 'state_id';
    const target_id = 'target_id';
    const referred_from = 'referred_from';
    const referral_source = 'referral_source';
    const name_the_client = 'name_the_client';
    const date_of_counselling = 'date_of_counselling';
    const phone_number = 'phone_number';
    const location = 'location';
    const other_target_population = 'other_target_population';
    const type_of_counselling_offered = 'type_of_counselling_offered';
    const type_of_counselling_offered_other = 'type_of_counselling_offered_other';
    const counselling_medium = 'counselling_medium';
    const other_counselling_medium = 'other_counselling_medium';
    const duration_of_counselling = 'duration_of_counselling';
    const key_concerns_discussed = 'key_concerns_discussed';
    const follow_up_date = 'follow_up_date';
    const remarks = 'remarks';
    const status = 'status';
    const created_at = 'created_at';
    const is_deleted = 'is_deleted';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = self::outreach_counselling_services;
    protected $primaryKey = self::counselling_services_id;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;


    protected $fillable = [
        self::profile_id,
        self::client_type_id,
        self::user_id,
        self::referral_service_id,
        self::district_id,
        self::state_id,
        self::target_id,
        self::referred_from,
        self::referral_source,
        self::name_the_client,
        self::date_of_counselling,
        self::phone_number,
        self::location,
        self::other_target_population,
        self::type_of_counselling_offered,
        self::type_of_counselling_offered_other,
        self::counselling_medium,
        self::other_counselling_medium,
        self::duration_of_counselling,
        self::key_concerns_discussed,
        self::follow_up_date,
        self::remarks,
        self::status,
        self::created_at,
        self::is_deleted
    ];

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

    public function referral_service(): BelongsTo
    {
        return $this->belongsTo(ReferralService::class, self::referral_service_id, ReferralService::referral_service_id);
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(DistrictMaster::class, self::district_id);
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(StateMaster::class, self::state_id);
    }

    public function target(): BelongsTo
    {
        return $this->belongsTo(TargetPopulation::class, self::target_id, TargetPopulation::target_id);
    }
}