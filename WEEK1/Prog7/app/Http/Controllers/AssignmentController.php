<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AssignmentController extends Controller
{
    public function index()
    {
        $assignments = Assignment::latest()->get();
        $submissions = auth()->user()->isTeacher() 
            ? Submission::with(['student', 'assignment'])->latest()->get()
            : [];

        return view('assignments.index', compact('assignments', 'submissions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'file' => 'required|file'
        ]);

        $path = $request->file('file')->store('assignments');
        Assignment::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'file_path' => $path
        ]);
        dd($path);
        return redirect()->route('assignments.index');
    }

    public function submit(Request $request, Assignment $assignment)
    {
        $validated = $request->validate([
            'file' => 'required|file'
        ]);

        $path = $request->file('file')->store('submissions');

        Submission::create([
            'assignment_id' => $assignment->id,
            'student_id' => auth()->id(),
            'file_path' => $path
        ]);

        return back();
    }

    public function download($filePath)
    {
        if (Storage::exists($filePath)) {
            return Storage::download($filePath);
        }
        dd(Storage::exists($filePath));
        abort(404);
    }
}
