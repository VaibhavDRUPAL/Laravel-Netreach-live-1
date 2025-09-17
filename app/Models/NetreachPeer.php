<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NetreachPeer extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'netreach_peers';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;


    protected $fillable = array(
        'netreach_peer_Code',
        'serial_number_of_client',
        'date_of_outreach',
        'Date_of_Outreach',
        'location_of_client',
        'name_of_appplatform_client',
        'name_of_client',
        'clients_age',
        'gender',
        'type_of_target_population',
        'phone_number',
        'created_by',
    );
}
