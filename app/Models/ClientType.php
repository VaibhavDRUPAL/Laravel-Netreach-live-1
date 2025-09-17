<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientType extends Model
{
    use HasFactory;

    const client_type_master = 'client_type_master';
    const client_type_id = 'client_type_id';
    const client_type = 'client_type';
    const client_type_slug = 'client_type_slug';
    const created_at = 'created_at';

    // Table Details
    protected $table = self::client_type_master;
    protected $primaryKey = self::client_type_id;
    public $timestamps = false;

    // Fillable
    protected $fillable = [
        self::client_type,
        self::client_type_slug,
        self::created_at
    ];

    // Hidden
    protected $hidden = [
        self::created_at
    ];
}
