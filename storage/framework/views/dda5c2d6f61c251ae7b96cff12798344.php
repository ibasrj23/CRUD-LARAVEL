<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post</title>
</head>
<body>
    <h1>Edit Post</h1>
    <form action="<?php echo e(route('posts.update', $post->id)); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        <div>
            <label for="title">Judul:</label>
            <input type="text" id="title" name="title" value="<?php echo e(old('title', $post->title)); ?>" required>
        </div>
        <div>
            <label for="content">Isi:</label>
            <textarea id="content" name="content" required><?php echo e(old('content', $post->content)); ?></textarea>
        </div>
        <div>
            <label for="image">Gambar:</label>
            <input type="file" id="image" name="image">
            <?php if($post->image): ?>
                <p>Gambar saat ini: <img src="<?php echo e(asset('image/' . $post->image)); ?>" width="100"></p>
            <?php endif; ?>
        </div>
        <div>
            <label for="published_at">Tanggal Terbit:</label>
            <input type="date" id="published_at" name="published_at" value="<?php echo e(old('published_at', $post->published_at)); ?>" required>
        </div>
        <button type="submit">Update</button>
    </form>
</body>
</html>
<?php /**PATH C:\Users\ASUSTeK\latihan-laravel\resources\views\posts\edit.blade.php ENDPATH**/ ?>