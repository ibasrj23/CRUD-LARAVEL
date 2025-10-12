<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('home');
        }

        $roleName = ($user->role == 1) ? 'Administrator' : 'User Biasa';

        // ✅ Kolom foto di database: 'photo'
        $profileImage = null;
        if (!empty($user->photo) && File::exists(public_path('photos/' . $user->photo))) {
            $profileImage = asset('photos/' . $user->photo);
        } else {
            $profileImage = asset('images/default-avatar.png');
        }

        return view('profile.edit', compact('user', 'roleName', 'profileImage'));
    }

    public function edit()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('home');
        }

        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user->name = $validated['name'];
        $user->username = $validated['username'];
        $user->email = $validated['email'];

        // ✅ Update password hanya kalau user isi password baru
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        // ✅ Handle upload foto (kolom 'photo')
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();

            // Hapus foto lama jika ada
            if ($user->photo && File::exists(public_path('photos/' . $user->photo))) {
                File::delete(public_path('photos/' . $user->photo));
            }

            // Simpan foto baru
            $file->move(public_path('photos'), $filename);

            // Update nama file ke database
            $user->photo = $filename;
        }

        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Profil berhasil diperbarui!');
    }

    public function destroy()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('home');
        }

        $user->delete();
        Auth::logout();

        return redirect()->route('login')->with('success', 'Akun Anda berhasil dihapus.');
    }
}
