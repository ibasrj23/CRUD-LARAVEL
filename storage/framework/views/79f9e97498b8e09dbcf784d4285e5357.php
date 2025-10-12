<?php $__env->startSection('title', 'Dashboard Utama'); ?>

<?php $__env->startSection('header-title', Auth::check() ? 'Selamat Datang, ' . Auth::user()->name : 'Selamat Datang di Portal Kami'); ?>

<?php $__env->startSection('content'); ?>
<div class="content-wrapper mt-4">

    
    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>


    
    
    

    <?php if(auth()->guard()->check()): ?>

    <div class="row">

        
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100 bg-primary text-white">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <div class="text-uppercase small fw-bold mb-1">Total Post Terakhir</div>
                            <div class="h3 mb-0"><?php echo e($posts->total() ?? 0); ?></div>
                        </div>
                        <div class="col-4 text-end">
                            <i class="fas fa-pen-fancy fa-3x"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-secondary border-0 small">
                    <a href="<?php echo e(route('posts.public.index')); ?>" class="text-white text-decoration-none">Lihat Semua Post Publik &rarr;</a>
                </div>
            </div>
        </div>

        
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100 bg-warning text-dark">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <div class="text-uppercase small fw-bold mb-1">Jumlah User Terdaftar</div>
                            <div class="h3 mb-0">24</div>
                        </div>
                        <div class="col-4 text-end">
                            <i class="fas fa-users fa-3x"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-secondary border-0 small">
                    <span class="text-white text-decoration-none">Statistik User</span>
                </div>
            </div>
        </div>

        
        <div class="col-lg-4 col-md-12 mb-4">
            <div class="card border-0 shadow-sm h-100 bg-info text-white">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <div class="text-uppercase small fw-bold mb-1">Tanggal Hari Ini</div>
                            <div class="h5 mb-0"><?php echo e(\Carbon\Carbon::now()->translatedFormat('l, d F Y')); ?></div>
                        </div>
                        <div class="col-4 text-end">
                            <i class="fas fa-calendar-alt fa-3x"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-secondary border-0 small">
                    <span class="text-white text-decoration-none">Waktu Server: <?php echo e(\Carbon\Carbon::now()->format('H:i:s')); ?></span>
                </div>
            </div>
        </div>

    </div> 

    <?php endif; ?>


    
    
    

    <?php if(auth()->guard()->guest()): ?>
        
        <div class="alert alert-primary shadow-sm mb-4">
            <h4 class="alert-heading">Selamat Datang!</h4>
            <p class="mb-0">Silakan jelajahi postingan terbaru kami di bawah ini. Untuk mengakses fitur personal, silakan **Login** atau **Register**.</p>
        </div>
    <?php endif; ?>

    <div class="row mt-3">

        <div class="col-lg-8 mb-4">
            <div class="card shadow-lg border-0 h-100">
                <div class="card-header bg-white fw-bold"><i class="fas fa-chart-bar me-2"></i> Grafik Aktivitas Postingan (Placeholder)</div>
                <div class="card-body">
                    
                    <div class="text-center text-muted py-5 border rounded" style="min-height: 300px;">
                        [Di sini tempat library charting (misal: Chart.js) dimuat]
                        <p class="mt-3">Grafik Postingan Mingguan Belum Terimplementasi.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 mb-4">
            <div class="card shadow-lg border-0 h-100">
                <div class="card-header bg-white fw-bold"><i class="fas fa-info-circle me-2"></i> Postingan Terbaru (Untuk Semua Role)</div>
                <div class="card-body small">
                    <ul class="list-unstyled">
                        <?php $__empty_1 = true; $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <li class="mb-2 pb-2 border-bottom">
                                
                                <a href="<?php echo e(route('posts.public.show', $post->id)); ?>" class="text-dark text-decoration-none fw-bold">
                                    <?php echo e(Str::limit($post->title, 35)); ?>

                                </a>
                                <span class="d-block text-muted small">
                                    <i class="fas fa-calendar-alt me-1"></i> <?php echo e(\Carbon\Carbon::parse($post->published_at)->diffForHumans()); ?>

                                </span>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <li class="text-muted">Belum ada postingan terbaru.</li>
                        <?php endif; ?>
                    </ul>
                    <a href="<?php echo e(route('posts.public.index')); ?>" class="btn btn-sm btn-outline-dark w-100 mt-2">Lihat Semua Post</a>
                </div>
            </div>
        </div>

    </div>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ASUSTeK\latihan-laravel\resources\views/home.blade.php ENDPATH**/ ?>