<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap.min.css')}}">
	{{-- <link rel="stylesheet" href="{{asset('style.css')}}"> --}}
	<title>Beranda - Data</title>
</head>
<body>
	@if(Session::has('success'))
    <div id="notif" style="background: lightgreen; color: black; font-weight: bold; padding: 10px; margin-bottom: 10px; border: 2px solid green;">
        {{ Session::get('success') }}
    </div>

    <script>
        setTimeout(() => {
            document.getElementById('notif').style.display = 'none';
        }, 3000);
    </script>
@endif



	<h1>Tabel post</h1>
	<a href="{{ route('posts.create') }}" class="btn btn-primary">tambah post</a>
	<table style="border-collapse: collapse; width: 100%;" border="1">
		<tr>
			<th>No</th>
			<th>Judul</th>
			<th>Isi</th>
			<th>Tanggal terbit</th>
			<th>Gambar</th>
			<th>Penulis</th>
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
			<td>
    			<a href="{{ route('posts.edit', $post->id) }}">Edit</a>
    			<form action="{{ route('posts.destroy', $post->id) }}" method="POST" style="display:inline;">
        			@csrf
        			@method('DELETE')
        			<button type="submit" onclick="return confirm('Yakin hapus?')">Delete</button>
    			</form>
			</td>

		</tr>
		@empty
		<tr>
			<td colspan="6">Tidak ada data</td>
		</tr>
		@endforelse
	</table>

	{{ $posts->links() }}

	{{-- <button class="btn btn-primary">Tambah Post</button> --}}
</body>
</html>