<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class STIService extends Model
{
    use HasFactory;

    const other_sti_service = 'other_sti_service';
    const sti_service_master = 'sti_service_master';
    const sti_service_id = 'sti_service_id';
    const sti_service = 'sti_service';
    const sti_service_slug = 'sti_service_slug';
    const created_at = 'created_at';

    // Table Details
    protected $table = self::sti_service_master;
    protected $primaryKey = self::sti_service_id;
    public $timestamps = false;

    // Fillable
    protected $fillable = [
        self::sti_service,
        self::sti_service_slug,
        self::created_at
    ];

    // Hidden
    protected $hidden = [
        self::created_at
    ];
}
