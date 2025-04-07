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

        $validationRules = [
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'avatar_url' => 'nullable|url'
        ];

        if ($user->isTeacher()) {
            $validationRules['username'] = 'required|unique:users,username,' . $user->id;
            $validationRules['fullname'] = 'required';
        }

        $validated = $request->validate($validationRules);

        try {
            if ($request->hasFile('avatar')) {
                // Delete old avatar if exists
                if ($user->avatar && !filter_var($user->avatar, FILTER_VALIDATE_URL)) {
                    Storage::delete($user->avatar);
                }

                // Store new avatar in private storage
                $path = $request->file('avatar')->store('avatars', 'local');
                $validated['avatar'] = $path;
            } elseif ($request->filled('avatar_url')) {
                if ($user->avatar && !filter_var($user->avatar, FILTER_VALIDATE_URL)) {
                    Storage::delete($user->avatar);
                }
                $validated['avatar'] = $request->avatar_url;
            }

            if (!$user->isTeacher()) {
                unset($validated['username'], $validated['fullname']);
            }

            $user->update($validated);

            return redirect()->route('profile.show')->with('success', 'Profile updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors(['avatar' => 'Error updating profile: ' . $e->getMessage()]);
        }
    }

    // Add new method to serve private images
    public function getAvatar($filename)
    {
        $path = 'avatars/' . $filename;
        if (!Storage::disk('local')->exists($path)) {
            abort(404);
        }
        return response()->file(storage_path('app/private/' . $path));
    }
}
