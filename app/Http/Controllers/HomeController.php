<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class HomeController extends Controller
{
    /**
     * Display the Dashboard (Index) with recent posts data.
     */
    public function index(Request $request)
    {
        // Menggunakan helper request() untuk mengambil parameter search
        $search = request('search');

        // 1. Inisialisasi Query dengan Eager Loading User
        $query = Post::with('user');

        // 2. Logic Filtering Status Post (Dinamis berdasarkan skema DB)
        if (Schema::hasColumn('posts', 'is_active')) {
            $query->where('is_active', true);
        } elseif (Schema::hasColumn('posts', 'is_publish')) {
            $query->where('is_publish', true);
        }
        // Jika kedua kolom tidak ada, query dijalankan tanpa filter status,
        // yang penting untuk mencegah fatal error saat booting.

        // 3. Logic Pencarian
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('content', 'LIKE', "%{$search}%");
            });
        }

        // 4. Logic Pengurutan (Dinamis berdasarkan skema DB)
        // Gunakan published_at jika ada, jika tidak, gunakan created_at
        $orderByColumn = Schema::hasColumn('posts', 'published_at') ? 'published_at' : 'created_at';
        $posts = $query->orderBy($orderByColumn, 'desc')->paginate(6);

        // Mengembalikan view 'home' (home.blade.php)
        return view('home', compact('posts', 'search'));
    }
}