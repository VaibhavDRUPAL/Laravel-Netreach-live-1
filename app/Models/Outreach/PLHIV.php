<?php

namespace App\Models\Outreach;

use App\Models\CentreMaster;
use App\Models\ClientType;
use App\Models\DistrictMaster;
use App\Models\StateMaster;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PLHIV extends Model
{
    use HasFactory;

    const art_state = 'art_state';
    const art_district = 'art_district';
    const art_center = 'art_center';
    const outreach_plhiv = 'outreach_plhiv';
    const plhiv_id = 'plhiv_id';
    const profile_id = 'profile_id';
    const referral_service_id = 'referral_service_id';
    const client_type_id = 'client_type_id';
    const user_id = 'user_id';
    const registration_date = 'registration_date';
    const pid_or_other_unique_id_of_the_service_center = 'pid_or_other_unique_id_of_the_service_center';
    const date_of_confirmatory = 'date_of_confirmatory';
    const date_of_art_reg = 'date_of_art_reg';
    const pre_art_reg_number = 'pre_art_reg_number';
    const date_of_on_art = 'date_of_on_art';
    const on_art_reg_number = 'on_art_reg_number';
    const type_of_facility_where_treatment_sought = 'type_of_facility_where_treatment_sought';
    const art_state_id = 'art_state_id';
    const art_district_id = 'art_district_id';
    const art_center_id = 'art_center_id';
    const remarks = 'remarks';
    const status = 'status';
    const created_at = 'created_at';
    const is_deleted = 'is_deleted';
    const is_active = 'is_active';
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = self::outreach_plhiv;
    protected $primaryKey = self::plhiv_id;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;


    protected $fillable = [
        self::profile_id,
        self::referral_service_id,
        self::client_type_id,
        self::user_id,
        self::registration_date,
        self::pid_or_other_unique_id_of_the_service_center,
        self::date_of_confirmatory,
        self::date_of_art_reg,
        self::pre_art_reg_number,
        self::date_of_on_art,
        self::on_art_reg_number,
        self::type_of_facility_where_treatment_sought,
        self::art_state_id,
        self::art_district_id,
        self::art_center_id,
        self::remarks,
        self::status,
        self::created_at,
        self::is_deleted,
        self::is_active,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, self::user_id);
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(DistrictMaster::class, self::art_district_id);
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(StateMaster::class, self::art_state_id);
    }

    public function center(): BelongsTo
    {
        return $this->belongsTo(CentreMaster::class, self::art_center_id);
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
}