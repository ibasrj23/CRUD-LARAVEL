<?php $__env->startSection('title', isset($post) ? $post->title : 'Detail Post'); ?>
<?php $__env->startSection('header-title', ''); ?>

<?php $__env->startSection('content'); ?>

<div class="card shadow-lg border-0 mx-auto" style="max-width: 900px;">

    <div class="card-body p-5">

        <?php if(isset($post)): ?>
        <!-- Judul Utama Post -->
        <h1 class="display-5 fw-bold text-dark mb-4 border-bottom pb-3">
            <?php echo e($post->title); ?>

        </h1>

        <!-- Informasi Meta (Kolom Kiri-Kanan yang Rapi) -->
        <div class="row mb-5 text-muted small">
            <div class="col-md-6">
                
                <p class="mb-1"><strong><i class="fas fa-user-circle"></i> Penulis:</strong> <?php echo e($post->user->name ?? 'Tim Redaksi'); ?></p>
            </div>
            <div class="col-md-6 text-md-end">
                <p class="mb-0"><strong><i class="fas fa-share-square"></i> Dipublikasi:</strong> <?php echo e(\Carbon\Carbon::parse($post->published_at)->translatedFormat('d F Y')); ?></p>
            </div>
        </div>

        <!-- Gambar Utama (Fokus di Tengah) -->
        <?php if($post->image): ?>
            <div class="mb-5 d-flex justify-content-center">
                <div class="overflow-hidden border p-2 rounded shadow-sm" style="max-width: 800px;">
                    <img src="<?php echo e(asset('image/' . $post->image)); ?>" alt="<?php echo e($post->title); ?>" class="img-fluid rounded" style="max-height: 400px; object-fit: cover;">
                </div>
            </div>
        <?php else: ?>
            <div class="alert alert-info text-center small mb-5"><i class="fas fa-info-circle"></i> Tidak ada gambar unggulan.</div>
        <?php endif; ?>

        <!-- Konten Post (Menggunakan styling bawaan browser untuk teks) -->
        <div class="mt-4">
            <div class="p-4 rounded bg-white shadow-sm post-content">
                <?php echo $post->content; ?>

            </div>
        </div>

    </div> 

    <div class="card-footer bg-light border-top text-end">
        
        <a href="<?php echo e(route('posts.public.index')); ?>" class="btn btn-secondary shadow-sm">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Post
        </a>
    </div>

    <?php else: ?>
        <div class="card-body p-5">
            <div class="alert alert-danger text-center">Post tidak ditemukan atau URL salah.</div>
        </div>
    <?php endif; ?>

</div> 

<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
/* Style tambahan untuk memastikan konten HTML dari user terlihat bagus */
.post-content p {
    margin-bottom: 1rem;
    line-height: 1.7;
    font-size: 1.1rem;
    color: #333;
}
.post-content h1, .post-content h2, .post-content h3 {
    margin-top: 2rem;
    margin-bottom: 1rem;
    font-weight: 600;
    border-bottom: 1px solid #eee;
    padding-bottom: 5px;
}
</style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ASUSTeK\latihan-laravel\resources\views/posts/public_index.blade.php ENDPATH**/ ?>