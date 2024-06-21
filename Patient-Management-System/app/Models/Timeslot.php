<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Doctor;

class Timeslot extends Model
{
    use HasFactory;

    public $incrementing = false;



    public function docter()
    {
        return $this->belongsTo(Docter::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
