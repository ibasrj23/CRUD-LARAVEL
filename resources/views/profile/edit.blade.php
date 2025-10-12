@extends('layouts.app')

@section('title', 'Edit Profil')
@section('header-title', 'Kelola Akun Saya')

@section('content')
<div class="row justify-content-center mt-4">
    <div class="col-lg-10">

        {{-- Notifikasi (Sukses/Gagal) --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                <i class="fas fa-times-circle"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- ========================================================= --}}
        {{-- CARD 1: UPDATE PROFILE INFORMATION --}}
        {{-- ========================================================= --}}
        <div class="card shadow-lg border-0 mb-4">
            <div class="card-header bg-white border-bottom">
                <h5 class="mb-0 text-dark fw-bold">
                    <i class="fas fa-user-edit me-2 text-primary"></i> Update Informasi Profil & Foto
                </h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('put')

                    <div class="row">
                        {{-- Kolom Kiri --}}
                        <div class="col-md-7">

                            {{-- Nama --}}
                            <div class="mb-3">
                                <label for="name" class="form-label fw-bold">Nama</label>
                                <input type="text"
                                    class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name"
                                    value="{{ old('name', auth()->user()->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Username --}}
                            <div class="mb-3">
                                <label for="username" class="form-label fw-bold">Username</label>
                                <input type="text"
                                    class="form-control @error('username') is-invalid @enderror"
                                    id="username" name="username"
                                    value="{{ old('username', auth()->user()->username) }}" required>
                                @error('username')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div class="mb-3">
                                <label for="email" class="form-label fw-bold">Email</label>
                                <input type="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email"
                                    value="{{ old('email', auth()->user()->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                        {{-- Kolom Kanan: Foto --}}
                        <div class="col-md-5 border-start pt-3 pt-md-0">

                            {{-- Preview Foto --}}
                            <div class="mb-3 text-center">
                                <label class="form-label fw-bold">Foto Profil Saat Ini</label>
                                <div class="mx-auto border p-2 rounded-circle bg-light overflow-hidden shadow-sm"
                                     style="width: 120px; height: 120px;">
                                    @if(auth()->user()->photo)
                                        <img src="{{ asset('photos/' . auth()->user()->photo) }}"
                                             alt="Current Photo"
                                             class="img-fluid rounded-circle"
                                             style="width: 100%; height: 100%; object-fit: cover;">
                                    @else
                                        <i class="fas fa-user fa-4x text-secondary mt-3"></i>
                                    @endif
                                </div>
                            </div>

                            {{-- Input Foto --}}
                            <div class="mb-3">
                                <label for="photo" class="form-label small text-muted">Ganti Foto Baru:</label>
                                <input type="file"
                                    class="form-control @error('photo') is-invalid @enderror"
                                    id="photo" name="photo" accept=".jpg,.jpeg,.png">
                                <div class="form-text">Format: jpeg, png, jpg | Max: 2MB</div>
                                @error('photo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                {{-- Preview tambahan --}}
                                @if(auth()->user()->photo)
                                    <div class="mt-2">
                                        <p>Current Photo:</p>
                                        <img src="{{ asset('photos/' . auth()->user()->photo) }}" alt="Current Photo" width="100">
                                    </div>
                                @endif
                            </div>

                        </div>
                    </div>

                    <hr class="my-4">
                    <button type="submit" class="btn btn-primary shadow-sm">Update Profil Info</button>
                </form>
            </div>
        </div>

        {{-- ========================================================= --}}
        {{-- CARD 2: UPDATE PASSWORD --}}
        {{-- ========================================================= --}}
        <div class="card shadow-lg border-0 mb-4">
            <div class="card-header bg-light border-bottom">
                <h5 class="mb-0 text-dark fw-bold">
                    <i class="fas fa-lock me-2 text-success"></i> Update Password
                </h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    @method('put')

                    {{-- Current Password --}}
                    <div class="mb-3">
                        <label for="current_password" class="form-label fw-bold">Password Saat Ini</label>
                        <input type="password"
                               class="form-control @error('current_password', 'updatePassword') is-invalid @enderror"
                               id="current_password" name="current_password" required>
                        @error('current_password', 'updatePassword')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- New Password --}}
                    <div class="mb-3">
                        <label for="password" class="form-label fw-bold">Password Baru</label>
                        <input type="password"
                               class="form-control @error('password', 'updatePassword') is-invalid @enderror"
                               id="password" name="password" required>
                        @error('password', 'updatePassword')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Confirm Password --}}
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label fw-bold">Konfirmasi Password Baru</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                    </div>

                    <button type="submit" class="btn btn-primary shadow-sm">Update Password</button>
                </form>
            </div>
        </div>

        {{-- ========================================================= --}}
        {{-- CARD 3: DELETE ACCOUNT --}}
        {{-- ========================================================= --}}
        <div class="card shadow-lg border-0 mb-5">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0"><i class="fas fa-trash-alt me-2"></i> Hapus Akun Permanen</h5>
            </div>
            <div class="card-body">
                <p class="text-danger fw-bold">PERINGATAN: Menghapus akun bersifat permanen. Aksi ini tidak dapat dibatalkan.</p>

                <button type="button" class="btn btn-danger shadow-sm" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                    Hapus Akun
                </button>
            </div>
        </div>

        {{-- Modal Konfirmasi Hapus Akun --}}
        <div class="modal fade" id="deleteAccountModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title">Konfirmasi Hapus Akun</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p>Masukkan password Anda untuk mengkonfirmasi penghapusan akun <b>{{ auth()->user()->name }}</b>.</p>

                        <form method="post" action="{{ route('profile.destroy') }}" class="p-0">
                            @csrf
                            @method('delete')

                            <div class="mb-3">
                                <label for="password" class="form-label">Password Konfirmasi</label>
                                <input type="password" name="password"
                                    class="form-control @error('password', 'userDeletion') is-invalid @enderror" required>
                                @error('password', 'userDeletion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-danger">Hapus Permanen</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
