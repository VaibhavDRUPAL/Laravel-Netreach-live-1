<?php

namespace App\Models\SelfModule;

use App\Models\Scopes\{IsActive, IsDeleted};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiskAssessmentAnswer extends Model
{
    use HasFactory;

    const self_risk_assessment_answers = 'self_risk_assessment_answers';
    const answer_id = 'answer_id';
    const question_id = 'question_id';
    const answer = 'answer';
    const answer_slug = 'answer_slug';
    const answer_mr = 'answer_mr';
    const answer_hi = 'answer_hi';
    const answer_ta = 'answer_ta';
    const answer_te = 'answer_te';
    const weight = 'weight';
    const is_active = 'is_active';
    const is_deleted = 'is_deleted';

    // Table Details
    protected $table = self::self_risk_assessment_answers;
    protected $primaryKey = self::answer_id;
    public $timestamps = false;

    protected static function booted()
    {
        static::addGlobalScope(new IsActive);
        static::addGlobalScope(new IsDeleted);
    }

    // Fillable
    protected $fillable = [
        self::answer,
        self::answer_slug,
        self::answer_mr,
        self::answer_hi,
        self::answer_ta,
        self::answer_te,
        self::weight,
        self::is_active,
        self::is_deleted
    ];
}
