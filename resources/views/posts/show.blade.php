@extends('layouts.app')

@section('title', 'Detail Post: ' . $post->title)

@section('header-title', 'Detail Post')

@section('content')

<div class="card shadow-lg border-0">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h4 class="mb-0 text-truncate">{{ $post->title }}</h4>

        <!-- Tombol Aksi Admin -->
        <div class="d-flex flex-shrink-0">
            <!-- Tombol Edit -->
            <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-warning btn-sm me-2 text-white shadow-sm">
                <i class="fas fa-edit"></i> Edit
            </a>

            <!-- Tombol Delete -->
            <button type="button" class="btn btn-danger btn-sm shadow-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $post->id }}">
                <i class="fas fa-trash-alt"></i> Hapus
            </button>
        </div>
    </div>

    <div class="card-body">

        <!-- Informasi Meta (Kolom Kiri-Kanan yang Rapi) -->
        <div class="row mb-4 border-bottom pb-3 text-muted small">
            <div class="col-md-4">
                <p class="mb-1"><strong><i class="fas fa-user-circle"></i> Penulis:</strong> {{ $post->user->name ?? 'Admin Sistem' }}</p>
                <p class="mb-0"><strong><i class="fas fa-fingerprint"></i> ID Post:</strong> {{ $post->id }}</p>
            </div>
            <div class="col-md-4">
                <p class="mb-1"><strong><i class="fas fa-calendar-alt"></i> Dibuat:</strong> {{ \Carbon\Carbon::parse($post->created_at)->translatedFormat('d F Y H:i') }}</p>
                <p class="mb-0"><strong><i class="fas fa-share-square"></i> Dipublikasi:</strong> {{ \Carbon\Carbon::parse($post->published_at)->translatedFormat('d F Y') }}</p>
            </div>
            <div class="col-md-4">
                <span class="badge bg-success shadow-sm p-2">Status: Aktif</span>
            </div>
        </div>

        <!-- Gambar Utama (Diperkecil dan Fokus di Tengah) -->
        @if($post->image)
            <div class="mb-4 d-flex justify-content-center">
                <div class="overflow-hidden border p-2 rounded" style="max-width: 600px;">
                    <img src="{{ asset('image/' . $post->image) }}" alt="{{ $post->title }}" class="img-fluid rounded" style="max-height: 350px; object-fit: cover;">
                </div>
            </div>
        @else
            <div class="alert alert-info text-center small"><i class="fas fa-info-circle"></i> Tidak ada gambar unggulan.</div>
        @endif

        <!-- Konten Post -->
        <h6 class="mt-4 mb-3 text-secondary border-bottom pb-2"><i class="fas fa-newspaper"></i> Konten Post:</h6>
        <div class="border p-4 rounded bg-white shadow-sm">
            {!! $post->content !!}
        </div>

    </div> {{-- end card-body --}}

    <div class="card-footer bg-light border-top text-end">
        <a href="{{ route('posts.index') }}" class="btn btn-secondary shadow-sm">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar
        </a>
    </div>

</div> {{-- end card --}}

<!-- Modal Konfirmasi Hapus -->
<div class="modal fade" id="deleteModal{{ $post->id }}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-danger"><i class="fas fa-exclamation-triangle"></i> PERINGATAN! Aksi ini tidak bisa dibatalkan.</p>
                Apakah Anda yakin ingin menghapus post berjudul {{$post->tittle}} ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger shadow-sm">Hapus Permanen</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
