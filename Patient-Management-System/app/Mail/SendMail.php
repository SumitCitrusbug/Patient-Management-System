<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\App;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use App\Http\Controllers\PaymentController;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    protected $user,  $invoice;
    public function __construct($user, $invoice)
    {


        $this->user = $user;

        $this->invoice = $invoice;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Appointment payment',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {

        // $anotherController = App::make(PaymentController::class);
        // $data = $anotherController->makePayment();
        return new Content(
            view: 'stripemail',
            with: ['user' => $this->user,  'invoice' => $this->invoice]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
