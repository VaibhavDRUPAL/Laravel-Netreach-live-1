<?php

namespace App\Models;

use App\Models\Scopes\Status;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class VmMaster extends Model
{
    //
    protected $table = 'vm_master';
    protected $fillable = ['parent_id', 'name', 'last_name', 'email', 'password', 'mobile_number', 'state_code', 'vncode', 'region', 'status', 'regions_list'];
    protected $casts = [
        'regions_list' => 'array',
    ];
    protected $appends = [
        'state_list'
    ];
    protected static function booted()
    {
        static::addGlobalScope(new Status);
    }
    public function statename()
    {
        return $this->hasOne('App\Models\VmMaster');
    }
    // State list
    protected function stateList(): Attribute
    {
        return Attribute::make(
            get: fn($value, $attribute) => isset($attribute['state_code']) && !empty($attribute['state_code']) ? explode(',', $attribute['state_code']) : null
        );
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'vms_details_ids');
    }
}