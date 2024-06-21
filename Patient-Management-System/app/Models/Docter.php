<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Docter extends Model
{
    use HasFactory;


    public $incrementing = false;


    public function timeSlots()
    {
        return $this->hasMany(TimeSlot::class, 'docter_id', 'id');
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
