<?php

namespace App\Http\Controllers;

use App\Models\Appointment;


class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    //book appointment
    public function bookAppointment(Request $request)
    {
        $validate = Validator::make($request->all(), [
            "docter_id" => "required",
            "appointment_date" => "required|date",
            "appointment_time" => "required|date_format:H:i:s",
        ]);
        if ($validate->fails()) {
            return response()->json(['status' => false, 'message' => 'validation error ', 'data' => $validate->errors()]);
        }
        $timeslote = Timeslot::where('docter_id', $request->docter_id)->get();
        if (count($timeslote) > 0) {
            $timeslote = Timeslot::where('docter_id', $request->docter_id)
                ->where('date', $request->appointment_date)
                ->where('time_start', '<=', $request->appointment_time)
                ->where('time_end', '>=', $request->appointment_time)
                ->where('avaliblity', 1)
                ->first();

            if ($timeslote) {
                $appointment = new Appointment();
                $appointment->id = Str::uuid();
                $appointment->docter_id = $request->docter_id;
                $appointment->user_id = Auth::user()->id;
                $appointment->timeslot_id = $timeslote->id;
                $appointment->appointment_date = $request->appointment_date;
                $appointment->appointment_time = $request->appointment_time;
                $appointment->save();
                $timeslote = Timeslot::findOrFail($timeslote->id);
                $timeslote->avaliblity = 0;
                $timeslote->save();
                return response()->json(['status' => true, 'message' => 'appointment booked'], 200);;
            } else {
                return response()->json(['status' => false, 'message' => 'time slote not available for the appointment'], 400);;
            }
        } else {
            return response()->json(['status' => false, 'message' => 'no such id which are you looking for the docter '], 400);
        }
    }

    // view appointment
    public function viewAppointment()
    {
        //
    }
}
