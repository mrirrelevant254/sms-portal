<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $guarded = [];

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
    
    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }
}