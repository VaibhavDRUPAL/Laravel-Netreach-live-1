<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Sanctum\HasApiTokens; // ✅ Add this

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, HasRoles, LogsActivity, ThrottlesLogins; // ✅ Add HasApiTokens here

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }

    protected $fillable = [
        'name','center','email', 'vn_email', 'password', 'phone_number', 'profile_photo', 
        'status', 'user_type', 'vms_details_ids', 'email_verified_at', 'txt_password','bio'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected static $logFillable = true;
    protected static $logName = 'user';
    protected static $logOnlyDirty = true;

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function setStatusAttribute($status)
    {
        $this->attributes['status'] = ($status) ? 1 : 0;
    }

    // Password mutator
    protected function password(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => Hash::make($value)
        );
    }

    public function categories()
    {
        return $this->hasMany('App\Models\Category');
    }

    public function posts()
    {
        return $this->hasMany('App\Models\Post');
    }

    public function vndetails()
    {
        return $this->belongsTo('App\Models\VmMaster', 'vms_details_ids');
    }

    public function blogs()
    {
        return $this->hasMany('App\Models\Blog');
    }

    public static function getOneUserById($id)
    {
        return User::where('id', $id)->pluck("name")->first();
    }
}
