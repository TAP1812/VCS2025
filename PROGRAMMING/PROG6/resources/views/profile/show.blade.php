@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Profile Settings</h3>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Avatar Display -->
                    <div class="text-center mb-4">
                        @php
                            $avatarUrl = filter_var($user->avatar, FILTER_VALIDATE_URL)
                                ? $user->avatar
                                : ($user->avatar
                                    ? route('avatar.show', ['filename' => basename($user->avatar)])
                                    : 'https://via.placeholder.com/150');
                        @endphp
                        <img src="{{ $avatarUrl }}"
                             class="rounded-circle"
                             alt="Avatar"
                             style="width: 150px; height: 150px; object-fit: cover; border: 3px solid #007bff;">
                    </div>

                    <!-- Profile Form -->
                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Username and Role -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Username</label>
                                    @if($user->isTeacher())
                                        <input type="text" class="form-control" name="username"
                                               value="{{ old('username', $user->username) }}" required>
                                    @else
                                        <div class="form-control bg-light">{{ $user->username }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Role</label>
                                    <div class="form-control bg-light">{{ ucfirst($user->role) }}</div>
                                </div>
                            </div>
                        </div>

                        <!-- Full Name -->
                        <div class="mb-3">
                            <label for="fullname" class="form-label">Full Name</label>
                            @if($user->isTeacher())
                                <input type="text" class="form-control" id="fullname" name="fullname"
                                       value="{{ old('fullname', $user->fullname) }}" required>
                            @else
                                <div class="form-control bg-light">{{ $user->fullname }}</div>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                   value="{{ old('email', $user->email) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone"
                                   value="{{ old('phone', $user->phone) }}">
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Avatar</label>
                            <div class="mb-3">
                                <label for="avatar" class="form-label">Upload Image</label>
                                <input type="file" class="form-control" id="avatar" name="avatar" accept="image/*">
                            </div>
                            <div class="mb-3">
                                <label for="avatar_url" class="form-label">Or Use Image URL</label>
                                <input type="url" class="form-control" id="avatar_url" name="avatar_url"
                                       placeholder="https://example.com/image.jpg">
                                <small class="text-muted">Enter a URL to use an external image as your avatar</small>
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">Update Profile</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
