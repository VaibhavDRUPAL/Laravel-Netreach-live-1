<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Occupation extends Model
{
    use HasFactory;

    const primary_occupation = 'primary_occupation';
    const other_occupation = 'other_occupation';
    const primary_occupation_master = 'primary_occupation_master';
    const occupation_id = 'occupation_id';
    const occupation = 'occupation';
    const occupation_slug = 'occupation_slug';
    const created_at = 'created_at';

    // Table Details
    protected $table = self::primary_occupation_master;
    protected $primaryKey = self::occupation_id;
    public $timestamps = false;

    // Fillable
    protected $fillable = [
        self::occupation,
        self::occupation_slug,
        self::created_at
    ];

    // Hidden
    protected $hidden = [
        self::created_at
    ];
}
