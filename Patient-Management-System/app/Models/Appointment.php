<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Docter;

class Appointment extends Model
{
    use HasFactory;


    protected $guarded = [];
    public $incrementing = false;


    public function timeSlots()
    {
        return $this->belongsTo(TimeSlot::class, 'timeslot_id', 'id');
    }
    public function docter()
    {
        return $this->belongsTo(Docter::class, 'docter_id', 'id');
    }
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
