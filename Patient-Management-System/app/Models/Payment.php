<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $guarded = [];
    protected $hidden = [
        'created_at', 'updated_at'
    ];
    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
}
