<?php

namespace App\Models\AnonymousModule;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Visitors extends Model
{
    use HasFactory;

    const anonymous_visitors = 'anonymous_visitors';
    const visitor_id = 'visitor_id';
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
    protected $table = self::anonymous_visitors;
    protected $primaryKey = self::visitor_id;
    public $timestamps = false;

    // Fillable
    protected $fillable = [
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

    // Cast
    protected $casts = [
        self::created_at => 'datetime:' . READABLE_DATETIME
    ];

    // Set Request Parameters
    protected static function setRequest($self, $request)
    {
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

    // Get All Visitors
    public static function getAllVisitors($request)
    {
        return self::paginate();
    }

    // Get Visitor
    public static function getVisitor($request)
    {
        return self::where(self::ip_address, $request->ip())->first();
    }

    // Check Visitor
    public static function checkVisitor($request)
    {
        return self::where(self::ip_address, $request->ip())->exists();
    }

    // Delete Visitor
    public static function deleteVisitor($request)
    {
        return self::destroy($request);
    }
}
