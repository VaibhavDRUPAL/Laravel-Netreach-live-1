<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogCategories extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
            'blog_category_name',
            'status'
    ];

    protected $primaryKey = 'blog_category_id';
}
