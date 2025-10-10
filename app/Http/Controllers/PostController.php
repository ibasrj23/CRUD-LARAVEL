<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
// FIX KRITIS 1: Tambahkan dependency Auth, File, dan Log
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
    /**
     * Display a listing of the resource (Index).
     */
    public function index(Request $request)
    {
        // 1. Ambil parameter pencarian dan pengurutan
        $search = $request->get('search');
        $sort = $request->get('sort', 'published_at');

        // Query dasar
        $postsQuery = Post::query();

        // 2. Logic Pencarian
        if ($search) {
            $postsQuery->where('title', 'like', '%' . $search . '%')
                       ->orWhere('content', 'like', '%' . $search . '%');
        }

        // 3. Logic Pengurutan
        if ($sort == 'published_at') {
            $postsQuery->orderBy('published_at', 'desc');
        } elseif ($sort == 'title') {
            $postsQuery->orderBy('title', 'asc');
        } else {
            $postsQuery->latest('published_at');
        }

        // Kasih tampil cuma 5 halaman saja (Simple Paginate)
        $posts = $postsQuery->simplePaginate(5);

        $date = date('Y-m-d');

        return view('posts.index', [
            'posts' => $posts,
            'date' => $date,
            'search' => $search,
            'sort' => $sort,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //kasih validasi
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'published_at' => 'required|date',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        //simpan gambar di public bukan di storage
        $imageName = null;
        if ($request->hasFile('image')) {
            try {
                // Gunakan time() untuk nama file unik
                $imageName = time().'_'.$request->image->extension();
                // Pindahkan ke public/image
                $request->image->move(public_path('image'), $imageName);
            } catch (\Throwable $e) {
                // Log error jika gagal upload (misalnya karena permission)
                Log::error('Post Store Gagal Upload Image:', ['error' => $e->getMessage()]);
                return back()->withInput()->with('error', 'Gagal mengupload gambar. Cek izin folder public/image.');
            }
        }

        // Buat record di database
        $post = Post::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'published_at' => $validated['published_at'],
            'image' => $imageName,
            // FIX KRITIS 2: Ganti auth()->id() menjadi Auth::id()
            'user_id' => Auth::id() ?? 1,
        ]);

        return redirect()->route('posts.index')->with('Sukses', 'berhasil dibuat coy!');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::findOrFail($id);
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $post = Post::findOrFail($id);
        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'published_at' => 'required|date',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $post = Post::findOrFail($id);
        $imageName = $post->image; // Pertahankan nama gambar lama

        if ($request->hasFile('image')) {
            try {
                // Hapus foto lama jika ada
                if ($post->image && File::exists(public_path('image/' . $post->image))) {
                    File::delete(public_path('image/' . $post->image));
                }

                // Upload foto baru
                $imageName = time() . '_' . $request->image->extension();
                $request->image->move(public_path('image'), $imageName);

            } catch (\Throwable $e) {
                Log::error("Post Update Gagal (File):", ['post_id' => $post->id, 'error' => $e->getMessage()]);
                return back()->with('error', 'Update Gagal: Masalah saat mengupload gambar. Cek izin folder.');
            }
        }

        // Lakukan update data
        $post->title = $validated['title'];
        $post->content = $validated['content'];
        $post->published_at = $validated['published_at'];
        $post->image = $imageName; // Pastikan nama gambar di-update

        $post->save();

        return redirect()->route('posts.index')->with('Sukses', 'sudah update!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::findOrFail($id);

        try {
            // Hapus foto dari folder (jika ada)
            if ($post->image && File::exists(public_path('image/' . $post->image))) {
                File::delete(public_path('image/' . $post->image));
            }

            $post->delete();

            return redirect()->route('posts.index')->with('Sukses', 'hilang!');

        } catch (\Throwable $e) {
            Log::error("Post Delete Gagal:", ['post_id' => $id, 'error' => $e->getMessage()]);
            return redirect()->route('posts.index')->with('error', 'Gagal menghapus post. Cek log server.');
        }
    }
}