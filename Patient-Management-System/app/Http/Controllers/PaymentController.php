<?php

namespace App\Http\Controllers;

use DateTime;
use Exception;
use DateTimeZone;
use Carbon\Carbon;
use Stripe\Charge;
use Stripe\Stripe;
use Stripe\Invoice;

use App\Models\Payment;
use App\Jobs\VoidInvoice;
use App\Mail\confirmMail;
use App\Models\Appointment;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Jobs\confirmationMail;
use Stripe\Stripe as StripeStripe;
use Illuminate\Support\Facades\Log;
use GrahamCampbell\ResultType\Success;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function  payInvoice(Request $request)
    {
        $appointment_id = $request->id;
        $appointment = Appointment::with('users', 'doctor', 'timeSlots')->find($appointment_id);

        if (!$appointment) {
            return response()->json(['status' => false, 'message' => 'id not found '], 400);
        }
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        // create customer
        $res =   $stripe->customers->create([
            'name' => $appointment->users->name,
            'email' => $appointment->users->email,
        ]);




        $invoice =  $stripe->invoices->create(['customer' => $res->id, 'collection_method' => 'send_invoice', 'days_until_due' => 1]);
        //create invoice item
        $item =  $stripe->invoiceItems->create([
            'customer' => $res->id,
            'invoice' => $invoice->id,
            'amount' => $appointment->doctor->amount * 100,
            'currency' => 'usd',
            'description' => 'doctor name : ' . $appointment->doctor->name .
                ', appointment time :' . $appointment->timeSlots->time_start . '-' . $appointment->timeSlots->time_start .
                ', appointment date :' . $appointment->timeSlots->date,
            'metadata' => ['appointment_id' => $appointment_id],

        ]);


        //  finalize invoice
        $invoice =    $stripe->invoices->finalizeInvoice($invoice->id);

        $payment = new Payment;
        $payment->id = Str::uuid();
        $payment->appointment_id = $appointment_id;
        $payment->payment_intent_id = $invoice->payment_intent;
        $payment->save();


        dispatch(new VoidInvoice($invoice->id))->delay(Carbon::now()->addSeconds(20));


        return $invoice->hosted_invoice_url;
    }

    public function webhookCAll(Request $request)
    {
        $requestarray = $request->all();
        $id = $requestarray['data']['object']['id'];

        //get payment intent id
        $payment = Payment::where('payment_intent_id', $id)->first();
        $appointment = Appointment::where('id', $payment->appointment_id)->first();
        $user = Appointment::with('users', 'doctor', 'timeSlots')->find($payment->appointment_id);

        if ($request->type == 'payment_intent.succeeded') {




            //update payment table

            $payment->status = 'completed';
            $payment->save();
            // updete appointment table

            $appointment->status = 'paid';
            $appointment->save();

            // send payment confimation mail to doctor and admin
            dispatch(new confirmationMail($user));
        }
        if ($request->type == 'payment_intent.payment_failed' || $request->type == 'payment_intent.canceled') {

            //update payment table

            $payment->status = 'failed';
            $payment->save();

            $user->status = 'failed';
            $user->timeslots->avaliblity = 1;
            $user->timeslots->save();
            $user->save();
        } else {
            echo 'Received unknown event type ' . $request->type;
        }
    }
}
