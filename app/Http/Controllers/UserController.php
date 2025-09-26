<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

		$users = User::all();

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
    $validated = $request->validate([
        'name'  => 'required|min:3',
        'email' => 'required|email|unique:users',
    ]);

    try {
        User::create([
	        'name' => $validated->name,
	        'email' => $validated->email
        ]);
        return redirect()->route('user.index')->with('success', 'User berhasil ditambahkan!');
    } catch (\Exception $e) {
        return redirect()->route('user.index')->with('error', 'Gagal menambahkan user!');
    }
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
    public function edit(User $user)
{
    return view('user.edit', [
	    'user' => $user
    ]);
}


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
{
    $validated = $request->validate([
        'name'  => 'required|min:3',
        'email' => 'required|email|unique:user,email,' . $user->id
    ]);

    $user->update([
	    'name' => $validated->name,
      'email' => $validated->email
    ]);
    return redirect()->route('use.index')->with('success', 'User berhasil diupdate!');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
{
	$user->delete();
	return redirect()->route('users.index')->with('success', 'User berhasil dihapus!');
}

}
