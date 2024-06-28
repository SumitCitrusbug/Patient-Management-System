<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;


    public $incrementing = false;
    protected $guarded = [];

    protected $hidden = [
        'created_at', 'updated_at'
    ];
    public function timeSlots()
    {
        return $this->hasMany(TimeSlot::class, 'doctor_id', 'id');
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
