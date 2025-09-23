<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExampleController extends Controller
{
    public function index(Request  $request, $id)
	{
		$type = $request->type;
		// return 'ini adlah index dengan id: ' . $id . 'dan type: ' . $type;
		// dd($id);
		return view ('example', [
			'id' => $id,
			'type' => $type,
		]);
}
}
