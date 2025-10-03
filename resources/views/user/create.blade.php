@extends('layouts.app')

@push('styles')
@endpush

@section('title', 'Halaman Tambah User')
@section('header-title', 'Halaman Tambah User')


@section('content')
	<form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
		@csrf
		<div class="mb-3">
			<label for="name" class="form-label">Nama</label>
			<input type="text" class="form-control" id="name" name="name" required>
		</div>
		<div class="mb-3">
			<label for="username" class="form-label">Username</label>
			<input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" value="{{old('username')}}" required>
			@error('username')
       			<div class="text-danger">{{ $message }}</div>
    		@enderror
		</div>
		<div class="mb-3">
			<label for="email" class="form-label">Email</label>
			<input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{old('email')}}" required>
			@error('email')
       			<div class="text-danger">{{ $message }}</div>
    		@enderror
		</div>
		<div class="mb-3">
			<label for="photo" class="form-label">Photo</label>
			<input type="file" class="form-control @error('photo') is-invalid @enderror" id="photo" name="photo">
			@error('photo')
	   			<div class="text-danger">{{ $message }}</div>
			@enderror

		</div>
		<div class="mb-3">
			<label for="password" class="form-label">Password</label>
			<input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
			@error('password')
       			<div class="text-danger">{{ $message }}</div>
    		@enderror
		</div>

		<a href="{{ route('users.index') }}" class="btn btn-secondary">Kembali</a>
			<button type="submit" class="btn btn-primary">Simpan</button>
	</form>
@endsection

@push('scripts')

@endpush