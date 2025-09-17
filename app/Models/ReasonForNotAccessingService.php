<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReasonForNotAccessingService extends Model
{
    use HasFactory;

    const reason_for_not_accessing_service = 'reason_for_not_accessing_service';
    const reason_for_not_accessing_service_master = 'reason_for_not_accessing_service_master';
    const reason_id = 'reason_id';
    const reason = 'reason';
    const reason_slug = 'reason_slug';
    const created_at = 'created_at';

    // Table Details
    protected $table = self::reason_for_not_accessing_service_master;
    protected $primaryKey = self::reason_id;
    public $timestamps = false;

    // Fillable
    protected $fillable = [
        self::reason,
        self::reason_slug,
        self::created_at
    ];

    // Hidden
    protected $hidden = [
        self::created_at
    ];
}
