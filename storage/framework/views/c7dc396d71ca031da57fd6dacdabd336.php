<?php $__env->startSection('title', 'Edit Post: ' . $post->title); ?>
<?php $__env->startSection('header-title', 'Edit Post: ' . $post->title); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid px-4 mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-12">

            
            <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-1"></i> <?php echo e(session('success')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <?php if(session('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-times-circle me-1"></i> <?php echo e(session('error')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <form action="<?php echo e(route('posts.update', $post->id)); ?>" method="POST" enctype="multipart/form-data" class="mt-3">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <div class="row g-4">
                    
                    <div class="col-lg-8">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-header bg-white fw-bold">
                                <i class="fas fa-info-circle me-2"></i> Informasi Utama
                            </div>
                            <div class="card-body">

                                
                                <div class="mb-3">
                                    <label for="title" class="form-label fw-semibold">Judul Post</label>
                                    <input type="text" class="form-control" id="title" name="title"
                                           value="<?php echo e(old('title', $post->title)); ?>" required>
                                    <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                
                                <div class="mb-3">
                                    <label for="published_at" class="form-label fw-semibold">Tanggal Publish</label>
                                    <input type="date" class="form-control" id="published_at" name="published_at"
                                           value="<?php echo e(old('published_at', \Carbon\Carbon::parse($post->published_at)->format('Y-m-d'))); ?>" required>
                                    <?php $__errorArgs = ['published_at'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                
                                <div class="mb-3">
                                    <label for="content" class="form-label fw-semibold">Konten Post</label>
                                    <textarea class="form-control" id="content" name="content" rows="10" required><?php echo e(old('content', $post->content)); ?></textarea>
                                    <?php $__errorArgs = ['content'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                            </div>
                        </div>
                    </div>

                    
                    <div class="col-lg-4">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-header bg-white fw-bold">
                                <i class="fas fa-cog me-2"></i> Pengaturan & Media
                            </div>
                            <div class="card-body">

                                
                                <div class="mb-4">
                                    <label class="form-label fw-semibold d-block">Preview Gambar</label>
                                    <div class="text-center border p-2 rounded bg-light">
                                        <img id="image-preview"
                                            src="<?php echo e($post->image ? asset('image/' . $post->image) : 'https://placehold.co/400x200/cccccc/333333?text=Tidak+Ada+Gambar'); ?>"
                                            alt="Current Image"
                                            class="img-fluid rounded"
                                            style="max-height: 180px; object-fit: cover;">
                                    </div>
                                </div>

                                
                                <div class="mb-4">
                                    <label for="image" class="form-label fw-semibold">Ganti Gambar Utama</label>
                                    <input type="file" class="form-control" id="image-input" name="image" accept="image/*">
                                    <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah. Maksimal 2MB (jpg, jpeg, png).</small>
                                    <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                
                                <div class="mb-4">
                                    <label for="is_active" class="form-label fw-semibold">Status Postingan</label>
                                    <select class="form-select" id="is_active" name="is_active" required>
                                        <option value="1" <?php echo e(old('is_active', $post->is_active) == 1 ? 'selected' : ''); ?>>Public/Published</option>
                                        <option value="0" <?php echo e(old('is_active', $post->is_active) == 0 ? 'selected' : ''); ?>>Draft</option>
                                    </select>
                                    <small class="form-text text-muted">Pilih Draft jika belum siap tayang.</small>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="d-flex justify-content-between align-items-center mt-4 mb-5">
                    <a href="<?php echo e(route('posts.show', $post->id)); ?>" class="btn btn-secondary shadow-sm">
                        <i class="fas fa-arrow-left me-1"></i> Kembali ke Detail
                    </a>
                    <button type="submit" class="btn btn-primary shadow-sm">
                        <i class="fas fa-save me-1"></i> Perbarui Post
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function() {
    const imageInput = document.getElementById('image-input');
    const imagePreview = document.getElementById('image-preview');
    if (imageInput) {
        imageInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = e => imagePreview.src = e.target.result;
                reader.readAsDataURL(file);
            }
        });
    }
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ASUSTeK\latihan-laravel\resources\views/posts/edit.blade.php ENDPATH**/ ?>