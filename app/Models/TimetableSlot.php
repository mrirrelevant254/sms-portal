<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class TimetableSlot extends Model
{
    protected $guarded = [];
    public function unit() { return $this->belongsTo(Unit::class); }
}