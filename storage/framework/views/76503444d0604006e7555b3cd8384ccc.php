<?php $__env->startPush('styles'); ?>
    <!-- Panggil CSS kustom yang baru untuk tampilan mantap -->
    <link href="<?php echo e(asset('admin/css/styles.css')); ?>" rel="stylesheet">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('title', 'Halaman Post'); ?>
<?php $__env->startSection('header-title', 'Manajemen Post'); ?>


<?php $__env->startSection('content'); ?>
<div class="content-wrapper">

    <!-- Messages -->
    <?php if(session('success')): ?>
        <div class="alert alert-success">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>
    <?php if(session('error')): ?>
        <div class="alert alert-danger">
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>

    <!-- Tombol Tambah Post (Hanya terlihat oleh Admin/Role 1) -->
    
    <?php if(Auth::check() && Auth::user()->role == 1): ?>
        <a href="<?php echo e(route('posts.create')); ?>" class="btn btn-primary mb-4">
            <i class="fas fa-plus mr-2"></i> Tambah Post Baru
        </a>
    <?php endif; ?>

    <!-- Form Pencarian dan Sorting -->
    <div class="mb-4 p-3 bg-light rounded-lg shadow-sm d-flex justify-content-between align-items-center">
        <form action="<?php echo e(route('posts.index')); ?>" method="GET" class="d-flex w-50">
            <input type="text" name="search" class="form-control me-2" placeholder="Cari Judul atau Konten..." value="<?php echo e(request('search')); ?>">
            <button type="submit" class="btn btn-secondary"><i class="fas fa-search"></i> Cari</button>
        </form>

        <form action="<?php echo e(route('posts.index')); ?>" method="GET" class="d-flex">
            <input type="hidden" name="search" value="<?php echo e(request('search')); ?>">
            <select name="sort" onchange="this.form.submit()" class="form-select w-auto">
                <option value="published_at" <?php echo e(request('sort') == 'published_at' ? 'selected' : ''); ?>>Urutkan: Terbaru</option>
                <option value="title" <?php echo e(request('sort') == 'title' ? 'selected' : ''); ?>>Urutkan: Judul (A-Z)</option>
            </select>
        </form>
    </div>

    <!-- Table Content -->
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th style="width: 50px;">No</th>
                    <th>Judul</th>
                    <th style="width: 150px;">Tanggal Publish</th>
                    <th style="width: 120px;">Gambar</th>
                    <!-- Kolom Aksi selalu tampil, tetapi isinya berbeda -->
                    <th style="width: 150px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        
                        <td><?php echo e($loop->iteration + ($posts->currentPage() - 1) * $posts->perPage()); ?></td>
                        <td><?php echo e($post->title); ?></td>
                        <td><?php echo e($post->published_at); ?></td>
                        <td>
                        <?php if($post->image): ?>
                            <img src="<?php echo e(asset('image/' . $post->image)); ?>" alt="<?php echo e($post->title); ?>" width="100" height="60" style="object-fit: cover; border-radius: 4px;">
                        <?php else: ?>
                            Tidak ada gambar
                        <?php endif; ?>
                        </td>
                        <td class="d-flex justify-content-start align-items-center">

                            
                            <!-- 1. Tombol Show (Selalu terlihat untuk user yang login) -->
                            <a href="<?php echo e(route('posts.show', $post->id)); ?>" class="btn btn-info btn-sm me-1" title="Lihat Detail">
                                <i class="fas fa-eye"></i>
                            </a>

                            
                            <!-- 2. Tombol Edit & Hapus (Hanya terlihat oleh Admin/Role 1) -->
                            <?php if(Auth::check() && Auth::user()->role == 1): ?>
                                <!-- Tombol Edit -->
                                <a href="<?php echo e(route('posts.edit', $post->id)); ?>" class="btn btn-warning btn-sm me-1" title="Edit">
                                    <i class="fas fa-pen"></i>
                                </a>

                                <!-- Tombol Hapus -->
                                <form action="<?php echo e(route('posts.destroy', $post->id)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus post ini?')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada post yang ditemukan.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination Links -->
    <div class="d-flex justify-content-center">
        
        <?php echo e($posts->appends(['search' => request('search'), 'sort' => request('sort')])->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ASUSTeK\latihan-laravel\resources\views/posts/index.blade.php ENDPATH**/ ?>