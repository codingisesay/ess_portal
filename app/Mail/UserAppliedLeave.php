<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

use Illuminate\Support\Facades\DB;
use App\Models\organisation;
use App\Models\organisation_config_mail;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;

class UserAppliedLeave extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

     // public $userEmail;
    // public $userPassword;

    public $subject;
    public $data;

    /**
     * Create a new message instance.
     */

     /**
     * Create a new message instance.
     *
     * @param string $subject
     * @param string $data
     * @return void
     */
    // public function __construct($userEmail, $userPassword)
    // {
    //     $this->userEmail = $userEmail;
    //     $this->userPassword = $userPassword;
    // }
    public function __construct($subject, $data)
    {
        $this->subject = $subject;
        $this->data = $data;
    }

    /**
     * Get the message envelope.
     */
    // * Build the message.
    // *
    // * @return $this
    // */
//    public function build()
//    {
//        return $this->subject($this->subject)
//                    ->view('emails.applied_leave_mail')
//                    ->with($this->data);
               
//                }

public function build()
{
    // Assuming the org_id is passed in $this->data, extract it
    $orgId = $this->data['org_id'];

    // Fetch mail configuration for the given organization
    $mailConfig = DB::table('organisation_config_mails')
        ->where('organisation_id', $orgId)
        ->first();

    if ($mailConfig) {
        // Dynamically set the mail configuration for the organization
        Config::set('mail.mailers.smtp.host', $mailConfig->MAIL_HOST);
        Config::set('mail.mailers.smtp.port', $mailConfig->MAIL_PORT);
        Config::set('mail.mailers.smtp.username', $mailConfig->MAIL_USERNAME);
        Config::set('mail.mailers.smtp.password', $mailConfig->MAIL_PASSWORD);
        Config::set('mail.mailers.smtp.encryption', $mailConfig->MAIL_ENCRYPTION);
        Config::set('mail.from.address', $mailConfig->MAIL_FROM_ADDRESS);
        Config::set('mail.from.name', $mailConfig->MAIL_FROM_NAME);
    }

    return $this->from(Config::get('mail.from.address'), Config::get('mail.from.name'))
                ->subject($this->subject)
                ->view('emails.applied_leave_mail')
                ->with(['data' => $this->data]);
}
}
