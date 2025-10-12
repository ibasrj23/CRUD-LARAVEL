<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
    /**
     * Konstruktor: Middleware 'auth' diterapkan untuk semua metode di Controller ini.
     * FIX: Dihapus karena middleware 'auth' sudah diimplementasikan di routes/web.php.
     */
    // public function __construct()
    // {
    //     // Memastikan hanya user yang login yang bisa mengakses CRUD
    //     $this->middleware('auth');
    // }

    /**
     * Display a listing of the resource (Index)
     * Logika Kepemilikan: Admin melihat semua, User biasa melihat milik sendiri.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $search = $request->get('search');
        $sort = $request->get('sort', 'published_at');

        $postsQuery = Post::query()->with('user');

        // *** START: LOGIKA KEPEMILIKAN UNTUK INDEX ***
        if ($user->role !== 1) {
            // Jika bukan Admin, hanya tampilkan post yang dibuat oleh user ini
            $postsQuery->where('user_id', $user->id);
        }
        // *** END: LOGIKA KEPEMILIKAN UNTUK INDEX ***

        // Pencarian
        $postsQuery->when($search, function ($query, $search) {
            return $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        });

        // Urutan
        $postsQuery->when($sort === 'title', function ($q) {
            $q->orderBy('title', 'asc');
        }, function ($q) {
            $q->orderBy('published_at', 'desc');
        });

        // Paginate hasil
        $posts = $postsQuery->simplePaginate(5)->withQueryString();

        return view('posts.index', compact('posts', 'search', 'sort'));
    }

    /**
     * Show the form for creating a new resource.
     * FIX: Dulu hanya Admin, sekarang semua yang sudah login diizinkan.
     */
    public function create()
    {
        // Route sudah dilindungi oleh middleware 'auth' di routes/web.php
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     * FIX: Dulu hanya Admin, sekarang semua yang sudah login diizinkan.
     */
    public function store(Request $request)
    {
        // Cek Auth sudah dilakukan oleh middleware, tidak perlu pengecekan role di sini.
        $validated = $request->validate([
            'title'        => 'required|max:255',
            'content'      => 'required',
            'published_at' => 'required|date',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'is_active'    => 'required|boolean',
        ]);

        $imageName = null;

        if ($request->hasFile('image')) {
            try {
                $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
                $request->file('image')->move(public_path('image'), $imageName);
            } catch (\Throwable $e) {
                Log::error('Gagal upload gambar saat membuat post:', [
                    'error' => $e->getMessage(),
                ]);
                return back()->withInput()->with('error', 'Gagal mengupload gambar.');
            }
        }

        Post::create([
            'title'        => $validated['title'],
            'content'      => $validated['content'],
            'published_at' => $validated['published_at'],
            'image'        => $imageName,
            'is_active'    => $validated['is_active'],
            'user_id'      => Auth::id(), // ID user yang sedang login
        ]);

        return redirect()->route('posts.index')->with('success', 'Post berhasil dibuat!');
    }

    /**
     * Display the specified resource.
     * Semua yang sudah login (user, admin) bisa melihat detail post.
     */
    public function show(string $id)
    {
        $post = Post::with('user')->findOrFail($id);
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     * Logika Otorisasi: Hanya pemilik post atau Admin yang boleh mengedit.
     */
    public function edit(string $id)
    {
        $post = Post::findOrFail($id);

        // *** START: LOGIKA OTORISASI KEPEMILIKAN ***
        if (Auth::user()->role !== 1 && Auth::id() !== $post->user_id) {
            // Jika bukan Admin DAN bukan pemilik post
            return redirect()->route('posts.index')
                ->with('error', 'Anda tidak memiliki izin untuk mengedit post milik orang lain.');
        }
        // *** END: LOGIKA OTORISASI KEPEMILIKAN ***

        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     * Logika Otorisasi: Hanya pemilik post atau Admin yang boleh update.
     */
    public function update(Request $request, string $id)
    {
        $post = Post::findOrFail($id);

        // *** START: LOGIKA OTORISASI KEPEMILIKAN ***
        if (Auth::user()->role !== 1 && Auth::id() !== $post->user_id) {
            return redirect()->route('posts.index')
                ->with('error', 'Anda tidak memiliki izin untuk memperbarui post milik orang lain.');
        }
        // *** END: LOGIKA OTORISASI KEPEMILIKAN ***

        $validated = $request->validate([
            'title'        => 'required|max:255',
            'content'      => 'required',
            'published_at' => 'required|date',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'is_active'    => 'required|boolean',
        ]);

        $imageName = $post->image;

        if ($request->hasFile('image')) {
            try {
                if ($post->image && File::exists(public_path('image/' . $post->image))) {
                    File::delete(public_path('image/' . $post->image));
                }

                $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
                $request->file('image')->move(public_path('image'), $imageName);
            } catch (\Throwable $e) {
                Log::error('Gagal update gambar:', [
                    'post_id' => $post->id,
                    'error'   => $e->getMessage(),
                ]);
                return back()->with('error', 'Gagal memperbarui gambar.');
            }
        }

        $post->update([
            'title'        => $validated['title'],
            'content'      => $validated['content'],
            'published_at' => $validated['published_at'],
            'image'        => $imageName,
            'is_active'    => $validated['is_active'],
        ]);

        return redirect()->route('posts.index')->with('success', 'Post berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     * Logika Otorisasi: Hanya pemilik post atau Admin yang boleh menghapus.
     */
    public function destroy(string $id)
    {
        $post = Post::findOrFail($id);

        // *** START: LOGIKA OTORISASI KEPEMILIKAN ***
        if (Auth::user()->role !== 1 && Auth::id() !== $post->user_id) {
            return redirect()->route('posts.index')
                ->with('error', 'Anda tidak memiliki izin untuk menghapus post milik orang lain.');
        }
        // *** END: LOGIKA OTORISASI KEPEMILIKAN ***

        try {
            if ($post->image && File::exists(public_path('image/' . $post->image))) {
                File::delete(public_path('image/' . $post->image));
            }

            $post->delete();
            return redirect()->route('posts.index')->with('success', 'Post berhasil dihapus!');
        } catch (\Throwable $e) {
            Log::error('Gagal menghapus post:', [
                'post_id' => $id,
                'error'   => $e->getMessage(),
            ]);
            return redirect()->route('posts.index')->with('error', 'Terjadi kesalahan saat menghapus post.');
        }
    }
}
