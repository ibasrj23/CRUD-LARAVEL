<?php $__env->startSection('title', 'Daftar Post Publik'); ?>
<?php $__env->startSection('header-title', 'Koleksi Postingan Terbaru'); ?>

<?php $__env->startSection('content'); ?>
<div class="content-wrapper">

    <!-- Form Pencarian dan Sorting (Pertahankan fungsi) -->
    <div class="mb-4 p-3 bg-light rounded-lg shadow-sm d-flex justify-content-between align-items-center">
        <form action="<?php echo e(route('posts.public.index')); ?>" method="GET" class="d-flex w-50 me-3">
            <input type="text" name="search" class="form-control me-2" placeholder="Cari Judul atau Konten..." value="<?php echo e(request('search')); ?>">
            <button type="submit" class="btn btn-secondary"><i class="fas fa-search"></i> Cari</button>
        </form>

        <form action="<?php echo e(route('posts.public.index')); ?>" method="GET" class="d-flex">
            <input type="hidden" name="search" value="<?php echo e(request('search')); ?>">
            <select name="sort" onchange="this.form.submit()" class="form-select w-auto">
                <option value="published_at" <?php echo e(request('sort') == 'published_at' ? 'selected' : ''); ?>>Urutkan: Terbaru</option>
                <option value="title" <?php echo e(request('sort') == 'title' ? 'selected' : ''); ?>>Urutkan: Judul (A-Z)</option>
            </select>
        </form>
    </div>

    <!-- Card Layout untuk Daftar Post -->
    <div class="row">
        <?php $__empty_1 = true; $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100 shadow-sm border-0">

                    <!-- Gambar Post -->
                    <div class="overflow-hidden" style="height: 200px;">
                        <?php if($post->image): ?>
                            <img src="<?php echo e(asset('image/' . $post->image)); ?>" class="card-img-top" alt="<?php echo e($post->title); ?>" style="object-fit: cover; height: 100%;">
                        <?php else: ?>
                            <div class="bg-light text-center d-flex align-items-center justify-content-center" style="height: 100%;">
                                <i class="fas fa-image fa-3x text-muted"></i>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="card-body d-flex flex-column">
                        <!-- Judul -->
                        <h5 class="card-title text-primary text-truncate"><?php echo e($post->title); ?></h5>

                        <!-- Deskripsi Singkat (Ambil beberapa baris konten) -->
                        <p class="card-text text-muted small mb-3 flex-grow-1">
                            <?php echo e(Str::limit(strip_tags($post->content), 100, '...')); ?>

                        </p>

                        <!-- Meta Data -->
                        <div class="d-flex justify-content-between align-items-center small text-secondary border-top pt-2 mt-auto">
                            <span>
                                <i class="fas fa-user-circle"></i> <?php echo e($post->user->name ?? 'Redaksi'); ?>

                            </span>
                            <span>
                                <i class="fas fa-calendar-alt"></i> <?php echo e(\Carbon\Carbon::parse($post->published_at)->translatedFormat('d M Y')); ?>

                            </span>
                        </div>
                    </div>

                    <div class="card-footer bg-white border-top-0">
                        <!-- Tombol Baca Selengkapnya -->
                        <a href="<?php echo e(route('posts.public.show', $post->id)); ?>" class="btn btn-primary btn-sm btn-block w-100">
                            Baca Selengkapnya <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle"></i> Tidak ada post aktif yang ditemukan.
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Pagination Links -->
    <div class="d-flex justify-content-center mt-4">
        <?php echo e($posts->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ASUSTeK\latihan-laravel\resources\views/posts/public_index.blade.php ENDPATH**/ ?>