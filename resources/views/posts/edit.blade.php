<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post</title>
</head>
<body>
    <h1>Edit Post</h1>
    <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div>
            <label for="title">Judul:</label>
            <input type="text" id="title" name="title" value="{{ old('title', $post->title) }}" required>
        </div>
        <div>
            <label for="content">Isi:</label>
            <textarea id="content" name="content" required>{{ old('content', $post->content) }}</textarea>
        </div>
        <div>
            <label for="image">Gambar:</label>
            <input type="file" id="image" name="image">
            @if($post->image)
                <p>Gambar saat ini: <img src="{{ asset('posts/' . $post->image) }}" width="100"></p>
            @endif
        </div>
        <div>
            <label for="published_at">Tanggal Terbit:</label>
            <input type="date" id="published_at" name="published_at" value="{{ old('published_at', $post->published_at) }}" required>
        </div>
        <button type="submit">Update</button>
    </form>
</body>
</html>
