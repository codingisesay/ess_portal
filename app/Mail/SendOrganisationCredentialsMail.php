<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
// Mailable class to send organisation credentials email
class SendOrganisationCredentialsMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;
    protected $password;
    protected $loginUrl;
// Constructor to initialize email details
    public function __construct($email, $password, $loginUrl)
    {
        $this->email = $email;
        $this->password = $password;
        $this->loginUrl = $loginUrl;
    }
// Send the email with credentials
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
