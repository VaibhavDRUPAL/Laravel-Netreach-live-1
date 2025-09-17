<?php

namespace App\Models\ChatbotModule;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use HasFactory;

    const chatbot_other_content = 'chatbot_other_content';
    const content_id = 'content_id';
    const title = 'title';
    const description = 'description';
    const slug = 'slug';
    const content = 'content';
    const created_at = 'created_at';
    const updated_at = 'updated_at';

    // Table Details
    protected $table = self::chatbot_other_content;
    protected $primaryKey = self::content_id;
    public $timestamps = false;

    // Fillable
    protected $fillable = [
        self::title,
        self::description,
        self::slug,
        self::content,
        self::created_at,
        self::updated_at
    ];

    // Hidden
    protected $hidden = [
        self::created_at,
        self::updated_at
    ];

    // Cast
    protected $casts = [
        self::content => 'array'
    ];

    // Update content
    public static function updateContent($request)
    {
        $data = self::where(self::content_id, $request->input(self::content_id))
            ->update(
                [
                    self::content => $request->input(self::content),
                    self::updated_at => currentDateTime()
                ]
            );

        return $data ? $data : null;
    }

    // Get All Content
    public static function getAllContent($request = null)
    {
        $data = new self;

        if (!empty($request) && $request->filled(self::slug)) $data = is_array($request->input(self::slug)) ? $data->whereIn(self::slug, $request->input(self::slug)) : $data->where(self::slug, $request->input(self::slug));

        $data = $data->get();

        return $data ? $data : null;
    }

    // Get Content By ID
    public static function getContentByID($request)
    {
        $data = self::find($request->input(self::content_id));

        return $data ? $data : null;
    }
}