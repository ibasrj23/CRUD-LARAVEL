<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="<?php echo e(asset('bootstrap/css/bootstrap.min.css')); ?>">
	<title>Tambah data</title>
</head>
<body>
	
	<h1>Tambah Post</h1>
	<form action="<?php echo e(route('posts.store')); ?>" method="POST" enctype="multipart/form-data">
		<?php echo csrf_field(); ?>
		<div>
			<label for="title">Judul:</label>
			<input type="text" id="title" name="title" required>
		</div>
		<div>
			<label for="content">Isi:</label>
			<textarea id="content" name="content" required></textarea>
		</div>
		<div>
			<label for="image">Gambar:</label>
			<input type="file" id="image" name="image">
			<?php $__errorArgs = ['image'];
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
		<div>
			<label for="published_at">Tanggal Terbit:</label>
			<input type="date" id="published_at" name="published_at" required>
		</div>
		<button type="submit">Simpan</button>
	</form>
</body>
</html><?php /**PATH C:\Users\ASUSTeK\latihan-laravel\resources\views\posts\create.blade.php ENDPATH**/ ?>