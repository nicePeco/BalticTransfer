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
        $adminId = 1; // Replace this with the actual admin ID or logic to get the admin's ID

        $messages = Message::with('sender:id,name')
            ->where(function ($query) use ($adminId) {
                $query->where('sender_id', Auth::id()) // Messages sent by the user
                    ->orWhere('sender_id', $adminId)->where('receiver_id', Auth::id());; // Messages sent by the admin
            })
            ->whereNull('offer_id') // Only direct messages (not related to offers)
            ->orderBy('created_at', 'asc') // Sort by oldest to newest
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
            'sender_id' => Auth::id(), // The logged-in user
            'message' => $request->message,
            'offer_id' => null,
            'receiver_id' => Auth::id(), // Mark as a direct message
        ]);
    
        return redirect()->route('messages.user')->with('success', 'Your message has been sent to the admin.');
    }

    public function chat($userId)
    {
        $adminId = Auth::id(); // Admin's ID (logged-in admin)

        $messages = Message::with('sender:id,name')
            ->where(function ($query) use ($userId, $adminId) {
                $query->where('sender_id', $userId)// Messages sent by the user
                    ->orWhere('sender_id', $adminId)->where('receiver_id', $userId);; // Messages sent by the admin
            })
            ->whereNull('offer_id') // Only direct messages
            ->orderBy('created_at', 'asc') // Sort by oldest to newest
            ->get();

        $user = User::findOrFail($userId); // Get the user details for the chat

        return view('admin.messages.chat', compact('messages', 'user'));
    }

    public function reply(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'user_id' => 'required|exists:users,id', // Validate that the user exists
        ]);
    
        Message::create([
            'sender_id' => Auth::id(), // Admin's ID (logged-in admin)
            'receiver_id' => $request->user_id, // The user receiving the message
            'message' => $request->message,
            'offer_id' => null, // Direct message
        ]);
    
        return redirect()->route('admin.messages.chat', ['userId' => $request->user_id])
                         ->with('success', 'Message sent successfully.');
    }

}
