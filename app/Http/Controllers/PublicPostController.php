<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PublicPostController extends Controller
{
    /**
     * Menampilkan daftar semua Post untuk pengguna biasa (publik).
     */
    public function index()
    {
        // Mengambil post yang aktif (is_active = true)
        // Diurutkan dari yang terbaru dibuat.
        $posts = Post::where('is_active', true)
                     ->orderBy('created_at', 'desc')
                     ->paginate(5);

        // Mengembalikan view index publik.
        // FIX: Mengubah kembali ke 'posts.public_index' (huruf kecil)
        // untuk sinkronisasi dengan standar Laravel dan menghindari error jika file sudah dibuat.
        return view('posts.public_index', compact('posts'));
    }
}