<?php

namespace App\Models\ChatbotModule;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Questionnaire extends Model
{
    use HasFactory;

    const locale = 'locale';
    const body = 'body';
    const content = 'content';
    const answer = 'answer';
    const title = 'title';
    const selected_questions = 'selected_questions';
    const chatbot_questionnaire = 'chatbot_questionnaire';
    const question_id = 'question_id';
    const priority = 'priority';
    const question = 'question';
    const answer_sheet = 'answer_sheet';
    const counter = 'counter';
    const is_deleted = 'is_deleted';
    const created_at = 'created_at';
    const updated_at = 'updated_at';

    // Table Details
    protected $table = self::chatbot_questionnaire;
    protected $primaryKey = self::question_id;
    public $timestamps = false;

    // Fillable
    protected $fillable = [
        self::priority,
        self::question,
        self::answer_sheet,
        self::counter,
        self::is_deleted,
        self::created_at,
        self::updated_at
    ];

    // Hidden
    protected $hidden = [
        self::created_at,
        self::updated_at,
        self::is_deleted
    ];

    // Cast
    protected $casts = [
        self::question => 'array',
        self::answer_sheet => 'array'
    ];

    // Add Questionnaire
    public static function addQuestionnaire($request)
    {
        $self = new self;

        $self->priority = self::max(self::priority) + 1;
        $self->question = $request->input(self::question);
        $self->created_at = currentDateTime();

        $self->save();

        return $self;
    }

    // Get All Questionnaire
    public static function getAllQuestionnaire($request)
    {
        $data = self::orderBy(self::priority);

        if ($request->filled(self::selected_questions)) $data = $data->whereNotIn(self::question_id, $request->input(self::selected_questions));

        if ($request->ajax()) $data = $data->whereNotNull(self::answer_sheet);

        if ($request->ajax()) $data = $data->limit($request->input(LIMIT, 5))->offset($request->input(OFFSET, 0));

        $data = $data->get();

        return $data;
    }
    // Get Questionnaire By ID
    public static function getQuestionnaireByID($request)
    {
        return self::find($request->input(self::question_id));
    }

    // Update Questionnaire
    public static function updateQuestionnaire($request)
    {
        return self::where(self::question_id, $request->input(self::question_id))
            ->update([
                self::question => $request->input(self::question),
                self::updated_at => currentDateTime()
            ]);
    }

    // Update Answer Sheet
    public static function updateAnswerSheet($request)
    {
        return self::where(self::question_id, $request->input(self::question_id))
            ->update([
                self::answer_sheet => $request->input(self::answer_sheet),
                self::updated_at => currentDateTime()
            ]);
    }

    // Counter Increment
    public static function counterIncrement($request)
    {
        $data = self::where(self::question_id, $request->input(self::question_id))
            ->increment(self::counter);

        return $data;
    }

    // Destroy Questionnaire
    public static function destroyQuestionnaire($request)
    {
        return self::destroy($request->input(self::question_id));
    }
}