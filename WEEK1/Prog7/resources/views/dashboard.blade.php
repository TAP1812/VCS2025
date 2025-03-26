@extends('layouts.app')

@section('content')
<h1 class="mb-4">Welcome, {{ auth()->user()->fullname }}</h1>

<div class="card shadow mb-4">
    <div class="card-header bg-primary text-white">
        <h5 class="card-title mb-0">Students List</h5>
    </div>
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $student)
                    <tr>
                        <td>{{ $student->username }}</td>
                        <td>{{ $student->fullname }}</td>
                        <td>{{ $student->email }}</td>
                        <td>
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#messageModal{{ $student->id }}">
                                Send Message
                            </button>
                        </td>
                    </tr>
                    
                    <!-- Message Modal -->
                    <div class="modal fade" id="messageModal{{ $student->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('messages.store', $student) }}" method="POST">
                                    @csrf
                                    <div class="modal-header">
                                        <h5 class="modal-title">Send Message to {{ $student->fullname }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="message" class="form-label">Message</label>
                                            <textarea class="form-control" name="message" required></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Send</button>
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

@if(auth()->user()->isStudent())
<div class="card shadow">
    <div class="card-header bg-primary text-white">
        <h5 class="card-title mb-0">Received Messages</h5>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>From</th>
                    <th>Message</th>
                    <th>Sent At</th>
                </tr>
            </thead>
            <tbody>
                @foreach($receivedMessages as $message)
                    <tr>
                        <td>{{ $message->sender->fullname }}</td>
                        <td>{{ $message->message }}</td>
                        <td>{{ $message->created_at->diffForHumans() }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif
@endsection
