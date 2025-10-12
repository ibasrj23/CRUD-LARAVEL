@extends('layouts.app')

@section('title', 'Baca: ' . ($post->title ?? 'Post Tidak Ditemukan'))
@section('header-title', '')

@section('content')
@isset($post)
<div class="card shadow-lg border-0 mx-auto stylish-card">
    <div class="card-body p-5">

        <!-- Judul Utama -->
        <h1 class="display-5 fw-bold text-dark mb-4 elegant-title">
            {{ $post->title }}
        </h1>

        <!-- Info Meta -->
        <div class="row mb-5 text-muted small meta-section">
            <div class="col-md-6">
                <p class="mb-1">
                    <i class="fas fa-user-circle me-2 text-primary"></i>
                    <strong>Penulis:</strong> {{ $post->user?->name ?? 'Tim Redaksi' }}
                </p>
            </div>
            <div class="col-md-6 text-md-end">
                <p class="mb-0">
                    <i class="fas fa-calendar-alt me-2 text-primary"></i>
                    <strong>Dipublikasi:</strong> {{ \Carbon\Carbon::parse($post->published_at)->translatedFormat('d F Y') }}
                </p>
            </div>
        </div>

        <!-- Gambar Utama -->
        @if($post->image)
            <div class="mb-5 d-flex justify-content-center">
                <div class="image-frame">
                    <img src="{{ asset('image/' . $post->image) }}" alt="{{ $post->title }}" class="img-fluid rounded-4 main-image">
                </div>
            </div>
        @else
            <div class="alert alert-info text-center small mb-5">
                <i class="fas fa-info-circle"></i> Tidak ada gambar unggulan.
            </div>
        @endif

        <!-- Isi Postingan -->
        <h6 class="mt-4 mb-3 text-secondary border-bottom pb-2 section-title">
            <i class="fas fa-book-open me-2 text-primary"></i> Isi Postingan
        </h6>

        <div class="p-4 rounded-4 bg-white shadow-sm post-content smooth-text">
            {!! $post->content !!}
        </div>
    </div>

    <!-- Footer -->
    <div class="card-footer bg-light border-top text-end">
        <a href="{{ route('posts.public.index') }}" class="btn btn-secondary shadow-sm rounded-pill px-4 py-2 hover-lift">
            <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar Post
        </a>
    </div>
</div>
@else
<div class="alert alert-danger text-center shadow-sm">
    <i class="fas fa-exclamation-triangle"></i> Postingan tidak ditemukan atau URL tidak valid.
</div>
@endisset
@endsection

@push('styles')
<style>
/* 🌿 Style keseluruhan */
body {
    background: linear-gradient(135deg, #f6f9fc, #ffffff);
}

/* Card Utama */
.card.shadow-lg {
    border-radius: 1rem;
    background: #ffffff;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
}

/* Judul Post */
h1.display-5 {
    font-family: 'Poppins', sans-serif;
    color: #222;
    border-bottom: 3px solid #0d6efd;
    display: inline-block;
    padding-bottom: 8px;
    letter-spacing: 0.5px;
}

/* Meta Data */
.text-muted small {
    font-size: 0.95rem;
    color: #555 !important;
}

/* 🖼️ Gambar Postingan */
.image-frame {
    border-radius: 1rem;
    overflow: hidden;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
    max-width: 200px; /* 🔥 Ukuran gambar diperkecil */
    margin: 30px auto; /* Tengah dan jarak rapi */
}
.image-frame:hover {
    transform: scale(1.03);
}
.image-frame img {
    width: 100%;
    height: auto;
    border-radius: 1rem;
    object-fit: cover;
}

/* Konten Postingan */
.post-content {
    background: #fdfdfd;
    padding: 20px 25px;
    border-left: 4px solid #0d6efd;
    border-radius: 0.5rem;
    font-size: 1.05rem;
    line-height: 1.8;
    color: #333;
}
.post-content p {
    margin-bottom: 1rem;
}
.post-content h1, .post-content h2, .post-content h3 {
    margin-top: 2rem;
    margin-bottom: 1rem;
    font-weight: 700;
    color: #222;
}

/* Tombol Kembali */
.btn-secondary {
    border-radius: 50px;
    padding: 8px 20px;
    font-weight: 500;
    transition: all 0.3s ease;
}
.btn-secondary:hover {
    background-color: #0d6efd !important;
    border-color: #0d6efd !important;
    color: #fff !important;
    transform: translateY(-2px);
}
</style>
@endpush
