<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 
class StateMaster extends Model
{
    use HasFactory;
 
    const state = 'state';
 
    protected $table = 'state_master';
    public $timestamps = false;
 
    protected $fillable = [
        'state_code',
        'state_name',
        'state_name_mr',
        'state_name_hi',
        'state_name_te',
        'state_name_ta',
        'st_cd',
        'region',
        'weight'
    ];
 
    public static function getStateName($ids)
    {
        return StateMaster::whereIn('state_code', $ids)->get();
    }
    public static function getOneStateName($id)
    {
        return StateMaster::where('id', $id)->pluck("state_name")->first();
    }
	public static function getRegionByState($id){
		return StateMaster::select('region')->where('id', $id)->pluck("region")->first();
	}
}