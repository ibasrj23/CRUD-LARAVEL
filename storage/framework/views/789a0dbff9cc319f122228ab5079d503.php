<?php $__env->startPush('styles'); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('title', 'Halaman Edit User'); ?>
<?php $__env->startSection('header-title', 'Halaman Edit User'); ?>


<?php $__env->startSection('content'); ?>
	<form action="<?php echo e(route('users.update', $user->id)); ?>" method="POST">
		<?php echo csrf_field(); ?>
		<?php echo method_field('PUT'); ?>
		<div class="mb-3">
			<label for="name" class="form-label">Nama</label>
			<input type="text" class="form-control" id="name" name="name" value="<?php echo e($user->name); ?>" required>
		</div>
		<div class="mb-3">
			<label for="email" class="form-label">Email</label>
			<input type="email" class="form-control" id="email" name="email" value="<?php echo e($user->email); ?>" required>
		</div>
		<div class="mb-3">
			<label for="password" class="form-label">Password Baru</label>
			<input type="password" class="form-control" id="password" name="password">
			<small class="form-text text-muted">Kosongkan jika tidak ingin mengubah password</small>
		</div>
		<button type="submit" class="btn btn-primary">Simpan</button>
		<a href="<?php echo e(route('users.index')); ?>" class="btn btn-secondary">Kembali</a>
	</form>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>

<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ASUSTeK\latihan-laravel\resources\views\user\edit.blade.php ENDPATH**/ ?>