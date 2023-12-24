<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'user_id',
        'ip_address',
        'latitude',
        'longitude',
        'type',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
