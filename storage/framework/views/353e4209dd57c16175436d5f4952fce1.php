<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="<?php echo e(asset('bootstrap/css/bootstrap.min.css')); ?>">
	
	<title>Full Data</title>
</head>
<body class="container mt-3">


	<h1>Tabel post</h1>
	<a href="<?php echo e(route('posts.create')); ?>" class="btn btn-success mb-3">tambah post</a>
	
	<?php if(session('success')): ?>
		<div class="alert alert-success">
			<?php echo e(session('success')); ?>

		</div>
	<?php endif; ?>
	<table class="table table-bordered">
		<tr>
			<th>No</th>
			<th>Judul</th>
			<th>Isi</th>
			<th>Tanggal terbit</th>
			<th>Gambar</th>
			<th>Penulis</th>
			<th>Aksi</th>
		</tr>
		<?php $__empty_1 = true; $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
		<tr>
			<td><?php echo e($loop->iteration); ?></td>
			<td><?php echo e($post->title); ?></td>
			<td><?php echo e($post->content); ?></td>
			<td><?php echo e($post->published_at); ?></td>
			<td>
				<?php if($post->image): ?>
					<img src="<?php echo e(asset('image/' . $post->image)); ?>" alt="<?php echo e($post->title); ?>" width="100">
				<?php else: ?>
					Tidak ada gambar
				<?php endif; ?>
			</td>
			<td><?php echo e($post->user ? $post->user->name : 'Penulis tidak ditemukan'); ?></td>
			<td class="text-center">
    			<a href="<?php echo e(route('posts.edit', $post->id)); ?>" class="btn btn-warning btn-sm ">Edit</a>
    			<form action="<?php echo e(route('posts.destroy', $post->id)); ?>" method="POST" style="display:inline;">
        			<?php echo csrf_field(); ?>
        			<?php echo method_field('DELETE'); ?>
        			<button type="submit" onclick="return confirm('Yakin hapus?')" class="btn btn-danger btn-sm">Delete</button>
    			</form>
			</td>

		</tr>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
		<tr>
			<td colspan="6">Tidak ada data</td>
		</tr>
		<?php endif; ?>
	</table>
	<div>
		<?php echo e($posts->links()); ?>

	</div> 
</body>
</html><?php /**PATH C:\Users\ASUSTeK\latihan-laravel\resources\views\posts\index.blade.php ENDPATH**/ ?>