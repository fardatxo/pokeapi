<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'user_id',
        'service_name',
        'service_price',
        'service_duration',
        'date',
        'time',
        'client_name',
        'client_phone',
        'client_email',
        'notes',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
