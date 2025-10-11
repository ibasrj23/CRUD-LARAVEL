@extends('layouts.app')

{{-- FIX: Gunakan @isset untuk mencegah error jika variabel $post belum didefinisikan --}}
@section('title', isset($post) ? $post->title : 'Detail Post')
@section('header-title', '')

@section('content')

<div class="card shadow-lg border-0 mx-auto" style="max-width: 900px;">

    <div class="card-body p-5">

        @isset($post)
        <!-- Judul Utama Post -->
        <h1 class="display-5 fw-bold text-dark mb-4 border-bottom pb-3">
            {{ $post->title }}
        </h1>

        <!-- Informasi Meta (Kolom Kiri-Kanan yang Rapi) -->
        <div class="row mb-5 text-muted small">
            <div class="col-md-6">
                {{-- Memastikan $post->user ada sebelum memanggil name --}}
                <p class="mb-1"><strong><i class="fas fa-user-circle"></i> Penulis:</strong> {{ $post->user->name ?? 'Tim Redaksi' }}</p>
            </div>
            <div class="col-md-6 text-md-end">
                <p class="mb-0"><strong><i class="fas fa-share-square"></i> Dipublikasi:</strong> {{ \Carbon\Carbon::parse($post->published_at)->translatedFormat('d F Y') }}</p>
            </div>
        </div>

        <!-- Gambar Utama (Fokus di Tengah) -->
        @if($post->image)
            <div class="mb-5 d-flex justify-content-center">
                <div class="overflow-hidden border p-2 rounded shadow-sm" style="max-width: 800px;">
                    <img src="{{ asset('image/' . $post->image) }}" alt="{{ $post->title }}" class="img-fluid rounded" style="max-height: 400px; object-fit: cover;">
                </div>
            </div>
        @else
            <div class="alert alert-info text-center small mb-5"><i class="fas fa-info-circle"></i> Tidak ada gambar unggulan.</div>
        @endif

        <!-- Konten Post (Menggunakan styling bawaan browser untuk teks) -->
        <div class="mt-4">
            <div class="p-4 rounded bg-white shadow-sm post-content">
                {!! $post->content !!}
            </div>
        </div>

    </div> {{-- end card-body --}}

    <div class="card-footer bg-light border-top text-end">
        {{-- Mengarahkan kembali ke daftar post publik --}}
        <a href="{{ route('posts.public.index') }}" class="btn btn-secondary shadow-sm">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Post
        </a>
    </div>

    @else
        <div class="card-body p-5">
            <div class="alert alert-danger text-center">Post tidak ditemukan atau URL salah.</div>
        </div>
    @endisset

</div> {{-- end card --}}

@endsection

@push('styles')
<style>
/* Style tambahan untuk memastikan konten HTML dari user terlihat bagus */
.post-content p {
    margin-bottom: 1rem;
    line-height: 1.7;
    font-size: 1.1rem;
    color: #333;
}
.post-content h1, .post-content h2, .post-content h3 {
    margin-top: 2rem;
    margin-bottom: 1rem;
    font-weight: 600;
    border-bottom: 1px solid #eee;
    padding-bottom: 5px;
}
</style>
@endpush
