<?php

namespace App\Models\MediaModule;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MediaType extends Model
{
    use HasFactory;

    const media_type = 'media_type';
    const media_type_id = 'media_type_id';
    const type_name = 'type_name';
    const slug = 'slug';
    const scope = 'scope';
    const is_deleted = 'is_deleted';
    const created_at = 'created_at';
    const updated_at = 'updated_at';

    // Table Details
    protected $table = self::media_type;
    protected $primaryKey = self::media_type_id;
    public $timestamps = false;

    // Fillable
    protected $fillable = [
        self::type_name,
        self::slug,
        self::scope,
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
        self::scope => 'array'
    ];

    // Slug
    protected function slug(): Attribute
    {
        return Attribute::make(
            set: fn ($value, $attribute) => createSlug($attribute[self::type_name])
        );
    }

    // Get All Media Types
    public static function getAllMediaTypes($request)
    {
        $data = self::orderBy(self::type_name)
            ->whereJsonContains(self::scope, $request->input(self::scope))
            ->where(self::is_deleted, false)
            ->get();

        return $data;
    }
}