<?php

namespace App\Http\Controllers;

use Exception;
use Stripe\Charge;
use Stripe\Stripe;
use Stripe\Invoice;
use App\Models\Payment;
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
        $appointment = Appointment::with('users', 'docter', 'timeSlots')->find($appointment_id);

        if (!$appointment) {
            return response()->json(['status' => false, 'message' => 'id not found '], 400);
        }
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));

        // create customer
        $res =   $stripe->customers->create([
            'name' => $appointment->users->name,
            'email' => $appointment->users->email,
        ]);
        $invoice =  $stripe->invoices->create(['customer' => $res->id, 'collection_method' => 'send_invoice', 'days_until_due' => 7,]);

        //create invoice item
        $item =  $stripe->invoiceItems->create([
            'customer' => $res->id,
            'invoice' => $invoice->id,
            'amount' => $appointment->docter->amount * 100,
            'currency' => 'usd',
            'description' => 'docter name : ' . $appointment->docter->name .
                ', appointment time :' . $appointment->appointment_time .
                ', appointment date :' . $appointment->appointment_date,
            'metadata' => ['appointment_id' => $appointment_id],

        ]);

        //finalize invoice
        $invoice =    $stripe->invoices->finalizeInvoice($invoice->id);

        //add paiding payment to table
        $payment = new Payment;
        $payment->id = Str::uuid();
        $payment->appointment_id = $appointment_id;
        $payment->payment_intent_id = $invoice->payment_intent;
        $payment->save();

        return $invoice->hosted_invoice_url;
    }

    public function webhookCAll(Request $request)
    {
        switch ($request->type) {

                // handle on payment successful
            case 'payment_intent.succeeded':
                $requestarray = $request->all();

                //get payment intent id
                $id = $requestarray['data']['object']['id'];

                //update payment table
                $payment = Payment::where('payment_intent_id', $id)->first();
                $payment->status = 'completed';
                $payment->save();
                // updete appointment table
                $appointment = Appointment::where('id', $payment->appointment_id)->first();
                $appointment->status = 'paid';
                $appointment->save();

                $user = Appointment::with('users', 'docter', 'timeSlots')->find($payment->appointment_id);
                // send payment confimation mail to docter and admin
                dispatch(new confirmationMail($user));

                //   handle on payment failed
            case 'invoice.payment_failed':
                $requestarray = $request->all();

                //get payment intent id
                $id = $requestarray['data']['object']['id'];

                //update payment table
                $payment = Payment::where('payment_intent_id', $id)->first();
                $payment->status = 'failed';
                $payment->save();
            default:
                echo 'Received unknown event type ' . $request->type;
        }
    }
}
