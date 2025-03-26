<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

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
        $this->authorize('update', $message);
        
        $validated = $request->validate([
            'message' => 'required'
        ]);

        $message->update($validated);
        return back();
    }

    public function destroy(Message $message)
    {
        $this->authorize('delete', $message);
        $message->delete();
        return back();
    }
}
