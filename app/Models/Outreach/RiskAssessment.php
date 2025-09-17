<?php

namespace App\Models\Outreach;

use App\Models\ClientType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RiskAssessment extends Model
{
    use HasFactory;

    const outreach_risk_assesment = 'outreach_risk_assesment';
    const risk_assesment_id = 'risk_assesment_id';
    const profile_id = 'profile_id';
    const client_type_id = 'client_type_id';
    const provided_client_with_information = 'provided_client_with_information';
    const types_of_information = 'types_of_information';
    const user_id = 'user_id';
    const date_of_risk_assessment = 'date_of_risk_assessment';
    const had_sex_without_a_condom = 'had_sex_without_a_condom';
    const shared_needle_for_injecting_drugs = 'shared_needle_for_injecting_drugs';
    const sexually_transmitted_infection = 'sexually_transmitted_infection';
    const sex_with_more_than_one_partners = 'sex_with_more_than_one_partners';
    const had_chemical_stimulantion_or_alcohol_before_sex = 'had_chemical_stimulantion_or_alcohol_before_sex';
    const had_sex_in_exchange_of_goods_or_money = 'had_sex_in_exchange_of_goods_or_money';
    const other_reason_for_hiv_test = 'other_reason_for_hiv_test';
    const risk_category = 'risk_category';
    const status = 'status';
    const created_at = 'created_at';
    const is_deleted = 'is_deleted';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = self::outreach_risk_assesment;
    protected $primaryKey = self::risk_assesment_id;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;


    protected $fillable = [
        self::profile_id,
        self::client_type_id,
        self::provided_client_with_information,
        self::types_of_information,
        self::user_id,
        self::date_of_risk_assessment,
        self::had_sex_without_a_condom,
        self::shared_needle_for_injecting_drugs,
        self::sexually_transmitted_infection,
        self::sex_with_more_than_one_partners,
        self::had_chemical_stimulantion_or_alcohol_before_sex,
        self::had_sex_in_exchange_of_goods_or_money,
        self::other_reason_for_hiv_test,
        self::risk_category,
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
}