<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    protected $guarded = [];

    public static function current()
    {
        return static::where('is_current', true)->first();
    }
}