<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UserRegistrationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $userEmail;
    public $userPassword;

    /**
     * Create a new message instance.
     *
     * @param string $userEmail
     * @param string $userPassword
     * @return void
     */
    public function __construct($userEmail, $userPassword)
    {
        $this->userEmail = $userEmail;
        $this->userPassword = $userPassword;
    }


    /**
     * Create a new message instance.
     */

        /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Registration Successful')
                    ->view('emails.welcome')
                    ->with([
                        'email' => $this->userEmail,
                        'password' => $this->userPassword,
                    ]);
    }

    // /**
    //  * Get the message envelope.
    //  */
    // public function envelope(): Envelope
    // {
    //     return new Envelope(
    //         subject: 'User Registration Mail',
    //     );
    // }

    // /**
    //  * Get the message content definition.
    //  */
    // public function content(): Content
    // {
    //     return new Content(
    //         view: 'view.name',
    //     );
    // }

    // /**
    //  * Get the attachments for the message.
    //  *
    //  * @return array<int, \Illuminate\Mail\Mailables\Attachment>
    //  */
    // public function attachments(): array
    // {
    //     return [];
    // }
}
