<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DirectMessagesController extends Controller
{
    public function index()
    {
        $adminId = 1;

        $messages = Message::with('sender:id,name')
            ->where(function ($query) use ($adminId) {
                $query->where('sender_id', Auth::id())
                    ->orWhere('sender_id', $adminId)->where('receiver_id', Auth::id());
            })
            ->whereNull('offer_id')
            ->orderBy('created_at', 'asc')
            ->get();

        return view('messages.user', compact('messages'));
    }

    /**
     * Store a newly created message in the database.
     */
    
    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
        ]);
    
    
        Message::create([
            'sender_id' => Auth::id(),
            'message' => $request->message,
            'offer_id' => null,
            'receiver_id' => Auth::id(),
        ]);
    
        return redirect()->route('messages.user')->with('success', 'Your message has been sent to the admin.');
    }

    public function chat($userId)
    {
        $adminId = Auth::id();

        $messages = Message::with('sender:id,name')
            ->where(function ($query) use ($userId, $adminId) {
                $query->where('sender_id', $userId)
                    ->orWhere('sender_id', $adminId)->where('receiver_id', $userId);
            })
            ->whereNull('offer_id')
            ->orderBy('created_at', 'asc')
            ->get();

        $user = User::findOrFail($userId);

        return view('admin.messages.chat', compact('messages', 'user'));
    }

    public function reply(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'user_id' => 'required|exists:users,id',
        ]);
    
        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->user_id,
            'message' => $request->message,
            'offer_id' => null,
        ]);
    
        return redirect()->route('admin.messages.chat', ['userId' => $request->user_id])
                         ->with('success', 'Message sent successfully.');
    }

    public function markRead($id)
    {
        $message = Message::findOrFail($id);
        $message->update(['is_read' => true]);

        return redirect()->back()->with('success', 'Message marked as read.');
    }

    public function markUnread($id)
    {
        $message = Message::findOrFail($id);
        $message->update(['is_read' => false]);

        return redirect()->back()->with('success', 'Message marked as unread.');
    }

}
