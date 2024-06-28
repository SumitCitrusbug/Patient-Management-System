<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Role;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Payment;
use App\Models\Timeslot;
use Illuminate\Contracts\Database\Eloquent\Builder;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function doctorList()
    {



        try {
            //list the doctor with time slot


            $doctors = Doctor::with('timeSlots:id,time_start,time_end,date,doctor_id,avaliblity')->get(['id', 'name', 'amount']);
            // $doctors = Doctor::with([
            //     'timeSlots' => [
            //         'time_start',

            //     ]
            // ])->get(['id', 'name', 'amount']);




            return response()->json(['status' => true, 'message' => ' All doctor list ', 'data' => $doctors], 200);
        } catch (Exception $e) {
            return response()->json(['status' => true, 'message' => 'Error found ', 'data' => $e->getMessage()], 400);
        }
    }
}
