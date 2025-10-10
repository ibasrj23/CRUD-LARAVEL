@extends('layouts.app')

@section('title', 'Detail User: ' . $user->name)
@section('header-title', 'Detail Pengguna')


@section('content')
<!-- FIX KRITIS: Tambahkan mt-5 (Margin Top) pada content-wrapper agar tidak nabrak fixed navbar -->
<div class="content-wrapper mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-lg border-0 rounded-xl">
                <!-- WARNA DIUBAH KE MERAH (bg-danger) untuk diagnosis -->
                <div class="card-header bg-danger text-white text-center py-3">
                    <h4 class="mb-0">Profil Pengguna</h4>
                </div>
                <div class="card-body p-4">

                    <!-- Foto Profil -->
                    <div class="text-center mb-4">
                        @if ($user->photo)
                            <img src="{{ asset('photos/' . $user->photo) }}"
                                 alt="{{ $user->name }}"
                                 width="120"
                                 height="120"
                                 class="img-fluid rounded-circle border border-5 border-light shadow-sm user-profile-photo">
                        @else
                            <div class="p-4 bg-light rounded-circle border border-secondary d-inline-block">
                                <i class="fas fa-user-circle fa-4x text-secondary"></i>
                            </div>
                        @endif
                        <h5 class="mt-3 mb-1">{{ $user->name }}</h5>
                        <p class="text-muted small">{{ $user->email }}</p>
                    </div>

                    <!-- Detail Data -->
                    <dl class="row mb-0 pt-3 border-top px-3">

                        <dt class="col-sm-5 text-sm-left font-weight-bold">Username</dt>
                        <dd class="col-sm-7">{{ $user->username }}</dd>

                        <dt class="col-sm-5 text-sm-left font-weight-bold">Email</dt>
                        <dd class="col-sm-7">{{ $user->email }}</dd>

                        <dt class="col-sm-5 text-sm-left font-weight-bold">Role</dt>
                        <dd class="col-sm-7">
                            @if ($user->role == 1)
                                <span class="badge bg-primary text-white">Admin</span>
                            @else
                                <span class="badge bg-secondary text-white">User</span>
                            @endif
                        </dd>

                        <dt class="col-sm-5 text-sm-left font-weight-bold">Tanggal Registrasi</dt>
                        <dd class="col-sm-7">{{ $user->created_at->translatedFormat('d F Y (H:i)') }}</dd>

                    </dl>

                </div>
                <div class="card-footer bg-light border-top text-center">
                    <a href="{{ route('users.index') }}" class="btn btn-secondary me-2">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning">
                        <i class="fas fa-pen"></i> Edit Profil
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Style kustom untuk foto profil di halaman show */
    .user-profile-photo {
        width: 120px;
        height: 120px;
        object-fit: cover;
    }
    .card-footer a {
        border-radius: 8px;
    }
</style>
@endsection