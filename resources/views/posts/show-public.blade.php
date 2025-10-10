@extends('layouts.app')

@section('title', $post->title)

@section('content')

<div class="py-12 bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <article class="bg-white shadow-xl rounded-lg overflow-hidden p-6 md:p-10">

            @if($post->image_url)
                <img src="{{ $post->image_url }}" alt="{{ $post->title }}" class="w-full h-80 object-cover rounded-md mb-6 shadow-md">
            @endif

            <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 leading-tight mb-3">
                {{ $post->title }}
            </h1>

            <div class="text-sm text-gray-500 mb-8 flex items-center space-x-3 border-b pb-4">
                <p>Oleh: <span class="font-semibold text-teal-600">{{ $post->author ?? 'Admin' }}</span></p>
                <span class="text-gray-300">|</span>
                <p>Tanggal: <span class="font-semibold">{{ \Carbon\Carbon::parse($post->created_at)->translatedFormat('d F Y') }}</span></p>
            </div>

            {{-- Gunakan 'prose' untuk styling markdown/HTML yang bagus --}}
            <div class="prose max-w-none text-gray-700 leading-relaxed space-y-6">
                {!! $post->content !!}
            </div>

            <div class="mt-10 pt-6 border-t">
                {{-- Pastikan route 'posts.public.index' sudah terdaftar di web.php --}}
                <a href="{{ route('posts.public.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-teal-600 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 transition duration-150">
                    &larr; Kembali ke Daftar Post
                </a>
            </div>

        </article>
    </div>
</div>

@endsection

@push('scripts')
{{-- Tidak perlu ada skrip khusus jika ini hanya untuk view --}}
@endpush