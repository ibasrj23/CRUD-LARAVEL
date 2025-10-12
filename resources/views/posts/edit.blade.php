@extends('layouts.app')

@section('title', 'Edit Post: ' . $post->title)
@section('header-title', 'Edit Post: ' . $post->title)

@section('content')
<div class="container-fluid px-4 mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-12">

            {{-- Notifikasi (Sukses/Gagal) --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-times-circle me-1"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data" class="mt-3">
                @csrf
                @method('PUT')

                <div class="row g-4">
                    {{-- KOLOM KIRI --}}
                    <div class="col-lg-8">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-header bg-white fw-bold">
                                <i class="fas fa-info-circle me-2"></i> Informasi Utama
                            </div>
                            <div class="card-body">

                                {{-- Judul Post --}}
                                <div class="mb-3">
                                    <label for="title" class="form-label fw-semibold">Judul Post</label>
                                    <input type="text" class="form-control" id="title" name="title"
                                           value="{{ old('title', $post->title) }}" required>
                                    @error('title')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Tanggal Publish --}}
                                <div class="mb-3">
                                    <label for="published_at" class="form-label fw-semibold">Tanggal Publish</label>
                                    <input type="date" class="form-control" id="published_at" name="published_at"
                                           value="{{ old('published_at', \Carbon\Carbon::parse($post->published_at)->format('Y-m-d')) }}" required>
                                    @error('published_at')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Konten Post --}}
                                <div class="mb-3">
                                    <label for="content" class="form-label fw-semibold">Konten Post</label>
                                    <textarea class="form-control" id="content" name="content" rows="10" required>{{ old('content', $post->content) }}</textarea>
                                    @error('content')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                        </div>
                    </div>

                    {{-- KOLOM KANAN --}}
                    <div class="col-lg-4">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-header bg-white fw-bold">
                                <i class="fas fa-cog me-2"></i> Pengaturan & Media
                            </div>
                            <div class="card-body">

                                {{-- Preview Gambar --}}
                                <div class="mb-4">
                                    <label class="form-label fw-semibold d-block">Preview Gambar</label>
                                    <div class="text-center border p-2 rounded bg-light">
                                        <img id="image-preview"
                                            src="{{ $post->image ? asset('image/' . $post->image) : 'https://placehold.co/400x200/cccccc/333333?text=Tidak+Ada+Gambar' }}"
                                            alt="Current Image"
                                            class="img-fluid rounded"
                                            style="max-height: 180px; object-fit: cover;">
                                    </div>
                                </div>

                                {{-- Input Gambar --}}
                                <div class="mb-4">
                                    <label for="image" class="form-label fw-semibold">Ganti Gambar Utama</label>
                                    <input type="file" class="form-control" id="image-input" name="image" accept="image/*">
                                    <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah. Maksimal 2MB (jpg, jpeg, png).</small>
                                    @error('image')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Status Post --}}
                                <div class="mb-4">
                                    <label for="is_active" class="form-label fw-semibold">Status Postingan</label>
                                    <select class="form-select" id="is_active" name="is_active" required>
                                        <option value="1" {{ old('is_active', $post->is_active) == 1 ? 'selected' : '' }}>Public/Published</option>
                                        <option value="0" {{ old('is_active', $post->is_active) == 0 ? 'selected' : '' }}>Draft</option>
                                    </select>
                                    <small class="form-text text-muted">Pilih Draft jika belum siap tayang.</small>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                {{-- Tombol Aksi --}}
                <div class="d-flex justify-content-between align-items-center mt-4 mb-5">
                    <a href="{{ route('posts.show', $post->id) }}" class="btn btn-secondary shadow-sm">
                        <i class="fas fa-arrow-left me-1"></i> Kembali ke Detail
                    </a>
                    <button type="submit" class="btn btn-primary shadow-sm">
                        <i class="fas fa-save me-1"></i> Perbarui Post
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

{{-- Preview Gambar Dinamis --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const imageInput = document.getElementById('image-input');
    const imagePreview = document.getElementById('image-preview');
    if (imageInput) {
        imageInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = e => imagePreview.src = e.target.result;
                reader.readAsDataURL(file);
            }
        });
    }
});
</script>
@endsection
