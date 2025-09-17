<?php

namespace App\Models\ChatbotModule;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Greetings extends Model
{
    use HasFactory;

    const locale = 'locale';
    const body = 'body';
    const chatbot_greetings = 'chatbot_greetings';
    const greeting_id = 'greeting_id';
    const greeting_title = 'greeting_title';
    const greetings = 'greetings';
    const is_deleted = 'is_deleted';
    const created_at = 'created_at';
    const updated_at = 'updated_at';

    // Table Details
    protected $table = self::chatbot_greetings;
    protected $primaryKey = self::greeting_id;
    public $timestamps = false;

    // Fillable
    protected $fillable = [
        self::greeting_title,
        self::greetings,
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
        self::greetings => 'array'
    ];

    // Update Greetings
    public static function addGreetings($request)
    {
        $data = self::create([
            self::greeting_title => $request->input(self::greeting_title),
            self::created_at => currentDateTime()
        ]);

        return $data ? $data : null;
    }
    
    // Update Greetings
    public static function updateGreetings($request)
    {
        $data = self::where(self::greeting_id, $request->input(self::greeting_id))
            ->update(
                [
                    self::greetings => $request->input(self::greetings),
                    self::updated_at => currentDateTime()
                ]
            );

        return $data ? $data : null;
    }

    // Get All Greetings
    public static function getAllGreetings()
    {
        $data = self::where(self::is_deleted, false)->get();

        return $data ? $data : null;
    }

    // Get Greeting By ID
    public static function getGreetingByID($request)
    {
        $data = self::find($request->input(self::greeting_id));

        return $data ? $data : null;
    }

    // Delete Greeting
    public static function deleteGreeting($request)
    {
        $data = self::where(self::greeting_id, $request->input(self::greeting_id))
            ->update(
                [
                    self::is_deleted => true,
                    self::updated_at => currentDateTime()
                ]
            );

        return $data ? $data : null;
    }
}