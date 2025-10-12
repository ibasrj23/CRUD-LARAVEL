@extends('layouts.app')

@section('title', 'Daftar Post Admin')
@section('header-title', 'Kelola Postingan Anda')

@section('content')
<div class="content-wrapper">

    <!-- Header & Tombol Tambah Post -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0 text-primary">
            <i class="fas fa-newspaper"></i> Daftar Postingan
        </h4>
        <a href="{{ route('posts.create') }}" class="btn btn-success shadow-sm">
            <i class="fas fa-plus-circle"></i> Tambah Post Baru
        </a>
    </div>

    <!-- Form Pencarian dan Sorting -->
    <div class="mb-4 p-3 bg-light rounded-lg shadow-sm d-flex justify-content-between align-items-center">
        <form action="{{ route('posts.index') }}" method="GET" class="d-flex w-50 me-3">
            <input type="text" name="search" class="form-control me-2" placeholder="Cari Judul atau Konten..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-secondary"><i class="fas fa-search"></i> Cari</button>
        </form>

        <form action="{{ route('posts.index') }}" method="GET" class="d-flex">
            <input type="hidden" name="search" value="{{ request('search') }}">
            <select name="sort" onchange="this.form.submit()" class="form-select w-auto">
                <option value="published_at" {{ request('sort') == 'published_at' ? 'selected' : '' }}>Urutkan: Terbaru</option>
                <option value="title" {{ request('sort') == 'title' ? 'selected' : '' }}>Urutkan: Judul (A-Z)</option>
            </select>
        </form>
    </div>

    <!-- Card Layout untuk Daftar Post -->
    <div class="row">
        @forelse ($posts as $post)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100 shadow-sm border-0">

                    <!-- Gambar Post -->
                    <div class="overflow-hidden" style="height: 200px;">
                        @if ($post->image)
                            <img src="{{ asset('image/' . $post->image) }}" class="card-img-top" alt="{{ $post->title }}" style="object-fit: cover; height: 100%;">
                        @else
                            <div class="bg-light text-center d-flex align-items-center justify-content-center" style="height: 100%;">
                                <i class="fas fa-image fa-3x text-muted"></i>
                            </div>
                        @endif
                    </div>

                    <div class="card-body d-flex flex-column">
                        <!-- Judul -->
                        <h5 class="card-title text-primary text-truncate">{{ $post->title }}</h5>

                        <!-- Deskripsi Singkat -->
                        <p class="card-text text-muted small mb-3 flex-grow-1">
                            {{ Str::limit(strip_tags($post->content), 100, '...') }}
                        </p>

                        <!-- Meta Data -->
                        <div class="d-flex justify-content-between align-items-center small text-secondary border-top pt-2 mt-auto">
                            <span><i class="fas fa-calendar-alt"></i> {{ \Carbon\Carbon::parse($post->published_at)->translatedFormat('d M Y') }}</span>
                            <span><i class="fas fa-user-circle"></i> {{ $post->user->name ?? 'Admin' }}</span>
                        </div>
                    </div>

                    <div class="card-footer bg-white border-top-0 d-flex justify-content-between">
                        <!-- Tombol Aksi -->
                        <a href="{{ route('posts.show', $post->id) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-eye"></i> Lihat
                        </a>
                        <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-warning btn-sm text-white">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus postingan ini?')" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle"></i> Tidak ada postingan yang ditemukan.
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $posts->links() }}
    </div>
</div>
@endsection
