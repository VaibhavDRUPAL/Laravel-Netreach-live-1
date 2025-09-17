<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Genrate extends Model
{
    //
    protected $fillable = ['platform_id', 'unique_code_link', 'detail', 'user_id', 'tinyurl', 'user_identified'];
}
