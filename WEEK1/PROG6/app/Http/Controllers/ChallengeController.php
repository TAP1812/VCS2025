<?php

namespace App\Http\Controllers;

use App\Models\Challenge;
use App\Models\ChallengeStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ChallengeController extends Controller
{
    public function index()
    {
        $challenges = Challenge::latest()->get();
        $statuses = auth()->user()->challengeStatuses()->pluck('status', 'challenge_id');
        
        return view('challenges.index', compact('challenges', 'statuses'));
    }

    public function store(Request $request)
    {
        try {
            $path = $request->file('file')->store('challenges');
            Challenge::create([
                'hint' => $request->hint,
                'file_path' => $path
            ]);
            return redirect()->route('challenges.index')->with('success', 'Challenge created successfully');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to create challenge'])->withInput();
        }
    }

    public function solve(Request $request, Challenge $challenge)
    {
        $validated = $request->validate(['answer' => 'required']);
        $fileContent = Storage::get($challenge->file_path);
        
        $status = 'not solved';
        if (strtolower($validated['answer']) === strtolower(trim($fileContent))) {
            $status = 'solved';
        }

        ChallengeStatus::updateOrCreate(
            [
                'student_id' => auth()->id(),
                'challenge_id' => $challenge->id
            ],
            [
                'status' => $status,
                'solved_at' => $status === 'solved' ? now() : null
            ]
        );

        if ($status === 'solved') {
            return back()->with('success', "Correct! Answer: $fileContent");
        }
        return back()->with('error', 'Incorrect answer. Try again.');
    }
}
