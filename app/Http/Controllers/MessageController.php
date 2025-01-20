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
                $query->where('offer_id', $offerId);
            }, function ($query) {
                $query->whereNull('offer_id');
            })
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($messages);
    }

    /**
     * Show the form for creating a new resource.
     */

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'offer_id' => 'nullable|exists:offers,id',
        ]);
    
        Message::create([
            'sender_id' => Auth::id(),
            'message' => $request->message,
            'offer_id' => $request->offer_id,
            'receiver_id' => $request->user_id,
        ]);
    
        return response()->json(['success' => true]);
    }

    public function viewMessages()
    {
        $adminId = 1;
        $users = Message::with('sender:id,name')
            ->whereNull('offer_id')
            ->whereNotNull('sender_id')
            ->where('sender_id', '!=', $adminId)
            ->distinct('sender_id')
            ->get()
            ->pluck('sender');

        $messages = Message::with('sender:id,name', 'receiver:id,name')
            ->whereNull('offer_id')
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
