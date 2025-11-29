<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * 🔔 SystemNotification
 * ------------------------------------------------
 * Handles all system-wide notifications such as
 * approval, rejection, leave updates, etc.
 */
class SystemNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $title;
    public $message;
    public $link;
    public $type;

    /**
     * Create a new notification instance.
     */
    public function __construct($title, $message, $link = null, $type = null)
    {
        $this->title = $title;
        $this->message = $message;
        $this->link = $link;
        $this->type = $type;
    }

    /**
     * Get the notification's delivery channels.
     * You can add 'mail' if you also want emails.
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Store data in the notifications table
     */
    public function toArray($notifiable)
    {
        return [
            'title'   => $this->title,
            'message' => $this->message,
            'link'    => $this->link,
            'type'    => $this->type,
        ];
    }

    /**
     * (Optional) Define how it looks in email.
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject($this->title)
            ->line($this->message)
            ->action('View Details', $this->link ?? url('/'))
            ->line('Thank you for using our system!');
    }
}
