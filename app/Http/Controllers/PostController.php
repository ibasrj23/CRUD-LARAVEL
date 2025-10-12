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
     * Display a listing of the resource (Index)
     * - Bisa dilihat semua (guest, user, admin)
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $sort = $request->get('sort', 'published_at');

        $postsQuery = Post::query()->with('user');

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
     * - Hanya admin yang bisa membuat post
     */
    public function create()
    {
        if (!Auth::check() || Auth::user()->role !== 1) {
            return redirect()->route('posts.index')
                ->with('error', 'Anda tidak memiliki izin untuk membuat post.');
        }

        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     * - Hanya admin yang bisa menambah post
     */
    public function store(Request $request)
    {
        if (!Auth::check() || Auth::user()->role !== 1) {
            return redirect()->route('posts.index')
                ->with('error', 'Anda tidak memiliki izin untuk menambah post.');
        }

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
            'user_id'      => Auth::id(),
        ]);

        return redirect()->route('posts.index')->with('success', 'Post berhasil dibuat!');
    }

    /**
     * Display the specified resource.
     * - Semua bisa melihat detail post
     */
    public function show(string $id)
    {
        $post = Post::with('user')->findOrFail($id);
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     * - Hanya admin yang bisa mengedit
     */
    public function edit(string $id)
    {
        if (!Auth::check() || Auth::user()->role !== 1) {
            return redirect()->route('posts.index')
                ->with('error', 'Anda tidak memiliki izin untuk mengedit post.');
        }

        $post = Post::findOrFail($id);
        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     * - Hanya admin yang bisa update post
     */
    public function update(Request $request, string $id)
    {
        if (!Auth::check() || Auth::user()->role !== 1) {
            return redirect()->route('posts.index')
                ->with('error', 'Anda tidak memiliki izin untuk memperbarui post.');
        }

        $validated = $request->validate([
            'title'        => 'required|max:255',
            'content'      => 'required',
            'published_at' => 'required|date',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'is_active'    => 'required|boolean',
        ]);

        $post = Post::findOrFail($id);
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
     * - Hanya admin yang bisa menghapus
     */
    public function destroy(string $id)
    {
        if (!Auth::check() || Auth::user()->role !== 1) {
            return redirect()->route('posts.index')
                ->with('error', 'Anda tidak memiliki izin untuk menghapus post.');
        }

        $post = Post::findOrFail($id);

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
