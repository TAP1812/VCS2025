@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-primary fw-bold">Users Directory</h2>
        <div class="d-flex align-items-center">
            <span class="badge bg-primary fs-6 me-2">{{ $users->count() }} Users</span>
        </div>
    </div>
    
    <div class="row g-4">
        @foreach($users as $user)
            @if($user->id !== auth()->id())
                <div class="col-md-4 col-lg-3">
                    <div class="card h-100 shadow-sm hover-card">
                        <div class="card-body d-flex flex-column">
                            <div class="text-center mb-3">
                                @if($user->avatar)
                                    <div class="avatar-circle mb-3 overflow-hidden">
                                        <img src="{{ filter_var($user->avatar, FILTER_VALIDATE_URL) ? $user->avatar : ($user->avatar ? Storage::url($user->avatar) : 'https://via.placeholder.com/150') }}" alt="{{ $user->username }}" 
                                             class="img-fluid rounded-circle" style="width: 100%; height: 100%; object-fit: cover;">
                                    </div>
                                @else
                                    <div class="avatar-circle mb-3">
                                        <span class="avatar-text">{{ substr($user->username, 0, 1) }}</span>
                                    </div>
                                @endif
                                <h5 class="card-title fw-bold mb-1">{{ $user->username }}</h5>
                                @if($user->fullname)
                                    <p class="text-muted small mb-2">{{ $user->fullname }}</p>
                                @endif
                                <span class="badge bg-{{ $user->role === 'admin' ? 'danger' : 'secondary' }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </div>
                            
                            <div class="user-info mb-3">
                                <div class="d-flex align-items-center mb-1">
                                    <i class="fas fa-envelope text-muted me-2 small"></i>
                                    <small class="text-truncate">{{ $user->email }}</small>
                                </div>
                                @if($user->phone)
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-phone text-muted me-2 small"></i>
                                    <small>{{ $user->phone }}</small>
                                </div>
                                @endif
                            </div>
                            
                            <a href="{{ route('users.show', $user) }}" class="btn btn-outline-primary mt-auto">
                                <i class="fas fa-user-circle me-1"></i> View Profile
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</div>

<style>
.hover-card {
    transition: all 0.3s ease;
    border: none;
    border-radius: 12px;
}
.hover-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.12);
}
.avatar-circle {
    width: 100px;
    height: 100px;
    background: linear-gradient(135deg, #0061f2 0%, #6e00ff 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
    transition: all 0.3s ease;
}
.hover-card:hover .avatar-circle {
    transform: scale(1.1);
}
.avatar-text {
    color: white;
    font-size: 36px;
    font-weight: bold;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
}
.badge {
    padding: 6px 10px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 500;
    text-transform: capitalize;
}
.card-body {
    padding: 1.5rem;
}
.user-info {
    background: #f9f9f9;
    padding: 10px;
    border-radius: 8px;
    font-size: 0.85rem;
}
.btn {
    padding: 8px 16px;
    border-radius: 8px;
    font-weight: 500;
    transition: all 0.3s ease;
    font-size: 0.9rem;
}
.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}
.text-truncate {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
</style>
@endsection