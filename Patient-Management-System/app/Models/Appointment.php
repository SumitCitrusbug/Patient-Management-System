<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Doctor;

class Appointment extends Model
{
    use HasFactory;


    protected $guarded = [];
    public $incrementing = false;
    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public function timeSlots()
    {
        return $this->belongsTo(TimeSlot::class, 'timeslot_id', 'id');
    }
    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id', 'id');
    }
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
