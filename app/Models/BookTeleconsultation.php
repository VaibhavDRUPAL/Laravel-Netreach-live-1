<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookTeleconsultation extends Model
{
    use HasFactory;

    protected $table = 'book_teleconsultations';

    protected $fillable = [
        'user_id',
        'type',
        'service',
        'date',
        'time',
        'language',
    ];

    /**
     * Relation: A booking belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
