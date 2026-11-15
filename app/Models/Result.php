<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $guarded = [];
    public function registration() { return $this->belongsTo(UnitRegistration::class, 'unit_registration_id'); }
}