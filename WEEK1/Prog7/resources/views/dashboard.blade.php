@extends('layouts.app')

@section('content')
<h1 class="mb-4">Welcome, {{ auth()->user()->username }}</h1>

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
                    @if($student->id !== auth()->id())
                        <tr>
                            <td>{{ $student->username }}</td>
                            <td>{{ $student->fullname }}</td>
                            <td>{{ $student->email }}</td>
                            <td>
                                <a href="{{ route('users.show', $student) }}" class="btn btn-primary btn-sm">
                                    View Profile
                                </a>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
</div>

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
@endsection
