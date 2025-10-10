<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'username' => 'required|string|unique:users,username',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            // Di sini saya ubah 'nullable' menjadi 'required' agar wajib ada foto
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            // Pesan-pesan kustom untuk error 'photo'
            'photo.required' => 'Foto Profil wajib diunggah.', // Tambahan pesan required
            'photo.image' => 'File yang diunggah harus berupa gambar.',
            'photo.mimes' => 'Gambar yang diunggah harus bertipe jpg, jpeg, atau png.',
            'photo.max'   => 'Ukuran gambar tidak boleh melebihi 2MB.',

            // Pesan-pesan kustom lainnya
            'username.required' => 'Username wajib diisi, jangan biarkan kosong.',
            'name.required' => 'Nama lengkap harus diisi.',
            'email.required' => 'Email tidak boleh kosong, mohon diisi.',
            'email.email' => 'Email yang dimasukkan tidak valid.',
            'email.unique' => 'Email yang ini sudah digunakan oleh orang lain.',
            'username.unique' => 'Username ini sudah terdaftar, coba pilih yang lain.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password harus terdiri dari minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $photoPath = null;

        // START: LOGIKA BARU UNTUK MENGURUS FILE PHOTO
        if ($request->hasFile('photo')) {
            // Menyimpan file di folder 'photos' di disk 'public'
            // dan mendapatkan path-nya.
            // Pastikan Anda sudah menjalankan 'php artisan storage:link'
            $photoPath = $request->file('photo')->store('photos', 'public');
        }
        // END: LOGIKA BARU UNTUK MENGURUS FILE PHOTO

        $user = User::create([
            'username' => $request->username,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 2,
            'photo' => $photoPath, // Menyimpan path ke kolom 'photo' di database
        ]);

        // Opsional: Logika Remember Me/Login Otomatis
           return redirect()
            ->intended(route('home')) // Arahkan ke dashboard setelah login
            ->with('success', 'Registrasi berhasil! Anda telah masuk.');
    }
}