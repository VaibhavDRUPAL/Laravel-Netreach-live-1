<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TargetPopulation extends Model
{
    use HasFactory;

    const target_population = 'target_population';
    const target_population_master = 'target_population_master';
    const target_id = 'target_id';
    const target_type = 'target_type';
    const target_slug = 'target_slug';
    const created_at = 'created_at';

    // Table Details
    protected $table = self::target_population_master;
    protected $primaryKey = self::target_id;
    public $timestamps = false;

    // Fillable
    protected $fillable = [
        self::target_type,
        self::target_slug,
        self::created_at
    ];

    // Hidden
    protected $hidden = [
        self::created_at
    ];
    public static function getTypeById($id){
        // return TargetPopulation::select('target_type')->where('id', $id)->pluck("target_type")->first();
        return TargetPopulation::where('target_id', $id)->pluck("target_type")->first();
        
    }
}