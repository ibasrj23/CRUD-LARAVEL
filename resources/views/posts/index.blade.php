@extends('layouts.app')

@push('styles')
    <!-- Panggil CSS kustom yang baru untuk tampilan mantap -->
    <link href="{{ asset('admin/css/styles.css') }}" rel="stylesheet">
@endpush

@section('title', 'Halaman Post')
@section('header-title', 'Manajemen Post')


@section('content')
<div class="content-wrapper">

    <!-- Messages -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <!-- Form Pencarian dan Sorting -->
    <div class="mb-4 p-3 bg-light rounded-lg shadow-sm d-flex justify-content-between align-items-center">
        <form action="{{ route('posts.index') }}" method="GET" class="d-flex w-50">
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

    <!-- Table Content -->
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th style="width: 50px;">No</th>
                    <th>Judul</th>
                    <th style="width: 150px;">Tanggal Publish</th>
                    <th style="width: 120px;">Gambar</th>
                    <!-- Kolom Aksi selalu tampil, tetapi isinya berbeda -->
                    <th style="width: 150px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($posts as $post)
                    <tr>
                        {{-- Perhitungan iterasi harus disesuaikan dengan pagination --}}
                        <td>{{ $loop->iteration + ($posts->currentPage() - 1) * $posts->perPage() }}</td>
                        <td>{{ $post->title }}</td>
                        <td>{{ $post->published_at }}</td>
                        <td>
                        @if ($post->image)
                            <img src="{{ asset('image/' . $post->image) }}" alt="{{ $post->title }}" width="100" height="60" style="object-fit: cover; border-radius: 4px;">
                        @else
                            Tidak ada gambar
                        @endif
                        </td>
                        <td class="d-flex justify-content-start align-items-center">

                            {{-- Asumsi bahwa route posts.show bisa diakses semua user login --}}
                            <!-- 1. Tombol Show (Selalu terlihat untuk user yang login) -->
                            <a href="{{ route('posts.show', $post->id) }}" class="btn btn-info btn-sm me-1" title="Lihat Detail">
                                <i class="fas fa-eye"></i>
                            </a>

                            {{-- FIX 2: Tambahkan pemeriksaan Auth::check() sebelum akses role --}}
                            <!-- 2. Tombol Edit & Hapus (Hanya terlihat oleh Admin/Role 1) -->
                            @if (Auth::check() && Auth::user()->role == 1)
                                <!-- Tombol Edit -->
                                <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-warning btn-sm me-1" title="Edit">
                                    <i class="fas fa-pen"></i>
                                </a>

                                <!-- Tombol Hapus -->
                                <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus post ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada post yang ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination Links -->
    <div class="d-flex justify-content-center">
        {{-- FIX 3: Pastikan links memegang parameter search/sort --}}
        {{ $posts->appends(['search' => request('search'), 'sort' => request('sort')])->links() }}
    </div>
</div>
@endsection

@push('scripts')

@endpush
