<?php

namespace App\Jobs;

use Stripe\Stripe;
use Stripe\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class VoidInvoice implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */

    protected $invoiceId;
    public function __construct($invoiceId)
    {
        $this->invoiceId = $invoiceId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            Log::info('Invoice running');
            $invoice = Invoice::retrieve($this->invoiceId);
            $invoice->voidInvoice();
        } catch (\Exception $e) {
            Log::error('Failed to void invoice: ' . $e->getMessage());
        }
        //
    }
}
