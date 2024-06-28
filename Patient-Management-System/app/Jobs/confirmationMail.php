<?php

namespace App\Jobs;

use Exception;
use App\Models\Role;
use App\Models\User;
use App\Mail\confirmMail;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class confirmationMail implements ShouldQueue
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
            $adminemail = Role::with('users')->where('roles', 'admin')->first();

            Mail::to($adminemail->users->first()->email)->send(new confirmMail($this->user));

            Mail::to($this->user->doctor->email)->send(new confirmMail($this->user));
        }
    }

    public function failed(Exception $exception)
    {

        Log::error('Job failed' . $exception->getMessage());
    }
}
