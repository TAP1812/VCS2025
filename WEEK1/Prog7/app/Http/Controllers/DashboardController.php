<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $students = User::where('role', 'student')->get();
        $receivedMessages = Message::with('sender')
            ->where('receiver_id', auth()->id())
            ->latest()
            ->get();

        return view('dashboard', compact('students', 'receivedMessages'));
    }

    public function users()
    {
        $users = User::where('id', '!=', auth()->id())->get();
        return view('dashboard.users.index', compact('users'));
    }

    public function showUser(User $user)
    {
        $messages = Message::where(function($query) use ($user) {
                $query->where('sender_id', auth()->id())
                      ->where('receiver_id', $user->id);
            })->orWhere(function($query) use ($user) {
                $query->where('sender_id', $user->id)
                      ->where('receiver_id', auth()->id());
            })
            ->with('sender')
            ->latest()
            ->get();

        return view('dashboard.users.show', compact('user', 'messages'));
    }
}
