<?php $__env->startSection('title', 'Detail User: ' . $user->name); ?>
<?php $__env->startSection('header-title', 'Detail Pengguna'); ?>


<?php $__env->startSection('content'); ?>
<!-- FIX KRITIS: Tambahkan mt-5 (Margin Top) pada content-wrapper agar tidak nabrak fixed navbar -->
<div class="content-wrapper mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-lg border-0 rounded-xl">
                <!-- WARNA DIUBAH KE MERAH (bg-danger) untuk diagnosis -->
                <div class="card-header bg-danger text-white text-center py-3">
                    <h4 class="mb-0">Profil Pengguna</h4>
                </div>
                <div class="card-body p-4">

                    <!-- Foto Profil -->
                    <div class="text-center mb-4">
                        <?php if($user->photo): ?>
                            <img src="<?php echo e(asset('photos/' . $user->photo)); ?>"
                                 alt="<?php echo e($user->name); ?>"
                                 width="120"
                                 height="120"
                                 class="img-fluid rounded-circle border border-5 border-light shadow-sm user-profile-photo">
                        <?php else: ?>
                            <div class="p-4 bg-light rounded-circle border border-secondary d-inline-block">
                                <i class="fas fa-user-circle fa-4x text-secondary"></i>
                            </div>
                        <?php endif; ?>
                        <h5 class="mt-3 mb-1"><?php echo e($user->name); ?></h5>
                        <p class="text-muted small"><?php echo e($user->email); ?></p>
                    </div>

                    <!-- Detail Data -->
                    <dl class="row mb-0 pt-3 border-top px-3">

                        <dt class="col-sm-5 text-sm-left font-weight-bold">Username</dt>
                        <dd class="col-sm-7"><?php echo e($user->username); ?></dd>

                        <dt class="col-sm-5 text-sm-left font-weight-bold">Email</dt>
                        <dd class="col-sm-7"><?php echo e($user->email); ?></dd>

                        <dt class="col-sm-5 text-sm-left font-weight-bold">Role</dt>
                        <dd class="col-sm-7">
                            <?php if($user->role == 1): ?>
                                <span class="badge bg-primary text-white">Admin</span>
                            <?php else: ?>
                                <span class="badge bg-secondary text-white">User</span>
                            <?php endif; ?>
                        </dd>

                        <dt class="col-sm-5 text-sm-left font-weight-bold">Tanggal Registrasi</dt>
                        <dd class="col-sm-7"><?php echo e($user->created_at->translatedFormat('d F Y (H:i)')); ?></dd>

                    </dl>

                </div>
                <div class="card-footer bg-light border-top text-center">
                    <a href="<?php echo e(route('users.index')); ?>" class="btn btn-secondary me-2">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <a href="<?php echo e(route('users.edit', $user->id)); ?>" class="btn btn-warning">
                        <i class="fas fa-pen"></i> Edit Profil
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Style kustom untuk foto profil di halaman show */
    .user-profile-photo {
        width: 120px;
        height: 120px;
        object-fit: cover;
    }
    .card-footer a {
        border-radius: 8px;
    }
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ASUSTeK\latihan-laravel\resources\views/user/show.blade.php ENDPATH**/ ?>