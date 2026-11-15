<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $guarded = [];
    public function hostel() { return $this->belongsTo(Hostel::class); }
    public function bookings() { return $this->hasMany(HostelBooking::class); }
    
    // Helper to check if room is full
    public function isFull()
    {
        return $this->bookings()->where('status', '!=', 'cancelled')->count() >= $this->capacity;
    }
}