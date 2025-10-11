<?php $__env->startSection('title', 'Daftar Post Publik'); ?>
<?php $__env->startSection('header-title', 'Daftar Post Aktif'); ?>

<?php $__env->startSection('content'); ?>

<div class="table-responsive">
    <?php if($posts->isEmpty()): ?>
        <div class="alert alert-info" role="alert">
            Belum ada Post aktif yang tersedia saat ini.
        </div>
    <?php else: ?>
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
                <?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($posts->firstItem() + $index); ?></td>
                    <td><?php echo e(\Illuminate\Support\Str::limit($post->title, 50)); ?></td>
                    <td><?php echo e($post->user->name ?? 'Admin Terhapus'); ?></td>
                    <td><?php echo e(\Carbon\Carbon::parse($post->published_at)->translatedFormat('d M Y')); ?></td>
                    <td>
                        
                        <a href="<?php echo e(route('posts.show_public', $post->id)); ?>" class="btn btn-sm btn-info text-white">
                            <i class="fas fa-eye"></i> Lihat
                        </a>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>

        
        <div class="d-flex justify-content-center mt-4">
            <?php echo e($posts->links('pagination::bootstrap-5')); ?>

        </div>
    <?php endif; ?>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ASUSTeK\latihan-laravel\resources\views/posts/show-public.blade.php ENDPATH**/ ?>