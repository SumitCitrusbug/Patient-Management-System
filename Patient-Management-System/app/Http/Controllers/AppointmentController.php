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
use PhpParser\Node\Stmt\Return_;

class AppointmentController extends Controller
{

    //book appointment
    public function bookAppointment(Request $request)
    {
        //validation
        $validate = Validator::make($request->all(), [
            "timeslot_id" => "required",

        ]);
        if ($validate->fails()) {
            return response()->json(['status' => false, 'message' => 'validation error ', 'data' => $validate->errors()]);
        }

        $timeslote = Timeslot::where('id', $request->timeslot_id)->first();

        if ($timeslote) {

            // upadte appointment table in database
            if ($timeslote->avaliblity == 1) {
                $appointment = new Appointment();
                $appointment->id = Str::uuid();
                $appointment->doctor_id = $timeslote->doctor_id;
                $appointment->user_id = Auth::user()->id;
                $appointment->timeslot_id = $timeslote->id;
                $appointment->save();

                //change timeslot availability
                $timeslote = Timeslot::findOrFail($timeslote->id);
                $timeslote->avaliblity = 0;
                $timeslote->save();

                return response()->json(['status' => true, 'message' => 'appointment booked'], 200);;
            } else {
                return response()->json(['status' => false, 'message' => 'time slot not available for the appointment'], 400);;
            }
        } else {
            return response()->json(['status' => false, 'message' => 'No appointment which are you looking for '], 400);
        }
    }

    // view appointment
    public function viewAppointment()
    {
        //
        try {


            $appointment = Appointment::with('users:id,name', 'doctor:id,name,specialties,amount', 'timeSlots:id,time_start,time_end,date')->get()->setHidden([
                'timeslot_id', 'user_id', 'doctor_id', 'created_at', 'updated_at'
            ]);;

            if (count($appointment) <= 0) {
                return response()->json(['status' => false, 'message' => 'No appointment'], 400);
            }
            return response()->json(['status' => true, 'message' => 'All Appointments', 'data' => $appointment], 200);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => 'error found ', 'data' => $e->getMessage()], 400);
        }
    }


    // reject appointment
    public function rejectAppointment(Request $request)
    {

        try {

            $appointmentStatus = Appointment::with('users')->find($request->id);
            //appointment check validation
            if (!$appointmentStatus) {
                return response()->json(['status' => false, 'message' => 'id not found '], 400);
            }
            if ($appointmentStatus->status == 'paid') {

                return response()->json(['message' => 'appointment all ready paid '], 400);
            }
            if ($appointmentStatus->status == 'reject') {

                return response()->json(['message' => 'appointment all ready rejected book Another appointment '], 400);
            }


            $appointment = Appointment::find($request->id);
            if (!$appointment) {
                return response()->json(['status' => false, 'message' => 'id not found '], 400);
            } else {
                // send reject mail
                dispatch(new rejectAppointment($appointmentStatus));
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

            $appointmentStatus = Appointment::with('users', 'doctor', 'timeSlots')->find($request->id);
            //  appointment check validation


            if (!$appointmentStatus) {
                return response()->json(['status' => false, 'message' => 'id not found '], 400);
            }
            if ($appointmentStatus->status == 'accept') {

                return response()->json(['message' => 'appointment all ready accepted '], 400);
            }
            if ($appointmentStatus->status == 'paid') {

                return response()->json(['message' => 'appointment all ready paid '], 400);
            }
            if ($appointmentStatus->status == 'reject') {

                return response()->json(['message' => 'appointment all ready rejected book another appointment '], 400);
            }


            $appointment = Appointment::with('users')->find($request->id);


            if (!$appointment) {
                return response()->json(['status' => false, 'message' => 'id not found '], 400);
            } else {
                $invoice = app(PaymentController::class)->payInvoice($request);
                //send payment mail
                dispatch(new sendStripelink($appointmentStatus, $invoice));

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
