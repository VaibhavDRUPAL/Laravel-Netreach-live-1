<?php

namespace App\Models\SelfModule;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiskAssessmentItems extends Model
{
    use HasFactory;

    const self_risk_assessment_items = 'self_risk_assessment_items';
    const risk_assessment_item_id = 'risk_assessment_item_id';
    const risk_assessment_id = 'risk_assessment_id';
    const question_id = 'question_id';
    const answer_id = 'answer_id';

    // Table Details
    protected $table = self::self_risk_assessment_items;
    protected $primaryKey = self::risk_assessment_item_id;
    public $timestamps = false;

    // Fillable
    protected $fillable = [
        self::risk_assessment_id,
        self::question_id,
        self::answer_id
    ];

    public function question()
    {
        return $this->hasOne(RiskAssessmentQuestionnaire::class, RiskAssessmentAnswer::question_id, self::question_id);
    }

    public function answer()
    {
        return $this->hasOne(RiskAssessmentAnswer::class, RiskAssessmentAnswer::answer_id, self::answer_id);
    }

    // Add OR Update Record
    public static function addOrUpdate($request)
    {
        return self::insert($request);
    }
}
