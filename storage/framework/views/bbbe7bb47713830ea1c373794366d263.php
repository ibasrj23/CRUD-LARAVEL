<?php $__env->startPush('styles'); ?>

<!-- Panggil CSS kustom yang baru untuk tampilan mantap -->

<link href="<?php echo e(asset('admin/css/index.css')); ?>" rel="stylesheet">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('title', 'Halaman User'); ?>
<?php $__env->startSection('header-title', 'Halaman User'); ?>

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

<!-- Tombol Tambah User -->
<a href="<?php echo e(route('users.create')); ?>" class="btn btn-primary mb-4">
    <i class="fas fa-user-plus mr-2"></i> Tambah User
</a>

<!-- Table Content -->
<div class="table-responsive"> <!-- Fix untuk scroll horizontal -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Username</th>
                <th>Role</th>
                <th>Email</th>
                <th>Foto</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($loop->iteration); ?></td>
                    <td><?php echo e($user->name); ?></td>
                    <td><?php echo e($user->username ?? '-'); ?></td>
                    <td><?php echo e($user->role == 1 ? 'Admin' : 'User'); ?></td>
                    <td><?php echo e($user->email); ?></td>
                    <td>
                    <?php if($user->photo): ?>
                        <img src="<?php echo e(asset('photos/' . $user->photo)); ?>" alt="<?php echo e($user->name); ?>" width="100" height="100">
                    <?php else: ?>
                        Tidak ada gambar
                    <?php endif; ?>
                    </td>
                    <!-- START: FIX Aksi Tombol -->
                    <td class="d-flex justify-content-start align-items-center">
                        <!-- Tombol Show Detail (Icon + Margin) -->
                        <a href="<?php echo e(route('users.show', $user->id)); ?>" class="btn btn-info btn-sm me-1" title="Lihat Detail">
                            <i class="fas fa-eye"></i>
                        </a>

                        <!-- Tombol Edit (Icon + Margin) -->
                        <a href="<?php echo e(route('users.edit', $user->id)); ?>" class="btn btn-warning btn-sm me-1" title="Edit">
                            <i class="fas fa-pen"></i>
                        </a>

                        <!-- Tombol Hapus (Icon Saja, Dihapus Teks 'Hapus') -->
                        <form action="<?php echo e(route('users.destroy', $user->id)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </td>
                    <!-- END: FIX Aksi Tombol -->
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="7" class="text-center">Tidak ada data user.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Pagination Links -->
<div class="d-flex justify-content-center">
    <?php echo e($users->links()); ?>

</div>

</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>

<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ASUSTeK\latihan-laravel\resources\views/user/index.blade.php ENDPATH**/ ?>