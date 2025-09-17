<?php

namespace App\Models\Outreach;

use App\Models\ClientResponse;
use App\Models\ClientType;
use App\Models\DistrictMaster;
use App\Models\Gender;
use App\Models\Platform;
use App\Models\StateMaster;
use App\Models\TargetPopulation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Profile extends Model
{
    use HasFactory;

    const profile = 'profile';
    const gender = 'gender';
    const outreach_profile = 'outreach_profile';
    const profile_id = 'profile_id';
    const district_id = 'district_id';
    const state_id = 'state_id';
    const platform_id = 'platform_id';
    const gender_id = 'gender_id';
    const target_id = 'target_id';
    const response_id = 'response_id';
    const client_type_id = 'client_type_id';
    const user_id = 'user_id';
    const mention_platform_id = 'mention_platform_id';
    const region_id = 'region_id';
    const unique_serial_number = 'unique_serial_number';
    const age = 'age';
    const age_not_disclosed = 'age_not_disclosed';
    const uid = 'uid';
    const registration_date = 'registration_date';
    const location = 'location';
    const other_platform = 'other_platform';
    const profile_name = 'profile_name';
    const other_gender = 'other_gender';
    const others_target_population = 'others_target_population';
    const virtual_platform = 'virtual_platform';
    const others_mentioned = 'others_mentioned';
    const reached_out = 'reached_out';
    const phone_number = 'phone_number';
    const follow_up_date = 'follow_up_date';
    const shared_website_link = 'shared_website_link';
    const remarks = 'remarks';
    const status = 'status';
    const created_at = 'created_at';
    const is_deleted = 'is_deleted';
    const is_active = 'is_active';
    const in_referral = 'in_referral';
    const referral_other = 'referral_other';
    const purpose_val = 'purpose_val';
    const purpose_other = 'purpose_other';
    const comment = 'comment';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = self::outreach_profile;
    protected $primaryKey = self::profile_id;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    protected $casts = [
        self::age_not_disclosed => 'boolean'
    ];

    protected $fillable = [
        self::district_id,
        self::state_id,
        self::platform_id,
        self::gender_id,
        self::target_id,
        self::response_id,
        self::client_type_id,
        self::user_id,
        self::mention_platform_id,
        self::region_id,
        self::unique_serial_number,
        self::age,
        self::age_not_disclosed,
        self::uid,
        self::registration_date,
        self::location,
        self::other_platform,
        self::profile_name,
        self::other_gender,
        self::others_target_population,
        self::virtual_platform,
        self::others_mentioned,
        self::reached_out,
        self::phone_number,
        self::follow_up_date,
        self::shared_website_link,
        self::remarks,
        self::status,
        self::created_at,
        self::is_deleted,
        self::is_active,
        self::in_referral,
        self::referral_other,
        self::purpose_val,
        self::purpose_other,
        self::comment
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

    public function target(): BelongsTo
    {
        return $this->belongsTo(TargetPopulation::class, self::target_id, TargetPopulation::target_id);
    }

    public function platform(): BelongsTo
    {
        return $this->belongsTo(Platform::class, self::platform_id, Platform::id);
    }

    public function mentioned_platform(): BelongsTo
    {
        return $this->belongsTo(Platform::class, self::mention_platform_id, Platform::id);
    }

    public function gender(): BelongsTo
    {
        return $this->belongsTo(Gender::class, self::gender_id, Gender::gender_id);
    }

    public function response(): BelongsTo
    {
        return $this->belongsTo(ClientResponse::class, self::response_id, ClientResponse::response_id);
    }

    public function referral_service(): HasOne
    {
        return $this->hasOne(ReferralService::class, self::profile_id, ReferralService::profile_id)->orderByDesc(ReferralService::referral_service_id);
    }
   public static function getUniqueSerialNoById($id){
        return Profile::where('profile_id', $id)->pluck("unique_serial_number")->first();
   }
   public static function getNameById($id){
        return Profile::where('profile_id', $id)->pluck("profile_name")->first();
   }

}
