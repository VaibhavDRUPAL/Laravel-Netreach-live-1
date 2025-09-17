<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeetCounsellorFollowUp extends Model
{
    use HasFactory;
    protected $fillable = [
        'meet_id',
        'user_id',
        'contacted',
        'action_taken',
        'follow_up_image',
        'created_at',
        'updated_at'
    ];
}
