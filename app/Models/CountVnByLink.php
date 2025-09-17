<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CountVnByLink extends Model
{
    //
    protected $table = 'vn_count_by_link';
    protected $fillable = ['vn_ctr', 'user_id'];
}
