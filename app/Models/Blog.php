<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
    use HasFactory;
    use SoftDeletes;

        protected $fillable = [
            'title',
            'title_mr',
            'title_hi',
            'title_te',
            'title_ta',
            'description',
            'description_mr',
            'description_hi',
            'description_te',
            'description_ta',
            'image',
            'youtube_video_embed',
            'tags',
            'meta_title',
            'meta_description',
            'meta_keywords',
            'status',
            'author_name',
            'author_name_mr',
            'author_name_hi',
            'author_name_te',
            'author_name_ta',
            'author_details',
            'facebook',
            'whatsapp',
            'instagram'
    ];

        protected $primaryKey = 'blog_id';

    public function blogCategories()
    {
        return $this->belongsTo('App\Models\BlogCategories','blog_category_id','blog_category_id')->withTrashed();
    }

    public function users()
    {
        return $this->belongsTo('App\Models\User','user_id','id');
    }
}
