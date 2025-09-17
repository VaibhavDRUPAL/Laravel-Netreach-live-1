<?php

namespace App\Models\SelfModule;

use App\Models\Scopes\{IsActive, IsDeleted};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiskAssessmentQuestionnaire extends Model
{
    use HasFactory;

    const self_risk_assessment_questionnaire = 'self_risk_assessment_questionnaire';
    const question_id = 'question_id';
    const question = 'question';
    const question_slug = 'question_slug';
    const question_mr = 'question_mr';
    const question_hi = 'question_hi';
    const question_te = 'question_te';
    const question_ta = 'question_ta';
    const answer_input_type = 'answer_input_type';
    const priority = 'priority';
    const group_no = 'group_no';
    const counter = 'counter';
    const is_active = 'is_active';
    const is_deleted = 'is_deleted';

    // Table Details
    protected $table = self::self_risk_assessment_questionnaire;
    protected $primaryKey = self::question_id;
    public $timestamps = false;

    protected static function booted()
    {
        static::addGlobalScope(new IsActive);
        static::addGlobalScope(new IsDeleted);
    }
    
    // Fillable
    protected $fillable = [
        self::question,
        self::question_mr,
        self::question_hi,
        self::question_te,
        self::question_ta,
        self::answer_input_type,
        self::priority,
        self::group_no,
        self::counter,
        self::is_active,
        self::is_deleted
    ];

    public function answers()
    {
        return $this->hasMany(RiskAssessmentAnswer::class, RiskAssessmentAnswer::question_id, self::question_id);
    }

// -------------------original
    public static function getAllQuestionnaire($request)
    {
        $data = self::with('answers')
            ->where(self::is_active, true)
            ->where(self::is_deleted, false)
            ->orderBy(self::priority)
            ->get();

        return $data;
    }

    // Counter Increment
    public static function counterIncrement($request)
    {
        $data = self::where(self::question_id, $request->input(self::question_id))
            ->increment(self::counter);

        return $data;
    }
}