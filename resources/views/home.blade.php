@extends('layouts.app')

@section('title', 'Dashboard Utama')
{{-- Pesan header disesuaikan berdasarkan status login --}}
@section('header-title', Auth::check() ? 'Selamat Datang, ' . Auth::user()->name : 'Selamat Datang di Portal Kami')

@section('content')
<div class="content-wrapper mt-4">

    {{-- Notifikasi (Jika ada) --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif


    {{-- ========================================================================= --}}
    {{-- BLOK 1: STATISTIK & METRIK (Hanya Muncul Jika Login) --}}
    {{-- ========================================================================= --}}

    @auth

    <div class="row">

        {{-- CARD METRIK 1: Total Post Aktif --}}
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100 bg-primary text-white">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <div class="text-uppercase small fw-bold mb-1">Total Post Terakhir</div>
                            <div class="h3 mb-0">{{ $posts->total() ?? 0 }}</div>
                        </div>
                        <div class="col-4 text-end">
                            <i class="fas fa-pen-fancy fa-3x"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-secondary border-0 small">
                    <a href="{{ route('posts.public.index') }}" class="text-white text-decoration-none">Lihat Semua Post Publik &rarr;</a>
                </div>
            </div>
        </div>

        {{-- CARD METRIK 2: Jumlah User (Placeholder) --}}
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100 bg-warning text-dark">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <div class="text-uppercase small fw-bold mb-1">Jumlah User Terdaftar</div>
                            <div class="h3 mb-0">24</div>
                        </div>
                        <div class="col-4 text-end">
                            <i class="fas fa-users fa-3x"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-secondary border-0 small">
                    <span class="text-white text-decoration-none">Statistik User</span>
                </div>
            </div>
        </div>

        {{-- CARD METRIK 3: Tanggal Hari Ini --}}
        <div class="col-lg-4 col-md-12 mb-4">
            <div class="card border-0 shadow-sm h-100 bg-info text-white">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <div class="text-uppercase small fw-bold mb-1">Tanggal Hari Ini</div>
                            <div class="h5 mb-0">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</div>
                        </div>
                        <div class="col-4 text-end">
                            <i class="fas fa-calendar-alt fa-3x"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-secondary border-0 small">
                    <span class="text-white text-decoration-none">Waktu Server: {{ \Carbon\Carbon::now()->format('H:i:s') }}</span>
                </div>
            </div>
        </div>

    </div> {{-- end row metrik --}}

    @endauth


    {{-- ========================================================================= --}}
    {{-- BLOK 2: KONTEN UTAMA (Terlihat oleh SEMUA ORANG) --}}
    {{-- ========================================================================= --}}

    @guest
        {{-- Pesan sambutan untuk Guest --}}
        <div class="alert alert-primary shadow-sm mb-4">
            <h4 class="alert-heading">Selamat Datang!</h4>
            <p class="mb-0">Silakan jelajahi postingan terbaru kami di bawah ini. Untuk mengakses fitur personal, silakan **Login** atau **Register**.</p>
        </div>
    @endguest

    <div class="row mt-3">

        <div class="col-lg-8 mb-4">
            <div class="card shadow-lg border-0 h-100">
                <div class="card-header bg-white fw-bold"><i class="fas fa-chart-bar me-2"></i> Grafik Aktivitas Postingan (Placeholder)</div>
                <div class="card-body">
                    {{-- Placeholder untuk grafik --}}
                    <div class="text-center text-muted py-5 border rounded" style="min-height: 300px;">
                        [Di sini tempat library charting (misal: Chart.js) dimuat]
                        <p class="mt-3">Grafik Postingan Mingguan Belum Terimplementasi.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 mb-4">
            <div class="card shadow-lg border-0 h-100">
                <div class="card-header bg-white fw-bold"><i class="fas fa-info-circle me-2"></i> Postingan Terbaru (Untuk Semua Role)</div>
                <div class="card-body small">
                    <ul class="list-unstyled">
                        @forelse ($posts as $post)
                            <li class="mb-2 pb-2 border-bottom">
                                {{-- Link show akan otomatis bekerja untuk guest maupun user --}}
                                <a href="{{ route('posts.public.show', $post->id) }}" class="text-dark text-decoration-none fw-bold">
                                    {{ Str::limit($post->title, 35) }}
                                </a>
                                <span class="d-block text-muted small">
                                    <i class="fas fa-calendar-alt me-1"></i> {{ \Carbon\Carbon::parse($post->published_at)->diffForHumans() }}
                                </span>
                            </li>
                        @empty
                            <li class="text-muted">Belum ada postingan terbaru.</li>
                        @endforelse
                    </ul>
                    <a href="{{ route('posts.public.index') }}" class="btn btn-sm btn-outline-dark w-100 mt-2">Lihat Semua Post</a>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection