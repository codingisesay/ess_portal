<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendOrganisationCredentialsMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;
    protected $password;
    protected $loginUrl;

    public function __construct($email, $password, $loginUrl)
    {
        $this->email = $email;
        $this->password = $password;
        $this->loginUrl = $loginUrl;
    }

    public function handle(): void
    {
        Mail::raw(
            "Welcome to PayVance HRMS 👋

Your account has been created successfully.

Login Details:
Email: {$this->email}
Password: {$this->password}

Login URL: {$this->loginUrl}

Please change your password after first login.",
            function ($message) {
                $message->to($this->email)
                        ->subject('Your PayVance HRMS Login Credentials');
            }
        );
    }
}
