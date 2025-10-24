<?php

use App\Notifications\SystemNotification;
use App\Models\User;

/**
 * sendSystemNotification
 * ------------------------------------------------
 * Global helper for sending a Laravel notification
 * from anywhere in the project.
 *
 * @param int|string $userId   ID of recipient user
 * @param string     $title    Title shown in mail/UI
 * @param string     $message  Body message
 * @param string|null $link    Optional redirect link
 * @param string|null $type    Type (approve, reject, leave, etc.)
 */
if (!function_exists('sendSystemNotification')) {
    function sendSystemNotification($userId, $title, $message, $link = null, $type = null)
    {
        $user = User::find($userId);

        if ($user) {
            $user->notify(new SystemNotification($title, $message, $link, $type));
        }
    }
}
