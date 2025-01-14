<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($offerId)
    {
        $messages = Message::with('sender:id,name')
            ->when($offerId, function ($query, $offerId) {
                $query->where('offer_id', $offerId); // If offer_id exists, filter by it
            }, function ($query) {
                $query->whereNull('offer_id'); // If no offer_id, fetch direct messages
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($messages);
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     return view('messages.direct');
    // }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'offer_id' => 'nullable|exists:offers,id', // Offer ID is optional
        ]);
    
        Message::create([
            'sender_id' => Auth::id(),
            'message' => $request->message,
            'offer_id' => $request->offer_id, // If offer_id is null, it's a direct message
            'receiver_id' => $request->user_id,
        ]);
    
        return response()->json(['success' => true]);
    }

    // public function userMessages()
    // {
    //     // Fetch messages sent by the logged-in user
    //     $messages = Message::where('sender_id', Auth::id())
    //         ->orderBy('created_at', 'desc')
    //         ->get();

    //     // Return the view with the messages
    //     return view('messages.user', compact('messages'));
    // }


    // public function sendDirectMessage(Request $request)
    // {
    //     $request->validate([
    //         'message' => 'required|string',
    //     ]);

    //     Message::create([
    //         'sender_id' => Auth::id(),
    //         'message' => $request->message,
    //         // Leave offer_id null for direct messages
    //     ]);

    //     return redirect()->back()->with('success', 'Your message has been sent to the admin.');
    // }

    public function viewMessages()
    {
        // // Fetch distinct users who have participated in direct messages (offer_id is null)
        // $users = Message::whereNull('offer_id') // Only direct messages
        // ->where(function ($query) {
        //     $query->whereNotNull('sender_id') // Ensure sender exists
        //         ->whereNotNull('receiver_id'); // Ensure receiver exists
        // })
        // ->get()
        // ->flatMap(function ($message) {
        //     // Get both sender and receiver as participants
        //     return [$message->sender, $message->receiver];
        // })
        // ->filter() // Remove null participants
        // ->unique('id'); // Ensure unique users

        // // Fetch all direct messages for the admin dashboard
        // $messages = Message::with('sender:id,name', 'receiver:id,name')
        //     ->whereNull('offer_id') // Only direct messages
        //     ->orderBy('created_at', 'desc')
        //     ->get();

        // return view('admin.messages.index', compact('users', 'messages'));
        $adminId = 1;
            // Fetch distinct senders of messages
        $users = Message::with('sender:id,name')
            ->whereNull('offer_id') // Only direct messages
            ->whereNotNull('sender_id')
            ->where('sender_id', '!=', $adminId) // Ensure sender exists
            ->distinct('sender_id')
            ->get()
            ->pluck('sender'); // Get the sender details

        $messages = Message::with('sender:id,name', 'receiver:id,name')
            ->whereNull('offer_id') // Only direct messages
            ->where('sender_id', '!=', $adminId)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.messages.index', compact('users', 'messages'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Message $message)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Message $message)
    {
        //
    }
}
