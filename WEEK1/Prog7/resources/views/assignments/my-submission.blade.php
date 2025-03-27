@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">My Submission for: {{ $assignment->title }}</h1>
    
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h5 class="card-title mb-0">Submission Details</h5>
        </div>
        <div class="card-body">
            @if($submission)
                <div class="mb-4">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h6 class="mb-3">Current Submission</h6>
                            <p class="mb-2"><strong>Submitted:</strong> {{ $submission->created_at->diffForHumans() }}</p>
                            <p class="mb-3"><strong>Last Updated:</strong> {{ $submission->updated_at->diffForHumans() }}</p>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <a href="{{ route('submissions.download', ['filePath' => str_replace('submissions/', '', $submission->file_path)]) }}" 
                               class="btn btn-primary">
                                <i class="bi bi-download"></i> Download Current Submission
                            </a>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <form action="{{ route('submissions.update', $submission) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="file" class="form-label fw-bold">Update Submission</label>
                        <input type="file" class="form-control" name="file" required>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-arrow-up-circle"></i> Update Submission
                    </button>
                </form>
            @else
                <p>You haven't submitted anything for this assignment yet.</p>
                <a href="{{ route('assignments.index') }}" class="btn btn-primary">Go Back to Assignments</a>
            @endif
        </div>
    </div>
</div>
@endsection
