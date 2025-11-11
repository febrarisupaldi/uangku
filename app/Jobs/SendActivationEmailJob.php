<?php

namespace App\Jobs;

use App\Mail\ActivationMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendActivationEmailJob implements ShouldQueue
{
    use Queueable, InteractsWithQueue, SerializesModels;


    public string $email;
    public string $url;
    public string $username;
    /**
     * Create a new job instance.
     */
    public function __construct(string $email, string $url, string $username)
    {
        $this->email = $email;
        $this->url = $url;
        $this->username = $username;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->email)->send(new ActivationMail($this->username, $this->url));
    }
}
