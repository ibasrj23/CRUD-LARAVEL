<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Postnew;

class PostnewController extends Controller
{
	//tampilkan smeua data
    public function index()
    {
        $newposts = Postnew::all();
        // return view('posts.index', compact('posts'));
		dd($newposts);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $newpost = Postnew::create([
			'title' => $request->judul,
			'content' => $request ->content,
		]);
		dd($newpost);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $newpost = Postnew::findOrFail($id);
        dd($newpost);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $newpost = Postnew::findOrFail($id);
		$newpost->update([
			'title' => $request->judul,
			'content' => $request->content,
		]);
		dd($newpost);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $newpost = Postnew::findOrFail($id);
		$newpost->delete();
		dd("Post dengan ID $id telah dihapus");
	}
}