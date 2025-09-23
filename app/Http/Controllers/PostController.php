<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
		$posts = Post::latest()->simplePaginate(5); // kasih tampil cuma 5 halaman saja
        // $posts = Post::all(); //tampil semua ini
		$date = date('Y-m-d');
		// dd($posts);
		// return view('posts.index', compact('posts', 'date'));
		// return view('posts.index')->with('posts', $posts);
		return view('posts.index', [
			'posts' => $posts,
			'date' => $date
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
			$imageName = time().'_'.$request->image->extension();
			$request->image->move(public_path('image'), $imageName);
		}

		// dd($request->all());
		$post = Post::create([
			'title' => $validated['title'],
			'content' => $validated['content'],
			'published_at' => $validated['published_at'],
			'image' => $imageName,
			'user_id' => 1, //static user_id
		]);
		// dd($post);
		return redirect()->route('posts.index')->with('Sukses', 'berhasil dibuat coy!');

		//seperti INSERT INTO posts (title, content, published_at, image, user_id) VALUES (...)
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
		if ($request->hasFile('image')) {
			$imageName = time().'_'.$request->image->extension();
			$request->image->move(public_path('image'), $imageName);
			$post->image = $imageName;
		}
		$post->title = $validated['title'];
		$post->content = $validated['content'];
		$post->published_at = $validated['published_at'];
		$post->save();

		return redirect()->route('posts.index')->with('Sukses', 'sudah update!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::findOrFail($id);
		$post->delete();
		return redirect()->route('posts.index')->with('Sukses', 'hilang!');
    }
}
