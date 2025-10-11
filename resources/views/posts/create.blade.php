@extends('layouts.app')

@section('title', 'Tambah Post')
@section('header-title', 'Buat Post Baru')

@section('content')

<!-- Alert Sesi Error/Sukses -->
@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
        <i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="row">
        <!-- Kolom Kiri: Input Utama -->
        <div class="col-lg-8">
            <div class="card shadow-lg mb-4 border-0">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-edit me-2"></i> Detail Konten</h5>
                </div>
                <div class="card-body">
                    <!-- Judul Post -->
                    <div class="mb-3">
                        <label for="title" class="form-label fw-bold">Judul Post</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" placeholder="Masukkan judul post yang menarik..." required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Tanggal Publish -->
                    <div class="mb-3">
                        <label for="published_at" class="form-label fw-bold">Tanggal Publish</label>
                        <input type="date" class="form-control @error('published_at') is-invalid @enderror" id="published_at" name="published_at" value="{{ old('published_at') ?? date('Y-m-d') }}" required>
                        @error('published_at')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Konten Post -->
                    <div class="mb-3">
                        <label for="content" class="form-label fw-bold">Konten Post</label>
                        <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="15" placeholder="Tulis konten post di sini..." required>{{ old('content') }}</textarea>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Gambar dan Aksi -->
        <div class="col-lg-4">
            <div class="card shadow-lg border-0 mb-4 fixed-stop">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0"><i class="fas fa-image me-2"></i> Gambar & Aksi</h5>
                </div>
                <div class="card-body">
                    <!-- Gambar Utama Input -->
                    <div class="mb-4">
                        <label for="image" class="form-label fw-bold">Gambar Utama</label>
                        <!-- FIX: Menggunakan form-control-file agar styling lebih kompak -->
                        <input type="file" class="form-control-file @error('image') is-invalid @enderror" id="image" name="image" accept="image/*" onchange="previewImage(event)">
                        <small class="form-text text-muted">Maksimal 2MB (jpg, jpeg, png).</small>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Gambar Preview -->
                    <div id="image-preview-container" class="mb-4 d-none border p-2 rounded text-center bg-light">
                        <p class="small text-muted mb-2">Preview Gambar:</p>
                        <img id="image-preview" src="#" alt="Preview Gambar" class="img-fluid rounded shadow-sm" style="max-height: 200px; object-fit: cover;">
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg shadow-sm">
                            <i class="fas fa-save me-2"></i> Simpan Post
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
     * Fungsi untuk menampilkan preview gambar setelah dipilih.
     */
    function previewImage(event) {
        const preview = document.getElementById('image-preview');
        const container = document.getElementById('image-preview-container');

        if (event.target.files.length > 0) {
            const src = URL.createObjectURL(event.target.files[0]);
            preview.src = src;
            container.classList.remove('d-none');

            // Opsional: Atur ulang style untuk memastikan gambar terlihat baik
            preview.style.display = 'block';
        } else {
            container.classList.add('d-none');
            preview.src = '#';
        }
    }

    // Set default value for published_at to today's date if empty
    document.addEventListener('DOMContentLoaded', function() {
        const publishedAtInput = document.getElementById('published_at');
        if (!publishedAtInput.value) {
            const today = new Date();
            const yyyy = today.getFullYear();
            const mm = String(today.getMonth() + 1).padStart(2, '0'); // Months start at 0!
            const dd = String(today.getDate()).padStart(2, '0');
            publishedAtInput.value = `${yyyy}-${mm}-${dd}`;
        }
    });
</script>
@endpush
