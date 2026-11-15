<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HostelBooking extends Model
{
    protected $guarded = [];

    protected $casts = [
        'booked_at' => 'datetime',
    ];

    public function student() { return $this->belongsTo(Student::class); }
    public function room()    { return $this->belongsTo(Room::class); }
}