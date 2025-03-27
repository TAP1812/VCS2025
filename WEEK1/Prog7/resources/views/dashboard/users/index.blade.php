@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 text-primary fw-bold">Users Directory</h2>
    <div class="row g-4">
        @foreach($users as $user)
            @if($user->id !== auth()->id())
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm hover-card">
                        <div class="card-body d-flex flex-column">
                            <div class="text-center mb-3">
                                <div class="avatar-circle mb-3">
                                    <span class="avatar-text">{{ substr($user->username, 0, 1) }}</span>
                                </div>
                                <h5 class="card-title fw-bold">{{ $user->username }}</h5>
                                <span class="badge bg-secondary">{{ $user->role }}</span>
                            </div>
                            <a href="{{ route('users.show', $user) }}" class="btn btn-primary mt-auto">View Profile</a>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</div>

<style>
.hover-card {
    transition: transform 0.2s;
}
.hover-card:hover {
    transform: translateY(-5px);
}
.avatar-circle {
    width: 60px;
    height: 60px;
    background-color: #007bff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
}
.avatar-text {
    color: white;
    font-size: 24px;
    font-weight: bold;
}
</style>
@endsection
