@extends('layouts.app')

@section('title', 'Dashboard')
@section('header-title', 'Halaman Dashboard')

@section('content')

    {{-- KONTEN UTAMA DASHBOARD --}}
    <div class="row">
        <div class="col-md-12">

            {{-- Bagian Selamat Datang / Ringkasan --}}
            <div class="card bg-primary text-white mb-4 shadow-sm">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h5 class="card-title text-uppercase mb-0">Selamat Datang!</h5>
                            {{-- Aman karena halaman ini hanya bisa diakses setelah login --}}
                            <h2 class="mb-0">{{ Auth::user()->name ?? 'Pengguna' }}</h2>
                        </div>
                        <div class="col-4 text-right">
                            {{-- Icon Besar --}}
                            <i class="fas fa-chart-line fa-3x"></i>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Kartu Ringkasan Statistik (Contoh) --}}
            <div class="row">

                {{-- Kartu 1: Total Post Aktif --}}
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Total Post Aktif
                                    </div>
                                    {{-- Asumsi Anda punya variabel $totalPosts dari Controller --}}
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">42</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-file-alt fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Kartu 2: Total User (Hanya Admin) --}}
                @if (Auth::user() && Auth::user()->role == 1) {{-- FIX: Menambahkan Auth::user() check --}}
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                        Total Pengguna
                                    </div>
                                    {{-- Asumsi Anda punya variabel $totalUsers dari Controller --}}
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">10</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-users fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                {{-- Kartu 3: Sisa Slot (Contoh) --}}
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Pesan Baru
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">3</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-comments fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Notifikasi --}}
            <div class="alert alert-success" role="alert">
                Anda berhasil masuk! Anda adalah **
                {{-- FIX: Menggunakan Auth::user() check yang lebih aman --}}
                @if (Auth::user() && Auth::user()->role == 1)
                    Administrator
                @else
                    Pengguna Biasa
                @endif
                **.
            </div>

        </div>
    </div>
@endsection

@push('styles')
<style>
/* Custom style untuk kartu dashboard agar lebih menarik */
.card.border-left-success {
    border-left: .25rem solid #1cc88a !important; /* Hijau */
}
.card.border-left-info {
    border-left: .25rem solid #36b9cc !important; /* Biru muda */
}
.card.border-left-warning {
    border-left: .25rem solid #f6c23e !important; /* Kuning */
}
.bg-primary {
    background-color: #0d6efd !important;
}
.text-gray-300 {
    color: #dee2e6 !important;
}
</style>
@endpush
