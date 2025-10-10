<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash; // PENTING: Memastikan Hash ada
use Illuminate\Support\Facades\Log; // PENTING: Untuk logging
use Illuminate\Support\Facades\File; // PENTING: Untuk menghapus file jika menggunakan public_path
use Exception; // Untuk try-catch

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
            'password' => 'required|string|min:6', // Diubah menjadi required
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'role' => 'required|integer|in:1,2',
        ], [
            'photo.image' => 'File yang diunggah harus berupa gambar.',
            'photo.mimes' => 'Gambar yang diunggah harus bertipe jpg, jpeg, atau png.',
            'photo.max'   => 'Ukuran gambar tidak boleh melebihi 2MB.',
            'username.required' => 'Username wajib diisi, jangan biarkan kosong.',
            'name.required' => 'Nama lengkap harus diisi.',
            'email.required' => 'Email tidak boleh kosong, mohon diisi.',
            'email.email' => 'Email yang dimasukkan tidak valid.',
            'email.unique' => 'Email yang ini sudah digunakan oleh orang lain.',
            'password.required' => 'Password wajib diisi.', // Pesan tambahan
            'password.min' => 'Password harus terdiri dari minimal 6 karakter.',
            'username.unique' => 'Username ini sudah terdaftar, coba pilih yang lain.',
        ]);

        // Upload foto
        $photoName = null;
        if ($request->hasFile('photo')) {
            $photoName = $request->file('photo')->hashName(); // Menggunakan hashName()
            $request->photo->move(public_path('photos'), $photoName);
        }

        // Menyimpan data user
        User::create([
            'username' => $validated['username'],
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']), // Menggunakan Hash::make
            'photo' => $photoName,
            'role' => $validated['role']
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
        // Pengecualian ID user saat ini untuk Email dan Username
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            // Pengecualian untuk Email
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|integer|in:1,2',
            // Menambahkan 'confirmed' untuk Password Baru (opsional)
            'password' => 'nullable|string|min:6|confirmed',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            // Pengecualian untuk Username
            'username' => 'required|string|unique:users,username,' . $user->id,
        ], [
            // ... (Pesan-pesan kustom)
            'photo.image' => 'Pastikan file yang diunggah adalah gambar.',
            'photo.mimes' => 'Format gambar yang diperbolehkan adalah jpg, jpeg, dan png.',
            'photo.max' => 'Maksimal ukuran gambar adalah 2MB.',
            'username.required' => 'Username harus diisi, tidak boleh kosong.',
            'role.required' => 'Role harus diisi, tidak boleh kosong.',
            'email.required' => 'Email tidak boleh kosong, pastikan sudah benar.',
            'email.email' => 'Email yang Anda masukkan tidak valid.',
            'email.unique' => 'Email sudah terdaftar, coba menggunakan email lain.',
            'password.min' => 'Password harus terdiri dari minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'username.unique' => 'Username sudah digunakan oleh orang lain, pilihlah yang unik.',
        ]);

        try {
            // --- LOGIKA UPDATE FOTO ---
            if ($request->hasFile('photo')) {
                $oldImagePath = public_path('photos/' . $user->photo);

                // Cek dan hapus foto lama menggunakan File::exists()
                if ($user->photo && File::exists($oldImagePath)) {
                    File::delete($oldImagePath);
                }

                // Simpan foto baru
                $photoName = $request->file('photo')->hashName();
                $request->photo->move(public_path('photos'), $photoName);
                $user->photo = $photoName;
            }

            // --- UPDATE FIELD TEKS ---
            $user->name = $validated['name'];
            $user->email = $validated['email'];
            $user->role = $validated['role'];
            $user->username = $validated['username']; // BARIS INI KRUSIAL

            // Update password hanya jika diisi dan valid
            if (!empty($validated['password'])) {
                $user->password = Hash::make($validated['password']);
            }

            $user->save();

            return redirect()->route('users.index')->with('success', 'Data user berhasil diperbarui!');

        } catch (Exception $e) {
            // Log the error for debugging
            Log::error('User Update Failed: ' . $e->getMessage() . ' for user ID: ' . $user->id);

            // Kembalikan error yang lebih spesifik ke user
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui data. Cek log server untuk detail: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try {
            // Menghapus foto lama
            $oldImage = public_path('photos/' . $user->photo);
            if ($user->photo && File::exists($oldImage)) {
                File::delete($oldImage);
            }

            $user->delete();

            return redirect()->route('users.index')->with('success', 'User berhasil dihapus!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus user: ' . $e->getMessage());
        }
    }
}
