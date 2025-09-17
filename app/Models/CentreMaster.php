<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class CentreMaster extends Model
{
	const center_name = 'center_name';
	const user_id = 'user_id';
	//
	protected $table = 'centre_master';
	protected $fillable = ['name', 'name_mr', 'name_hi', 'name_te', 'name_ta', 'address', 'pin_code', 'state_code', 'district_id', 'services_avail', 'services_available', 'name_counsellor', 'centre_contact_no', 'incharge', 'contact_no', 'user_id', 'created_at'];
	public $timestamps = false;

	protected $appends = [
		'center_services'
	];

	// Center Services
	protected function centerServices(): Attribute
	{
		return Attribute::make(
			get: fn($value, $attribute) => isset($attribute['services_available']) && !empty($attribute['services_available']) ? explode(',', $attribute['services_available']) : null
		);
	}

	public function centreUser()
	{
		return $this->belongsTo(User::class, self::user_id, 'id');
	}
	public static function getOneCentreName($id)
	{
		return CentreMaster::where('id', $id)->pluck("name")->first();
	}
}
