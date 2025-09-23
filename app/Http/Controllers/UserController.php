<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
	{
		$users = User::all();
		//SELECT * FROM users;

		$user = User::find(1);
		//SELECT * FROM users WHERE id = 1;
		//berdasarkan id

		$user = User::where('username','=', 'fakhri')->first();
		//SELECT * FROM users WHERE username = 'fakhri' LIMIT 1;


		dd($users);

	

	$user = User::create([
		'username' => 'fakhri',
		'name' => 'Fakhri',
		'email' => 'fakhri@example.com',
		'password' => bcrypt('password'),
	]);
	}
}



