<?php $__env->startPush('styles'); ?>
    
    <style>
        /* Gaya Kustom untuk Tampilan Lebih Soft dan Elegan */
        .content-header {
            border-bottom: 2px solid #e9ecef; /* Garis bawah yang halus */
            padding-bottom: 1rem;
            margin-bottom: 1.5rem;
        }
        .action-card {
            border: none;
            border-radius: 0.75rem; /* Sudut lebih membulat */
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05); /* Bayangan lembut */
        }
        .table thead th {
            background-color: #f8f9fa; /* Header tabel warna soft grey */
            color: #495057;
            font-weight: 600;
        }
        .table tbody tr:hover {
            background-color: #f1f1f1; /* Efek hover yang lembut */
        }
        .btn-action-group .btn {
            padding: 0.375rem 0.5rem; /* Tombol aksi yang lebih kecil */
        }
        .search-sort-bar {
            background-color: #ffffff; /* Bar pencarian/sort diubah jadi putih */
            border-radius: 0.75rem;
            padding: 1rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('title', 'Manajemen Post'); ?>
<?php $__env->startSection('header-title', 'Manajemen Post'); ?>


<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center content-header">
        <h2 class="h3 mb-0 text-dark">Manajemen Post</h2>
        <a href="<?php echo e(route('posts.create')); ?>" class="btn btn-primary shadow-sm" style="background-color: #007bff; border-color: #007bff;">
            <i class="fas fa-plus me-2"></i> Tambah Post Baru
        </a>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show action-card" role="alert">
            <i class="fas fa-check-circle me-2"></i> <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show action-card" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i> <?php echo e(session('error')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="mb-4 search-sort-bar d-flex justify-content-between align-items-center">
        <form action="<?php echo e(route('posts.index')); ?>" method="GET" class="d-flex w-50">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Cari Judul atau Konten..." value="<?php echo e(request('search')); ?>">
                <button type="submit" class="btn btn-primary" style="background-color: #6c757d; border-color: #6c757d;" title="Cari">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>

        <form action="<?php echo e(route('posts.index')); ?>" method="GET" class="d-flex">
            <input type="hidden" name="search" value="<?php echo e(request('search')); ?>">
            <select name="sort" onchange="this.form.submit()" class="form-select w-auto">
                <option value="published_at" <?php echo e(request('sort') == 'published_at' ? 'selected' : ''); ?>>Urutkan: Terbaru</option>
                <option value="title" <?php echo e(request('sort') == 'title' ? 'selected' : ''); ?>>Urutkan: Judul (A-Z)</option>
            </select>
        </form>
    </div>

    <div class="card action-card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th style="width: 50px;">No</th>
                            <th>Judul</th>
                            <th style="width: 150px;">Tanggal Publish</th>
                            <th style="width: 120px;">Gambar</th>
                            <th style="width: 170px;" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($loop->iteration + ($posts->currentPage() - 1) * $posts->perPage()); ?></td>
                                <td><strong class="text-primary"><?php echo e(Str::limit($post->title, 50)); ?></strong></td> 
                                <td class="text-muted"><?php echo e(\Carbon\Carbon::parse($post->published_at)->isoFormat('D MMMM YYYY')); ?></td> 
                                <td>
                                    <?php if($post->image): ?>
                                        <img src="<?php echo e(asset('image/' . $post->image)); ?>" alt="<?php echo e($post->title); ?>" class="img-fluid" style="width: 100px; height: 60px; object-fit: cover; border-radius: 4px; border: 1px solid #dee2e6;">
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Tidak ada gambar</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center btn-action-group">

                                    

                                    <a href="<?php echo e(route('posts.show', $post->id)); ?>" class="btn btn-sm btn-outline-info me-1" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <?php if(Auth::check() && Auth::user()->role == 1): ?>
                                        <a href="<?php echo e(route('posts.edit', $post->id)); ?>" class="btn btn-sm btn-outline-warning me-1" title="Edit">
                                            <i class="fas fa-pen"></i>
                                        </a>

                                        <form action="<?php echo e(route('posts.destroy', $post->id)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus post: <?php echo e($post->title); ?>?')">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="5" class="text-center p-4">
                                    <i class="fas fa-box-open fa-2x text-muted mb-3"></i>
                                    <p class="mb-0">Tidak ada post yang ditemukan. Coba ganti kata kunci pencarian Anda.</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-4">
        <?php echo e($posts->appends(['search' => request('search'), 'sort' => request('sort')])->links('pagination::bootstrap-5')); ?> 
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ASUSTeK\latihan-laravel\resources\views/posts/index.blade.php ENDPATH**/ ?>