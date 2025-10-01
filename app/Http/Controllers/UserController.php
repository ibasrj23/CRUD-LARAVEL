<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

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
            'name' => 'required|string|max:255', // pastikan nama diisi
            'username' => 'required|string|unique:users,username', // username wajib dan unik
            'email' => 'required|email|unique:users,email', // email wajib dan unik
            'password' => 'required|string|min:6', // password wajib dan minimal 6 karakter
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // foto opsional, maksimal 2MB
        ]);


        // Mengupload foto jika ada
        $photoName = null;
        if ($request->hasFile('photo')) {
            // Menyimpan foto di folder public/photos
            $photoName = time() . '.' . $request->photo->extension();
            $request->photo->move(public_path('photos'), $photoName);
        }

        // Menyimpan data user
        User::create([
            'name' => $validated['name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']), // Password terenkripsi
            'photo' => $photoName, // Menyimpan nama foto
        ]);

        return redirect()->route('users.index')->with('success', 'Data user berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
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
            'password' => 'nullable|string|min:6|confirmed', // Password opsional
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Foto opsional
        ]);

        // Jika ada foto baru yang di-upload
        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            $oldImage = public_path('photos/' . $user->photo);
            if (file_exists($oldImage)) {
                unlink($oldImage); // Menghapus foto lama
            }

            // Upload foto baru
            $photoName = time() . '.' . $request->photo->extension();
            $request->photo->move(public_path('photos'), $photoName); // Menyimpan foto di folder public/photos
            $user->photo = $photoName; // Update foto dengan yang baru
        }

        // Update data user dengan data baru
        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if (!empty($validated['password'])) {
            $user->password = bcrypt($validated['password']);
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'Data user berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // Hapus foto lama jika ada
        $oldImage = public_path('photos/' . $user->photo);
        if ($user->photo && file_exists($oldImage)) {
            unlink($oldImage); // Menghapus foto
        }

        // Hapus data user
        $user->delete();

        return redirect()->route('users.index')->with('success', 'Data user berhasil dihapus');
    }
}
