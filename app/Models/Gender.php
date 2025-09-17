<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gender extends Model
{
    use HasFactory;

    const gender_master = 'gender_master';
    const gender_id = 'gender_id';
    const gender = 'gender';
    const created_at = 'created_at';

    // Table Details
    protected $table = self::gender_master;
    protected $primaryKey = self::gender_id;
    public $timestamps = false;

    // Fillable
    protected $fillable = [
        self::gender,
        self::created_at
    ];

    // Hidden
    protected $hidden = [
        self::created_at
    ];
}
