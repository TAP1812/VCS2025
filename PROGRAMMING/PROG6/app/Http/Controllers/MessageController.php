<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class MessageController extends Controller
{
    public function store(Request $request, User $user)
    {
        $validated = $request->validate([
            'message' => 'required'
        ]);

        Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $user->id,
            'message' => $validated['message']
        ]);

        return back();
    }

    public function update(Request $request, Message $message)
    {
        // Check if user owns the message
        if ($message->sender_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'message' => 'required|string|max:1000'
        ]);

        $message->update($validated);

        return back()->with('success', 'Message updated successfully');
    }

    public function destroy(Message $message)
    {
        // Check if user owns the message
        if ($message->sender_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $message->delete();
        return back()->with('success', 'Message deleted successfully');
    }
}
