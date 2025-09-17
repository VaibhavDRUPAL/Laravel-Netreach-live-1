<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TIService extends Model
{
    use HasFactory;

    const other_ti_service = 'other_ti_service';
    const ti_service_master = 'ti_service_master';
    const ti_service_id = 'ti_service_id';
    const ti_service = 'ti_service';
    const ti_service_slug = 'ti_service_slug';
    const created_at = 'created_at';

    // Table Details
    protected $table = self::ti_service_master;
    protected $primaryKey = self::ti_service_id;
    public $timestamps = false;

    // Fillable
    protected $fillable = [
        self::ti_service,
        self::ti_service_slug,
        self::created_at
    ];

    // Hidden
    protected $hidden = [
        self::created_at
    ];
}
