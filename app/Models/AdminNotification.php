<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminNotification extends Model
{
    //
    protected $table = 'admin_notification';
    protected $fillable = ['center_id'];
    protected $casts = [
        'created_at' => 'datetime:y-m-d H:i a'
    ];
}