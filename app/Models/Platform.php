<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Platform extends Model
{
    const platform_name = 'platform_name';
    const others_platform = 'others_platform';
    const other_virtual_platform = 'other_virtual_platform';
    const use_other_virtual_platform = 'use_other_virtual_platform';

    const platforms = 'platforms';
    const id = 'id';
    const name = 'name';
    const created_at = 'created_at';
    const updated_at = 'updated_at';

    protected $fillable = [
        self::name,
        self::created_at,
        self::updated_at
    ];
}