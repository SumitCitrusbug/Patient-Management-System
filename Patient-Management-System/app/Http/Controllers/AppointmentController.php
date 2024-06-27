<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Payment;
use App\Models\Timeslot;
use App\Models\Appointment;
use Illuminate\Http\Reques;
use Illuminate\Support\Str;
use App\Jobs\sendStripelink;
use Illuminate\Http\Request;
use App\Jobs\rejectAppointment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class AppointmentController extends Controller
{

    //book appointment
    public function bookAppointment(Request $request)
    {
        //validation
        $validate = Validator::make($request->all(), [
            "docter_id" => "required",
            "appointment_date" => "required|date",
            "appointment_time" => "required|date_format:H:i:s",
        ]);
        if ($validate->fails()) {
            return response()->json(['status' => false, 'message' => 'validation error ', 'data' => $validate->errors()]);
        }
        $timeslote = Timeslot::where('docter_id', $request->docter_id)->get();

        // time slote validation
        if (count($timeslote) > 0) {
            $timeslote = Timeslot::where('docter_id', $request->docter_id)
                ->where('date', $request->appointment_date)
                ->where('time_start', '<=', $request->appointment_time)
                ->where('time_end', '>=', $request->appointment_time)
                ->where('avaliblity', 1)
                ->first();

            // upadte appointment table in database
            if ($timeslote) {
                $appointment = new Appointment();
                $appointment->id = Str::uuid();
                $appointment->docter_id = $request->docter_id;
                $appointment->user_id = Auth::user()->id;
                $appointment->timeslot_id = $timeslote->id;
                $appointment->appointment_date = $request->appointment_date;
                $appointment->appointment_time = $request->appointment_time;
                $appointment->save();

                //change timeslot availability
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
        try {
            $appointment = Appointment::with('users', 'docter', 'timeSlots')->get();
            return response()->json(['status' => true, 'message' => 'All Appointments', 'data' => $appointment], 200);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => 'error found ', 'data' => $e->getMessage()], 400);
        }
    }


    // reject appointment
    public function rejectAppointment(Request $request)
    {

        try {

            $user = Appointment::with('users')->find($request->id);
            //appointment check validation
            if (!$user) {
                return response()->json(['status' => false, 'message' => 'id not found '], 400);
            }
            if ($user->status == 'paid') {

                return response()->json(['message' => 'appointment all ready paid '], 400);
            }
            if ($user->status == 'reject') {

                return response()->json(['message' => 'appointment all ready rejected book Unother appointment '], 400);
            }


            $appointment = Appointment::find($request->id);
            if (!$appointment) {
                return response()->json(['status' => false, 'message' => 'id not found '], 400);
            } else {
                // send reject mail
                dispatch(new rejectAppointment($user));
                // change status in database
                $appointment->status = 'reject';
                $appointment->save();
                return response()->json(['status' => true, 'message' => 'appointment rejected ', 'data' => $appointment], 200);
            }
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => 'error found ', 'data' => $e->getMessage()], 400);
        }
    }

    //accept appointment
    public function acceptAppointment(Request $request)
    {

        try {

            $user = Appointment::with('users', 'docter', 'timeSlots')->find($request->id);
            //appointment check validation
            // if (!$user) {
            //     return response()->json(['status' => false, 'message' => 'id not found '], 400);
            // }
            // if ($user->status == 'accept') {

            //     return response()->json(['message' => 'appointment all ready accepted '], 400);
            // }
            // if ($user->status == 'paid') {

            //     return response()->json(['message' => 'appointment all ready paid '], 400);
            // }
            // if ($user->status == 'reject') {

            //     return response()->json(['message' => 'appointment all ready rejected book Unother appointment '], 400);
            // }
            // return $user;

            $appointment = Appointment::with('users')->find($request->id);


            if (!$appointment) {
                return response()->json(['status' => false, 'message' => 'id not found '], 400);
            } else {
                $invoice = app(PaymentController::class)->payInvoice($request);
                //send payment mail
                dispatch(new sendStripelink($user, $invoice));

                // change status in database
                $appointment->status = 'accept';
                $appointment->save();
                return response()->json(['status' => true, 'message' => 'appointment accepted ', 'data' => $appointment], 200);
            }
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => 'error found ', 'data' => $e->getMessage()], 400);
        }
    }
}
