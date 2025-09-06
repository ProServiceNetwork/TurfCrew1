<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceRequest extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'address',
        'city',
        'state',
        'zip',
        'phone',
        'email',
        'ip_address',
        'user_agent',
        'processed_at'
    ];

    protected $casts = [
        'processed_at' => 'datetime',
    ];
}
