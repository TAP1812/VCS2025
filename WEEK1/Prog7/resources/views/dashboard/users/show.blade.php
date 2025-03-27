@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row g-4">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="text-center mb-4">
                        <div class="avatar-circle mb-3">
                            <span class="avatar-text">{{ substr($user->username, 0, 1) }}</span>
                        </div>
                        <h2 class="fw-bold text-primary">{{ $user->username }}'s Profile</h2>
                    </div>
                    <div class="profile-info">
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-envelope text-primary me-2"></i>
                            <p class="mb-0">{{ $user->email }}</p>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-user-tag text-primary me-2"></i>
                            <p class="mb-0">{{ $user->role }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm">
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
        </div>

        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0">Messages with {{ $user->username }}</h3>
                        <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#newMessageModal">
                            <i class="bi bi-plus-lg"></i> New Message
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="messages-list">
                        @forelse($messages as $message)
                            <div class="message-item mb-3 {{ $message->sender_id === auth()->id() ? 'text-end' : '' }}">
                                <div class="card d-inline-block {{ $message->sender_id === auth()->id() ? 'bg-primary text-white' : 'bg-light' }}" style="max-width: 80%;">
                                    <div class="card-body p-2">
                                        <p class="mb-1">{{ $message->message }}</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="text-{{ $message->sender_id === auth()->id() ? 'light' : 'muted' }}">
                                                {{ $message->created_at->diffForHumans() }}
                                            </small>
                                            @if($message->sender_id === auth()->id())
                                                <div class="btn-group btn-group-sm">
                                                    <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#editMessageModal{{ $message->id }}">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                    <form action="{{ route('messages.destroy', $message) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-light btn-sm" onclick="return confirm('Delete this message?')">
                                                            <i class="bi bi-trash"></i>
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
                            <div class="text-center text-muted">
                                <p>No messages yet. Start a conversation!</p>
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
    width: 100px;
    height: 100px;
    background-color: #007bff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
}
.avatar-text {
    color: white;
    font-size: 40px;
    font-weight: bold;
}
.profile-info {
    max-width: 400px;
    margin: 0 auto;
}
.messages-list {
    max-height: 500px;
    overflow-y: auto;
}
.message-item {
    animation: fadeIn 0.3s ease-in;
}
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>
@endsection
