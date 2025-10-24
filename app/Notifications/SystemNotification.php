<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SystemNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $title;
    protected $message;
    protected $link;
    protected $type; // e.g., approval, leave, revert

    /**
     * @param string $title - Title of the notification
     * @param string $message - Message shown to user
     * @param string|null $link - Optional link for action
     * @param string|null $type - Type of notification (approve/reject/leave)
     */
    public function __construct($title, $message, $link = null, $type = null)
    {
        $this->title = $title;
        $this->message = $message;
        $this->link = $link;
        $this->type = $type;
    }

    /**
     * Channels used
     */
    public function via($notifiable)
    {
        return ['database', 'mail']; // can add 'broadcast' later
    }

    /**
     * Database structure
     */
    public function toDatabase($notifiable)
    {
        return [
            'title' => $this->title,
            'message' => $this->message,
            'link' => $this->link,
            'type' => $this->type,
            'sent_by' => auth()->user()->name ?? 'System',
        ];
    }

    /**
     * Mail structure
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject($this->title)
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line($this->message)
            ->action('View Details', $this->link ?? url('/'))
            ->line('Thank you for using the Employee Self Service System.');
    }
}
