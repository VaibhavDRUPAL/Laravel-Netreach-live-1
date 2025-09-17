<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    //
    protected $table = 'customers';
    protected $fillable = [
        'name', 'email', 'password', 'phone_number', 'profile_photo', 'status', 'hiv_test', 'anony'
    ];
}
