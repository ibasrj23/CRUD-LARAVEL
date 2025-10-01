<?php $__env->startSection('title', 'Halaman User'); ?>
<?php $__env->startSection('header-title', 'Halaman User'); ?>

<?php $__env->startSection('content'); ?>
    <!-- Menampilkan alert success jika ada -->
    <?php if(session('success')): ?>
        <div class="alert alert-success">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <!-- Menampilkan alert error jika ada -->
    <?php if(session('error')): ?>
        <div class="alert alert-danger">
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>

    <a href="<?php echo e(route('users.create')); ?>" class="btn btn-primary mb-3">Tambah User</a>
    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Username</th>
            <th>Email</th>
            <th>Foto</th>
            <th>Aksi</th>
        </tr>
        <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td><?php echo e($loop->iteration); ?></td>
                <td><?php echo e($user->name); ?></td>
                <td><?php echo e($user->username); ?></td>
                <td><?php echo e($user->email); ?></td>
                <td>
                    <?php if($user->photo): ?>
                        <img src="<?php echo e(asset('photos/' . $user->photo)); ?>" alt="Foto <?php echo e($user->name); ?>" width="50">
                    <?php else: ?>
                        <span>No Photo</span>
                    <?php endif; ?>
                </td>
                <td>
                    <a href="<?php echo e(route('users.edit', $user->id)); ?>" class="btn btn-warning btn-sm">Edit</a>
                    <form action="<?php echo e(route('users.destroy', $user->id)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="6">Tidak ada data</td>
            </tr>
        <?php endif; ?>
    </table>

    <!-- Menambahkan pagination -->
    <?php echo e($users->links()); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ASUSTeK\latihan-laravel\resources\views\user\index.blade.php ENDPATH**/ ?>