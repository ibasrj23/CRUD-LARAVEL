<?php $__env->startSection('title', 'Profil Saya'); ?>
<?php $__env->startSection('header-title', 'Detail Akun Pengguna'); ?>

<?php $__env->startSection('content'); ?>
<?php
    use Illuminate\Support\Facades\Storage;
?>

<div class="row justify-content-center mt-4">
    <div class="col-md-10 col-lg-8">

        
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

        <div class="card shadow-xl border-0">

            
            <div class="card-header bg-dark text-white p-4 rounded-top-lg">
                <div class="d-flex align-items-center">

                    
                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center me-4 overflow-hidden" style="width: 80px; height: 80px;">
                        <?php
                            // Cek apakah file foto benar-benar ada di storage
                            $photoPath = 'public/photos/' . $user->photo;
                            $photoUrl = asset('storage/photos/' . $user->photo);
                        ?>

                        <?php if(!empty($user->photo) && Storage::disk('public')->exists('photos/' . $user->photo)): ?>
                            <img src="<?php echo e($photoUrl); ?>"
                                 alt="Foto Profil"
                                 style="width: 100%; height: 100%; object-fit: cover;"
                                 class="rounded-circle">
                        <?php else: ?>
                            <i class="fas fa-user fa-3x text-secondary"></i>
                        <?php endif; ?>
                    </div>

                    
                    <div>
                        <h4 class="mb-0 fw-bold text-white"><?php echo e($user->name); ?></h4>
                        <span class="badge bg-warning text-dark fw-bold shadow-sm p-2 mt-1">
                            Role: <?php echo e($user->role == 1 ? 'Administrator' : 'User Biasa'); ?>

                        </span>
                    </div>
                </div>
            </div>

            <div class="card-body p-4">
                <h5 class="fw-bold text-dark mb-3 border-bottom pb-2">Informasi Akun</h5>

                <!-- Detail Profil -->
                <div class="row mb-3">
                    <div class="col-sm-3 text-secondary"><i class="fas fa-envelope me-2"></i> Email:</div>
                    <div class="col-sm-9 fw-bold"><?php echo e($user->email); ?></div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-3 text-secondary"><i class="fas fa-calendar-plus me-2"></i> Bergabung:</div>
                    <div class="col-sm-9">
                        <?php echo e(\Carbon\Carbon::parse($user->created_at)->translatedFormat('d F Y (H:i)')); ?>

                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-sm-3 text-secondary"><i class="fas fa-fingerprint me-2"></i> ID Akun:</div>
                    <div class="col-sm-9 text-muted small"><?php echo e($user->id); ?></div>
                </div>

                <hr class="my-4">

                <!-- Tombol Aksi -->
                <div class="d-flex justify-content-end">
                    <a href="<?php echo e(route('profile.edit')); ?>" class="btn btn-warning text-white shadow-sm me-2">
                        <i class="fas fa-edit"></i> Edit Profil
                    </a>

                    <button type="button" class="btn btn-danger shadow-sm" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                        <i class="fas fa-trash-alt"></i> Hapus Akun
                    </button>
                </div>
            </div> 
        </div> 
    </div>
</div>

<!-- Modal Konfirmasi Hapus Akun -->
<div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteAccountModalLabel">Konfirmasi Penghapusan Akun</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-danger"><i class="fas fa-exclamation-triangle"></i> **PERINGATAN KERAS!** Akun Anda **(<?php echo e($user->name); ?>)** akan dihapus **secara permanen** dan tidak dapat dibatalkan.</p>
                <p>Semua data terkait akun Anda akan hilang. Apakah Anda yakin ingin melanjutkan?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form action="<?php echo e(route('profile.destroy')); ?>" method="POST" class="d-inline">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="btn btn-danger shadow-sm">Ya, Hapus Permanen</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ASUSTeK\latihan-laravel\resources\views/profile/show.blade.php ENDPATH**/ ?>