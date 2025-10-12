<?php $__env->startSection('title', 'Tambah Post'); ?>
<?php $__env->startSection('header-title', 'Buat Post Baru'); ?>

<?php $__env->startSection('content'); ?>

<div class="pt-4"></div>

<div class="row justify-content-center">
    <div class="col-lg-12"> 

        
        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> <?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <?php if(session('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-times-circle"></i> <?php echo e(session('error')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <form action="<?php echo e(route('posts.store')); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>

            <div class="row">

                
                <div class="col-lg-8 mb-4">
                    <div class="card shadow-lg border-0">
                        <div class="card-header bg-white fw-bold border-bottom">
                            <h5 class="mb-0 text-primary"><i class="fas fa-file-alt me-2"></i> Detail Konten Utama</h5>
                        </div>
                        <div class="card-body">

                            
                            <div class="mb-3">
                                <label for="title" class="form-label fw-bold">Judul Post</label>
                                <input type="text" class="form-control" id="title" name="title" value="<?php echo e(old('title')); ?>" required>
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
                                <label for="published_at" class="form-label fw-bold">Tanggal Publish</label>
                                <input type="date" class="form-control" id="published_at" name="published_at" value="<?php echo e(old('published_at', date('Y-m-d'))); ?>" required>
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
                                <label for="content" class="form-label fw-bold">Konten Post</label>
                                <textarea class="form-control" id="content" name="content" rows="18" required><?php echo e(old('content')); ?></textarea>
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

                
                <div class="col-lg-4 mb-4">
                    <div class="card shadow-lg border-0">
                        <div class="card-header bg-white fw-bold border-bottom">
                            <h5 class="mb-0 text-secondary"><i class="fas fa-cog me-2"></i> Pengaturan & Media</h5>
                        </div>
                        <div class="card-body">

                            
                            <div class="mb-4">
                                <label for="is_active" class="form-label fw-bold"><i class="fas fa-toggle-on me-1"></i> Status Postingan</label>
                                <select class="form-select" id="is_active" name="is_active" required>
                                    <option value="1" <?php echo e(old('is_active', 1) == 1 ? 'selected' : ''); ?>>Public/Published</option>
                                    <option value="0" <?php echo e(old('is_active', 1) == 0 ? 'selected' : ''); ?>>Draft</option>
                                </select>
                                <small class="form-text text-muted">Pilih Draft jika belum siap tayang.</small>
                                <?php $__errorArgs = ['is_active'];
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
                                <label class="form-label fw-bold d-block"><i class="fas fa-eye me-1"></i> Preview Gambar</label>
                                <div class="text-center border p-2 rounded mb-2 bg-light">
                                    <img id="image-preview"
                                        src="https://placehold.co/400x150/cccccc/333333?text=Preview+Gambar"
                                        alt="Image Preview"
                                        class="img-fluid rounded"
                                        style="max-height: 150px; object-fit: cover;">
                                </div>
                            </div>

                            
                            <div class="mb-4">
                                <label for="image" class="form-label">Upload Gambar Utama</label>
                                <input type="file" class="form-control" id="image-input" name="image" accept="image/*">
                                <small class="form-text text-muted">Maksimal 2MB (jpg, jpeg, png).</small>
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

                            
                            <div class="d-grid gap-2 mt-4 pt-3 border-top">
                                <button type="submit" class="btn btn-primary btn-lg shadow-sm">
                                    <i class="fas fa-save me-2"></i> Simpan Post
                                </button>
                                <a href="<?php echo e(route('posts.index')); ?>" class="btn btn-secondary shadow-sm">
                                    <i class="fas fa-arrow-left me-2"></i> Kembali
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </form>

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
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    }
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ASUSTeK\latihan-laravel\resources\views/posts/create.blade.php ENDPATH**/ ?>