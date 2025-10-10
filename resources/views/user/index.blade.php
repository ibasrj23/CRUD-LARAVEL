@extends('layouts.app')

@push('styles')

<!-- Panggil CSS kustom yang baru untuk tampilan mantap -->

<link href="{{ asset('admin/css/index.css') }}" rel="stylesheet">
@endpush

@section('title', 'Halaman User')
@section('header-title', 'Halaman User')

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

<!-- Tombol Tambah User -->
<a href="{{ route('users.create') }}" class="btn btn-primary mb-4">
    <i class="fas fa-user-plus mr-2"></i> Tambah User
</a>

<!-- Table Content -->
<div class="table-responsive"> <!-- Fix untuk scroll horizontal -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Username</th>
                <th>Role</th>
                <th>Email</th>
                <th>Foto</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($users as $user)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->username ?? '-' }}</td>
                    <td>{{ $user->role == 1 ? 'Admin' : 'User'}}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                    @if ($user->photo)
                        <img src="{{ asset('photos/' . $user->photo) }}" alt="{{ $user->name }}" width="100" height="100">
                    @else
                        Tidak ada gambar
                    @endif
                    </td>
                    <!-- START: FIX Aksi Tombol -->
                    <td class="d-flex justify-content-start align-items-center">
                        <!-- Tombol Show Detail (Icon + Margin) -->
                        <a href="{{ route('users.show', $user->id) }}" class="btn btn-info btn-sm me-1" title="Lihat Detail">
                            <i class="fas fa-eye"></i>
                        </a>

                        <!-- Tombol Edit (Icon + Margin) -->
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm me-1" title="Edit">
                            <i class="fas fa-pen"></i>
                        </a>

                        <!-- Tombol Hapus (Icon Saja, Dihapus Teks 'Hapus') -->
                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </td>
                    <!-- END: FIX Aksi Tombol -->
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Tidak ada data user.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination Links -->
<div class="d-flex justify-content-center">
    {{ $users->links() }}
</div>

</div>
@endsection

@push('scripts')

@endpush