<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EducationalAttainment extends Model
{
    use HasFactory;

    const educational_attainment_master = 'educational_attainment_master';
    const educational_attainment_id = 'educational_attainment_id';
    const educational_attainment = 'educational_attainment';
    const educational_attainment_slug = 'educational_attainment_slug';
    const created_at = 'created_at';

    // Table Details
    protected $table = self::educational_attainment_master;
    protected $primaryKey = self::educational_attainment_id;
    public $timestamps = false;

    // Fillable
    protected $fillable = [
        self::educational_attainment,
        self::educational_attainment_slug,
        self::created_at
    ];

    // Hidden
    protected $hidden = [
        self::created_at
    ];
}
