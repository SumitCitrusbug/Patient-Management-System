<?php

namespace App\Jobs;

use Exception;
use App\Mail\SendMail;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class sendStripelink implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */

    protected $user, $invoice;

    public function __construct($user, $invoice)
    {
        $this->user = $user;

        $this->invoice = $invoice;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    { {
            Mail::to($this->user->users->email)->send(new SendMail($this->user, $this->invoice));
        }
    }
    public function failed(Exception $exception)
    {

        Log::error('Job failed' . $exception->getMessage());
    }
}
