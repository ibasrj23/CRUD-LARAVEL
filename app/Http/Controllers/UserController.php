<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengambil data user dengan pagination 5 per halaman
        $users = User::latest()->paginate(5);

        return view('user.index', [
            'users' => $users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'username' => 'required|string|unique:users,username',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'nullable|string|min:6|',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'photo.image' => 'File yang diunggah harus berupa gambar.',
            'photo.mimes' => 'Gambar yang diunggah harus bertipe jpg, jpeg, atau png.',
            'photo.max'   => 'Ukuran gambar tidak boleh melebihi 2MB.',
            'username.required' => 'Username wajib diisi, jangan biarkan kosong.',
            'name.required' => 'Nama lengkap harus diisi.',
            'email.required' => 'Email tidak boleh kosong, mohon diisi.',
            'email.email' => 'Email yang dimasukkan tidak valid.',
            'email.unique' => 'Email yang ini sudah digunakan oleh orang lain.',
            'password.min' => 'Password harus terdiri dari minimal 6 karakter.',
            'username.unique' => 'Username ini sudah terdaftar, coba pilih yang lain.',
        ]);

        // Upload foto
        $photoName = null;
        if ($request->hasFile('photo')) {
            $photoName = time().'.'.$request->photo->extension();
            $request->photo->move(public_path('photos'), $photoName);
        }

        // Menyimpan data user
        User::create([
            'username' => $validated['username'],
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'photo' => $photoName,
        ]);

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user) // Route model binding
    {
        return view('user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user) // Route model binding
    {
        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'username' => 'required|string|unique:users,username,' . $user->id,
        ], [
            'photo.image' => 'Pastikan file yang diunggah adalah gambar.',
            'photo.mimes' => 'Format gambar yang diperbolehkan adalah jpg, jpeg, dan png.',
            'photo.max'   => 'Maksimal ukuran gambar adalah 2MB.',
            'username.required' => 'Username harus diisi, tidak boleh kosong.',
            'email.required' => 'Email tidak boleh kosong, pastikan sudah benar.',
            'email.email' => 'Email yang Anda masukkan tidak valid.',
            'email.unique' => 'Email sudah terdaftar, coba menggunakan email lain.',
            'password.min' => 'Password harus terdiri dari minimal 6 karakter.',
            'username.unique' => 'Username sudah digunakan oleh orang lain, pilihlah yang unik.',
        ]);

        // Jika ada foto baru
        if ($request->hasFile('photo')) {
            $oldImage = public_path('photos/' . $user->photo);
            if ($user->photo && file_exists($oldImage)) {
                unlink($oldImage); // Menghapus foto lama
            }
            $photoName = time() . '.' . $request->photo->extension();
            $request->photo->move(public_path('photos'), $photoName);
            $user->photo = $photoName; // Update foto dengan yang baru
        }

        // Update data user
        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if (!empty($validated['password'])) {
            $user->password = bcrypt($validated['password']);
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'Data user berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // Menghapus foto lama jika ada
        $oldImage = public_path('photos/' . $user->photo);
        if ($user->photo && file_exists($oldImage)) {
            unlink($oldImage); // Menghapus foto
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User berhasil dihapus!');
    }
}
