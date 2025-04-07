@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card shadow-sm sticky-top" style="top: 20px;">
                <div class="card-body text-center">
                    @if($user->avatar)
                        <div class="avatar-circle mb-4 mx-auto overflow-hidden" style="width: 150px; height: 150px;">
                            @php
                                $avatarUrl = filter_var($user->avatar, FILTER_VALIDATE_URL)
                                    ? $user->avatar
                                    : ($user->avatar
                                        ? route('avatar.show', ['filename' => basename($user->avatar)])
                                        : 'https://via.placeholder.com/150');
                            @endphp
                            <img src="{{ $avatarUrl }}"
                                 alt="{{ $user->username }}"
                                 class="img-fluid rounded-circle"
                                 style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                    @else
                        <div class="avatar-circle mb-4 mx-auto" style="width: 150px; height: 150px;">
                            <span class="avatar-text text-white" style="font-size: 60px;">
                                {{ substr($user->username, 0, 1) }}
                            </span>
                        </div>
                    @endif

                    <h2 class="fw-bold mb-3">{{ $user->fullname ?? $user->username }}</h2>
                    <span class="badge bg-{{ $user->role === 'admin' ? 'danger' : 'primary' }} mb-3">
                        {{ ucfirst($user->role) }}
                    </span>

                    <div class="profile-details text-start mt-4">
                        <div class="d-flex align-items-center mb-3">
                            <div>
                                <small class="text-muted d-block">Username</small>
                                <strong>{{ $user->username }}</strong>
                            </div>
                        </div>

                        <div class="d-flex align-items-center mb-3">
                            <div>
                                <small class="text-muted d-block">Email</small>
                                <strong>{{ $user->email }}</strong>
                            </div>
                        </div>

                        @if($user->phone)
                        <div class="d-flex align-items-center mb-3">
                            <div>
                                <small class="text-muted d-block">Phone</small>
                                <strong>{{ $user->phone }}</strong>
                            </div>
                        </div>
                        @endif

                        @if($user->fullname)
                        <div class="d-flex align-items-center">
                            <div>
                                <small class="text-muted d-block">Full Name</small>
                                <strong>{{ $user->fullname }}</strong>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h3 class="card-title fw-bold mb-3">Send Message</h3>
                    <form action="{{ route('messages.store', $user) }}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <textarea name="message" class="form-control" rows="3"
                                placeholder="Type your message here..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-paper-plane me-2"></i>Send Message
                        </button>
                    </form>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0">Messages with {{ $user->username }}</h3>
                        <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#newMessageModal">
                            <i class="fas fa-plus me-1"></i> New Message
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="messages-list">
                        @forelse($messages as $message)
                            <div class="message-item mb-3 {{ $message->sender_id === auth()->id() ? 'text-end' : '' }}">
                                <div class="card d-inline-block {{ $message->sender_id === auth()->id() ? 'bg-primary text-white' : 'bg-light' }}" style="max-width: 80%;">
                                    <div class="card-body p-3">
                                        <p class="mb-1">{{ $message->message }}</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="text-{{ $message->sender_id === auth()->id() ? 'light' : 'muted' }}">
                                                {{ $message->created_at->diffForHumans() }}
                                            </small>
                                            @if($message->sender_id === auth()->id())
                                                <div class="btn-group btn-group-sm">
                                                    <button class="btn btn-{{ $message->sender_id === auth()->id() ? 'light' : 'secondary' }} btn-sm"
                                                            data-bs-toggle="modal" data-bs-target="#editMessageModal{{ $message->id }}">Update
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <form action="{{ route('messages.destroy', $message) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-{{ $message->sender_id === auth()->id() ? 'light' : 'secondary' }} btn-sm"
                                                                onclick="return confirm('Delete this message?')">Delete
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if($message->sender_id === auth()->id())
                                <!-- Edit Message Modal -->
                                <div class="modal fade" id="editMessageModal{{ $message->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="{{ route('messages.update', $message) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Message</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <textarea name="message" class="form-control" rows="3" required>{{ $message->message }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-primary">Update</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @empty
                            <div class="text-center text-muted py-4">
                                <i class="fas fa-comment-slash fa-3x mb-3"></i>
                                <p class="h5">No messages yet. Start a conversation!</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- New Message Modal -->
<div class="modal fade" id="newMessageModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('messages.store', $user) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Send New Message</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <textarea name="message" class="form-control" rows="3" placeholder="Type your message here..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Send</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.avatar-circle {
    background: linear-gradient(135deg, #0061f2 0%, #6e00ff 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
}
.icon-circle {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}
.profile-details {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 10px;
}
.messages-list {
    max-height: 500px;
    overflow-y: auto;
    padding: 15px;
}
.message-item {
    animation: fadeIn 0.3s ease-in;
    margin-bottom: 15px;
}
.message-item .card {
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}
.card {
    border: none;
    border-radius: 12px;
    transition: all 0.3s ease;
}
.card-header {
    border-radius: 12px 12px 0 0 !important;
}
.btn {
    transition: all 0.3s ease;
}
.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}
.sticky-top {
    position: -webkit-sticky;
    position: sticky;
}
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>
@endsection







