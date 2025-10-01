<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap.min.css')}}">
	<title>Tambah data</title>
</head>
<body>
	{{-- {{dd(session('errors')('image'))}} --}}
	<h1>Tambah Post</h1>
	<form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
		@csrf
		<div>
			<label for="title">Judul:</label>
			<input type="text" id="title" name="title" required>
		</div>
		<div>
			<label for="content">Isi:</label>
			<textarea id="content" name="content" required></textarea>
		</div>
		<div>
			<label for="image">Gambar:</label>
			<input type="file" id="image" name="image">
			@error('image')
       			<div class="text-danger">{{ $message }}</div>
    		@enderror
		</div>
		<div>
			<label for="published_at">Tanggal Terbit:</label>
			<input type="date" id="published_at" name="published_at" required>
		</div>
		<button type="submit">Simpan</button>
	</form>
</body>
</html>