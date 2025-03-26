@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Challenges</h1>

    @if(auth()->user()->isTeacher())
    <div class="card shadow mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="card-title mb-0">Create Challenge</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('challenges.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="hint" class="form-label">Hint</label>
                    <textarea class="form-control" name="hint" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="file" class="form-label">Upload .txt file</label>
                    <input type="file" class="form-control" name="file" accept=".txt" required>
                </div>
                <button type="submit" class="btn btn-primary">Create Challenge</button>
            </form>
        </div>
    </div>
    @endif

    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h5 class="card-title mb-0">Challenges List</h5>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Hint</th>
                        <th>Action</th>
                        <th>State</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($challenges as $challenge)
                        <tr>
                            <td>{{ $challenge->hint }}</td>
                            <td>
                                <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#challengeModal{{ $challenge->id }}">
                                    Solve
                                </button>
                            </td>
                            <td>
                                <span class="badge {{ isset($statuses[$challenge->id]) && $statuses[$challenge->id] === 'solved' ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $statuses[$challenge->id] ?? 'not solved' }}
                                </span>
                            </td>
                        </tr>
                        
                        <div class="modal fade" id="challengeModal{{ $challenge->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('challenges.solve', $challenge) }}" method="POST">
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title">Solve Challenge</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="answer" class="form-label">Your Answer</label>
                                                <input type="text" class="form-control" name="answer" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
