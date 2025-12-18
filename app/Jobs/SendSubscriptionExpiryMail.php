<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendSubscriptionExpiryMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;
    protected $name;
    protected $expireDate;

    public function __construct($email, $name, $expireDate)
    {
        $this->email = $email;
        $this->name = $name;
        $this->expireDate = $expireDate;
    }

    public function handle(): void
    {
        Mail::raw(
            "Dear {$this->name}, your subscription will expire on {$this->expireDate}. Please renew to avoid service interruption.",
            function ($message) {
                $message->from(
                    config('mail.from.address'),
                    config('mail.from.name')
                )
                ->to($this->email)
                ->subject('Subscription Expiry Reminder');
            }
        );
    }
}
