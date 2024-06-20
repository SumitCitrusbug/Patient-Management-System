<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    public $incrementing = false;
    public function timeSlots()
    {
        return $this->hasMany(TimeSlot::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }


    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
