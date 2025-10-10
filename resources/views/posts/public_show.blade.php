@extends('layouts.app')

@section('title', 'Daftar Post Publik')
@section('header-title', 'Daftar Post Aktif')

@section('content')

<div class="table-responsive">
    @if ($posts->isEmpty())
        <div class="alert alert-info" role="alert">
            Belum ada Post aktif yang tersedia saat ini.
        </div>
    @else
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Judul</th>
                    <th scope="col">Penulis</th>
                    <th scope="col">Tgl. Terbit</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($posts as $index => $post)
                <tr>
                    <td>{{ $posts->firstItem() + $index }}</td>
                    <td>{{ \Illuminate\Support\Str::limit($post->title, 50) }}</td>
                    <td>{{ $post->user->name ?? 'Admin Terhapus' }}</td>
                    <td>{{ \Carbon\Carbon::parse($post->published_at)->translatedFormat('d M Y') }}</td>
                    <td>
                        {{-- Tautan ke halaman detail post (show) --}}
                        <a href="{{ route('posts.show_public', $post->id) }}" class="btn btn-sm btn-info text-white">
                            <i class="fas fa-eye"></i> Lihat
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Tampilkan Link Pagination --}}
        <div class="d-flex justify-content-center mt-4">
            {{ $posts->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>

@endsection
