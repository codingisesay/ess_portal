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

/**
 * ✅ Fetch latest notifications via AJAX
 * Returns a JSON response for dynamic header updates
 */
public function fetchNotifications()
{
    $user = auth()->user();

    // Fetch 10 latest notifications (unread first)
    $notifications = $user->notifications()
        ->latest()
        ->take(10)
        ->get()
        ->map(function ($notification) {
            return [
                'id'         => $notification->id,
                'title'      => $notification->data['title'] ?? 'Notification',
                'message'    => $notification->data['message'] ?? '',
                'link'       => $notification->data['link'] ?? null,
                'type'       => $notification->data['type'] ?? null,
                'read_at'    => $notification->read_at,
                'created_at' => $notification->created_at->diffForHumans(),
            ];
        });

    // Return as JSON for frontend
    return response()->json([
        'success' => true,
        'notifications' => $notifications,
        'unread_count' => $user->unreadNotifications->count(),
    ]);
}


/**
 * ✅ Clear (delete) a single notification
 */
public function clearNotification($id)
{
    $user = auth()->user();

    // Find the notification belonging to the logged-in user
    $notification = $user->notifications()->find($id);

    if ($notification) {
        $notification->delete();
        return response()->json(['success' => true, 'message' => 'Notification cleared.']);
    }

    return response()->json(['success' => false, 'message' => 'Notification not found.'], 404);
}

/**
 * ✅ Clear all notifications for the logged-in user
 */
public function clearAllNotifications()
{
    $user = auth()->user();

    $user->notifications()->delete();

    return response()->json(['success' => true, 'message' => 'All notifications cleared.']);
}


}
