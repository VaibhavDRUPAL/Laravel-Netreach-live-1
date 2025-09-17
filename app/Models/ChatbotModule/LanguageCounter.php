<?php

namespace App\Models\ChatbotModule;

use App\Models\LanguageModule\Language;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LanguageCounter extends Model
{
    use HasFactory;

    const chatbot_language_counter = 'chatbot_language_counter';
    const language_counter_id = 'language_counter_id';
    const language_id = 'language_id';
    const counter = 'counter';

    // Table Details
    protected $table = self::chatbot_language_counter;
    protected $primaryKey = self::language_counter_id;
    public $timestamps = false;

    // Fillable
    protected $fillable = [
        self::language_id,
        self::counter
    ];

    const RL_LANGUAGE = 'language';
    public function language()
    {
        return $this->belongsTo(Language::class, self::language_id, Language::language_id);
    }

    // Get all counter
    public static function getAllCounter()
    {
        $data = self::with(self::RL_LANGUAGE)->orderByDesc(self::counter)->get();

        return $data;
    }
    
    // Counter Increment
    public static function counterIncrement($request)
    {
        $data = self::whereHas(self::RL_LANGUAGE, function ($query) use ($request) {
            return $query->where(Language::locale, $request->input(Language::locale));
        })->increment(self::counter);

        return $data;
    }
}
