@extends('layouts.app')

@push('styles')
@endpush

@section('title', 'Halaman Edit User')
@section('header-title', 'Halaman Edit User')


@section('content')
	<form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="name" class="form-label">Nama</label>
        <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
    </div>

    <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control" id="username" name="username" value="{{ $user->username }}" required>
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
    </div>

	<div class="mb-3">
        <label for="photo" class="form-label">Foto</label>
        <input type="file" class="form-control" id="photo" name="photo">
        @if($user->photo)
            <p>Foto Dipilih Saat Ini:</p>
            <img src="{{ asset('photos/'.$user->photo) }}" alt="Foto User" width="100">
        @endif
		@error('photo')
	   			<div class="text-danger">{{ $message }}</div>
		@enderror
    </div>


    <div class="mb-3">
        <label for="password" class="form-label">Password Baru</label>
        <input type="password" class="form-control" id="password" name="password">
        <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah password</small>
    </div>

    <a href="{{ route('users.index') }}" class="btn btn-secondary">Kembali</a>
	<button type="submit" class="btn btn-primary">Simpan</button>
</form>

@endsection

@push('scripts')

@endpush