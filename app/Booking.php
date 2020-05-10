<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'id', 'title', 'user_id', 'start', 'resourceId'
    ];

    public function user()
    {
        $this->belongsTo(User::class);
    }
}
