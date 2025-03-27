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

    public function downloadAssignment($filePath)
    {
        $path = "assignments/{$filePath}";
        if (Storage::exists($path)) {
            return Storage::download($path);
        }
        abort(404);
    }

    public function downloadSubmission($filePath)
    {
        $path = "submissions/{$filePath}";
        if (Storage::exists($path)) {
            return Storage::download($path);
        }
        abort(404);
    }

    public function viewSubmissions(Assignment $assignment)
    {
        $submissions = $assignment->submissions()
            ->with('student')
            ->latest()
            ->get();
            
        return view('assignments.submissions', compact('assignment', 'submissions'));
    }

    public function viewMySubmission(Assignment $assignment)
    {
        $submission = Submission::where('assignment_id', $assignment->id)
            ->where('student_id', auth()->id())
            ->first();
            
        return view('assignments.my-submission', compact('assignment', 'submission'));
    }

    public function updateSubmission(Request $request, Submission $submission)
    {
        // Verify the submission belongs to the student
        if ($submission->student_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'file' => 'required|file'
        ]);

        // Delete old file
        Storage::delete($submission->file_path);
        
        // Store new file
        $path = $request->file('file')->store('submissions');
        $submission->update(['file_path' => $path]);

        return back()->with('success', 'Submission updated successfully');
    }
}
