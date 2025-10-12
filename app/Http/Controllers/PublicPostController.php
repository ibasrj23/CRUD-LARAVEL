<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Database\Eloquent\Builder;

class PublicPostController extends Controller
{
    /**
     * Display a listing of the published posts.
     * Route: posts.public.index (Untuk User/Publik)
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $sort = $request->get('sort', 'published_at');

        // Query dasar: Eager Load User.
        $postsQuery = Post::with('user');

        // FIX KRITIS: Filter where('is_active', true) di HILANGKAN
        // agar semua post muncul di tampilan publik untuk debugging dan user.

        // 1. Logic Pencarian (Menggunakan when() yang clean)
        $postsQuery->when($search, function (Builder $query, $search) {
            return $query->where('title', 'like', '%' . $search . '%')
                         ->orWhere('content', 'like', '%' . $search . '%');
        });

        // 2. Logic Pengurutan (Menggunakan if/elseif/else yang efisien)
        if ($sort == 'published_at') {
            $postsQuery->orderBy('published_at', 'desc');
        } elseif ($sort == 'title') {
            $postsQuery->orderBy('title', 'asc');
        } else {
            // Fallback: Default diurutkan berdasarkan tanggal terbaru
            $postsQuery->latest('published_at');
        }

        // Tampilkan 10 post per halaman untuk publik, pertahankan filter di URL
        $posts = $postsQuery->simplePaginate(10)->withQueryString();

        return view('posts.public_index', [
            'posts' => $posts, // Mengirim variabel jamak $posts
            'search' => $search,
            'sort' => $sort,
        ]);
    }

    /**
     * Display the specified resource.
     * Route: posts.public.show
     */
    public function show(string $id)
    {
        // Mencari post berdasarkan ID dan melakukan eager loading untuk user.
        // TIDAK ada filter is_active agar post tetap bisa dilihat.
        $post = Post::with('user')->findOrFail($id);

        return view('posts.public_show', compact('post'));
    }
}
