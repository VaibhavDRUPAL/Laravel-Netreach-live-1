<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientResponse extends Model
{
    use HasFactory;

    const client_response = 'client_response';
    const client_response_master = 'client_response_master';
    const response_id = 'response_id';
    const response = 'response';
    const response_slug = 'response_slug';
    const created_at = 'created_at';

    // Table Details
    protected $table = self::client_response_master;
    protected $primaryKey = self::response_id;
    public $timestamps = false;

    // Fillable
    protected $fillable = [
        self::response,
        self::response_slug,
        self::created_at
    ];

    // Hidden
    protected $hidden = [
        self::created_at
    ];
}
