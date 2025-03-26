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
}
