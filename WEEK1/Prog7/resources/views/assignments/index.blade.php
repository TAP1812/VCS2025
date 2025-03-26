@extends('layouts.app')

@section('content')
<h1 class="mb-4">Assignments</h1>

@if(auth()->user()->isTeacher())
<div class="card shadow mb-4">
    <div class="card-header bg-primary text-white">
        <h5 class="card-title mb-0">Create Assignment</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('assignments.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" name="title" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" name="description" required></textarea>
            </div>
            <div class="mb-3">
                <label for="file" class="form-label">File</label>
                <input type="file" class="form-control" name="file" required>
            </div>
            <button type="submit" class="btn btn-primary">Create Assignment</button>
        </form>
    </div>
</div>
@endif

<div class="card shadow">
    <div class="card-header bg-primary text-white">
        <h5 class="card-title mb-0">Assignments List</h5>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($assignments as $assignment)
                    <tr>
                        <td>{{ $assignment->title }}</td>
                        <td>{{ $assignment->description }}</td>
                        <td>
                            <div class="btn-group">
                                <a href="/download/{{ $assignment->file_path }}" class="btn btn-primary btn-sm">Download</a>
                                @if(auth()->user()->isStudent())
                                    <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#submitModal{{ $assignment->id }}">
                                        Submit
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    
                    @if(auth()->user()->isStudent())
                    <!-- Submit Modal -->
                    <div class="modal fade" id="submitModal{{ $assignment->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('assignments.submit', $assignment) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-header">
                                        <h5 class="modal-title">Submit Assignment</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="file" class="form-label">Upload File</label>
                                            <input type="file" class="form-control" name="file" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
