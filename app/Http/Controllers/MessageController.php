<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

        $messages = Message::select('messages.*')
            ->join(
                DB::raw('(SELECT MAX(created_at) as latest_time, sender_id, receiver_id FROM messages GROUP BY sender_id, receiver_id) as latest_messages'),
                function ($join) {
                    $join->on('messages.created_at', '=', 'latest_messages.latest_time')
                        ->on('messages.sender_id', '=', 'latest_messages.sender_id')
                        ->on('messages.receiver_id', '=', 'latest_messages.receiver_id');
                }
            )
            ->where(function ($query) use ($adminId) {
                $query->where('messages.sender_id', '!=', $adminId)
                    ->where('messages.receiver_id', '!=', $adminId);
            })
            ->orderBy('messages.created_at', 'desc')
            ->with('sender:id,name')
            ->get();

        return view('admin.messages.index', compact('messages'));
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
