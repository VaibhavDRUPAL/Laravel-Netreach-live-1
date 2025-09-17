<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceType extends Model
{
    use HasFactory;

    const other_service = 'other_service';
    const service_type_master = 'service_type_master';
    const service_type_id = 'service_type_id';
    const service_type = 'service_type';
    const service_type_slug = 'service_type_slug';
    const created_at = 'created_at';

    // Table Details
    protected $table = self::service_type_master;
    protected $primaryKey = self::service_type_id;
    public $timestamps = false;

    // Fillable
    protected $fillable = [
        self::service_type,
        self::service_type_slug,
        self::created_at
    ];

    // Hidden
    protected $hidden = [
        self::created_at
    ];
}
