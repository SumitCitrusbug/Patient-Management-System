<?php

namespace App\Jobs;

use Exception;
use App\Mail\rejectMail;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class rejectAppointment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    { {
            Mail::to($this->user->users->email)->send(new rejectMail($this->user));
        }
    }
    public function failed(Exception $exception)
    {

        Log::error('Job failed' . $exception->getMessage());
    }
}
