<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show()
    {
        return view('profile.show', ['user' => Auth::user()]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        
        // Different validation rules based on role
        $validationRules = [
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable',
            'avatar' => 'nullable|image|max:2048',
            'avatar_url' => 'nullable|url'
        ];

        // Add username and fullname validation only for teachers
        if ($user->isTeacher()) {
            $validationRules['username'] = 'required|unique:users,username,' . $user->id;
            $validationRules['fullname'] = 'required';
        }

        $validated = $request->validate($validationRules);

        // Handle avatar (file upload or URL)
        if ($request->hasFile('avatar')) {
            // Handle file upload
            if ($user->avatar && Storage::exists($user->avatar)) {
                Storage::delete($user->avatar);
            }
            $path = $request->file('avatar')->store('avatars', 'public');
            $validated['avatar'] = $path;
        } elseif ($request->filled('avatar_url')) {
            // Handle URL-based avatar
            if ($user->avatar && Storage::exists($user->avatar)) {
                Storage::delete($user->avatar);
            }
            $validated['avatar'] = $request->avatar_url;
        }

        // Update only allowed fields based on role
        if (!$user->isTeacher()) {
            unset($validated['username'], $validated['fullname']);
        }

        $user->update($validated);

        return redirect()->route('profile.show')->with('success', 'Profile updated successfully');
    }
}
