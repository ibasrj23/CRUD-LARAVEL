<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap.min.css')}}">
	{{-- <link rel="stylesheet" href="{{asset('style.css')}}"> --}}
	<title>Full Data</title>
</head>
<body class="container mt-3">


	<h1>Tabel post</h1>
	<a href="{{ route('posts.create') }}" class="btn btn-success mb-3">tambah post</a>
	{{-- {{ dd(session()->all()) }} --}}
	@if (session('success'))
		<div class="alert alert-success">
			{{ session('success') }}
		</div>
	@endif
	<table class="table table-bordered">
		<tr>
			<th>No</th>
			<th>Judul</th>
			<th>Isi</th>
			<th>Tanggal terbit</th>
			<th>Gambar</th>
			<th>Penulis</th>
			<th>Aksi</th>
		</tr>
		@forelse ($posts as $post)
		<tr>
			<td>{{ $loop->iteration }}</td>
			<td>{{ $post->title }}</td>
			<td>{{ $post->content }}</td>
			<td>{{ $post->published_at }}</td>
			<td>
				@if ($post->image)
					<img src="{{ asset('image/' . $post->image) }}" alt="{{ $post->title }}" width="100">
				@else
					Tidak ada gambar
				@endif
			</td>
			<td>{{ $post->user ? $post->user->name : 'Penulis tidak ditemukan' }}</td>
			<td class="text-center">
    			<a href="{{ route('posts.edit', $post->id) }}" class="btn btn-warning btn-sm ">Edit</a>
    			<form action="{{ route('posts.destroy', $post->id) }}" method="POST" style="display:inline;">
        			@csrf
        			@method('DELETE')
        			<button type="submit" onclick="return confirm('Yakin hapus?')" class="btn btn-danger btn-sm">Delete</button>
    			</form>
			</td>

		</tr>
		@empty
		<tr>
			<td colspan="6">Tidak ada data</td>
		</tr>
		@endforelse
	</table>
	<div>
		{{ $posts->links() }}
	</div> 
</body>
</html>