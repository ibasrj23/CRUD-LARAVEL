@extends('layouts.app')

@section('title', 'Tambah Post')
@section('header-title', 'Buat Post Baru')

@section('content')
<div class="content-wrapper mt-5">

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="title" class="form-label">Judul Post</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
            @error('title')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="published_at" class="form-label">Tanggal Publish</label>
            <input type="date" class="form-control" id="published_at" name="published_at" value="{{ old('published_at') }}" required>
            @error('published_at')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="content" class="form-label">Konten Post</label>
            <textarea class="form-control" id="content" name="content" rows="6" required>{{ old('content') }}</textarea>
            @error('content')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Gambar Utama</label>
            <input type="file" class="form-control" id="image" name="image" accept="image/*">
            <small class="form-text text-muted">Maksimal 5MB (jpg, jpeg, png).</small>
            @error('image')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary mt-3">
            <i class="fas fa-save mr-2"></i> Simpan Post
        </button>
        <a href="{{ route('posts.index') }}" class="btn btn-secondary mt-3">Kembali</a>
    </form>
</div>
@endsection