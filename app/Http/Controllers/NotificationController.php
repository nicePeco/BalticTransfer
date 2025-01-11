<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification as FacadesNotification;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Auth::user()->unreadNotifications;

        return response()->json($notifications);
    }

    public function deleteNotification($id)
    {
        $notification = Auth::user()->unreadNotifications()->find($id);

        if ($notification) {
            $redirectRoute = $notification->data['offer_id'] ?? null;

            $notification->delete();

            if ($redirectRoute) {
                return redirect()->route('offers.accept.show', $redirectRoute);
            }

            return redirect()->back()->with('success', 'Notification deleted.');
        }

        return redirect()->back()->with('error', 'Notification not found.');
    }

    public function markAsRead($id)
    {
        $notification = Auth::user()->unreadNotifications()->find($id);

        if ($notification) {
            $notification->markAsRead();
            return response()->json(['success' => true]);
        }

        return response()->json(['error' => 'Notification not found.'], 404);
    }
}
