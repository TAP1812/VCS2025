@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Submissions for: {{ $assignment->title }}</h1>
    
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h5 class="card-title mb-0">Student Submissions</h5>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Student Name</th>
                        <th>Submitted At</th>
                        <th>File</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($submissions as $submission)
                        <tr>
                            <td>{{ $submission->student->fullname }}</td>
                            <td>{{ $submission->created_at->diffForHumans() }}</td>
                            <td>
                                <div class="text-center">
                                    <a href="{{ route('submissions.download', ['filePath' => str_replace('submissions/', '', $submission->file_path)]) }}" 
                                       class="btn btn-primary btn-sm">
                                        <i class="bi bi-download"></i> Download
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
