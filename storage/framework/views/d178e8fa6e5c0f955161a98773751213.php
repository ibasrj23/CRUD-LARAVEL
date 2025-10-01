<?php $__env->startPush('styles'); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('title', 'Halaman Edit User'); ?>
<?php $__env->startSection('header-title', 'Halaman Edit User'); ?>


<?php $__env->startSection('content'); ?>
	<form action="<?php echo e(route('users.update', $user->id)); ?>" method="POST" enctype="multipart/form-data">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>

    <div class="mb-3">
        <label for="name" class="form-label">Nama</label>
        <input type="text" class="form-control" id="name" name="name" value="<?php echo e($user->name); ?>" required>
    </div>

    <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control" id="username" name="username" value="<?php echo e($user->username); ?>" required>
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" value="<?php echo e($user->email); ?>" required>
    </div>

	<div class="mb-3">
        <label for="photo" class="form-label">Foto</label>
        <input type="file" class="form-control" id="photo" name="photo">
        <?php if($user->photo): ?>
            <p>Foto Dipilih Saat Ini:</p>
            <img src="<?php echo e(asset('photos/'.$user->photo)); ?>" alt="Foto User" width="100">
        <?php endif; ?>
		<?php $__errorArgs = ['photo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
	   			<div class="text-danger"><?php echo e($message); ?></div>
		<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>


    <div class="mb-3">
        <label for="password" class="form-label">Password Baru</label>
        <input type="password" class="form-control" id="password" name="password">
        <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah password</small>
    </div>

    <a href="<?php echo e(route('users.index')); ?>" class="btn btn-secondary">Kembali</a>
	<button type="submit" class="btn btn-primary">Simpan</button>
</form>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>

<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ASUSTeK\latihan-laravel\resources\views/user/edit.blade.php ENDPATH**/ ?>