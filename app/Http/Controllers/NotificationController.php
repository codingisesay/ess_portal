<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * ✅ Display all notifications (read + unread)
     */
    public function index()
    {
        // Fetch all notifications for the logged-in user, latest first
        $notifications = auth()->user()->notifications()->latest()->paginate(20);

        return view('notifications.index', compact('notifications'));
    }

    /**
     * ✅ Mark a specific notification as read when clicked
     */
    public function markAsRead($id)
    {
        // Find the notification for the logged-in user
        $notification = auth()->user()->notifications()->find($id);

        if ($notification) {
            // Mark it as read
            $notification->markAsRead();

            // Redirect user to the relevant link if available
            $link = $notification->data['link'] ?? null;

            if ($link) {
                return redirect($link);
            }
        }

        // If no link or not found, just return back
        return redirect()->back();
    }

    /**
     * ✅ Mark all notifications as read
     * Useful for "Mark all as read" button
     */
    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return redirect()->back()->with('success', 'All notifications marked as read.');
    }
}
