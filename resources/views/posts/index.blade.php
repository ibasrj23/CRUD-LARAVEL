<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap.min.css')}}">
	<title>Beranda - Data</title>
	<style>
		body {
			background-color: #f4f4f9;
			font-family: Arial, sans-serif;
		}
		h1 {
			text-align: center;
			color: #2c3e50;
			margin-top: 30px;
		}
		.table-container {
			width: 90%;
			margin: 20px auto;
			background-color: #ffffff;
			border-radius: 8px;
			box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
		}
		table {
			width: 100%;
			border-collapse: collapse;
		}
		th, td {
			padding: 15px;
			text-align: center;
			border: 1px solid #ddd;
		}
		th {
			background-color: #3498db;
			color: white;
		}
		tr:nth-child(even) {
			background-color: #f2f2f2;
		}
		tr:hover {
			background-color: #e3e3e3;
		}
		.btn-primary {
			background-color: #3498db;
			border-color: #2980b9;
		}
		.btn-primary:hover {
			background-color: #2980b9;
			border-color: #3498db;
		}
		#notif {
			background: lightgreen;
			color: black;
			font-weight: bold;
			padding: 10px;
			margin-bottom: 10px;
			border: 2px solid green;
			border-radius: 5px;
			text-align: center;
		}
	</style>
</head>
<body>

	@if(Session::has('success'))
    <div id="notif">
        {{ Session::get('success') }}
    </div>

    <script>
        setTimeout(() => {
            document.getElementById('notif').style.display = 'none';
        }, 3000);
    </script>
	@endif

	<h1>Tabel Post</h1>

	<div class="text-center">
		<a href="{{ route('posts.create') }}" class="btn btn-primary">Tambah Post</a>
	</div>

	<div class="table-container">
		<table>
			<tr>
				<th>No</th>
				<th>Judul</th>
				<th>Isi</th>
				<th>Tanggal Terbit</th>
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
				<td>
					<a href="{{ route('posts.edit', $post->id) }}" class="btn btn-info btn-sm">Edit</a>
					<form action="{{ route('posts.destroy', $post->id) }}" method="POST" style="display:inline;">
						@csrf
						@method('DELETE')
						<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Delete</button>
					</form>
				</td>
			</tr>
			@empty
			<tr>
				<td colspan="7">Tidak ada data</td>
			</tr>
			@endforelse
		</table>
	</div>

	<div class="text-center">
		{{ $posts->links() }}
	</div>

</body>
</html>
