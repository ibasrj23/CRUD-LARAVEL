@extends('layouts.app')

@push('styles')
@endpush

@section('title', 'Halaman Edit User')
@section('header-title', 'Halaman Edit User')

@section('content')
@if(session('success'))
<div class="alert alert-success">
{{ session('success') }}
</div>
@endif
@if(session('error'))
<div class="alert alert-danger">
{{ session('error') }}
</div>
@endif

<form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
@csrf
@method('PUT')

<div class="mb-3">
    <label for="name" class="form-label">Nama</label>
    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
    @error('name')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="username" class="form-label">Username</label>
    <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" value="{{ old('username', $user->username) }}" required>
    @error('username')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="role" class="form-label">Role</label>
    <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
        <option value="1" {{ old('role', $user->role) == 1 ? 'selected' : '' }}>Admin</option>
        <option value="2" {{ old('role', $user->role) == 2 ? 'selected' : '' }}>User</option>
    </select>
    @error('role')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="email" class="form-label">Email</label>
    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
    @error('email')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="photo" class="form-label">Foto</label>
    <input type="file" class="form-control @error('photo') is-invalid @enderror" id="photo" name="photo">
    @if($user->photo)
        <p class="mt-2">Foto Dipilih Saat Ini:</p>
        <img src="{{ asset('photos/'.$user->photo) }}" alt="Foto User" width="100" class="img-thumbnail">
    @endif
    @error('photo')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>


<div class="mb-3">
    <label for="password" class="form-label">Password Baru</label>
    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
    <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah password</small>
    @error('password')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
    <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation">
    @error('password_confirmation')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<a href="{{ route('users.index') }}" class="btn btn-secondary">Kembali</a>
<button type="submit" class="btn btn-primary">Simpan Perubahan</button>

</form>

@endsection

@push('scripts')

@endpush