<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Doctor;

class Timeslot extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $guarded = [];
    protected $hidden = [
        'created_at', 'updated_at'
    ];
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
