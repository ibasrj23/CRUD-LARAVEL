@extends('layouts.app')

@push('styles')
 <style>
	h1 {
		color: rgb(64, 0, 255);
		font-size: 24px;
	}

	p {
		color: rgb(64, 0, 255);
		font-size: 18px;
	}
	
 </style>
@endpush

@section('title', 'Halaman Home')
@section('header-title', 'Halaman Home')

@section('content')
    <h1>Selamat Datang</h1>
    <p>Belajar Blade Template Engine Laravel</p>
@endsection