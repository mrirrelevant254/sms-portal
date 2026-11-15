<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'national_id' => 'encrypted',
    ];

    public function user() { return $this->belongsTo(User::class); }
    public function programme() { return $this->belongsTo(Programme::class); }
    public function campus() { return $this->belongsTo(Campus::class); }

    public function invoices() { return $this->hasMany(Invoice::class); }
    public function unitRegistrations() { return $this->hasMany(UnitRegistration::class); }


    public function requests()
    {
            return $this->hasMany(StudentRequest::class);
    }

    public function getFullNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->middle_name} {$this->last_name}");
    }
}