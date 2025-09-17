<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Category extends Model
{
    use LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }

    protected $fillable = ['category_name', 'status', 'user_id', 'slug'];

    protected static $logFillable = true;
    protected static $logName = 'category';
    protected static $logOnlyDirty = true;


    public function setStatusAttribute($status)
    {
        $this->attributes['status'] = ($status) ? 1 : 0;
    }
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    public function posts()
    {
        return $this->hasMany('App\Models\Post');
    }
}
