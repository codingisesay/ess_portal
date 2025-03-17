<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UserAppliedLeaveStatus extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

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
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'User Applied Leave Status',
        );
    }

    public function build()
    {
        return $this->subject($this->subject)
                    ->view('emails.applied_leave_status')
                    ->with($this->data);
                
                }
}
