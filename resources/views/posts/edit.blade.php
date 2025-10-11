@extends('layouts.app')

@section('title', 'Edit Post: ' . $post->title)
@section('header-title', 'Edit Post')

@section('content')

<!-- Alert Sesi Error/Sukses -->
@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
        <i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row">
        <!-- Kolom Kiri: Input Utama -->
        <div class="col-lg-8">
            <div class="card shadow-lg mb-4 border-0">
                <div class="card-header bg-warning text-white">
                    <h5 class="mb-0"><i class="fas fa-edit me-2"></i> Detail Konten</h5>
                </div>
                <div class="card-body">
                    <!-- Judul Post -->
                    <div class="mb-3">
                        <label for="title" class="form-label fw-bold">Judul Post</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title"
                            value="{{ old('title', $post->title) }}"
                            placeholder="Masukkan judul post yang menarik..." required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Tanggal Publish -->
                    <div class="mb-3">
                        <label for="published_at" class="form-label fw-bold">Tanggal Publish</label>
                        <input type="date" class="form-control @error('published_at') is-invalid @enderror" id="published_at" name="published_at"
                            value="{{ old('published_at', \Carbon\Carbon::parse($post->published_at)->format('Y-m-d')) }}"
                            required>
                        @error('published_at')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Konten Post -->
                    <div class="mb-3">
                        <label for="content" class="form-label fw-bold">Konten Post</label>
                        <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="15"
                            placeholder="Tulis konten post di sini..." required>{{ old('content', $post->content) }}</textarea>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Gambar dan Aksi -->
        <div class="col-lg-4">
            <div class="card shadow-lg border-0 mb-4">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0"><i class="fas fa-image me-2"></i> Gambar & Aksi</h5>
                </div>
                <div class="card-body">

                    <!-- Gambar Preview SAAT INI -->
                    <div id="image-preview-container" class="mb-4 border p-2 rounded text-center bg-light
                        {{ $post->image ? '' : 'd-none' }}">
                        <p class="small text-muted mb-2" id="preview-text">
                            Gambar Saat Ini:
                        </p>
                        <img id="image-preview"
                            src="{{ $post->image ? asset('image/' . $post->image) : '#' }}"
                            alt="Preview Gambar"
                            class="img-fluid rounded shadow-sm"
                            style="max-height: 200px; object-fit: cover; display: block;">
                    </div>

                    <!-- Gambar Utama Input -->
                    <div class="mb-4">
                        <label for="image" class="form-label fw-bold">Ganti Gambar</label>
                        <input type="file" class="form-control-file @error('image') is-invalid @enderror" id="image" name="image" accept="image/*" onchange="previewNewImage(event)">
                        <small class="form-text text-muted">Kosongkan jika tidak ingin ganti. Maksimal 2MB (jpg, jpeg, png).</small>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-warning btn-lg shadow-sm text-white">
                            <i class="fas fa-sync me-2"></i> Perbarui Post
                        </button>
                        <a href="{{ route('posts.index') }}" class="btn btn-secondary shadow-sm">
                            <i class="fas fa-arrow-left me-2"></i> Kembali ke Daftar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

@endsection

@push('scripts')
<script>
    /**
     * Fungsi untuk menampilkan preview gambar baru saat dipilih.
     */
    function previewNewImage(event) {
        const preview = document.getElementById('image-preview');
        const container = document.getElementById('image-preview-container');
        const previewText = document.getElementById('preview-text');

        if (event.target.files.length > 0) {
            // Preview gambar baru
            const src = URL.createObjectURL(event.target.files[0]);
            preview.src = src;
            previewText.textContent = 'Preview Gambar Baru:';
            container.classList.remove('d-none');
        } else {
            // Kembalikan ke gambar lama jika ada, atau sembunyikan jika tidak ada
            @if($post->image)
                preview.src = "{{ asset('image/' . $post->image) }}";
                previewText.textContent = 'Gambar Saat Ini:';
                container.classList.remove('d-none');
            @else
                container.classList.add('d-none');
                preview.src = '#';
            @endif
        }
    }

    // Set default value for published_at to today's date if empty (hanya untuk jaga-jaga)
    document.addEventListener('DOMContentLoaded', function() {
        const publishedAtInput = document.getElementById('published_at');
        if (!publishedAtInput.value) {
            const today = new Date();
            const yyyy = today.getFullYear();
            const mm = String(today.getMonth() + 1).padStart(2, '0');
            const dd = String(today.getDate()).padStart(2, '0');
            publishedAtInput.value = `${yyyy}-${mm}-${dd}`;
        }
    });
</script>
@endpush
