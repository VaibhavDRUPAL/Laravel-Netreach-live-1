<?php

namespace App\Models\ChatbotModule;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class UserDetails extends Model
{
    use HasFactory;

    const chatbot_user_details = 'chatbot_user_details';
    const chatbot_user_id = 'chatbot_user_id';
    const full_name = 'full_name';
    const phone_number = 'phone_number';
    const ip_address = 'ip_address';
    const latitude = 'latitude';
    const longitude = 'longitude';
    const country = 'country';
    const state = 'state';
    const city = 'city';
    const zip = 'zip';
    const isp = 'isp';
    const created_at = 'created_at';

    // Table Details
    protected $table = self::chatbot_user_details;
    protected $primaryKey = self::chatbot_user_id;
    public $timestamps = false;

    // Fillable
    protected $fillable = [
        self::full_name,
        self::phone_number,
        self::ip_address,
        self::latitude,
        self::longitude,
        self::country,
        self::state,
        self::city,
        self::zip,
        self::isp,
        self::created_at
    ];
    
    // Hidden
    protected $hidden = [
        self::latitude,
        self::longitude,
        self::isp
    ];

    // Cast
    protected $casts = [
        self::created_at => 'datetime:' . READABLE_DATETIME
    ];

    // Set Request Parameters
    protected static function setRequest($self, $request)
    {
        $self->full_name = Str::squish($request->input(self::full_name));
        $self->phone_number = Str::squish($request->input(self::phone_number));
        $self->ip_address = $request->ip();
        $self->latitude = Str::squish($request->input(self::latitude));
        $self->longitude = Str::squish($request->input(self::longitude));
        $self->country = Str::squish($request->input(self::country));
        $self->state = Str::squish($request->input(self::state));
        $self->city = Str::squish($request->input(self::city));
        $self->zip = Str::squish($request->input(self::zip));
        $self->isp = Str::squish($request->input(self::isp));
        $self->created_at = currentDateTime();

        return $self;
    }

    // Add OR Update Record
    public static function addOrUpdate($request)
    {
        return self::setRequest(new self, $request)?->save();
    }

    // Get all users
    public static function getAllUsers($request)
    {
        return self::paginate();
    }

    // Check users
    public static function checkUser($request)
    {
        return self::where(self::phone_number, $request->input(self::phone_number))->exists();
    }
}